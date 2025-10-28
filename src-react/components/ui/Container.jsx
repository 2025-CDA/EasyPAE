import React from "react";

<<<<<<< HEAD
export default function Container({ children, className }) {
    return (
        <div
            className={`flex rounded-lg  border border-[#B9B9B9] p-2 ${className}`}
        >
            {children}
        </div>
    );
=======


export default function Container({children, className}) {

  return (
    <div className={`rounded-lg border border-[#B9B9B9] p-2 ${className}`}>{children}
    </div>
  )
>>>>>>> origin/dev
}
