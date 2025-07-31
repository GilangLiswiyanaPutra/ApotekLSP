export const errorHandler = (err, req, res, next) => {
  let error = { ...err }
  error.message = err.message

  // Log error
  console.error('Error:', err)

  // Mongoose bad ObjectId
  if (err.name === 'CastError') {
    const message = 'Resource not found'
    error = { message, statusCode: 404 }
  }

  // Mongoose duplicate key
  if (err.code === 11000) {
    const message = 'Duplicate field value entered'
    error = { message, statusCode: 400 }
  }

  // Mongoose validation error
  if (err.name === 'ValidationError') {
    const message = Object.values(err.errors).map(val => val.message).join(', ')
    error = { message, statusCode: 400 }
  }

  // MySQL duplicate entry
  if (err.code === 'ER_DUP_ENTRY') {
    const message = 'Duplicate entry. This record already exists.'
    error = { message, statusCode: 400 }
  }

  // MySQL syntax error
  if (err.code === 'ER_PARSE_ERROR') {
    const message = 'Database query error'
    error = { message, statusCode: 500 }
  }

  // JWT errors
  if (err.name === 'JsonWebTokenError') {
    const message = 'Invalid token'
    error = { message, statusCode: 401 }
  }

  if (err.name === 'TokenExpiredError') {
    const message = 'Token expired'
    error = { message, statusCode: 401 }
  }

  // Express validator errors
  if (err.array && typeof err.array === 'function') {
    const message = err.array().map(error => error.msg).join(', ')
    error = { message, statusCode: 400 }
  }

  res.status(error.statusCode || 500).json({
    success: false,
    error: error.message || 'Server Error',
    code: error.code || 'INTERNAL_SERVER_ERROR',
    ...(process.env.NODE_ENV === 'development' && { stack: err.stack })
  })
}