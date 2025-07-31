import React from 'react'
import { motion } from 'framer-motion'
import { ChevronDown, Github, Linkedin, Mail, Download } from 'lucide-react'

const Hero = () => {
  const scrollToNext = () => {
    const nextSection = document.querySelector('#about')
    if (nextSection) {
      nextSection.scrollIntoView({ behavior: 'smooth' })
    }
  }

  return (
    <section className="min-h-screen flex items-center justify-center relative overflow-hidden pt-20">
      {/* 3D Background Elements */}
      <div className="absolute inset-0 perspective-1000">
        <motion.div
          className="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-primary-500/20 to-primary-700/20 rounded-full blur-xl"
          animate={{
            y: [0, -30, 0],
            x: [0, 20, 0],
            rotate: [0, 180, 360],
          }}
          transition={{
            duration: 20,
            repeat: Infinity,
            ease: "easeInOut",
          }}
        />
        <motion.div
          className="absolute bottom-20 right-10 w-48 h-48 bg-gradient-to-tl from-primary-600/20 to-primary-800/20 rounded-full blur-xl"
          animate={{
            y: [0, 40, 0],
            x: [0, -30, 0],
            rotate: [360, 180, 0],
          }}
          transition={{
            duration: 25,
            repeat: Infinity,
            ease: "easeInOut",
          }}
        />
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <motion.div
          initial={{ opacity: 0, y: 50 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 1, delay: 0.2 }}
          className="mb-8"
        >
          <motion.h1 
            className="text-5xl md:text-7xl lg:text-8xl font-bold mb-6"
            style={{
              background: 'linear-gradient(135deg, #0ea5e9 0%, #3b82f6 50%, #6366f1 100%)',
              backgroundClip: 'text',
              WebkitBackgroundClip: 'text',
              WebkitTextFillColor: 'transparent',
              textShadow: '0 0 30px rgba(14, 165, 233, 0.5)',
            }}
          >
            <motion.span
              className="inline-block"
              animate={{ rotateX: [0, 5, 0] }}
              transition={{ duration: 3, repeat: Infinity, ease: "easeInOut" }}
            >
              Hi, I'm
            </motion.span>
            <br />
            <motion.span
              className="inline-block"
              animate={{ 
                rotateY: [0, 5, 0],
                textShadow: [
                  '0 0 30px rgba(14, 165, 233, 0.5)',
                  '0 0 50px rgba(14, 165, 233, 0.8)',
                  '0 0 30px rgba(14, 165, 233, 0.5)'
                ]
              }}
              transition={{ duration: 4, repeat: Infinity, ease: "easeInOut" }}
            >
              Developer
            </motion.span>
          </motion.h1>

          <motion.p
            className="text-xl md:text-2xl text-gray-300 mb-8 max-w-3xl mx-auto leading-relaxed"
            initial={{ opacity: 0 }}
            animate={{ opacity: 1 }}
            transition={{ duration: 1, delay: 0.8 }}
          >
            Full Stack Developer dengan passion untuk menciptakan 
            <span className="text-primary-400 font-semibold"> experience digital yang luar biasa</span>. 
            Mengubah ide menjadi kenyataan dengan kode yang elegan.
          </motion.p>
        </motion.div>

        {/* CTA Buttons */}
        <motion.div
          className="flex flex-col sm:flex-row gap-4 justify-center items-center mb-12"
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 1, delay: 1.2 }}
        >
          <motion.button
            className="btn-primary flex items-center gap-2"
            whileHover={{ scale: 1.05, boxShadow: '0 10px 30px rgba(14, 165, 233, 0.3)' }}
            whileTap={{ scale: 0.95 }}
          >
            <Download size={20} />
            Download CV
          </motion.button>
          
          <motion.button
            className="btn-secondary flex items-center gap-2"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.95 }}
            onClick={() => document.querySelector('#contact').scrollIntoView({ behavior: 'smooth' })}
          >
            <Mail size={20} />
            Contact Me
          </motion.button>
        </motion.div>

        {/* Social Links */}
        <motion.div
          className="flex justify-center space-x-6 mb-16"
          initial={{ opacity: 0 }}
          animate={{ opacity: 1 }}
          transition={{ duration: 1, delay: 1.6 }}
        >
          {[
            { icon: Github, href: '#', color: 'hover:text-gray-400' },
            { icon: Linkedin, href: '#', color: 'hover:text-blue-400' },
            { icon: Mail, href: '#', color: 'hover:text-primary-400' },
          ].map((social, index) => (
            <motion.a
              key={index}
              href={social.href}
              className={`text-gray-400 ${social.color} transition-colors duration-300 p-3 rounded-full glass-effect`}
              whileHover={{ 
                scale: 1.2, 
                rotate: 5,
                boxShadow: '0 5px 20px rgba(14, 165, 233, 0.3)'
              }}
              whileTap={{ scale: 0.9 }}
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ delay: 1.8 + index * 0.1 }}
            >
              <social.icon size={24} />
            </motion.a>
          ))}
        </motion.div>

        {/* Scroll Indicator */}
        <motion.button
          onClick={scrollToNext}
          className="absolute bottom-8 left-1/2 transform -translate-x-1/2 text-primary-400 hover:text-primary-300 transition-colors"
          animate={{ y: [0, 10, 0] }}
          transition={{ duration: 2, repeat: Infinity, ease: "easeInOut" }}
          whileHover={{ scale: 1.1 }}
        >
          <ChevronDown size={32} />
        </motion.button>
      </div>

      {/* Floating elements */}
      <motion.div
        className="absolute top-1/4 left-8 w-4 h-4 bg-primary-500 rounded-full opacity-60"
        animate={{
          y: [0, -100, 0],
          x: [0, 50, 0],
          scale: [1, 1.5, 1],
        }}
        transition={{
          duration: 8,
          repeat: Infinity,
          ease: "easeInOut",
        }}
      />
      <motion.div
        className="absolute top-3/4 right-12 w-6 h-6 bg-primary-600 rounded-full opacity-40"
        animate={{
          y: [0, 80, 0],
          x: [0, -40, 0],
          scale: [1, 0.5, 1],
        }}
        transition={{
          duration: 10,
          repeat: Infinity,
          ease: "easeInOut",
        }}
      />
    </section>
  )
}

export default Hero