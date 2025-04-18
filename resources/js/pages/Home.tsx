import { Button } from '../components/ui/button'
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '../components/ui/card'
import { Badge } from '../components/ui/badge'
import { Avatar, AvatarFallback, AvatarImage } from '../components/ui/avatar'
import { motion } from 'framer-motion'
import Navbar from '../components/Navbar'
import { MaskedImage } from '../components/ui/masked-image'

// Types for our data
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
}

type Sea = {
  id: number
  name: string
  description: string
  crews: Crew[]
}

type TopCrew = {
  id: number
  name: string
  description: string
  sea_id: number
  total_bounty: number | null
  members_count: number
  highest_bounty: number | null
}

interface HomeProps {
  seas: Sea[]
  topCrews: TopCrew[]
}

const calculateTotalBounty = (crews: Crew[]): number => {
  if (!crews || !Array.isArray(crews)) return 0;
  
  return crews.reduce((total, crew) => {
    if (!crew.members || !Array.isArray(crew.members)) return total;
    
    return total + crew.members.reduce((crewTotal, member) => 
      crewTotal + (member?.bounty || 0)
    , 0)
  }, 0)
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

// Map coordinates for each sea - adjusted to match the map image
const seaCoordinates = {
  'East Blue': { x: '20%', y: '65%' },
  'Grand Line Paradise': { x: '50%', y: '50%' },
  'New World': { x: '80%', y: '35%' },
}

const Home = ({ seas, topCrews }: HomeProps) => {
  // Find the sea with the highest total bounty
  const getBestSea = (seas: Sea[]): Sea => {
    if (!seas || !Array.isArray(seas)) return seas[0];

    return seas.reduce((best, current) => {
      if (!best || !current) return best || current;
      
      const currentTotal = calculateTotalBounty(current.crews || []);
      const bestTotal = calculateTotalBounty(best.crews || []);
      return currentTotal > bestTotal ? current : best;
    }, seas[0]);
  }

  const bestSea = getBestSea(seas);

  return (
    <div className="min-h-screen">
      <Navbar />
      
      {/* Hero Section with map background */}
      <section className="relative overflow-hidden pt-32">
        <div className="absolute inset-0 -z-10">
          <motion.img
            initial={{ opacity: 0 }}
            animate={{ opacity: 0.8 }}
            transition={{ duration: 1.5 }}
            src="/about-us.jpg"
            alt="Grandline Hero"
            className="absolute inset-0 w-full h-full object-cover"
            style={{ filter: 'brightness(0.7)' }}
          />
        </div>
        <div className="container mx-auto px-4 py-32">
          <div className="max-w-4xl mx-auto text-center">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            >
              <Badge variant="outline" className="mb-4 text-lg px-4 py-2">Welcome to the New Era</Badge>
              <h1 className="text-7xl font-bold mb-6">
                Grandline
              </h1>
              <p className="text-2xl mb-12 max-w-2xl mx-auto leading-relaxed">
                Setting Sail Towards the New Era of Adventure. Join our crew and embark on an unforgettable journey.
              </p>
              <div className="flex justify-center gap-6">
                <Button variant="destructive" size="lg" className="px-8">
                  Join Our Crew
                </Button>
                <Button variant="outline" size="lg" className="border-yellow-500 text-yellow-500 hover:bg-yellow-500 hover:text-white px-8">
                  Learn More
                </Button>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Features Section */}
      <section id="features" className="py-24">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <h2 className="text-4xl font-bold mb-4">Why Choose Grandline?</h2>
            <p className="text-xl max-w-2xl mx-auto">
              Experience the adventure of a lifetime with our unique features
            </p>
          </motion.div>
          <div className="grid md:grid-cols-3 gap-8">
            {[
              { title: 'Adventure', description: 'Embark on epic journeys across the Grand Line' },
              { title: 'Community', description: 'Join a vibrant community of passionate fans' },
              { title: 'Growth', description: 'Develop your skills and achieve your dreams' }
            ].map((feature, index) => (
              <motion.div
                key={feature.title}
                initial={{ opacity: 0, y: 20 }}
                whileInView={{ opacity: 1, y: 0 }}
                transition={{ duration: 0.8, delay: index * 0.2 }}
                viewport={{ once: true }}
              >
                <Card className="h-full p-8 hover:shadow-lg transition-all duration-300 backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader className="p-0">
                    <CardTitle className="text-2xl mb-4">{feature.title}</CardTitle>
                    <CardDescription className="text-lg">
                      {feature.description}
                    </CardDescription>
                  </CardHeader>
                </Card>
              </motion.div>
            ))}
          </div>
        </div>
      </section>

      {/* Top Crews Section */}
      <section id="top-crews" className="py-24">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
            className="text-center mb-16"
          >
            <Badge variant="outline" className="mb-4 text-lg px-4 py-2">Most Wanted</Badge>
            <h2 className="text-4xl font-bold mb-4">Top Pirate Crews</h2>
            <p className="text-xl max-w-2xl mx-auto">
              The most notorious crews sailing the seas
            </p>
          </motion.div>

          <div className="grid md:grid-cols-3 gap-8">
            {topCrews.map((crew, index) => {
              const sea = seas.find(s => s.id === crew.sea_id);
              return (
                <motion.div
                  key={crew.id}
                  initial={{ opacity: 0, y: 20 }}
                  whileInView={{ opacity: 1, y: 0 }}
                  transition={{ duration: 0.8, delay: index * 0.2 }}
                  viewport={{ once: true }}
                >
                  <Card className="h-full hover:shadow-xl transition-all duration-300 relative overflow-hidden backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                    {index === 0 && (
                      <div className="absolute -right-12 top-6 rotate-45 bg-red-500 text-white px-12 py-1 text-sm">
                        Most Wanted
                      </div>
                    )}
                    <CardHeader>
                      <div className="flex items-center justify-between">
                        <Badge variant={index === 0 ? "destructive" : "outline"} className="mb-2">
                          Rank #{index + 1}
                        </Badge>
                        <Badge variant="secondary" className="bg-transparent">
                          {sea?.name}
                        </Badge>
                      </div>
                      <CardTitle className="text-2xl">{crew.name}</CardTitle>
                      <CardDescription className="text-base">
                        {crew.description}
                      </CardDescription>
                    </CardHeader>
                    <CardContent>
                      <div className="space-y-4">
                        <div>
                          <div className="text-sm opacity-70 mb-1">Total Bounty</div>
                          <div className="text-2xl font-bold text-red-500">
                            ฿{formatBounty(crew.total_bounty)}
                          </div>
                        </div>
                        <div className="grid grid-cols-2 gap-4">
                          <div>
                            <div className="text-sm opacity-70 mb-1">Crew Size</div>
                            <div className="text-lg font-semibold">{crew.members_count} Pirates</div>
                          </div>
                          <div>
                            <div className="text-sm opacity-70 mb-1">Highest Bounty</div>
                            <div className="text-lg font-semibold">฿{formatBounty(crew.highest_bounty)}</div>
                          </div>
                        </div>
                      </div>
                    </CardContent>
                  </Card>
                </motion.div>
              );
            })}
          </div>
        </div>
      </section>

      {/* Interactive Map Section */}
   

      {/* About Section */}
      <section id="about" className="py-24">
        <div className="container mx-auto px-4">
          <div className="grid md:grid-cols-2 gap-16 items-center">
            <motion.div
              initial={{ opacity: 0, x: -20 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8 }}
              viewport={{ once: true }}
            >
              <Badge variant="outline" className="mb-4 text-lg px-4 py-2">Our Story</Badge>
              <h2 className="text-5xl font-bold mb-6">About Grandline</h2>
              <p className="text-xl mb-8 leading-relaxed">
                We are a passionate group of One Piece enthusiasts dedicated to exploring the vast world of the Grand Line. 
                Our crew consists of nakama from all corners of the world, united by our love for adventure and the pursuit of dreams.
              </p>
              <div className="flex gap-4">
                <Badge variant="destructive" className="text-lg px-4 py-2">Adventure</Badge>
                <Badge variant="secondary" className="text-lg px-4 py-2 bg-transparent">Friendship</Badge>
                <Badge variant="outline" className="border-yellow-500 text-yellow-500 text-lg px-4 py-2">Dreams</Badge>
              </div>
            </motion.div>
            <motion.div
              initial={{ opacity: 0, x: 20 }}
              whileInView={{ opacity: 1, x: 0 }}
              transition={{ duration: 0.8 }}
              viewport={{ once: true }}
              className="relative w-full overflow-hidden px-4 md:px-0"
            >
              <div className="max-w-[600px] mx-auto">
                <MaskedImage
                  src="/about-us.jpg"
                  alt="About Grandline"
                  width={600}
                  height={400}
                  variant="shape6"
                  className="w-full hidden md:block h-auto max-w-full object-cover"
                />
              </div>
            </motion.div>
          </div>
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
                <Badge variant="outline" className="mb-4 text-lg px-4 py-2">Join Us</Badge>
                <CardTitle className="text-4xl text-center">Ready to Join Our Crew?</CardTitle>
                <CardDescription className="text-xl text-center mt-4">
                  Become part of our adventure and make your mark on the Grand Line
                </CardDescription>
              </CardHeader>
              <CardContent className="p-0 mb-8">
                <p className="text-xl text-center leading-relaxed">
                  We're always looking for new nakama to join our crew. Whether you're a seasoned pirate or just starting your journey,
                  there's a place for you in Grandline.
                </p>
              </CardContent>
              <CardFooter className="p-0 flex justify-center">
                <Button variant="destructive" size="lg" className="px-12 py-6 text-lg">
                  Set Sail With Us
                </Button>
              </CardFooter>
            </Card>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default Home