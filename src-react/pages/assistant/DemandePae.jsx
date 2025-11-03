import React from 'react'
import MainLayout from '../../components/layout/MainLayout'
import CardIntern from '../../components/ui/CardIntern'
import GlobalStateHistory from '../../components/assistant/GlobalStateHistory'
import Container from '../../components/ui/Container'


function DemandePae() {
 return (
   <MainLayout>
       <div className="flex flex-col gap-2">
       {/* ---------------composant Titre  ------------- */}
           <div className="w-full flex flex-row justify-between items-center px-6">
               <h1 className="text-2xl font-bold">Fiches de renseignement </h1>
           </div>


       {/* ---------------composant -Barre de positionement  ------------- */}


       {/* ---------------composant -Fiche d'un stagaire avec boutton (changer)  ------------- */}
        <Container className={"border-0"}>
            <CardIntern
                name="Marie Dubois"
                // role="Développeuse front"
                internNumber={true}
                email="marie.dubois@email.fr"
                courseName="React avancé"
                courseNumber="2025"
                trainerName="Jean Martin"
                startDateInternship="2025-09-01"
                endDateInternship="2025-12-01"
                avatarUrl="/assets/marie.png"
                onEdit={() => console.log('Changer')}
                buttonLabel="Changer"
                showButton={true}
            />
        </Container>
        






       {/* ---------------composant - Statut global ------------- */}
       <Container className={"border-0 "}>
            <GlobalStateHistory className={'w-full'}/>
        </Container>







       </div>
      
   </MainLayout>   
 )
}


export default DemandePae
