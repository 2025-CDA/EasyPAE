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
    if (step < 3) { // suppose qu’il y a 3 étapes
      setStep(step + 1)
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
    <div>
        <StepperNavbar currentStep={step} />
           <StepContent index={step} description={content[step].description}  /> 
           
           <div className="flex w-full flex-row mt-4 gap-4 justify-center">
                <Button
                className="m-2 w-full"
                fullWidth
                color="blue"
                variant="outline"
                onClick={handleNext}
            >
                {step < 3 ? 'Suivant' : 'Terminer'}
            </Button>
          { withBack &&  <Button
                className="m-2 w-full"
                fullWidth
                color="blue"
                variant="outline"
                onClick={handleNext}
            >
                {step < 3 ? 'Suivant' : 'Terminer'}
            </Button>}
           </div>
            
    </div>
  )
}

export default Stepper
