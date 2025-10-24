import React from 'react'
import MainLayout from '../layout/MainLayout'
import Breadcrumb from '../ui/Breadcrumb'
import test from '../../assets/Help-sheet.png'
import Stepper from '../../components/ui/stepper/Stepper'
import Container from '../../components/ui/Container'

function InfoFormInternPae() {
  return (
    <MainLayout>
      <div className="ml-5">
        <Breadcrumb content = 
          {[
            { title: "Dashboard", link: "#", isFinal: false, current: false },
            { title: "Demande de PAE", link: "#", isFinal: true, current: true },
          ]}>

        </Breadcrumb>
           <Stepper>
              <Container>
                
              </Container>
            </Stepper> 

      </div>
    

    </MainLayout>
  )
}

export default InfoFormInternPae
