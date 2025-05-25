import { Head } from '@inertiajs/react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../../components/ui/card'
import { Badge } from '../../components/ui/badge'
import Navbar from '../../components/Navbar'
import { motion } from 'framer-motion'

type Marine = {
  id: number
  name: string
  rank: string
  description: string
  status: string
  division: string
  specialty: string
  bounty: number
  sea: {
    id: number
    name: string
  }
}

interface IndexProps {
  marines: Marine[]
}

const getRankColor = (rank: string) => {
  switch (rank) {
    case 'Fleet Admiral':
      return 'bg-red-500'
    case 'Admiral':
      return 'bg-yellow-500'
    case 'Vice Admiral':
      return 'bg-blue-500'
    default:
      return 'bg-gray-500'
  }
}

const formatBounty = (bounty: number | null): string => {
  if (bounty === null) return '0'
  if (bounty >= 1000000000) {
    return `${(bounty / 1000000000).toFixed(1)}B`
  }
  if (bounty >= 1000000) {
    return `${(bounty / 1000000).toFixed(0)}M`
  }
  return bounty.toLocaleString()
}

const getStatusColor = (status: string) => {
  switch (status) {
    case 'active':
      return 'bg-green-500'
    case 'retired':
      return 'bg-gray-500'
    case 'deceased':
      return 'bg-black'
    default:
      return 'bg-gray-500'
  }
}

const Index = ({ marines }: IndexProps) => {
  return (
    <div className="min-h-screen">
      <Head>
        <title>Marine Officers - Grandline</title>
        <meta name="description" content="List of Marine Officers in the One Piece world" />
      </Head>

      <Navbar />

      <section className="relative overflow-hidden pt-32">
        <div className="container mx-auto px-4 py-16">
          <div className="max-w-6xl mx-auto">
            <Badge variant="outline" className="mb-4 text-lg px-4 py-2">Marine Officers</Badge>
            <h1 className="text-5xl font-bold mb-6">Marine Headquarters</h1>
            <p className="text-xl mb-12 max-w-3xl leading-relaxed">
              The Marines are the World Government's military sea force, tasked with law enforcement, international security, and military operations.
            </p>

            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              {marines.map((marine, index) => (
                <motion.div
                  key={marine.id}
                  initial={{ opacity: 0, y: 20 }}
                  animate={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.5, delay: index * 0.1 }}
                >
                  <Card className="h-full backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0 hover:shadow-lg transition-all duration-300">
                    <CardHeader>
                      <div className="flex items-center justify-between mb-4">
                        <Badge className={`${getRankColor(marine.rank)} text-white`}>
                          {marine.rank}
                        </Badge>
                        <Badge className={`${getStatusColor(marine.status)} text-white`}>
                          {marine.status}
                        </Badge>
                      </div>
                      <CardTitle className="text-2xl">{marine.name}</CardTitle>
                      <CardDescription className="text-base mt-2">
                        {marine.description}
                      </CardDescription>
                    </CardHeader>
                    <CardContent>
                      <div className="space-y-4">
                       {marine.bounty !== null && (
                       <div>
                          <div className="text-sm opacity-70 mb-1">Bounty</div>
                          <div className="text-lg font-semibold">฿{formatBounty(marine.bounty)}</div>
                        </div>
                        )}
                        <div>
                          <div className="text-sm opacity-70 mb-1">Division</div>
                          <div className="text-lg font-semibold">{marine.division}</div>
                        </div>
                        <div>
                          <div className="text-sm opacity-70 mb-1">Specialty</div>
                          <div className="text-lg font-semibold">{marine.specialty}</div>
                        </div>
                        <div>
                          <div className="text-sm opacity-70 mb-1">Sea</div>
                          <Badge variant="outline">{marine.sea.name}</Badge>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>
              ))}
            </div>
          </div>
        </div>
      </section>
    </div>
  )
}

export default Index
