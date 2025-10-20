import React from 'react'

function Pagination({ totalItems, itemsPerPage, currentPage, onPageChange }) {
  const totalPages = Math.ceil(totalItems / itemsPerPage)
  const pageNumbers = [...Array(totalPages).keys()].map(num => num + 1)

  if (totalPages <= 1) return null

  return (
    <div className="py-2 px-4">
      <nav className="flex justify-center items-center space-x-1" aria-label="Pagination">

        {/* Précédent */}
        <button
          onClick={() => onPageChange(currentPage - 1)}
          disabled={currentPage === 1}
          className={`p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full 
            ${currentPage === 1 
              ? 'text-gray-400 cursor-not-allowed' 
              : 'text-gray-800 hover:bg-gray-100 focus:bg-gray-100'}`}
          aria-label="Previous"
        >
          «
        </button>

        {/* Nombres de page */}
        {pageNumbers.map(number => (
          <button
            key={number}
            onClick={() => onPageChange(number)}
            className={`min-w-10 flex justify-center items-center py-2.5 text-sm rounded-full
              ${number === currentPage
                ? 'bg-blue-600 text-white'
                : 'text-gray-800 hover:bg-gray-100 focus:bg-gray-100'}`}
          >
            {number}
          </button>
        ))}

        {/* Suivant */}
        <button
          onClick={() => onPageChange(currentPage + 1)}
          disabled={currentPage === totalPages}
          className={`p-2.5 min-w-10 inline-flex justify-center items-center gap-x-2 text-sm rounded-full 
            ${currentPage === totalPages 
              ? 'text-gray-400 cursor-not-allowed' 
              : 'text-gray-800 hover:bg-gray-100 focus:bg-gray-100'}`}
          aria-label="Next"
        >
          »
        </button>
      </nav>
    </div>
  )
}

export default Pagination
