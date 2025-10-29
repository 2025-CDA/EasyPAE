import React from 'react'
import Container from '../../components/ui/Container'
import test from '../../assets/Business-man.png'
import Avatar from './Avatar'
import Button from './Button'


function CardIntern({name, role, internNumber, email, courseName, courseNumber, trainerName, startDateInternship, endDateInternship, className }) {
  return (

    <Container className={`flex flex-col font-medium w-full ${className}`}>
        <div className='flex items-center'>

             <Avatar size="sm" url={test} className="outline-hidden mr-2"/>
             <h1 >{name} {" "} {role}</h1>

        </div>

        <div className="flex flex-col gap-2 mb-3">
            <h5>N° stagiaire : {internNumber} </h5>
            <h5>Email :  {email} </h5>
            <h5>Formation : {courseName} {" "} n°{courseNumber} </h5>
            <h5>Formateur : {trainerName} </h5>
            <h5>{`Période de stage : du ${startDateInternship} au ${endDateInternship} `}</h5>
        </div>

        <Button> 
            Éditer les missions de stages
        </Button>
       

    </Container>
    
  )
}

export default CardIntern
