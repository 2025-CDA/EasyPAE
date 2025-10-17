import {useState} from 'react'
import StepperNavbar from './StepperNavbar'
// import StepperContent from './StepperContent'
import StepContent from './StepContent'

import Button from '../Button'
import StepperButton from './StepperButton'

function Stepper({content= [
    {
        index: 1, description: "lorem ipsum"
    },
    {
        index: 2, description: "lorem ipsum2"
    },
    {
        index: 3, description: "lorem ipsum3"
    }
],withBack = true}){
 const [step, setStep] = useState (0);

 const handleNext = () => {
    console.log(step);
    if (step < content.length-1) { // suppose qu’il y a 3 étapes
      setStep(step + 1)
    }
  }

  const handlePrevious = () => {
    console.log(step);
    if (step > 0) {
        setStep(step - 1)
    }
  }
  // Affichage conditionnel du contenu selon l’étape
//   const renderStepContent = () => {
//     switch (step) {
//       case 1:
//         return <StepperContent />
//       case 2:
//         return <FinalContent />
//       default:
//         return <h2>Étape finale terminée !</h2>
//     }
//   }

  return (
    <div className='flex flex-col justify-center items-center p-4'>
        <StepperNavbar content ={content.map((item, i) => ({
          step: i +1, 
          title: `Etape ${i + 1}`,
          description: item.description
        }))} 
        currentStep={step} 
        nextStep={step + 1} 
        />

           <StepContent index={step} description={content[step].description}  /> 

           <div className="flex w-full flex-row my-2 gap-4 items-center justify-center">
                <Button
                className="flex-1"
                color="blue"
                variant="outline"
                onClick={handlePrevious}
            >
                {step < 3 ? 'Précédent' : 'Terminer'}
            </Button>
          { withBack &&  <Button
                className="flex-1"              
                color="blue"
                variant="solid"
                onClick={handleNext}
            >
                {step < 3 ? 'Suivant' : 'Terminer'}
            </Button>}
           </div>
  {/* <Button color='green' variant='outline'>jjgg</Button>
  <Button color='white' variant='outline'>jjgg</Button>
  <Button color='red' variant='outline'>jjgg</Button> */}
            
    </div>
  )
}

export default Stepper
