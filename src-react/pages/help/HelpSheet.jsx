import { FrequentlyAsked } from './FrequentlyAsked';
import { ThemeItem } from './ThemeItem';
import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import icon1 from "../../assets/Help-sheet.png"
import Breadcrumb from '../../components/ui/Breadcrumb';


function HelpSheet() {
    
    return ( 
            <MainLayout withSearchbar = {false} >
                <div className='m-5'>
                <h1 className='font-bold'>Aides</h1>
                <Breadcrumb content = {[
        { title: "Aide", link: "#", isFinal: false, current: false },
        { title: "Thème", link: "#", isFinal: false, current: false },
        { title: "Fiche de renseignement", link: "#", isFinal: true, current: true },
    ]}></Breadcrumb>
                </div>
                    <SearchBar className={"w-[90%Ò] md:w-[80%] self-center"} />
                <div className="mt-6 m-5">
                

                </div>

                <div className="mt-6 m-5">

                    <h5 className="font-semibold">
                       D'autres articles
                    </h5>

                    <div className="flex flex-col gap-5 mt-5 justify-center">

                        <ThemeItem  titre={"Comment rectifier une erreur sur ma fiche de renseignement ?"} description={"Temps de lecture 5 min - 10/09/2025"}    />
                        <ThemeItem  titre={"Puis-je avoir un suivi de l'avancée des signatures ?"} description={"Temps de lecture 5 min - 10/09/2025"}    />

                    </div>

                </div>
                
    
            </MainLayout>
    
    )
}

export default HelpSheet;
