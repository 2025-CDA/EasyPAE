
import React, {useState} from 'react'
import MainLayout from '../../components/layout/MainLayout'
import CardCompany from '../../components/ui/CardCompany'
import TimeLine from '../../components/ui/TimeLine/TimeLine'
import CalendarSimpleGET from '../../components/calendar/CalendarSimpleGET'
import Container from '../../components/ui/Container'
import Buisinessman from '../../assets/Business-man.png'
import StepperNavbar from '../../components/ui/stepper/StepperNavbar'


function InternDashboardPage() {

  const [currentFormation] = useState({
            periodStart: new Date(2026, 0, 5),  // 5 janvier 2026
            periodEnd: new Date(2026, 2, 27),   // 27 mars 2026
        });

  const steps = [{
                  title: "Vous",
                  description: "Vous avez transmis votre demande le 04/11/2025",
                  finishedStep: 1
                                   
                                },
                {
                  title: "Entreprise",
                  description: "Formulaire transmis à l'entreprise",
                                    
                                },
                {
                  title: "Administration",
                  description: "Validation",
                                  
                                }

  ]


  const [finishedStep] = useState([0]);

  return (

        <MainLayout withSearchbar = {false} >

          <h2 className='ml-5 font-semibold'>Dashboard</h2>

          <div className='grid grid-cols-3 gap-4 m-5'>

            
            <Container className=' col-span-2 flex flex-col gap-4 font-semibold justify-center' >
              <h4 className='mb-5'>Statuts de la demande </h4>
              <StepperNavbar content = {steps} currentStep={1} finishedStep={finishedStep} />
            </Container>

            <CardCompany companyName={"ViveCom'"} adresse={"123 Rue 33000 Bordeaux"} tel={"05555555"}/>
            
            <div className='col-span-2' >
              <Container>
                <TimeLine/>
              </Container>
            </div>

            <CalendarSimpleGET
              dates={currentFormation}
            />

          </div>
          
          <div className='grid place-items-end ' >

            <img className='w-1/5 transform -scale-x-100' src={Buisinessman} alt="" />

          </div>
          

        </MainLayout>
        
      
    
  )
}

export default InternDashboardPage