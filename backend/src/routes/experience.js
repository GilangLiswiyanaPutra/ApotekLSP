import express from 'express'
const router = express.Router()

// Basic experience routes - will be expanded later
router.get('/', (req, res) => {
  res.json({ success: true, message: 'Experience endpoint ready', data: [] })
})

export default router