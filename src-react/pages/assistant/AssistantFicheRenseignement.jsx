import React from 'react'
import MainLayout from '../../components/layout/MainLayout'
import FicheRenseignStagaire from './FicheRenseignStagiaire'
import Button from '../../components/ui/Button';
import  Container  from '../../components/ui/container';
// import InformationSheet from '../company/InformationSheet';
import CompanyForm from '../company/information_sheet/CompanyForm';
import  {LegalRepresentativeForm}  from '../company/information_sheet/LegalRepresentativeForm';
import {TrainerForm} from '../company/information_sheet/TrainerForm';



function AssistantFicheRenseignement() {
 return (
   <MainLayout>
        <div className="flex flex-col gap-4 w-full">

           {/* ---------------composant Fiche renseignement stagiaire (Mounir) ------------- */}
           <Container className={"m-4 p-1 border"}>
                <div className={"p-4 border border-gray-200 rounded-2xl w-full"}>
                    <FicheRenseignStagaire />
                </div>
            </Container>

           {/* ---------------composant -Form entreprise responsable tutteur (Saria) ------------- */}

           <Container  className={"flex flex-col md:flex-row border-0 gap-5 p-5"} > 
                <CompanyForm   companyDetails={""}/>
                <div className="flex flex-col gap-5 md:w-[35%]">
                    <LegalRepresentativeForm legalRep={""} />
                    <TrainerForm trainerDetails={""} />
                </div>
            </Container> 

           {/* ---------- Button ---------- */}
           <div className='flex p-2 flex-row gap-2 w-full mb-50'>
               <Button variant='outline' className=' w-full' > Télécharger </Button>
               <Button className=' w-full'> Valider definitivement </Button>
           </div>
        </div>
  </MainLayout>
 )
}


export default AssistantFicheRenseignement