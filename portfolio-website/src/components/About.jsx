import React from 'react'
import { motion } from 'framer-motion'
import { Code2, Palette, Database, Zap, Heart, Target } from 'lucide-react'

const About = () => {
  const features = [
    {
      icon: Code2,
      title: 'Clean Code',
      description: 'Menulis kode yang rapi, maintainable, dan efisien'
    },
    {
      icon: Palette,
      title: 'UI/UX Design',
      description: 'Menciptakan antarmuka yang indah dan user-friendly'
    },
    {
      icon: Database,
      title: 'Full Stack',
      description: 'Menguasai frontend dan backend development'
    },
    {
      icon: Zap,
      title: 'Performance',
      description: 'Optimasi aplikasi untuk performa terbaik'
    }
  ]

  return (
    <section className="py-20 relative overflow-hidden">
      {/* Background Elements */}
      <div className="absolute inset-0">
        <motion.div
          className="absolute top-20 left-1/4 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl"
          animate={{
            scale: [1, 1.2, 1],
            opacity: [0.3, 0.6, 0.3],
          }}
          transition={{ duration: 8, repeat: Infinity, ease: "easeInOut" }}
        />
        <motion.div
          className="absolute bottom-20 right-1/4 w-80 h-80 bg-primary-600/5 rounded-full blur-3xl"
          animate={{
            scale: [1.2, 1, 1.2],
            opacity: [0.6, 0.3, 0.6],
          }}
          transition={{ duration: 10, repeat: Infinity, ease: "easeInOut" }}
        />
      </div>

      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <motion.div
          className="text-center mb-16"
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8 }}
          viewport={{ once: true }}
        >
          <h2 className="text-4xl md:text-5xl font-bold text-gradient mb-4">
            About Me
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Passionate developer yang selalu bersemangat untuk menciptakan solusi digital yang inovatif
          </p>
        </motion.div>

        <div className="grid lg:grid-cols-2 gap-12 items-center">
          {/* Left Side - Text Content */}
          <motion.div
            initial={{ opacity: 0, x: -50 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <div className="space-y-6">
              <motion.div
                className="glass-effect p-6 rounded-2xl"
                whileHover={{ scale: 1.02 }}
                transition={{ duration: 0.3 }}
              >
                <div className="flex items-center space-x-3 mb-4">
                  <Heart className="text-primary-400" size={24} />
                  <h3 className="text-2xl font-bold text-white">Passion</h3>
                </div>
                <p className="text-gray-300 leading-relaxed">
                  Saya memiliki passion yang besar dalam dunia teknologi dan programming. 
                  Setiap hari adalah kesempatan untuk belajar sesuatu yang baru dan 
                  mengembangkan keterampilan coding saya.
                </p>
              </motion.div>

              <motion.div
                className="glass-effect p-6 rounded-2xl"
                whileHover={{ scale: 1.02 }}
                transition={{ duration: 0.3 }}
              >
                <div className="flex items-center space-x-3 mb-4">
                  <Target className="text-primary-400" size={24} />
                  <h3 className="text-2xl font-bold text-white">Mission</h3>
                </div>
                <p className="text-gray-300 leading-relaxed">
                  Misi saya adalah menciptakan aplikasi web yang tidak hanya fungsional, 
                  tetapi juga memberikan pengalaman pengguna yang luar biasa. 
                  Saya percaya bahwa teknologi harus dapat diakses dan bermanfaat untuk semua orang.
                </p>
              </motion.div>

              <div className="flex flex-wrap gap-3">
                {['React', 'Node.js', 'JavaScript', 'TypeScript', 'Python', 'MySQL'].map((tech, index) => (
                  <motion.span
                    key={tech}
                    className="px-4 py-2 bg-primary-500/20 text-primary-400 rounded-full text-sm font-medium"
                    initial={{ opacity: 0, scale: 0 }}
                    whileInView={{ opacity: 1, scale: 1 }}
                    transition={{ delay: index * 0.1 }}
                    viewport={{ once: true }}
                    whileHover={{ scale: 1.1 }}
                  >
                    {tech}
                  </motion.span>
                ))}
              </div>
            </div>
          </motion.div>

          {/* Right Side - Feature Cards */}
          <motion.div
            className="grid grid-cols-2 gap-6"
            initial={{ opacity: 0, x: 50 }}
            whileInView={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            {features.map((feature, index) => (
              <motion.div
                key={feature.title}
                className="glass-effect p-6 rounded-2xl text-center group cursor-pointer"
                initial={{ opacity: 0, y: 30 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ delay: index * 0.2 }}
                viewport={{ once: true }}
                whileHover={{ 
                  scale: 1.05,
                  rotateY: 5,
                  rotateX: 5,
                }}
                style={{ transformStyle: 'preserve-3d' }}
              >
                <motion.div
                  className="w-16 h-16 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl mx-auto mb-4 flex items-center justify-center"
                  whileHover={{ rotateY: 180 }}
                  transition={{ duration: 0.6 }}
                >
                  <feature.icon className="text-white" size={28} />
                </motion.div>
                <h4 className="text-lg font-bold text-white mb-2 group-hover:text-primary-400 transition-colors">
                  {feature.title}
                </h4>
                <p className="text-gray-300 text-sm">
                  {feature.description}
                </p>
              </motion.div>
            ))}
          </motion.div>
        </div>

        {/* Stats Section */}
        <motion.div
          className="mt-20 grid grid-cols-2 md:grid-cols-4 gap-8"
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.4 }}
          viewport={{ once: true }}
        >
          {[
            { value: '5+', label: 'Years Experience', suffix: '' },
            { value: '50+', label: 'Projects Completed', suffix: '' },
            { value: '100', label: 'Happy Clients', suffix: '%' },
            { value: '24/7', label: 'Support Available', suffix: '' },
          ].map((stat, index) => (
            <motion.div
              key={stat.label}
              className="text-center"
              whileHover={{ scale: 1.1 }}
              initial={{ opacity: 0, scale: 0 }}
              whileInView={{ opacity: 1, scale: 1 }}
              transition={{ delay: index * 0.1 }}
              viewport={{ once: true }}
            >
              <motion.div
                className="text-3xl md:text-4xl font-bold text-gradient mb-2"
                animate={{ 
                  textShadow: [
                    '0 0 10px rgba(14, 165, 233, 0.5)',
                    '0 0 20px rgba(14, 165, 233, 0.8)',
                    '0 0 10px rgba(14, 165, 233, 0.5)'
                  ]
                }}
                transition={{ duration: 2, repeat: Infinity }}
              >
                {stat.value}{stat.suffix}
              </motion.div>
              <p className="text-gray-400 text-sm font-medium">{stat.label}</p>
            </motion.div>
          ))}
        </motion.div>
      </div>
    </section>
  )
}

export default About