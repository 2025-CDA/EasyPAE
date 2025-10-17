import React from "react";

function StepperNavbar(
    
    {   currentStep, nextStep,
        content = [
            {
                step: 1,
                title: "test",
                description: "lorem ipsum",
            },
            {
                step: 2,
                title: "test2",
                description: "lorem ipsum2",
            },
            {
                step: 3,
                title: "test3",
                description: "lorem ipsum3",
            },
        ],
    }
) {
    return (
        <ul className="w-full flex justify-center items-center flex-col md:flex-row gap-2">
            {content.map((step, i) => (
                <StepItem
                    key={i}
                    step={step.step}
                    title={step.title}
                    description={step.description}
                    isActive={i === nextStep}
                    isDone={i === currentStep}
                />
            ))}
        </ul>
    );
}

export default StepperNavbar;

function StepItem({ step, title, description, isActive, isDone }) {
    return (
        <li className="md:shrink md:basis-0 flex-1  group flex gap-x-2 md:block">
            <div className=" min-w-7 min-h-7 flex flex-col items-center md:w-full md:inline-flex md:flex-wrap md:flex-row text-xs align-middle">
                <span className= {
                    `bg-gray-100 text-gray-400 size-7 flex justify-center items-center shrink-0 font-medium rounded-full ${ isActive && "bg-logo text-primary"} ${isDone && "bg-primary text-white"}` 
                }>
                    {step}
                </span >
                <div className="mt-2 w-full h-full md:mt-0 md:ms-2 md:w-full md:h-px md:flex-1 bg-gray-100 group-last:hidden"></div>
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
