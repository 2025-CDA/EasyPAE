import React from "react";

function Textarea({ text, placeholder = "Autre" }) {
    return (
        <div className="w-full space-y-3">
            <textarea
                className="py-2 px-3 sm:py-3 sm:px-4 block w-full border border-primary rounded-lg placeholder-secondary-text sm:text-sm focus:border-primary focus:ring-primary disabled:opacity-50 disabled:pointer-events-none resize-none"
                rows="3"
                placeholder={placeholder}
            >
                {text}
            </textarea>
        </div>
    );
}

export default Textarea;
