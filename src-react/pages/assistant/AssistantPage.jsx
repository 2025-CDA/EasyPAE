import React from "react";
import CardFormation from "../../components/ui/CardFormation"
import MainLayout from "../../components/layout/MainLayout"
import Test from "../../components/ui/Test"


function AssistantPage() {
   return (  
       <MainLayout >
           <div className="flex flex-col flex-1 p-6">
               <h1 className="text-2xl font-bold mb-6">Informatique - Numérique</h1>
               {/* ---------------Cartes de formations------------- */}
               <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                   <CardFormation
                       trainingTitle="Nom de la formation 1"
                       nbOffer="xxxxxx"
                       trainerName="Nom du formateur"
                       startDateInternship="00/00/0000"
                       endDateInternship="00/00/0000"
                   />
                   <CardFormation
                       trainingTitle="Nom de la formation 1"
                       nbOffer="xxxxxx"
                       trainerName="Nom du formateur"
                       startDateInternship="00/00/0000"
                       endDateInternship="00/00/0000"
                   />
                   <CardFormation
                       trainingTitle="Nom de la formation 1"
                       nbOffer="xxxxxx"
                       trainerName="Nom du formateur"
                       startDateInternship="00/00/0000"
                       endDateInternship="00/00/0000"
                   />
                   <CardFormation                
                       className="max-w-xs w-full bg-white border border-gray-200 rounded-xl shadow-md flex flex-col min-h-[350px] justify-center items-center"
                   />
                   {/* On peut dupliquer CardFormation ou le faire dynamiquement selon tes données */}
               </div>
           </div>
       </MainLayout>
);
}


export default AssistantPage;