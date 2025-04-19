import { Head } from '@inertiajs/react'
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../../components/ui/card'
import { Badge } from '../../components/ui/badge'
import { motion } from 'framer-motion'
import Navbar from '../../components/Navbar'
import DefaultLayout from '@/layouts/DefaultLayout'

type Marine = {
  id: number
  name: string
  rank: string
  description: string
  status: string
  division: string
  specialty: string
  bounty: number | null
  sea: {
    id: number
    name: string
  }
}

interface ShowProps {
  marine: Marine
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

const Show = ({ marine }: ShowProps) => {
  return (
    <DefaultLayout>
      <Head>
        <title>{`${marine.name} - Marine Officer`}</title>
        <meta name="description" content={`Details about ${marine.name}, ${marine.rank} of the Marines.`} />
      </Head>

  
      
      <section className="relative overflow-hidden pt-32">
        <div className="absolute inset-0 -z-10">
          <motion.img
            initial={{ opacity: 0 }}
            animate={{ opacity: 0.8 }}
            transition={{ duration: 1.5 }}
            src="/marine-headquarters.jpg"
            alt="Marine Headquarters"
            className="absolute inset-0 w-full h-full object-cover"
            style={{ filter: 'brightness(0.7)' }}
          />
        </div>
        <div className="container mx-auto px-4 py-16">
          <div className="max-w-4xl mx-auto">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            >
              <Badge className={`${getRankColor(marine.rank)} text-white mb-4 text-lg px-4 py-2`}>
                {marine.rank}
              </Badge>
              <h1 className="text-7xl font-bold mb-6">
                {marine.name}
              </h1>
              <p className="text-2xl mb-12 max-w-2xl leading-relaxed">
                {marine.description}
              </p>
              <div className="grid md:grid-cols-4 gap-8">
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Status</CardDescription>
                    <CardTitle>
                      <Badge className={`${getStatusColor(marine.status)} text-white`}>
                        {marine.status}
                      </Badge>
                    </CardTitle>
                  </CardHeader>
                </Card>
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Division</CardDescription>
                    <CardTitle className="text-xl">{marine.division}</CardTitle>
                  </CardHeader>
                </Card>
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Specialty</CardDescription>
                    <CardTitle className="text-xl">{marine.specialty}</CardTitle>
                  </CardHeader>
                </Card>
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Sea</CardDescription>
                    <CardTitle>
                      <Badge variant="outline">{marine.sea.name}</Badge>
                    </CardTitle>
                  </CardHeader>
                </Card>
              </div>
            </motion.div>
          </div>
        </div>
      </section>
    </DefaultLayout>
  )
}

export default Show 