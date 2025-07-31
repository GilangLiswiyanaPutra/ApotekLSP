import React, { useState } from 'react'
import { motion } from 'framer-motion'
import { MapPin, Calendar, Phone, Mail, Globe, Star } from 'lucide-react'

const IDCard = () => {
  const [isFlipped, setIsFlipped] = useState(false)
  const [mousePosition, setMousePosition] = useState({ x: 0, y: 0 })

  const handleMouseMove = (e) => {
    const rect = e.currentTarget.getBoundingClientRect()
    const x = ((e.clientX - rect.left) / rect.width - 0.5) * 20
    const y = ((e.clientY - rect.top) / rect.height - 0.5) * 20
    setMousePosition({ x, y })
  }

  const handleMouseLeave = () => {
    setMousePosition({ x: 0, y: 0 })
  }

  return (
    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <motion.div
        className="text-center mb-16"
        initial={{ opacity: 0, y: 30 }}
        whileInView={{ opacity: 1, y: 0 }}
        transition={{ duration: 0.8 }}
        viewport={{ once: true }}
      >
        <h2 className="text-4xl md:text-5xl font-bold text-gradient mb-4">
          Digital ID Card
        </h2>
        <p className="text-xl text-gray-300 max-w-2xl mx-auto">
          Kartu identitas digital dengan teknologi 3D yang menunjukkan profil profesional saya
        </p>
      </motion.div>

      <div className="flex justify-center perspective-1000">
        <motion.div
          className="relative w-96 h-64 cursor-pointer"
          style={{ transformStyle: 'preserve-3d' }}
          animate={{
            rotateY: isFlipped ? 180 : 0,
            rotateX: mousePosition.y * 0.5,
            rotateZ: mousePosition.x * 0.2,
          }}
          transition={{ duration: 0.6, ease: "easeOut" }}
          onMouseMove={handleMouseMove}
          onMouseLeave={handleMouseLeave}
          onClick={() => setIsFlipped(!isFlipped)}
          whileHover={{ scale: 1.05 }}
        >
          {/* Front Side */}
          <motion.div
            className="absolute inset-0 w-full h-full rounded-2xl glass-effect border-2 border-primary-500/30 overflow-hidden"
            style={{ backfaceVisibility: 'hidden' }}
          >
            {/* Background Pattern */}
            <div className="absolute inset-0 bg-gradient-to-br from-primary-900/20 via-primary-800/10 to-primary-700/20" />
            <div className="absolute inset-0 opacity-20">
              <div className="absolute top-4 right-4 w-32 h-32 bg-primary-500/10 rounded-full blur-2xl" />
              <div className="absolute bottom-4 left-4 w-24 h-24 bg-primary-600/10 rounded-full blur-xl" />
            </div>

            {/* Content */}
            <div className="relative z-10 p-6 h-full flex flex-col">
              {/* Header */}
              <div className="flex items-center justify-between mb-4">
                <div className="flex items-center space-x-3">
                  <div className="w-12 h-12 bg-gradient-to-br from-primary-500 to-primary-700 rounded-full flex items-center justify-center">
                    <Star className="text-white" size={20} />
                  </div>
                  <div>
                    <h3 className="text-lg font-bold text-white">DEVELOPER ID</h3>
                    <p className="text-primary-400 text-sm">Professional</p>
                  </div>
                </div>
                <div className="text-right">
                  <p className="text-xs text-gray-400">ID: #2024</p>
                  <p className="text-xs text-gray-400">Level: Senior</p>
                </div>
              </div>

              {/* Profile Section */}
              <div className="flex items-center space-x-4 mb-4">
                <motion.div
                  className="w-16 h-16 rounded-full bg-gradient-to-br from-primary-500 to-primary-700 flex items-center justify-center text-white font-bold text-xl border-2 border-primary-400/50"
                  animate={{ rotate: [0, 5, -5, 0] }}
                  transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
                >
                  JD
                </motion.div>
                <div>
                  <h4 className="text-xl font-bold text-white">John Developer</h4>
                  <p className="text-primary-400">Full Stack Developer</p>
                  <div className="flex items-center space-x-1 text-sm text-gray-300">
                    <MapPin size={12} />
                    <span>Jakarta, Indonesia</span>
                  </div>
                </div>
              </div>

              {/* Stats */}
              <div className="grid grid-cols-3 gap-2 mt-auto">
                <div className="text-center">
                  <p className="text-lg font-bold text-primary-400">5+</p>
                  <p className="text-xs text-gray-400">Years Exp</p>
                </div>
                <div className="text-center">
                  <p className="text-lg font-bold text-primary-400">50+</p>
                  <p className="text-xs text-gray-400">Projects</p>
                </div>
                <div className="text-center">
                  <p className="text-lg font-bold text-primary-400">100%</p>
                  <p className="text-xs text-gray-400">Success Rate</p>
                </div>
              </div>
            </div>

            {/* Holographic Effect */}
            <motion.div
              className="absolute inset-0 bg-gradient-to-r from-transparent via-primary-500/10 to-transparent"
              animate={{
                x: [-100, 400],
                opacity: [0, 1, 0],
              }}
              transition={{
                duration: 3,
                repeat: Infinity,
                ease: "easeInOut",
              }}
            />
          </motion.div>

          {/* Back Side */}
          <motion.div
            className="absolute inset-0 w-full h-full rounded-2xl glass-effect border-2 border-primary-500/30 overflow-hidden"
            style={{ 
              backfaceVisibility: 'hidden', 
              transform: 'rotateY(180deg)' 
            }}
          >
            {/* Background */}
            <div className="absolute inset-0 bg-gradient-to-tl from-primary-900/20 via-primary-800/10 to-primary-700/20" />

            {/* Content */}
            <div className="relative z-10 p-6 h-full">
              <div className="text-center mb-6">
                <h3 className="text-xl font-bold text-white mb-2">Contact Information</h3>
                <div className="w-16 h-0.5 bg-gradient-to-r from-primary-500 to-primary-700 mx-auto" />
              </div>

              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <Mail size={16} className="text-primary-400" />
                  </div>
                  <div>
                    <p className="text-gray-400 text-sm">Email</p>
                    <p className="text-white">john@developer.com</p>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <Phone size={16} className="text-primary-400" />
                  </div>
                  <div>
                    <p className="text-gray-400 text-sm">Phone</p>
                    <p className="text-white">+62 812 3456 7890</p>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <Globe size={16} className="text-primary-400" />
                  </div>
                  <div>
                    <p className="text-gray-400 text-sm">Website</p>
                    <p className="text-white">www.johndeveloper.com</p>
                  </div>
                </div>

                <div className="flex items-center space-x-3">
                  <div className="w-8 h-8 bg-primary-500/20 rounded-full flex items-center justify-center">
                    <Calendar size={16} className="text-primary-400" />
                  </div>
                  <div>
                    <p className="text-gray-400 text-sm">Member Since</p>
                    <p className="text-white">January 2019</p>
                  </div>
                </div>
              </div>

              {/* QR Code Placeholder */}
              <div className="mt-6 text-center">
                <div className="w-16 h-16 mx-auto bg-gradient-to-br from-primary-500 to-primary-700 rounded-lg flex items-center justify-center">
                  <div className="w-12 h-12 bg-white/20 rounded border-2 border-white/40" />
                </div>
                <p className="text-xs text-gray-400 mt-2">Scan QR Code</p>
              </div>
            </div>
          </motion.div>
        </motion.div>
      </div>

      {/* Instruction */}
      <motion.p
        className="text-center text-gray-400 mt-8"
        initial={{ opacity: 0 }}
        whileInView={{ opacity: 1 }}
        transition={{ duration: 0.8, delay: 0.5 }}
        viewport={{ once: true }}
      >
        Klik kartu untuk membalik dan lihat informasi kontak
      </motion.p>
    </div>
  )
}

export default IDCard