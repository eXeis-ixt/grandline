import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '../../components/ui/card'
import { Badge } from '../../components/ui/badge'
import { motion } from 'framer-motion'
import Navbar from '../../components/Navbar'
import { Head } from '@inertiajs/react'
import {
  Table,
  TableBody,
  TableCaption,
  TableCell,
  TableHead,
  TableHeader,
  TableRow,
} from "../../components/ui/table"

type CrewMember = {
  id: number
  name: string
  role: string
  bounty: number
}

type Sea = {
  id: number
  name: string
  description: string
}

type Crew = {
  id: number
  name: string
  description: string
  sea: Sea
  members: CrewMember[]
  total_bounty: number
  highest_bounty: number
  members_count: number
}

interface ShowProps {
  crew: Crew
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

const Show = ({ crew }: ShowProps) => {
  return (
    <div className="min-h-screen">
      <Head>
        <title>{`${crew.name} - Grandline Pirate Crew`}</title>
        <meta name="description" content={`${crew.name} is a powerful pirate crew from ${crew.sea.name} with a total bounty of ฿${formatBounty(crew.total_bounty)}. Learn about their members and achievements.`} />
        <meta name="keywords" content={`${crew.name}, pirate crew, ${crew.sea.name}, One Piece, bounty, ${crew.members.map(m => m.name).join(', ')}`} />
        <meta property="og:title" content={`${crew.name} - Grandline Pirate Crew`} />
        <meta property="og:description" content={`${crew.name} is a powerful pirate crew from ${crew.sea.name} with a total bounty of ฿${formatBounty(crew.total_bounty)}.`} />
        <meta property="og:type" content="website" />
        <meta name="twitter:card" content="summary" />
        <meta name="twitter:title" content={`${crew.name} - Grandline Pirate Crew`} />
        <meta name="twitter:description" content={`${crew.name} is a powerful pirate crew from ${crew.sea.name} with a total bounty of ฿${formatBounty(crew.total_bounty)}.`} />
      </Head>
      
      <Navbar />
      
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
          <div className="max-w-4xl mx-auto">
            <motion.div
              initial={{ opacity: 0, y: 20 }}
              animate={{ opacity: 1, y: 0 }}
              transition={{ duration: 0.8 }}
            >
              <Badge variant="secondary" className="mb-4 text-lg px-4 py-2 bg-transparent">
                {crew.sea.name}
              </Badge>
              <h1 className="text-7xl font-bold mb-6">
                {crew.name}
              </h1>
              <p className="text-2xl mb-12 max-w-2xl leading-relaxed">
                {crew.description}
              </p>
              <div className="grid md:grid-cols-3 gap-8">
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Total Bounty</CardDescription>
                    <CardTitle className="text-2xl text-red-500">฿{formatBounty(crew.total_bounty)}</CardTitle>
                  </CardHeader>
                </Card>
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Highest Bounty</CardDescription>
                    <CardTitle className="text-2xl text-red-500">฿{formatBounty(crew.highest_bounty)}</CardTitle>
                  </CardHeader>
                </Card>
                <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
                  <CardHeader>
                    <CardDescription className="text-sm">Crew Size</CardDescription>
                    <CardTitle className="text-2xl">{crew.members_count} Pirates</CardTitle>
                  </CardHeader>
                </Card>
              </div>
            </motion.div>
          </div>
        </div>
      </section>

      {/* Members Table Section */}
      <section className="py-24">
        <div className="container mx-auto px-4">
          <motion.div
            initial={{ opacity: 0, y: 20 }}
            whileInView={{ opacity: 1, y: 0 }}
            transition={{ duration: 0.8 }}
            viewport={{ once: true }}
          >
            <Card className="backdrop-blur-sm bg-white/30 dark:bg-gray-800/30 border-0">
              <CardHeader>
                <CardTitle className="text-3xl">Crew Members</CardTitle>
                <CardDescription>
                  Listed by bounty amount in descending order
                </CardDescription>
              </CardHeader>
              <CardContent>
                <Table>
                  <TableHeader>
                    <TableRow>
                      <TableHead className="w-[50px] text-lg py-4">Rank</TableHead>
                      <TableHead className="text-lg py-4">Name</TableHead>
                      <TableHead className="text-lg py-4">Role</TableHead>
                      <TableHead className="text-lg py-4 text-right">Bounty</TableHead>
                    </TableRow>
                  </TableHeader>
                  <TableBody>
                    {crew.members.map((member, index) => (
                      <TableRow key={member.id}>
                        <TableCell className="font-medium text-lg py-4">#{index + 1}</TableCell>
                        <TableCell className="text-lg py-4">{member.name}</TableCell>
                        <TableCell className="text-lg py-4">{member.role}</TableCell>
                        <TableCell className="text-lg py-4 text-right text-red-500">
                          ฿{formatBounty(member.bounty)}
                        </TableCell>
                      </TableRow>
                    ))}
                  </TableBody>
                </Table>
              </CardContent>
            </Card>
          </motion.div>
        </div>
      </section>
    </div>
  )
}

export default Show 