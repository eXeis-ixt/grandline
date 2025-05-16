import { Button } from '../components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../components/ui/card'
import { Badge } from '../components/ui/badge'
import { motion } from 'framer-motion'
import Navbar from '../components/Navbar'
import { Avatar, AvatarFallback } from '../components/ui/avatar'
import { Head, Link } from '@inertiajs/react'
import DefaultLayout from '@/layouts/DefaultLayout'

// Types for our data structure
type CrewMember = {
  id: number
  name: string
  role: string
  bounty: number
}

type Crew = {
  id: number
  name: string
  description: string
  members: CrewMember[]
  sea_id: number
  total_bounty: number | null
  members_count: number
  highest_bounty: number | null
  slug: string
}

type Sea = {
  id: number
  name: string
  description: string
}

interface LeaderboardProps {
  crews?: Crew[]  // Make crews optional
  seas?: Sea[]    // Make seas optional
}

const formatBounty = (bounty: number | null): string => {
  if (bounty === null || bounty === undefined) return '0';
  
  if (bounty >= 1000000000) {
    return `${(bounty / 1000000000).toFixed(1)}B`
  }
  if (bounty >= 1000000) {
    return `${(bounty / 1000000).toFixed(0)}M`
  }
  return bounty.toLocaleString()
}

const Leaderboard = ({ crews = [], seas = [] }: LeaderboardProps) => {  // Add default empty arrays
  // Sort crews by total bounty in descending order
  const sortedCrews = [...(crews || [])].sort((a, b) => {
    const bountyA = a.total_bounty || 0
    const bountyB = b.total_bounty || 0
    return bountyB - bountyA
  })

  return (
    <DefaultLayout >
   <Head>
    <title>Leaderboard - Grandline</title>
    <meta name="description" content="Leaderboard of the most wanted pirates and crews in the Grand Line" />
   </Head>
      
      {/* Hero Section */}
      <section className="relative overflow-hidden pt-32">
        <div className="absolute inset-0 -z-10">
          <motion.img
            initial={{ opacity: 0 }}
            animate={{ opacity: 0.8 }}
            transition={{ duration: 1.5 }}
            src="/wanted-poster-bg.jpg"
            alt="Wanted Posters Background"
            className="absolute inset-0 w-full h-full object-cover"
            style={{ filter: 'brightness(0.7)' }}
          />
        </div>
        <div className="container mx-auto px-4 py-16">
          <div className="max-w-4xl mx-auto text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            >
              <Badge variant="destructive" className="mb-4 text-lg px-4 py-2">Most Wanted</Badge>
              <h1 className="text-4xl md:text-7xl font-bold mb-6">
                Pirate Crews Leaderboard
              </h1>
              <p className="text-2xl mb-12 max-w-2xl mx-auto leading-relaxed">
                Track the most notorious crews across all seas. Updated in real-time with the latest bounty information.
              </p>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Top Crews Extended Section */}
      <section className="py-24">
        <div className="container mx-auto px-4">
          {sortedCrews.length === 0 ? (
            <Card className="p-12 text-center backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
              <CardTitle className="text-2xl mb-4">No Crews Found</CardTitle>
              <CardDescription className="text-lg">
                There are currently no pirate crews registered in our database.
              </CardDescription>
            </Card>
          ) : (
            <div className="grid gap-8">
              {sortedCrews.map((crew, index) => {
                const sea = seas.find(s => s.id === crew.sea_id);
                return (
                  <motion.div
                    key={crew.id}
                    initial={{ opacity: 0, y: 20 }}
                    whileInView={{ opacity: 1, y: 0 }}
                    transition={{ duration: 0.8, delay: index * 0.1 }}
                    viewport={{ once: true }}
                  >
                    <Card className="hover:shadow-xl transition-all duration-300 relative overflow-hidden backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                      {index < 3 && (
                        <div className="absolute -right-12 top-6 rotate-45 bg-red-500 text-white px-12 py-1 text-sm">
                          Top {index + 1}
                        </div>
                      )}
                      <div className="grid md:grid-cols-4 gap-6 p-6">
                        <div className="md:col-span-2">
                          <div className="flex items-center justify-between mb-4">
                            <Badge 
                              variant={index < 3 ? "destructive" : "outline"} 
                              className="text-lg px-4 py-2"
                            >
                              Rank #{index + 1}
                            </Badge>
                            <Badge variant="secondary" className="bg-transparent text-lg">
                              {sea?.name || 'Unknown Sea'}
                            </Badge>
                          </div>
                          <CardTitle className="text-3xl mb-4">{crew.name}</CardTitle>
                          <CardDescription className="text-lg">
                            {crew.description}
                          </CardDescription>
                        </div>
                        
                        <div className="space-y-4">
                          <div>
                            <div className="text-sm opacity-70 mb-1">Total Bounty</div>
                            <div className="text-3xl font-bold text-red-500">
                              ฿{formatBounty(crew.total_bounty)}
                            </div>
                          </div>
                          <div>
                            <div className="text-sm opacity-70 mb-1">Highest Single Bounty</div>
                            <div className="text-xl font-semibold">
                              ฿{formatBounty(crew.highest_bounty)}
                            </div>
                          </div>
                        </div>
                        
                        <div className="space-y-4">
                          <div>
                            <div className="text-sm opacity-70 mb-1">Crew Size</div>
                            <div className="text-xl font-semibold">
                              {crew.members_count} Pirates
                            </div>
                          </div>
                          <Button 
                            variant="outline" 
                            className="w-full border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white"
                            asChild
                          >
                            <Link href={`/crews/${crew.slug}`}>
                              View Details
                            </Link>
                          </Button>
                        </div>
                      </div>
                    </Card>
                  </motion.div>
                );
              })}
            </div>
          )}
        </div>
      </section>

      {/* CTA Section */}
      <section className="py-24">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <Card className="max-w-4xl mx-auto p-12 backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
              <CardHeader className="p-0 mb-8">
                <Badge variant="destructive" className="mb-4 text-lg px-4 py-2">Join the Rankings</Badge>
                <CardTitle className="text-4xl text-center">Think You Have What it Takes?</CardTitle>
                <CardDescription className="text-xl text-center mt-4">
                  Register your crew and start building your reputation in the Grand Line
                </CardDescription>
              </CardHeader>
              <CardFooter className="p-0 flex justify-center gap-4">
                <Button variant="destructive" size="lg" className="px-12 py-6 text-lg">
                  Register Your Crew
                </Button>
                <Button 
                  variant="outline" 
                  size="lg" 
                  className="px-12 py-6 text-lg border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white"
                >
                  Learn More
                </Button>
              </CardFooter>
            </Card>
          </motion.div>
        </div>
      </section>
    </DefaultLayout>
  )
}

export default Leaderboard 
