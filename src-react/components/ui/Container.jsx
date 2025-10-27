import React from 'react'



export default function Container({children, className, ...props}) {

    return (
        <div className={`rounded-lg border border-[#B9B9B9] p-2 ${className}`} {...props}>{children}
        </div>
    )
}

