import { ThemeItem } from './ThemeItem';
import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import Container from "../../components/ui/Container";
import { FileText, GraduationCap, Building2, File } from 'lucide-react';


function HelpPage() {
    
    return ( 
            <MainLayout >
                <div className="flex w-full justify-center">
                    <SearchBar className={"w-[90%] md:w-[80%]"} />
                </div>

                <div className="mt-6">
                    
                    <h5 className="font-semibold">
                       Fréquemment demandées
                    </h5>

                    <div className=" mt-5 flex flex-row gap-5 justify-center overflow-x-auto p-4 snap-x snap-mandatory">

                        <Container className="bg-[#BEF264] rounded shadow snap-start">
                        <p>Où puis-je télécharger la fiche <br /> de renseignement ? </p>
                        </Container>

                        <Container className="bg-[#BEF264] rounded shadow snap-start">
                        <p>Comment remplir la fiche de <br /> renseignement ?</p>
                        </Container>

                        <Container className="bg-[#BEF264] rounded shadow snap-start">
                        <p>Comment suivre l'avancée <br /> des signatures </p>
                        </Container>

                        <Container className="bg-[#BEF264] rounded shadow snap-start">
                        <p>Comment sont organisés les <br /> heures en entreprise ?</p>
                        </Container>

                    </div>

                </div>

                <div className="mt-6">

                    <h5 className="font-semibold">
                       Thèmes
                    </h5>

                    <div className="flex flex-col gap-5 mt-5 justify-center">

                        <ThemeItem  NArticles={2} icon={<FileText strokeWidth={1} />} titre={"Fiche de renseignement"}    />
                        <ThemeItem  NArticles={6} icon={<GraduationCap strokeWidth={1} />} titre={"Stagiaires"}    />
                        <ThemeItem  NArticles={4} icon={<Building2 strokeWidth={1} />} titre={"Entreprises"}    />
                        <ThemeItem  NArticles={10} icon={<File strokeWidth={1} />} titre={"Fonctionnement"}    />

                        
                    </div>

                </div>
                
    
            </MainLayout>
    
    )
}

export default HelpPage;
