import React from 'react'
import Container from '../../components/ui/Container'
import Avatar from './Avatar'
import Button from './Button'


function CardCompany({companyName, adresse, tutorEmail, tel, tutorName, className, avatar }) {
        const conditionTutorName= tutorName || '[aucune donnée renseignée]';

  return (


    <Container className={`flex flex-col font-medium w-full h-full ${className}`}>

        <h3 className='font-medium'>Entreprise d'accueil</h3>

        <div className='flex items-center'>

             <Avatar size="sm" url={avatar} className="outline-hidden mr-3"/>
             <p >{companyName}</p>

        </div>

        <div className="flex flex-col gap-2 mb-3">
            <p>Adresse : {adresse} </p>
            <p>Mail contact :  {tutorEmail} </p>
            <p>N° téléphone : {tel} </p>
            <p>Nom du tuteur : {conditionTutorName} </p>
         
        </div>

    </Container>
    
  )
}

export default CardCompany;


