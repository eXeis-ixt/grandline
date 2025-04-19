import React, { PropsWithChildren, useEffect } from 'react'
import { initializeTheme } from '../hooks/use-appearance'
import Navbar from '@/components/Navbar'
import Footer from '@/components/Footer'

const DefaultLayout = ({children}: PropsWithChildren) => {
  useEffect(() => {
    initializeTheme()
  }, [])

  return (
    <div className="min-h-screen bg-background flex flex-col justify-between">
      <div>
        <Navbar />
        <main className="min-h-[calc(100vh-14rem)]">
          {children}
        </main>
      </div>
      <Footer />
    </div>
  )
}

export default DefaultLayout