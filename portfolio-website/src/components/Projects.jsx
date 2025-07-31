import React, { useState } from 'react'
import { motion, AnimatePresence } from 'framer-motion'
import { ExternalLink, Github, Eye, Zap, Star, Calendar } from 'lucide-react'

const Projects = () => {
  const [selectedProject, setSelectedProject] = useState(null)
  const [filter, setFilter] = useState('all')

  const projects = [
    {
      id: 1,
      title: 'E-Commerce Platform',
      category: 'fullstack',
      description: 'Platform e-commerce modern dengan React, Node.js, dan MySQL',
      longDescription: 'Platform e-commerce full-stack yang dilengkapi dengan sistem pembayaran, manajemen inventory, dashboard admin, dan user authentication. Menggunakan teknologi modern seperti React.js untuk frontend, Express.js untuk backend, dan MySQL untuk database.',
      image: '/api/placeholder/400/250',
      technologies: ['React', 'Node.js', 'MySQL', 'Stripe', 'JWT'],
      features: ['Payment Gateway', 'Admin Dashboard', 'Real-time Notifications', 'Responsive Design'],
      github: '#',
      demo: '#',
      date: '2024',
      status: 'completed'
    },
    {
      id: 2,
      title: 'Task Management App',
      category: 'frontend',
      description: 'Aplikasi manajemen task dengan drag & drop interface',
      longDescription: 'Aplikasi manajemen tugas yang intuitif dengan fitur drag & drop, kolaborasi real-time, dan integrasi kalender. Dibangun dengan React.js dan menggunakan beautiful UI/UX design.',
      image: '/api/placeholder/400/250',
      technologies: ['React', 'TypeScript', 'Tailwind', 'Firebase'],
      features: ['Drag & Drop', 'Real-time Collaboration', 'Calendar Integration', 'Dark Mode'],
      github: '#',
      demo: '#',
      date: '2024',
      status: 'completed'
    },
    {
      id: 3,
      title: 'Weather Dashboard',
      category: 'frontend',
      description: 'Dashboard cuaca dengan visualisasi data yang menarik',
      longDescription: 'Dashboard cuaca interaktif yang menampilkan data cuaca real-time dengan visualisasi grafik yang menarik. Menggunakan API weather dan chart libraries untuk menampilkan data historis.',
      image: '/api/placeholder/400/250',
      technologies: ['Vue.js', 'Chart.js', 'Weather API', 'CSS3'],
      features: ['Real-time Data', 'Interactive Charts', 'Location Search', 'Forecast'],
      github: '#',
      demo: '#',
      date: '2023',
      status: 'completed'
    },
    {
      id: 4,
      title: 'Social Media API',
      category: 'backend',
      description: 'RESTful API untuk aplikasi social media',
      longDescription: 'RESTful API lengkap untuk aplikasi social media dengan fitur authentication, posts, comments, likes, dan real-time messaging menggunakan WebSocket.',
      image: '/api/placeholder/400/250',
      technologies: ['Node.js', 'Express', 'MongoDB', 'Socket.io'],
      features: ['JWT Authentication', 'Real-time Messaging', 'File Upload', 'Rate Limiting'],
      github: '#',
      demo: '#',
      date: '2023',
      status: 'completed'
    },
    {
      id: 5,
      title: 'Mobile Learning App',
      category: 'mobile',
      description: 'Aplikasi pembelajaran mobile dengan React Native',
      longDescription: 'Aplikasi pembelajaran mobile yang interaktif dengan fitur video streaming, quiz, progress tracking, dan offline mode. Dibangun dengan React Native untuk cross-platform compatibility.',
      image: '/api/placeholder/400/250',
      technologies: ['React Native', 'Expo', 'Firebase', 'Redux'],
      features: ['Video Streaming', 'Offline Mode', 'Progress Tracking', 'Push Notifications'],
      github: '#',
      demo: '#',
      date: '2024',
      status: 'in-progress'
    },
    {
      id: 6,
      title: 'Portfolio Website',
      category: 'frontend',
      description: 'Website portfolio dengan efek 3D dan animasi',
      longDescription: 'Website portfolio modern dengan efek 3D yang menakjubkan, animasi smooth, dan desain responsive. Menggunakan Three.js untuk efek 3D dan Framer Motion untuk animasi.',
      image: '/api/placeholder/400/250',
      technologies: ['React', 'Three.js', 'Framer Motion', 'Tailwind'],
      features: ['3D Effects', 'Smooth Animations', 'Responsive Design', 'Dark Theme'],
      github: '#',
      demo: '#',
      date: '2024',
      status: 'completed'
    }
  ]

  const categories = [
    { key: 'all', label: 'All Projects' },
    { key: 'fullstack', label: 'Full Stack' },
    { key: 'frontend', label: 'Frontend' },
    { key: 'backend', label: 'Backend' },
    { key: 'mobile', label: 'Mobile' }
  ]

  const filteredProjects = filter === 'all' 
    ? projects 
    : projects.filter(project => project.category === filter)

  return (
    <section className="py-20 relative overflow-hidden">
      {/* Background */}
      <div className="absolute inset-0">
        <motion.div
          className="absolute top-20 left-20 w-64 h-64 bg-primary-500/5 rounded-full blur-3xl"
          animate={{
            x: [0, 100, 0],
            y: [0, -50, 0],
            scale: [1, 1.3, 1],
          }}
          transition={{ duration: 15, repeat: Infinity, ease: "easeInOut" }}
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
            Featured Projects
          </h2>
          <p className="text-xl text-gray-300 max-w-3xl mx-auto">
            Koleksi project yang telah saya kerjakan dengan berbagai teknologi modern
          </p>
        </motion.div>

        {/* Filter Buttons */}
        <motion.div
          className="flex flex-wrap justify-center gap-4 mb-12"
          initial={{ opacity: 0, y: 20 }}
          whileInView={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.8, delay: 0.2 }}
          viewport={{ once: true }}
        >
          {categories.map((category) => (
            <motion.button
              key={category.key}
              onClick={() => setFilter(category.key)}
              className={`px-6 py-3 rounded-2xl transition-all duration-300 ${
                filter === category.key
                  ? 'glass-effect border-2 border-primary-500 text-primary-400'
                  : 'glass-effect border-2 border-transparent text-gray-400 hover:text-primary-400'
              }`}
              whileHover={{ scale: 1.05 }}
              whileTap={{ scale: 0.95 }}
            >
              {category.label}
            </motion.button>
          ))}
        </motion.div>

        {/* Projects Grid */}
        <motion.div 
          className="grid md:grid-cols-2 lg:grid-cols-3 gap-8"
          layout
        >
          <AnimatePresence>
            {filteredProjects.map((project, index) => (
              <motion.div
                key={project.id}
                className="glass-effect rounded-2xl overflow-hidden group cursor-pointer"
                initial={{ opacity: 0, scale: 0.9 }}
                animate={{ opacity: 1, scale: 1 }}
                exit={{ opacity: 0, scale: 0.9 }}
                transition={{ delay: index * 0.1 }}
                whileHover={{ 
                  scale: 1.02,
                  rotateY: 5,
                  rotateX: 5,
                }}
                style={{ transformStyle: 'preserve-3d' }}
                onClick={() => setSelectedProject(project)}
              >
                {/* Project Image */}
                <div className="relative h-48 bg-gradient-to-br from-primary-900/20 to-primary-700/20 overflow-hidden">
                  <div className="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent z-10" />
                  <motion.div
                    className="absolute top-4 right-4 z-20"
                    whileHover={{ scale: 1.1 }}
                  >
                    <span className={`px-3 py-1 rounded-full text-xs font-medium ${
                      project.status === 'completed' 
                        ? 'bg-green-500/20 text-green-400' 
                        : 'bg-yellow-500/20 text-yellow-400'
                    }`}>
                      {project.status === 'completed' ? 'Completed' : 'In Progress'}
                    </span>
                  </motion.div>
                  
                  {/* Placeholder for project image */}
                  <div className="w-full h-full bg-gradient-to-br from-primary-600/30 to-primary-800/30 flex items-center justify-center">
                    <div className="text-4xl opacity-50">🚀</div>
                  </div>
                </div>

                {/* Project Content */}
                <div className="p-6">
                  <div className="flex items-center justify-between mb-3">
                    <h3 className="text-xl font-bold text-white group-hover:text-primary-400 transition-colors">
                      {project.title}
                    </h3>
                    <div className="flex items-center space-x-1 text-gray-400">
                      <Calendar size={14} />
                      <span className="text-sm">{project.date}</span>
                    </div>
                  </div>
                  
                  <p className="text-gray-300 text-sm mb-4 line-clamp-2">
                    {project.description}
                  </p>

                  {/* Technologies */}
                  <div className="flex flex-wrap gap-2 mb-4">
                    {project.technologies.slice(0, 3).map((tech) => (
                      <span
                        key={tech}
                        className="px-2 py-1 bg-primary-500/20 text-primary-400 rounded text-xs font-medium"
                      >
                        {tech}
                      </span>
                    ))}
                    {project.technologies.length > 3 && (
                      <span className="px-2 py-1 bg-gray-700 text-gray-400 rounded text-xs">
                        +{project.technologies.length - 3}
                      </span>
                    )}
                  </div>

                  {/* Action Buttons */}
                  <div className="flex items-center space-x-3">
                    <motion.a
                      href={project.demo}
                      className="flex items-center space-x-1 text-primary-400 hover:text-primary-300 transition-colors"
                      whileHover={{ scale: 1.05 }}
                      onClick={(e) => e.stopPropagation()}
                    >
                      <Eye size={16} />
                      <span className="text-sm">Demo</span>
                    </motion.a>
                    <motion.a
                      href={project.github}
                      className="flex items-center space-x-1 text-gray-400 hover:text-white transition-colors"
                      whileHover={{ scale: 1.05 }}
                      onClick={(e) => e.stopPropagation()}
                    >
                      <Github size={16} />
                      <span className="text-sm">Code</span>
                    </motion.a>
                  </div>
                </div>
              </motion.div>
            ))}
          </AnimatePresence>
        </motion.div>

        {/* Project Modal */}
        <AnimatePresence>
          {selectedProject && (
            <motion.div
              className="fixed inset-0 bg-black/80 backdrop-blur-sm z-50 flex items-center justify-center p-4"
              initial={{ opacity: 0 }}
              animate={{ opacity: 1 }}
              exit={{ opacity: 0 }}
              onClick={() => setSelectedProject(null)}
            >
              <motion.div
                className="glass-effect rounded-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto"
                initial={{ scale: 0.9, opacity: 0 }}
                animate={{ scale: 1, opacity: 1 }}
                exit={{ scale: 0.9, opacity: 0 }}
                onClick={(e) => e.stopPropagation()}
              >
                <div className="p-6">
                  <div className="flex items-center justify-between mb-6">
                    <h2 className="text-2xl font-bold text-white">{selectedProject.title}</h2>
                    <button
                      onClick={() => setSelectedProject(null)}
                      className="text-gray-400 hover:text-white transition-colors"
                    >
                      ✕
                    </button>
                  </div>
                  
                  <p className="text-gray-300 mb-6">{selectedProject.longDescription}</p>
                  
                  <div className="grid md:grid-cols-2 gap-6">
                    <div>
                      <h3 className="text-lg font-semibold text-white mb-3">Technologies Used</h3>
                      <div className="flex flex-wrap gap-2">
                        {selectedProject.technologies.map((tech) => (
                          <span
                            key={tech}
                            className="px-3 py-1 bg-primary-500/20 text-primary-400 rounded-full text-sm"
                          >
                            {tech}
                          </span>
                        ))}
                      </div>
                    </div>
                    
                    <div>
                      <h3 className="text-lg font-semibold text-white mb-3">Key Features</h3>
                      <ul className="space-y-2">
                        {selectedProject.features.map((feature) => (
                          <li key={feature} className="flex items-center space-x-2 text-gray-300">
                            <Star size={14} className="text-primary-400" />
                            <span>{feature}</span>
                          </li>
                        ))}
                      </ul>
                    </div>
                  </div>
                  
                  <div className="flex items-center space-x-4 mt-6 pt-6 border-t border-gray-700">
                    <a
                      href={selectedProject.demo}
                      className="btn-primary flex items-center gap-2"
                    >
                      <ExternalLink size={20} />
                      View Demo
                    </a>
                    <a
                      href={selectedProject.github}
                      className="btn-secondary flex items-center gap-2"
                    >
                      <Github size={20} />
                      View Code
                    </a>
                  </div>
                </div>
              </motion.div>
            </motion.div>
          )}
        </AnimatePresence>
      </div>
    </section>
  )
}

export default Projects