import { Separator } from "@/components/ui/separator"

const Footer = () => {
  return (
    <footer className="border-t mt-auto bg-card">
      <div className="container mx-auto py-8">
        <div className="flex flex-col items-center justify-center space-y-3">
          <div className="flex items-center space-x-2 text-base">
            <span className="text-card-foreground">Made with ❤️ by</span>
            <span className="font-bold text-card-foreground hover:text-primary transition-colors">
              The Bloodwake Dynasty Crew
            </span>
          </div>
          <Separator className="w-48" />
          <div className="text-sm text-card-foreground/80">
            Under Grandline Verse Bangladesh
          </div>
        </div>
      </div>
    </footer>
  )
}

export default Footer 
