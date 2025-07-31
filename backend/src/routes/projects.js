import express from 'express'
const router = express.Router()

// Basic projects routes - will be expanded later
router.get('/', (req, res) => {
  res.json({ success: true, message: 'Projects endpoint ready', data: [] })
})

export default router