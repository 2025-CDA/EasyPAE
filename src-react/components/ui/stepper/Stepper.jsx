import { useState } from "react";
import StepperNavbar from "./StepperNavbar";
import StepContent from "./StepContent";
import Button from "../Button";
import StepperButton from "./StepperButton";
import Container from "../Container";

function Stepper({
    content = [
        {
            title: "test1",
            description: "lorem ipsum2",
            stepContent: <h1>Test1</h1>,
        },
        {
            title: "test2",
            description: "lorem ipsum2",
            stepContent: <h1>Test2</h1>,
        },
        {
            title: "test3",
            description: "lorem ipsum3",
            stepContent: <h1>Test3</h1>,
        },
    ],
    withBack = true,
    handleLastEvent, //par example download file
    lastEventButtonTitle = "Download",
    handleValidateEvent, // par example pour navigate apres validation
    className,
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
            handleValidateEvent();
        }
    };

    const handlePrevious = () => {
        if (step > 0) {
            // const arr = ;
            setFinishedSteps(finishedSteps.filter((item) => item !== step - 1));
            setStep(step - 1);
        }
    };

    return (
<<<<<<< HEAD
        <Container
            className={`flex flex-col justify-center items-center p-4 ${className}`}
        >
=======
        <Container className="flex flex-col justify-center items-center">
>>>>>>> origin/dev
            <StepperNavbar
                content={content}
                currentStep={step}
                nextStep={step + 1}
                finishedStep={finishedSteps}
                validated={validated}
            />

            <StepContent content={content[step].stepContent} />

            <div className="flex w-full flex-row my-2 gap-4 items-center justify-center">
                {/* Afficher bouton "Précédent" sauf à la première étape */}
                {withBack && !validated && step > 0 && (
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
                {withBack && !validated && (
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

                {validated && (
                    <Button
                        className="flex-1"
                        color="blue"
                        variant="solid"
                        onClick={handleLastEvent}
                    >
                        {lastEventButtonTitle}
                    </Button>
                )}
            </div>
        </Container>
    );
}

export default Stepper;
