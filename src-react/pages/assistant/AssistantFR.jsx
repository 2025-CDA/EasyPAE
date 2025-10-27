import React from 'react'
import Test from "../../components/ui/Test"
import MainLayout from '../../components/layout/MainLayout'
import FicheRenseignStagaire from './FicheRenseignStagaire'
import Button from '../../components/ui/Button';


function AssistantFR() {
 return (
   <MainLayout>
       <div className="flex flex-col gap-2">


           {/* ---------------composant Fiche renseignement stagiaire ------------- */}
           <div className='border border-gray-200 rounded-2xl'>
               <FicheRenseignStagaire/>
           </div>


           {/* ---------------composant de tableau ------------- */}
           <div className="">
               <Test />
           </div>


           {/* ---------- Button ---------- */}
           <div className='flex flex-row gap-2 w-full'>
               <Button variant='outline' className=' w-200' > Télécharger </Button>
               <Button className=' w-200'> Valider definitivement </Button>
           </div>
          
       </div>


     










   </MainLayout>
 )
}


export default AssistantFR
