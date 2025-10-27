import React from "react"

function SearchBarTable({ value, onChange, placeholder }) {
  return (
    <div className="py-3 px-4">
      <div className="relative max-w-xs">
        <input
          type="text"
          value={value}
          onChange={(e) => onChange(e.target.value)}
          className="py-1.5 sm:py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg sm:text-sm 
                     focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
          placeholder={placeholder}
        />
        <div className="absolute inset-y-0 start-0 flex items-center pointer-events-none ps-3">
          <svg
            className="size-4 text-gray-400"
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
          >
            <circle cx="11" cy="11" r="8"></circle>
            <path d="m21 21-4.3-4.3"></path>
          </svg>
        </div>
      </div>
    </div>
  )
}

export default SearchBarTable
