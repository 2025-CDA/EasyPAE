import React from 'react'



export default function Container({children, className, ...props}) {

<<<<<<< HEAD
    return (
        <div className={`flex rounded-lg  border border-[#B9B9B9] p-2 ${className}`} {...props}>{children}
        </div>
    )
=======
  return (
    <div className={`rounded-lg border border-[#B9B9B9] p-2 ${className}`}>{children}
    </div>
  )
>>>>>>> origin
}

