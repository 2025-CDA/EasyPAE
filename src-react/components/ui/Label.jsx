import React from 'react'

function Label({labelFor, text, weight, color, size}) {
  return (
    <div>
      <label htmlFor={`${labelFor}-label`} className= {`block text-${size} font-${weight}  text-${color} mb-2`}> {text} </label>
    </div>
  )
}

export default Label