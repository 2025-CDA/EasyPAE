import { useState } from "react";
import StepperNavbar from "./StepperNavbar";
import StepContent from "./StepContent";
import Button from "../Button";
import StepperButton from "./StepperButton";
import Container from "../Container";

function Stepper({
    content = [
        {
            index: 1,
            description: "lorem ipsum",
        },
        {
            index: 2,
            description: "lorem ipsum2",
        },
        {
            index: 3,
            description: "lorem ipsum3",
        },
    ],
    withBack = true,
}) {
    const [step, setStep] = useState(0);
    const [finishedSteps, setFinishedSteps] = useState([]);
    const [validated, setValidated] = useState(false);

    const handleNext = () => {
        if (!finishedSteps.includes(step)) {
            setFinishedSteps([...finishedSteps, step]);
        }
        if (step < content.length - 1) {
            // suppose qu’il y a 3 étapes
            setStep(step + 1);
        } else {
            setFinishedSteps([...Array(content.length).keys()]);
            setValidated(true);
        }
    };

    const handlePrevious = () => {
        if (step > 0) {
            setStep(step - 1);
        }
    };

    return (
        <Container className="flex flex-col justify-center items-center p-4">
            <StepperNavbar
                content={content.map((item, i) => ({
                    step: i + 1,
                    title: `Etape ${i + 1}`,
                    description: item.description,
                }))}
                currentStep={step}
                nextStep={step + 1}
                finishedStep={finishedSteps}
                validated={validated}
            />

            <StepContent index={step} description={content[step].description} />

            <div className="flex w-full flex-row my-2 gap-4 items-center justify-center">
                {/* Afficher bouton "Précédent" sauf à la première étape */}
                {withBack && step > 0 && (
                    <Button
                        className="flex-1"
                        color="blue"
                        variant="outline"
                        onClick={handlePrevious}
                    >
                        Précédent
                    </Button>
                )}

                {/* Afficher bouton "Suivant" sauf à la dernière étape où on affiche "Valider" */}
                {withBack && (
                    <Button
                        className="flex-1"
                        color="blue"
                        variant="solid"
                        onClick={handleNext}
                    >
                        {step < content.length - 1
                            ? "Suivant"
                            : "Valider la demande"}
                    </Button>
                )}
            </div>
        </Container>
    );
}

export default Stepper;
