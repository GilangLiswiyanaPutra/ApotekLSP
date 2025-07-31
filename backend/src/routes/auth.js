import express from 'express'
const router = express.Router()

// Basic auth routes - will be expanded later
router.post('/login', (req, res) => {
  res.json({ success: true, message: 'Auth endpoint ready' })
})

export default router