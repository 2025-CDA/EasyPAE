import React from 'react'
import Container from '../../components/ui/Container'
import Avatar from './Avatar'
import Button from './Button'


function CardCompany({companyName, adresse, tutorEmail, tel, tutorName, className, avatar }) {
        const conditionTutorName= tutorName || '[aucune donnée renseignée]';

  return (


    <Container className={`flex flex-col font-medium w-full ${className}`}>

        <h1 className='font-medium'>Entreprise d'accueil</h1>

        <div className='flex items-center'>

             <Avatar size="sm" url={avatar} className="outline-hidden mr-3"/>
             <h3 >{companyName}</h3>

        </div>

        <div className="flex flex-col gap-2 mb-3">
            <h5>Adresse : {adresse} </h5>
            <h5>Mail contact :  {tutorEmail} </h5>
            <h5>N° téléphone : {tel} </h5>
            <h5>Nom du tuteur : {conditionTutorName} </h5>
         
        </div>

    </Container>
    
  )
}

export default CardCompany;


