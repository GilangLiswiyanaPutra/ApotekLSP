import express from 'express'
const router = express.Router()

// Basic settings routes - will be expanded later
router.get('/', (req, res) => {
  res.json({ success: true, message: 'Settings endpoint ready', data: {} })
})

export default router