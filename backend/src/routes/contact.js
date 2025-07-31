import express from 'express'
import { body, validationResult } from 'express-validator'
import rateLimit from 'express-rate-limit'
import db from '../config/database.js'

const router = express.Router()

// Rate limiting for contact form
const contactLimiter = rateLimit({
  windowMs: 15 * 60 * 1000, // 15 minutes
  max: 5, // limit each IP to 5 requests per windowMs
  message: {
    error: 'Too many contact form submissions, please try again later.',
    code: 'CONTACT_RATE_LIMIT_EXCEEDED'
  }
})

// Validation rules
const contactValidation = [
  body('name')
    .trim()
    .notEmpty()
    .withMessage('Name is required')
    .isLength({ min: 2, max: 100 })
    .withMessage('Name must be between 2 and 100 characters'),
  
  body('email')
    .trim()
    .isEmail()
    .withMessage('Please provide a valid email')
    .normalizeEmail(),
  
  body('subject')
    .trim()
    .notEmpty()
    .withMessage('Subject is required')
    .isLength({ min: 5, max: 200 })
    .withMessage('Subject must be between 5 and 200 characters'),
  
  body('message')
    .trim()
    .notEmpty()
    .withMessage('Message is required')
    .isLength({ min: 10, max: 5000 })
    .withMessage('Message must be between 10 and 5000 characters')
]

// @desc    Send contact message
// @route   POST /api/contact
// @access  Public
router.post('/', contactLimiter, contactValidation, async (req, res, next) => {
  try {
    // Check for validation errors
    const errors = validationResult(req)
    if (!errors.isEmpty()) {
      return res.status(400).json({
        success: false,
        error: 'Validation failed',
        details: errors.array()
      })
    }

    const { name, email, subject, message } = req.body
    
    // Get client info
    const ipAddress = req.ip || req.connection.remoteAddress
    const userAgent = req.get('User-Agent')

    // Insert message into database
    const [result] = await db.execute(
      `INSERT INTO contact_messages 
       (name, email, subject, message, ip_address, user_agent) 
       VALUES (?, ?, ?, ?, ?, ?)`,
      [name, email, subject, message, ipAddress, userAgent]
    )

    // Send response
    res.status(201).json({
      success: true,
      message: 'Message sent successfully! I will get back to you soon.',
      data: {
        id: result.insertId,
        name,
        email,
        subject
      }
    })

    // TODO: Send email notification to admin
    // You can implement email sending here using nodemailer

  } catch (error) {
    next(error)
  }
})

// @desc    Get all contact messages (Admin only)
// @route   GET /api/contact
// @access  Private/Admin
router.get('/', async (req, res, next) => {
  try {
    const { status, page = 1, limit = 10, search } = req.query
    
    let query = 'SELECT * FROM contact_messages'
    let queryParams = []
    let whereClause = []

    // Filter by status
    if (status && ['unread', 'read', 'replied'].includes(status)) {
      whereClause.push('status = ?')
      queryParams.push(status)
    }

    // Search functionality
    if (search) {
      whereClause.push('(name LIKE ? OR email LIKE ? OR subject LIKE ?)')
      const searchTerm = `%${search}%`
      queryParams.push(searchTerm, searchTerm, searchTerm)
    }

    // Add WHERE clause if exists
    if (whereClause.length > 0) {
      query += ' WHERE ' + whereClause.join(' AND ')
    }

    // Add ordering and pagination
    query += ' ORDER BY created_at DESC LIMIT ? OFFSET ?'
    queryParams.push(parseInt(limit), (parseInt(page) - 1) * parseInt(limit))

    // Get total count
    let countQuery = 'SELECT COUNT(*) as total FROM contact_messages'
    let countParams = []
    
    if (whereClause.length > 0) {
      countQuery += ' WHERE ' + whereClause.join(' AND ')
      countParams = queryParams.slice(0, -2) // Remove limit and offset
    }

    const [messages] = await db.execute(query, queryParams)
    const [countResult] = await db.execute(countQuery, countParams)
    const total = countResult[0].total

    res.json({
      success: true,
      data: {
        messages,
        pagination: {
          page: parseInt(page),
          limit: parseInt(limit),
          total,
          pages: Math.ceil(total / parseInt(limit))
        }
      }
    })

  } catch (error) {
    next(error)
  }
})

// @desc    Update message status
// @route   PUT /api/contact/:id
// @access  Private/Admin
router.put('/:id', async (req, res, next) => {
  try {
    const { id } = req.params
    const { status } = req.body

    if (!['unread', 'read', 'replied'].includes(status)) {
      return res.status(400).json({
        success: false,
        error: 'Invalid status. Must be: unread, read, or replied'
      })
    }

    const [result] = await db.execute(
      'UPDATE contact_messages SET status = ? WHERE id = ?',
      [status, id]
    )

    if (result.affectedRows === 0) {
      return res.status(404).json({
        success: false,
        error: 'Message not found'
      })
    }

    res.json({
      success: true,
      message: 'Message status updated successfully'
    })

  } catch (error) {
    next(error)
  }
})

// @desc    Delete contact message
// @route   DELETE /api/contact/:id
// @access  Private/Admin
router.delete('/:id', async (req, res, next) => {
  try {
    const { id } = req.params

    const [result] = await db.execute(
      'DELETE FROM contact_messages WHERE id = ?',
      [id]
    )

    if (result.affectedRows === 0) {
      return res.status(404).json({
        success: false,
        error: 'Message not found'
      })
    }

    res.json({
      success: true,
      message: 'Message deleted successfully'
    })

  } catch (error) {
    next(error)
  }
})

// @desc    Get message statistics
// @route   GET /api/contact/stats
// @access  Private/Admin
router.get('/stats', async (req, res, next) => {
  try {
    const [stats] = await db.execute(`
      SELECT 
        COUNT(*) as total,
        SUM(CASE WHEN status = 'unread' THEN 1 ELSE 0 END) as unread,
        SUM(CASE WHEN status = 'read' THEN 1 ELSE 0 END) as read,
        SUM(CASE WHEN status = 'replied' THEN 1 ELSE 0 END) as replied,
        COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY) THEN 1 END) as this_week,
        COUNT(CASE WHEN created_at >= DATE_SUB(NOW(), INTERVAL 30 DAY) THEN 1 END) as this_month
      FROM contact_messages
    `)

    res.json({
      success: true,
      data: stats[0]
    })

  } catch (error) {
    next(error)
  }
})

export default router