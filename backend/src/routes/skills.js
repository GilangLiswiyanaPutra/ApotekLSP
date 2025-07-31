import express from 'express'
const router = express.Router()

// Basic skills routes - will be expanded later
router.get('/', (req, res) => {
  res.json({ success: true, message: 'Skills endpoint ready', data: [] })
})

export default router