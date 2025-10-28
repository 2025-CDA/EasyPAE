import React from "react";

function StepperNavbar({ validated, currentStep, finishedStep = [], content , isHorizontal}) {
    return (
        <ul className={`w-full flex justify-center md:items-center ${!isHorizontal && 'flex-col'} md:flex-row gap-2`}>
            {content.map((step, i) => (
                <StepItem
                    key={i}
                    step={i + 1}
                    title={step.title}
                    description={step.description}
                    isActive={i === currentStep}
                    isDone={finishedStep.includes(i)}
                    isValidated={validated}
                    isHorizontal
                />
            ))}
        </ul>
    );
}

export default StepperNavbar;

function StepItem({ step, title, description, isValidated, isActive, isDone, isHorizontal=false }) {
    let stepCircleClass = "bg-gray-100 text-gray-400";
    if (isValidated) {
        stepCircleClass = "bg-validate-text text-white";
    } else if (isDone) {
        stepCircleClass = "bg-primary text-white";
    } else if (isActive) {
        stepCircleClass = "bg-logo text-primary";
    }

    let barClass = "bg-gray-100";
    if (isValidated) {
        barClass = "bg-validate-text";
    } else if (isDone) {
        barClass = "bg-primary";
    }

    return (
        <li className="md:shrink md:basis-0 flex-1 group  gap-x-2 md:block">
            <div className={` min-w-7 min-h-7 flex ${!isHorizontal && 'flex-col' } items-center md:w-full md:inline-flex md:flex-wrap md:flex-row text-xs align-middle`}>
                <span
                    className={` ${stepCircleClass} size-8 flex justify-center items-center shrink-0 font-medium rounded-full`}
                >
                    {step}
                </span>

                <div
                    className={`${barClass} ${!isHorizontal && 'w-1 h-full mt-2  md:mt-0 md:ms-2 md:w-full md:h-px md:flex-1 bg-gray-100 group-last:hidden'} ${isHorizontal && 'mt-0 ms-2 w-full h-px flex-1 bg-gray-100 group-last:hidden'}`}
                ></div>
            </div>
            <div className="grow md:grow-0 md:mt-3 pb-5">
                <span className="block text-sm font-medium text-gray-800">
                    {title}
                </span>
                <p className="text-sm text-gray-500">{description}</p>
            </div>
        </li>
    );
}
