import { useState } from 'react'
import { Button } from './ui/button'
import { Badge } from './ui/badge'
import { motion } from 'framer-motion'
import { Menu, X } from 'lucide-react'
import { Link } from '@inertiajs/react'

const Navbar = () => {
  const [isOpen, setIsOpen] = useState(false)

  const navItems = [
    { name: 'Home', href: '/' },
    { name: 'About', href: '#about' },
    { name: 'World Government', href: '/world-government' },
    { name: 'Leaderboard', href: '/leaderboard' },
    { name: 'Marines', href: '/marines' },
    
  ]

  return (
    <nav className="fixed top-0 left-0 right-0 z-50 bg-background/80 backdrop-blur-sm border-b">
      <div className="container mx-auto px-4">
        <div className="flex items-center justify-between h-20">
          {/* Logo */}
          <div className="flex items-center">
            <Badge variant="outline" className="text-lg px-4 py-2">
              Grandline
            </Badge>
          </div>

          {/* Desktop Navigation */}
          <div className="hidden md:flex items-center gap-8">
            {navItems.map((item) => (
              <Link prefetch
                key={item.name}
                href={item.href}
                className="text-lg font-medium hover:text-yellow-500 transition-colors"
              >
                {item.name}
              </Link>
            ))}
            <a href='https://www.facebook.com/groups/1272043480532115' className=' cursor-pointer' target='_blank'>
            <Button variant="destructive" size="lg">
              Join Crew
            </Button>
            </a>
          </div>

          {/* Mobile Menu Button */}
          <div className="md:hidden">
            <Button
              variant="ghost"
              size="icon"
              onClick={() => setIsOpen(!isOpen)}
              className="h-10 w-10"
            >
              {isOpen ? <X className="h-6 w-6" /> : <Menu className="h-6 w-6" />}
            </Button>
          </div>
        </div>

        {/* Mobile Navigation */}
        <motion.div
          initial={{ opacity: 0, height: 0 }}
          animate={{ opacity: isOpen ? 1 : 0, height: isOpen ? 'auto' : 0 }}
          transition={{ duration: 0.3 }}
          className={`md:hidden ${isOpen ? 'block' : 'hidden'}`}
        >
          <div className="py-4 space-y-4">
            {navItems.map((item) => (
              <a
                key={item.name}
                href={item.href}
                className="block text-lg font-medium hover:text-yellow-500 transition-colors"
                onClick={() => setIsOpen(false)}
              >
                {item.name}
              </a>
            ))}
            <a href='https://www.facebook.com/groups/1272043480532115' target='_blank'>
            <Button variant="destructive" size="lg" className="w-full">
              Join Crew
            </Button>
            </a>
          </div>
        </motion.div>
      </div>
    </nav>
  )
}

export default Navbar 