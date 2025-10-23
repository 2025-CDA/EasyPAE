import React from "react";

export default function StepContent({ index, description }) {
    return (
        <div className="mt-5 sm:mt-8 justify-center items-center w-full">
            <div className="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
                <h3 className="text-gray-500 dark:text-neutral-500">
                    {description}
                </h3>
            </div>
        </div>
    );
}
