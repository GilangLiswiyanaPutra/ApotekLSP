import React from 'react'
import { motion } from 'framer-motion'
import { Calendar, MapPin, Building, Award, Users, TrendingUp } from 'lucide-react'

const Experience = () => {
  const experiences = [
    {
      id: 1,
      title: 'Senior Full Stack Developer',
      company: 'Tech Innovate Co.',
      location: 'Jakarta, Indonesia',
      period: '2022 - Present',
      type: 'Full-time',
      description: 'Leading development of enterprise web applications using React.js, Node.js, and cloud technologies. Mentoring junior developers and architecting scalable solutions.',
      achievements: [
        'Led a team of 5 developers to deliver 3 major projects',
        'Improved application performance by 40%',
        'Implemented CI/CD pipeline reducing deployment time by 60%'
      ],
      technologies: ['React', 'Node.js', 'AWS', 'Docker', 'MySQL'],
      icon: Building,
      color: 'from-blue-500 to-cyan-500'
    },
    {
      id: 2,
      title: 'Frontend Developer',
      company: 'Digital Solutions Ltd.',
      location: 'Bandung, Indonesia',
      period: '2020 - 2022',
      type: 'Full-time',
      description: 'Specialized in creating responsive and interactive web applications. Collaborated with design team to implement pixel-perfect UI/UX designs.',
      achievements: [
        'Developed 15+ responsive web applications',
        'Reduced bundle size by 35% through optimization',
        'Mentored 3 junior developers'
      ],
      technologies: ['React', 'TypeScript', 'Sass', 'Webpack', 'Jest'],
      icon: Award,
      color: 'from-green-500 to-emerald-500'
    },
    {
      id: 3,
      title: 'Junior Web Developer',
      company: 'StartUp Hub',
      location: 'Yogyakarta, Indonesia',
      period: '2019 - 2020',
      type: 'Full-time',
      description: 'Started my professional journey building web applications and learning modern development practices. Focused on frontend development with JavaScript frameworks.',
      achievements: [
        'Built 10+ client websites from scratch',
        'Learned and implemented modern development workflow',
        'Contributed to open source projects'
      ],
      technologies: ['JavaScript', 'jQuery', 'Bootstrap', 'PHP', 'MySQL'],
      icon: TrendingUp,
      color: 'from-purple-500 to-pink-500'
    },
    {
      id: 4,
      title: 'Freelance Web Developer',
      company: 'Self-Employed',
      location: 'Remote',
      period: '2018 - 2019',
      type: 'Freelance',
      description: 'Provided web development services to small businesses and startups. Gained experience with various technologies and client management.',
      achievements: [
        'Completed 20+ freelance projects',
        'Built long-term relationships with 5 clients',
        'Achieved 98% client satisfaction rate'
      ],
      technologies: ['HTML', 'CSS', 'JavaScript', 'WordPress', 'Photoshop'],
      icon: Users,
      color: 'from-orange-500 to-red-500'
    }
  ]

  return (
    <section className="py-20 relative overflow-hidden">
      {/* Background Elements */}
      <div className="absolute inset-0">
        <motion.div
          className="absolute top-1/4 right-20 w-72 h-72 bg-primary-500/5 rounded-full blur-3xl"
          animate={{
            scale: [1, 1.4, 1],
            opacity: [0.3, 0.7, 0.3],
            rotate: [0, 180, 360],
          }}
          transition={{ duration: 20, repeat: Infinity, ease: "easeInOut" }}
        />
        <motion.div
          className="absolute bottom-1/4 left-20 w-80 h-80 bg-primary-600/5 rounded-full blur-3xl"
          animate={{
            scale: [1.4, 1, 1.4],
            opacity: [0.7, 0.3, 0.7],
            rotate: [360, 180, 0],
          }}
          transition={{ duration: 25, repeat: Infinity, ease: "easeInOut" }}
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
            Professional Experience
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Perjalanan karir saya dalam dunia pengembangan software dan teknologi
          </p>
        </motion.div>

        {/* Timeline */}
        <div className="relative">
          {/* Timeline Line */}
          <div className="absolute left-1/2 transform -translate-x-1/2 w-1 bg-gradient-to-b from-primary-500 to-primary-700 h-full opacity-30" />

          <div className="space-y-12">
            {experiences.map((exp, index) => {
              const IconComponent = exp.icon
              const isEven = index % 2 === 0

              return (
                <motion.div
                  key={exp.id}
                  className={`flex items-center ${isEven ? 'flex-row' : 'flex-row-reverse'}`}
                  initial={{ opacity: 0, x: isEven ? -50 : 50 }}
                  whileInView={{ opacity: 1, x: 0 }}
                  transition={{ duration: 0.8, delay: index * 0.2 }}
                  viewport={{ once: true }}
                >
                  {/* Content Card */}
                  <motion.div
                    className={`w-5/12 ${isEven ? 'text-right pr-8' : 'text-left pl-8'}`}
                    whileHover={{ scale: 1.02 }}
                    style={{ transformStyle: 'preserve-3d' }}
                  >
                    <motion.div
                      className="glass-effect p-6 rounded-2xl border border-white/10"
                      whileHover={{
                        rotateY: isEven ? -5 : 5,
                        rotateX: 5,
                        boxShadow: '0 25px 50px rgba(14, 165, 233, 0.15)',
                      }}
                    >
                      {/* Header */}
                      <div className={`flex items-center ${isEven ? 'justify-end' : 'justify-start'} mb-4`}>
                        <div className={`flex items-center space-x-2 ${isEven ? 'flex-row-reverse space-x-reverse' : ''}`}>
                          <span className={`px-3 py-1 rounded-full text-xs font-medium ${
                            exp.type === 'Full-time' 
                              ? 'bg-green-500/20 text-green-400'
                              : 'bg-purple-500/20 text-purple-400'
                          }`}>
                            {exp.type}
                          </span>
                          <div className="flex items-center space-x-1 text-gray-400">
                            <Calendar size={14} />
                            <span className="text-sm">{exp.period}</span>
                          </div>
                        </div>
                      </div>

                      {/* Title & Company */}
                      <h3 className="text-xl font-bold text-white mb-2">{exp.title}</h3>
                      <div className={`flex items-center ${isEven ? 'justify-end' : 'justify-start'} mb-2`}>
                        <div className={`flex items-center space-x-2 ${isEven ? 'flex-row-reverse space-x-reverse' : ''}`}>
                          <Building className="text-primary-400" size={16} />
                          <span className="text-primary-400 font-medium">{exp.company}</span>
                        </div>
                      </div>
                      
                      <div className={`flex items-center ${isEven ? 'justify-end' : 'justify-start'} mb-4`}>
                        <div className={`flex items-center space-x-2 ${isEven ? 'flex-row-reverse space-x-reverse' : ''}`}>
                          <MapPin className="text-gray-400" size={14} />
                          <span className="text-gray-400 text-sm">{exp.location}</span>
                        </div>
                      </div>

                      {/* Description */}
                      <p className="text-gray-300 text-sm mb-4 leading-relaxed">
                        {exp.description}
                      </p>

                      {/* Achievements */}
                      <div className="mb-4">
                        <h4 className="text-white font-semibold mb-2">Key Achievements:</h4>
                        <ul className="space-y-1">
                          {exp.achievements.map((achievement, idx) => (
                            <li key={idx} className="flex items-start space-x-2 text-gray-300 text-sm">
                              <span className="text-primary-400 mt-1">•</span>
                              <span>{achievement}</span>
                            </li>
                          ))}
                        </ul>
                      </div>

                      {/* Technologies */}
                      <div className={`flex flex-wrap gap-2 ${isEven ? 'justify-end' : 'justify-start'}`}>
                        {exp.technologies.map((tech) => (
                          <motion.span
                            key={tech}
                            className="px-2 py-1 bg-primary-500/20 text-primary-400 rounded text-xs font-medium"
                            whileHover={{ scale: 1.1 }}
                          >
                            {tech}
                          </motion.span>
                        ))}
                      </div>
                    </motion.div>
                  </motion.div>

                  {/* Timeline Icon */}
                  <motion.div
                    className="absolute left-1/2 transform -translate-x-1/2 w-16 h-16 rounded-2xl flex items-center justify-center z-10"
                    style={{
                      background: `linear-gradient(135deg, ${exp.color.split(' ')[1]} 0%, ${exp.color.split(' ')[3]} 100%)`,
                    }}
                    whileHover={{ 
                      scale: 1.2,
                      rotate: 10,
                      boxShadow: '0 10px 30px rgba(14, 165, 233, 0.3)',
                    }}
                    initial={{ scale: 0 }}
                    whileInView={{ scale: 1 }}
                    transition={{ delay: index * 0.2 + 0.5, type: "spring" }}
                    viewport={{ once: true }}
                  >
                    <IconComponent className="text-white" size={24} />
                  </motion.div>

                  {/* Empty space for opposite side */}
                  <div className="w-5/12" />
                </motion.div>
              )
            })}
          </div>
        </div>

        {/* Current Status */}
        <motion.div
          className="mt-20 text-center"
          initial={{ opacity: 0, y: 30 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.5 }}
          viewport={{ once: true }}
        >
          <div className="glass-effect p-8 rounded-2xl max-w-3xl mx-auto">
            <motion.div
              className="w-20 h-20 bg-gradient-to-br from-primary-500 to-primary-700 rounded-2xl mx-auto mb-6 flex items-center justify-center"
              animate={{ 
                boxShadow: [
                  '0 0 20px rgba(14, 165, 233, 0.3)',
                  '0 0 40px rgba(14, 165, 233, 0.6)',
                  '0 0 20px rgba(14, 165, 233, 0.3)'
                ]
              }}
              transition={{ duration: 2, repeat: Infinity }}
            >
              <TrendingUp className="text-white" size={32} />
            </motion.div>
            <h3 className="text-2xl font-bold text-white mb-4">
              Always Growing, Always Learning
            </h3>
            <p className="text-gray-300 leading-relaxed">
              Saat ini saya terus fokus untuk mengembangkan skill dan memberikan kontribusi 
              terbaik di setiap project. Tertarik untuk berkolaborasi atau memiliki project menarik? 
              Mari kita diskusikan!
            </p>
            <motion.button
              className="btn-primary mt-6"
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
              onClick={() => document.querySelector('#contact').scrollIntoView({ behavior: 'smooth' })}
            >
              Let's Work Together
            </motion.button>
          </div>
        </motion.div>
      </div>
    </section>
  )
}

export default Experience