import { FrequentlyAsked } from './FrequentlyAsked';
import { ThemeItem } from './ThemeItem';
import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import icon1 from "../../assets/Help-sheet.png";
import Breadcrumb from '../../components/ui/Breadcrumb';
import internInformationForm from '../../assets/internInformationForm.png';





function HelpSheet() {
    
    return ( 
            <MainLayout withSearchbar = {false} >
                <div className='ml-5 mb-5'>
                    <h1 className='font-semibold'>Aides</h1>
                        <Breadcrumb content = {[
                            { title: "Aide", link: "#", isFinal: false, current: false },
                            { title: "Thème", link: "#", isFinal: false, current: false },
                            { title: "Fiche de renseignement", link: "#", isFinal: false, current: false },
                             { title: "Comment remplir la fiche de renseignement ?", link: "#", isFinal: true, current: true }
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

                    <h2 className="font-semibold">
                       Comment remplir ma fiche de renseignements
                    </h2>

                    
                    <div className='flex flex-row gap-5 mt-8'>
                        <div className='bg-[#BEF264] rounded-full w-24 h-24 flex items-center justify-center'>
                            <p className='font-semibold text-3xl'>1</p>
                        </div>

                        <div className="flex flex-col justify-center font-semibold">

                                <h3>STAGIAIRE</h3>
                                <p className="text-secondary-text font-light">Le stagiaire rempli UNIQUEMENT la partie haute du document. </p>

                        </div>
                    </div>
                    <div className="flex justify-center items-center mt-5"> 
                        <img src={internInformationForm} alt="" />
                    </div>
                    
                    <div className='flex flex-row gap-5 mt-8'>
                        <div className='bg-[#BEF264] rounded-full w-24 h-24 flex items-center justify-center'>
                            <p className='font-semibold text-3xl'>2</p>
                        </div>

                        <div className="flex flex-col justify-center font-semibold">

                                <h3>ENTREPRISE</h3>
                                <p className="text-secondary-text font-light">L'entreprise rempli UNIQUEMENT la partie centrale du document. </p>

                        </div>
                    </div>
                    <div className="flex justify-center items-center mt-5"> 
                        <img src={internInformationForm} alt="" />
                    </div>

                    <div className='flex flex-row gap-5 mt-8'>
                        <div className='bg-[#BEF264] rounded-full w-24 h-24 flex items-center justify-center'>
                            <p className='font-semibold text-3xl'>3</p>
                        </div>

                        <div className="flex flex-col justify-center font-semibold">

                                <h3>FORMATEUR</h3>
                                <p className="text-secondary-text font-light">Le formateur rempli UNIQUEMENT la partie basse du document. </p>

                        </div>
                    </div>
                    <div className="flex justify-center items-center mt-5"> 
                        <img src={internInformationForm} alt="" />
                    </div>
                    
                </div>
                
    
            </MainLayout>
    
    )
}

export default HelpSheet;
