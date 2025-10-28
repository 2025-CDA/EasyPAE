import { FrequentlyAsked } from './FrequentlyAsked';
import { ThemeItem } from './ThemeItem';
import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import icon1 from "../../assets/Help-sheet.png";
import icon2 from "../../assets/helpSheetRoundedError.jpg";
import icon3 from "../../assets/helpSheetRoundedSign.jpg";
import Breadcrumb from '../../components/ui/Breadcrumb';
import Container from '../../components/ui/Container';
import { Avatar } from '@mui/material';



function HelpSheet() {
    
    return ( 
            <MainLayout withSearchbar = {false} >
                <div className='ml-5 mb-5'>
                    <h1 className='font-semibold'>Aides</h1>
                        <Breadcrumb content = {[
                            { title: "Aide", link: "#", isFinal: false, current: false },
                            { title: "Thème", link: "#", isFinal: false, current: false },
                            { title: "Fiche de renseignement", link: "#", isFinal: true, current: true },
                            ]}>

                        </Breadcrumb>

                </div>

                <div className="flex w-full m-5 ">
                    <SearchBar className={"w-[90%] md:w-[80%]"} />
                </div>
                

                <div className="relative mt-6 m-5 h-64 bg-cover rounded-xl" style={{backgroundImage: `url(${icon1})`}} >
                            
                            <h3 className='text-white font-semibold absolute bottom-15 left-0 m-5'>Comment remplir la fiche de renseignements</h3>
                            <p className='text-white absolute bottom-10 left-0 m-5'>Temps de lecture 5 min - 10/09/2025 </p>
                </div>

                <div className="mt-6 m-5">

                    <h5 className="font-semibold">
                       D'autres articles
                    </h5>

                    <div className="flex flex-col gap-5 mt-5 justify-center">

                    <ThemeItem avatarUrl={icon2} titre={"Comment rectifier une erreur sur ma fiche de renseignement ?"} description={"Temps de lecture 5 min - 10/09/2025"}    />
                    <ThemeItem avatarUrl={icon3} titre={"Puis-je avoir un suivi de l'avancée des signatures ?"} description={"Temps de lecture 5 min - 10/09/2025"}    />

                    </div>

                </div>
                
    
            </MainLayout>
    
    )
}

export default HelpSheet;
