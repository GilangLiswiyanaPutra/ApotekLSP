import React, { useState } from 'react'
import { motion } from 'framer-motion'
import { 
  Code2, 
  Database, 
  Palette, 
  Globe, 
  Smartphone, 
  Cloud,
  GitBranch,
  Settings
} from 'lucide-react'

const Skills = () => {
  const [activeCategory, setActiveCategory] = useState('frontend')

  const skillCategories = {
    frontend: {
      title: 'Frontend Development',
      icon: Code2,
      color: 'from-blue-500 to-cyan-500',
      skills: [
        { name: 'React.js', level: 95, icon: '⚛️' },
        { name: 'JavaScript', level: 92, icon: '🟨' },
        { name: 'TypeScript', level: 88, icon: '🔷' },
        { name: 'Tailwind CSS', level: 90, icon: '🎨' },
        { name: 'Next.js', level: 85, icon: '▲' },
        { name: 'Vue.js', level: 80, icon: '💚' },
      ]
    },
    backend: {
      title: 'Backend Development',
      icon: Database,
      color: 'from-green-500 to-emerald-500',
      skills: [
        { name: 'Node.js', level: 90, icon: '🟢' },
        { name: 'Express.js', level: 88, icon: '🚀' },
        { name: 'Python', level: 85, icon: '🐍' },
        { name: 'MySQL', level: 87, icon: '🗄️' },
        { name: 'MongoDB', level: 82, icon: '🍃' },
        { name: 'PostgreSQL', level: 80, icon: '🐘' },
      ]
    },
    tools: {
      title: 'Tools & Technologies',
      icon: Settings,
      color: 'from-purple-500 to-pink-500',
      skills: [
        { name: 'Git', level: 93, icon: '📚' },
        { name: 'Docker', level: 85, icon: '🐳' },
        { name: 'AWS', level: 78, icon: '☁️' },
        { name: 'Figma', level: 88, icon: '🎯' },
        { name: 'Postman', level: 90, icon: '📮' },
        { name: 'VS Code', level: 95, icon: '💻' },
      ]
    },
    mobile: {
      title: 'Mobile Development',
      icon: Smartphone,
      color: 'from-orange-500 to-red-500',
      skills: [
        { name: 'React Native', level: 82, icon: '📱' },
        { name: 'Flutter', level: 75, icon: '🦋' },
        { name: 'Expo', level: 85, icon: '⚡' },
        { name: 'Android Studio', level: 70, icon: '🤖' },
        { name: 'iOS Development', level: 65, icon: '🍎' },
        { name: 'PWA', level: 88, icon: '📲' },
      ]
    }
  }

  return (
    <section className="py-20 relative overflow-hidden">
      {/* Animated Background */}
      <div className="absolute inset-0">
        <motion.div
          className="absolute top-10 right-10 w-72 h-72 bg-primary-500/10 rounded-full blur-3xl"
          animate={{
            rotate: [0, 360],
            scale: [1, 1.3, 1],
          }}
          transition={{ duration: 20, repeat: Infinity, ease: "linear" }}
        />
        <motion.div
          className="absolute bottom-10 left-10 w-96 h-96 bg-primary-600/10 rounded-full blur-3xl"
          animate={{
            rotate: [360, 0],
            scale: [1.3, 1, 1.3],
          }}
          transition={{ duration: 25, repeat: Infinity, ease: "linear" }}
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
            Skills & Expertise
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Teknologi dan tools yang saya kuasai untuk menciptakan solusi digital yang luar biasa
          </p>
        </motion.div>

        {/* Category Tabs */}
        <motion.div
          className="flex flex-wrap justify-center gap-4 mb-12"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          viewport={{ once: true }}
        >
          {Object.entries(skillCategories).map(([key, category]) => {
            const IconComponent = category.icon
            return (
              <motion.button
                key={key}
                onClick={() => setActiveCategory(key)}
                className={`flex items-center space-x-2 px-6 py-3 rounded-2xl transition-all duration-300 ${
                  activeCategory === key
                    ? 'glass-effect border-2 border-primary-500 text-primary-400'
                    : 'glass-effect border-2 border-transparent text-gray-400 hover:text-primary-400'
                }`}
                whileHover={{ scale: 1.05 }}
                whileTap={{ scale: 0.95 }}
              >
                <IconComponent size={20} />
                <span className="font-medium">{category.title}</span>
              </motion.button>
            )
          })}
        </motion.div>

        {/* Skills Content */}
        <motion.div
          key={activeCategory}
          initial={{ opacity: 0, y: 30 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.5 }}
          className="grid md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          {skillCategories[activeCategory].skills.map((skill, index) => (
            <motion.div
              key={skill.name}
              className="glass-effect p-6 rounded-2xl group hover:border-primary-500/50 transition-all duration-300"
              initial={{ opacity: 0, scale: 0.9 }}
              animate={{ opacity: 1, scale: 1 }}
              transition={{ delay: index * 0.1 }}
              whileHover={{ 
                scale: 1.05,
                rotateY: 5,
                rotateX: 5,
              }}
              style={{ transformStyle: 'preserve-3d' }}
            >
              <div className="flex items-center justify-between mb-4">
                <div className="flex items-center space-x-3">
                  <motion.div
                    className="text-2xl"
                    whileHover={{ scale: 1.2, rotate: 10 }}
                  >
                    {skill.icon}
                  </motion.div>
                  <h3 className="text-lg font-semibold text-white group-hover:text-primary-400 transition-colors">
                    {skill.name}
                  </h3>
                </div>
                <span className="text-primary-400 font-bold">{skill.level}%</span>
              </div>

              {/* Animated Progress Bar */}
              <div className="relative">
                <div className="w-full h-2 bg-gray-700 rounded-full overflow-hidden">
                  <motion.div
                    className={`h-full bg-gradient-to-r ${skillCategories[activeCategory].color} rounded-full relative`}
                    initial={{ width: 0 }}
                    animate={{ width: `${skill.level}%` }}
                    transition={{ 
                      duration: 1.5, 
                      delay: index * 0.1,
                      ease: "easeOut"
                    }}
                  >
                    {/* Glowing effect */}
                    <motion.div
                      className="absolute inset-0 bg-white/30 rounded-full"
                      animate={{
                        opacity: [0, 1, 0],
                        x: [-20, '100%'],
                      }}
                      transition={{
                        duration: 2,
                        repeat: Infinity,
                        ease: "easeInOut",
                      }}
                    />
                  </motion.div>
                </div>
              </div>

              {/* Skill level indicator */}
              <div className="flex justify-between text-xs text-gray-400 mt-2">
                <span>Beginner</span>
                <span>Intermediate</span>
                <span>Expert</span>
              </div>
            </motion.div>
          ))}
        </motion.div>

        {/* Additional Info */}
        <motion.div
          className="mt-16 text-center"
          initial={{ opacity: 0 }}
          whileInView={{ opacity: 1 }}
          transition={{ duration: 0.8, delay: 0.5 }}
          viewport={{ once: true }}
        >
          <div className="glass-effect p-8 rounded-2xl max-w-3xl mx-auto">
            <h3 className="text-2xl font-bold text-white mb-4">
              Always Learning, Always Growing
            </h3>
            <p className="text-gray-300 leading-relaxed">
              Dunia teknologi terus berkembang, dan saya selalu bersemangat untuk mempelajari 
              teknologi baru dan meningkatkan skill yang sudah ada. Setiap project adalah 
              kesempatan untuk berkembang dan memberikan value terbaik.
            </p>
          </div>
        </motion.div>
      </div>
    </section>
  )
}

export default Skills