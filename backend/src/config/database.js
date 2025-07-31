import mysql from 'mysql2/promise'
import dotenv from 'dotenv'

dotenv.config()

const dbConfig = {
  host: process.env.DB_HOST || 'localhost',
  port: process.env.DB_PORT || 3306,
  user: process.env.DB_USER || 'root',
  password: process.env.DB_PASSWORD || '',
  database: process.env.DB_NAME || 'portfolio_db',
  charset: 'utf8mb4',
  timezone: '+00:00',
  connectionLimit: 10,
  acquireTimeout: 60000,
  timeout: 60000,
  reconnect: true
}

// Create connection pool
const pool = mysql.createPool(dbConfig)

// Test database connection
export const testConnection = async () => {
  try {
    const connection = await pool.getConnection()
    console.log('✅ Database connected successfully')
    connection.release()
    return true
  } catch (error) {
    console.error('❌ Database connection failed:', error.message)
    return false
  }
}

// Initialize database tables
export const initializeDatabase = async () => {
  try {
    // Create database if not exists
    const tempConnection = await mysql.createConnection({
      host: process.env.DB_HOST || 'localhost',
      port: process.env.DB_PORT || 3306,
      user: process.env.DB_USER || 'root',
      password: process.env.DB_PASSWORD || ''
    })

    await tempConnection.execute(`CREATE DATABASE IF NOT EXISTS ${process.env.DB_NAME || 'portfolio_db'} CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci`)
    await tempConnection.end()

    // Create tables
    await createTables()
    console.log('✅ Database initialized successfully')
  } catch (error) {
    console.error('❌ Database initialization failed:', error.message)
    throw error
  }
}

// Create database tables
const createTables = async () => {
  const connection = await pool.getConnection()
  
  try {
    // Users table for admin authentication
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS users (
        id INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) UNIQUE NOT NULL,
        email VARCHAR(100) UNIQUE NOT NULL,
        password VARCHAR(255) NOT NULL,
        role ENUM('admin', 'user') DEFAULT 'user',
        avatar VARCHAR(255),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    // Contact messages table
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS contact_messages (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        subject VARCHAR(200) NOT NULL,
        message TEXT NOT NULL,
        status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_status (status),
        INDEX idx_created_at (created_at)
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    // Projects table
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS projects (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(200) NOT NULL,
        description TEXT,
        long_description TEXT,
        category ENUM('frontend', 'backend', 'fullstack', 'mobile') NOT NULL,
        technologies JSON,
        features JSON,
        image_url VARCHAR(500),
        demo_url VARCHAR(500),
        github_url VARCHAR(500),
        status ENUM('completed', 'in-progress', 'planned') DEFAULT 'completed',
        featured BOOLEAN DEFAULT FALSE,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category),
        INDEX idx_status (status),
        INDEX idx_featured (featured)
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    // Skills table
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS skills (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(100) NOT NULL,
        category ENUM('frontend', 'backend', 'tools', 'mobile') NOT NULL,
        level INT NOT NULL CHECK (level >= 0 AND level <= 100),
        icon VARCHAR(10),
        color VARCHAR(50),
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_category (category)
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    // Experience table
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS experiences (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(200) NOT NULL,
        company VARCHAR(200) NOT NULL,
        location VARCHAR(200),
        period_start DATE NOT NULL,
        period_end DATE,
        employment_type ENUM('full-time', 'part-time', 'freelance', 'contract', 'internship') NOT NULL,
        description TEXT,
        achievements JSON,
        technologies JSON,
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_period_start (period_start)
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    // Portfolio settings table
    await connection.execute(`
      CREATE TABLE IF NOT EXISTS portfolio_settings (
        id INT PRIMARY KEY AUTO_INCREMENT,
        setting_key VARCHAR(100) UNIQUE NOT NULL,
        setting_value TEXT,
        setting_type ENUM('text', 'json', 'number', 'boolean') DEFAULT 'text',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
      ) ENGINE=InnoDB CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci
    `)

    console.log('✅ All database tables created successfully')
  } finally {
    connection.release()
  }
}

// Insert default data
export const insertDefaultData = async () => {
  const connection = await pool.getConnection()
  
  try {
    // Check if admin user exists
    const [adminUsers] = await connection.execute('SELECT id FROM users WHERE role = "admin"')
    
    if (adminUsers.length === 0) {
      const bcrypt = await import('bcryptjs')
      const hashedPassword = await bcrypt.hash('admin123', 12)
      
      await connection.execute(`
        INSERT INTO users (username, email, password, role) 
        VALUES (?, ?, ?, ?)
      `, ['admin', 'admin@portfolio.com', hashedPassword, 'admin'])
      
      console.log('✅ Default admin user created: admin@portfolio.com / admin123')
    }

    // Insert default portfolio settings
    const defaultSettings = [
      ['site_name', 'Portfolio Website', 'text'],
      ['site_description', 'Full Stack Developer Portfolio', 'text'],
      ['contact_email', 'john@developer.com', 'text'],
      ['contact_phone', '+62 812 3456 7890', 'text'],
      ['contact_location', 'Jakarta, Indonesia', 'text'],
      ['social_github', 'https://github.com/johndeveloper', 'text'],
      ['social_linkedin', 'https://linkedin.com/in/johndeveloper', 'text'],
      ['social_twitter', 'https://twitter.com/johndeveloper', 'text']
    ]

    for (const [key, value, type] of defaultSettings) {
      await connection.execute(`
        INSERT IGNORE INTO portfolio_settings (setting_key, setting_value, setting_type) 
        VALUES (?, ?, ?)
      `, [key, value, type])
    }

    console.log('✅ Default settings inserted')
  } finally {
    connection.release()
  }
}

export default pool