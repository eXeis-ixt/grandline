import { Head } from '@inertiajs/react';
import DefaultLayout from '@/layouts/DefaultLayout';
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from '@/components/ui/card';
import { Badge } from '@/components/ui/badge';
import { Separator } from '@/components/ui/separator';

const WorldGovernmentPage = () => {
    const dictator = {
        name: 'Taib Hasan Alif',
        role: 'Dictator',
        title: 'Dictator Of the World',
        abilities: [
            'Advanced Observation Haki',
            'Advanced Armament Haki',
            'Advanced Conqueror\'s Haki',
            'Divine Haki',
        ],
        devilFruit: 'Unknown',
        additionalInfo: [
            'Ruler',
            'Founder',
        ],
    };

    return (
        <DefaultLayout>
            <Head title="World Government" />
            
            <div className="container mx-auto py-12 pt-35">
                <div className="max-w-4xl mx-auto space-y-6">
                    {/* Header Section */}
                    <div className="text-center space-y-2">
                        <h1 className="text-4xl font-bold tracking-tight text-foreground">World Government</h1>
                        <p className="text-lg text-foreground/80">Supreme Authority of the World</p>
                    </div>

                    <Card className="border bg-card">
                        <CardHeader className="text-center pb-2">
                            <div className="space-y-2">
                                <CardTitle className="text-3xl font-bold tracking-tight text-card-foreground">
                                    {dictator.name}
                                </CardTitle>
                                <CardDescription className="text-lg text-card-foreground/80">
                                    Supreme Leader of the World Government
                                </CardDescription>
                            </div>
                            <div className="flex justify-center gap-3 mt-4">
                                <Badge variant="destructive" className="px-4 py-1 text-base font-semibold">
                                    {dictator.role}
                                </Badge>
                                <Badge variant="outline" className="px-4 py-1 text-base">
                                    {dictator.title}
                                </Badge>
                            </div>
                        </CardHeader>

                        <CardContent className="space-y-8 pt-6">
                            <div className="space-y-4">
                                <div className="flex items-center">
                                    <h3 className="text-xl font-semibold text-card-foreground">Abilities</h3>
                                    <Separator className="flex-1 ml-4" />
                                </div>
                                <div className="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    {dictator.abilities.map((ability, index) => (
                                        <Badge 
                                            key={index} 
                                            variant="secondary"
                                            className="w-full py-2 text-base justify-center font-medium"
                                        >
                                            {ability}
                                        </Badge>
                                    ))}
                                </div>
                            </div>

                            <div className="space-y-4">
                                <div className="flex items-center">
                                    <h3 className="text-xl font-semibold text-card-foreground">Devil Fruit</h3>
                                    <Separator className="flex-1 ml-4" />
                                </div>
                                <Badge 
                                    variant="outline" 
                                    className="px-6 py-2 text-base font-medium"
                                >
                                    {dictator.devilFruit}
                                </Badge>
                            </div>

                            <div className="space-y-4">
                                <div className="flex items-center">
                                    <h3 className="text-xl font-semibold text-card-foreground">Additional Information</h3>
                                    <Separator className="flex-1 ml-4" />
                                </div>
                                <div className="flex flex-wrap gap-3">
                                    {dictator.additionalInfo.map((info, index) => (
                                        <Badge 
                                            key={index} 
                                            variant="default"
                                            className="px-4 py-1 text-base font-medium"
                                        >
                                            {info}
                                        </Badge>
                                    ))}
                                </div>
                            </div>
                        </CardContent>
                    </Card>
                </div>
            </div>
        </DefaultLayout>
    );
};

export default WorldGovernmentPage;