import React from 'react'
import CircleProgress from "./CircleProgress";
import Button from './Button';


function CardFormation({
  trainingTitle,
  nbOffer,
  trainerName,
  startDateInternship,
  endDateInternship,
}) {

  const isEmpty =
    !trainingTitle &&
    !nbOffer &&
    !trainerName &&
    !startDateInternship &&
    !endDateInternship;

  if (isEmpty) {
  return (
        <a href='/'><Button
          className= 'flex flex-col  border-gray-200 rounded-x border shadow-2xs aspect-square cursor-pointer transition hover:shadow-lg'
          color='white'
          // }}
          icon={
            // Icône SVG, taille et style pour centrer
            <svg xmlns="http://www.w3.org/2000/svg" width="38" height="38" viewBox="0 0 38 38" fill="none">
              <path d="M16.9186 0.669922C15.9571 0.669922 15.0349 1.05189 14.355 1.7318C13.6751 2.41171 13.2932 3.33386 13.2932 4.29539V13.3591H4.22948C3.26794 13.3591 2.34579 13.741 1.66588 14.421C0.985972 15.1009 0.604004 16.023 0.604004 16.9845V20.61C0.604004 22.604 2.23547 24.2355 4.22948 24.2355H13.2932V33.2992C13.2932 35.2932 14.9246 36.9246 16.9186 36.9246H20.5441C21.5056 36.9246 22.4278 36.5427 23.1077 35.8628C23.7876 35.1829 24.1696 34.2607 24.1696 33.2992V24.2355H33.2333C34.1948 24.2355 35.1169 23.8535 35.7969 23.1736C36.4768 22.4937 36.8587 21.5716 36.8587 20.61V16.9845C36.8587 16.023 36.4768 15.1009 35.7969 14.421C35.1169 13.741 34.1948 13.3591 33.2333 13.3591H24.1696V4.29539C24.1696 3.33386 23.7876 2.41171 23.1077 1.7318C22.4278 1.05189 21.5056 0.669922 20.5441 0.669922H16.9186Z" stroke="#666" strokeWidth="0.87" strokeLinecap="round" strokeLinejoin="round"/>
            </svg>
          }
        >
          <span className="block mt-2 text-lg text-secondary-text font-semibold">Ajouter une formation</span>
        </Button></a>
  );
}


  return (
    
    <div className='w-full'>
      <div className="flex flex-col bg-background border border-gray-200 shadow-2xs rounded-xl">
        <img
          className="w-full h-18 rounded-t-xl"
          src="https://images.unsplash.com/photo-1680868543815-b8666dba60f7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80"
          alt="Card Image"
        />
        <div className="p-4 md:p-5 font-semibold">
          <h4 className="font-bold text-primary-text">
            {trainingTitle}
          </h4>
          <p className="mt-1 text-secondary-text">
            Offre n°{nbOffer}
          </p>
          <p className="mt-1 text-secondary-text">
            {trainerName}
          </p>
          <p className="mt-1  text-secondary-text">
            Période de stage du<br />
            {startDateInternship} au {endDateInternship}
          </p>
          <div className="flex items-center space-x-14">
              <p className="text-secondary-text">PAE validées :</p>
              <CircleProgress statusPae="75%" className="mt-1"/>
          </div>
          <div className='w-24'>
            <Button color='blue' variant='solid' className='h-12'>Consulter</Button>
          </div>
        </div>
      </div>
    </div>
  );
}

export default CardFormation;




