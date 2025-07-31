import express from 'express'
import cors from 'cors'
import helmet from 'helmet'
import morgan from 'morgan'
import dotenv from 'dotenv'
import rateLimit from 'express-rate-limit'
import path from 'path'
import { fileURLToPath } from 'url'

// Import database configuration
import { testConnection, initializeDatabase, insertDefaultData } from './config/database.js'

// Import routes
import contactRoutes from './routes/contact.js'
import projectRoutes from './routes/projects.js'
import skillRoutes from './routes/skills.js'
import experienceRoutes from './routes/experience.js'
import authRoutes from './routes/auth.js'
import settingsRoutes from './routes/settings.js'

// Import middleware
import { errorHandler } from './middleware/errorHandler.js'
import { notFound } from './middleware/notFound.js'

// Initialize environment variables
dotenv.config()

// Get dirname for ES modules
const __filename = fileURLToPath(import.meta.url)
const __dirname = path.dirname(__filename)

// Create Express app
const app = express()
const PORT = process.env.PORT || 5000

// Trust proxy for rate limiting
app.set('trust proxy', 1)

// Security middleware
app.use(helmet({
  crossOriginResourcePolicy: { policy: "cross-origin" },
  contentSecurityPolicy: {
    directives: {
      defaultSrc: ["'self'"],
      styleSrc: ["'self'", "'unsafe-inline'"],
      scriptSrc: ["'self'"],
      imgSrc: ["'self'", "data:", "https:"],
    },
  },
}))

// CORS configuration
app.use(cors({
  origin: process.env.FRONTEND_URL || 'http://localhost:5173',
  credentials: true,
  methods: ['GET', 'POST', 'PUT', 'DELETE', 'OPTIONS'],
  allowedHeaders: ['Content-Type', 'Authorization', 'x-api-key']
}))

// Rate limiting
const limiter = rateLimit({
  windowMs: parseInt(process.env.RATE_LIMIT_WINDOW_MS) || 15 * 60 * 1000, // 15 minutes
  max: parseInt(process.env.RATE_LIMIT_MAX_REQUESTS) || 100, // limit each IP to 100 requests per windowMs
  message: {
    error: 'Too many requests from this IP, please try again later.',
    code: 'RATE_LIMIT_EXCEEDED'
  },
  standardHeaders: true,
  legacyHeaders: false,
})

app.use(limiter)

// Logging
if (process.env.NODE_ENV === 'development') {
  app.use(morgan('dev'))
} else {
  app.use(morgan('combined'))
}

// Body parsing middleware
app.use(express.json({ limit: '10mb' }))
app.use(express.urlencoded({ extended: true, limit: '10mb' }))

// Serve static files
app.use('/uploads', express.static(path.join(__dirname, '../uploads')))

// Health check endpoint
app.get('/health', (req, res) => {
  res.json({
    status: 'success',
    message: 'Portfolio API is running!',
    timestamp: new Date().toISOString(),
    environment: process.env.NODE_ENV,
    version: '1.0.0'
  })
})

// API Routes
app.use('/api/auth', authRoutes)
app.use('/api/contact', contactRoutes)
app.use('/api/projects', projectRoutes)
app.use('/api/skills', skillRoutes)
app.use('/api/experience', experienceRoutes)
app.use('/api/settings', settingsRoutes)

// API Documentation endpoint
app.get('/api', (req, res) => {
  res.json({
    message: 'Portfolio API v1.0.0',
    documentation: {
      endpoints: {
        auth: {
          'POST /api/auth/login': 'Admin login',
          'POST /api/auth/register': 'Admin register (development only)',
          'GET /api/auth/profile': 'Get admin profile',
          'PUT /api/auth/profile': 'Update admin profile'
        },
        contact: {
          'POST /api/contact': 'Send contact message',
          'GET /api/contact': 'Get all messages (admin)',
          'PUT /api/contact/:id': 'Update message status (admin)',
          'DELETE /api/contact/:id': 'Delete message (admin)'
        },
        projects: {
          'GET /api/projects': 'Get all projects',
          'GET /api/projects/:id': 'Get project by ID',
          'POST /api/projects': 'Create project (admin)',
          'PUT /api/projects/:id': 'Update project (admin)',
          'DELETE /api/projects/:id': 'Delete project (admin)'
        },
        skills: {
          'GET /api/skills': 'Get all skills',
          'GET /api/skills/category/:category': 'Get skills by category',
          'POST /api/skills': 'Create skill (admin)',
          'PUT /api/skills/:id': 'Update skill (admin)',
          'DELETE /api/skills/:id': 'Delete skill (admin)'
        },
        experience: {
          'GET /api/experience': 'Get all experiences',
          'GET /api/experience/:id': 'Get experience by ID',
          'POST /api/experience': 'Create experience (admin)',
          'PUT /api/experience/:id': 'Update experience (admin)',
          'DELETE /api/experience/:id': 'Delete experience (admin)'
        },
        settings: {
          'GET /api/settings': 'Get all settings',
          'PUT /api/settings': 'Update settings (admin)'
        }
      }
    }
  })
})

// Error handling middleware
app.use(notFound)
app.use(errorHandler)

// Initialize database and start server
const startServer = async () => {
  try {
    console.log('🚀 Starting Portfolio API Server...')
    
    // Test database connection
    const dbConnected = await testConnection()
    if (!dbConnected) {
      console.error('❌ Failed to connect to database. Please check your database configuration.')
      process.exit(1)
    }

    // Initialize database
    await initializeDatabase()
    await insertDefaultData()

    // Start server
    app.listen(PORT, () => {
      console.log(`
🎉 Portfolio API Server is running!
🔗 Environment: ${process.env.NODE_ENV}
🌐 Server: http://localhost:${PORT}
📚 API Docs: http://localhost:${PORT}/api
❤️ Health Check: http://localhost:${PORT}/health
      `)
    })

  } catch (error) {
    console.error('❌ Failed to start server:', error.message)
    process.exit(1)
  }
}

// Graceful shutdown
process.on('SIGTERM', () => {
  console.log('👋 SIGTERM received. Shutting down gracefully...')
  process.exit(0)
})

process.on('SIGINT', () => {
  console.log('👋 SIGINT received. Shutting down gracefully...')
  process.exit(0)
})

// Handle uncaught exceptions
process.on('uncaughtException', (error) => {
  console.error('💥 Uncaught Exception:', error)
  process.exit(1)
})

process.on('unhandledRejection', (reason, promise) => {
  console.error('💥 Unhandled Rejection at:', promise, 'reason:', reason)
  process.exit(1)
})

// Start the server
startServer()

export default app