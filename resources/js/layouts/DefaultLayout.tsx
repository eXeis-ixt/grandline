import React, { PropsWithChildren, useEffect } from 'react'
import { initializeTheme } from '../hooks/use-appearance'

const DefaultLayout = ({children}: PropsWithChildren) => {
  useEffect(() => {
    initializeTheme()
  }, [])

  return (
    <div className=' texture'>
        {children}
    </div>
  )
}

export default DefaultLayout