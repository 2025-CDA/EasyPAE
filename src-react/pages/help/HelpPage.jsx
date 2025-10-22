import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import Container from "../../components/ui/Container";
import { FileText, GraduationCap, Building2, File } from 'lucide-react';


function HelpPage() {
    
    return ( 
            <MainLayout>
                <div className="w-full">
                    <SearchBar className={"w-[90%] md:w-[80%]"} />
                </div>

                <div className="mt-6">
                    
                    <h5 className="font-semibold">
                       Fréquemment demandées
                    </h5>

                    <div className=" mt-5 flex flex-row gap-5 justify-center">

                        <Container className="bg-[#BEF264]">
                        <p>Où puis-je télécharger la fiche <br /> de renseignement ? </p>
                        </Container>

                        <Container className="bg-[#BEF264]">
                        <p>Comment remplir la fiche de <br /> renseignement ?</p>
                        </Container>

                        <Container className="bg-[#BEF264]">
                        <p>Comment suivre l'avancée <br /> des signatures </p>
                        </Container>

                        <Container className="bg-[#BEF264]">
                        <p>Comment sont organisés les <br /> heures en entreprise ?</p>
                        </Container>

                    </div>

                </div>

                <div className="mt-6">

                    <h5 className="font-semibold">
                       Thèmes
                    </h5>

                    <div className="flex flex-col gap-5 mt-5">
                        <Container>
                            <FileText />
                            <h5>Fiche de renseignements</h5>
                            <p>2 articles</p>
                        </Container>
                        <Container>
                            <GraduationCap />
                            <h5>Fiche de renseignements</h5>
                        </Container>
                        <Container >
                            <Building2 />    
                            <h5>Fiche de renseignements</h5>
                        </Container>

                        <Container>
                            <File />
                            <h5>Fiche de renseignements</h5>
                        </Container>
                        
                    </div>

                </div>
                
    
            </MainLayout>
    
    )
}

export default HelpPage;
