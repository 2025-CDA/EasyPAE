import React, { useState, useMemo } from "react";

function Table({ columns, data, actions, rowsPerPage = 5 }) {
  const [searchTerm, setSearchTerm] = useState("");
  const [currentPage, setCurrentPage] = useState(1);

  // 🔍 Filtrage des données
  const filteredData = useMemo(() => {
    return data.filter((row) =>
      Object.values(row).some((value) =>
        value?.toString().toLowerCase().includes(searchTerm.toLowerCase())
      )
    );
  }, [data, searchTerm]);

  // Pagination
  const totalPages = Math.ceil(filteredData.length / rowsPerPage);
  const paginatedData = filteredData.slice(
    (currentPage - 1) * rowsPerPage,
    currentPage * rowsPerPage
  );

  const handlePrevPage = () => setCurrentPage((p) => Math.max(p - 1, 1));
  const handleNextPage = () => setCurrentPage((p) => Math.min(p + 1, totalPages));

  return (
    <div className="flex flex-col">
      <div className="-m-1.5 overflow-x-auto">
        <div className="p-1.5 min-w-full inline-block align-middle">
          <div className="border border-gray-200 rounded-lg divide-y divide-gray-200">

            {/* Barre de recherche */}
            <div className="py-3 px-4 flex justify-between items-center">
              <div className="relative max-w-xs">
                <label htmlFor="table-search" className="sr-only">Search</label>
                <input
                  type="text"
                  id="table-search"
                  className="py-2 px-3 ps-9 block w-full border-gray-200 shadow-sm rounded-lg sm:text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500"
                  placeholder="Rechercher..."
                  value={searchTerm}
                  onChange={(e) => setSearchTerm(e.target.value)}
                />
                <div className="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                  <svg className="size-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                  </svg>
                </div>
              </div>
            </div>

            {/* Tableau principal */}
            <div className="overflow-hidden">
              <table className="min-w-full divide-y divide-gray-200">
                <thead className="bg-gray-50">
                  <tr>
                    <th className="py-3 ps-4">
                      <div className="flex items-center h-5">
                        <input type="checkbox" className="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500" />
                      </div>
                    </th>

                    {columns.map((col, index) => (
                      <th key={index} className="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase">
                        {col.header}
                      </th>
                    ))}

                    {actions?.length > 0 && (
                      <th className="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase">
                        Actions
                      </th>
                    )}
                  </tr>
                </thead>

                <tbody className="divide-y divide-gray-200">
                  {paginatedData.map((row, index) => (
                    <tr key={index} className="hover:bg-gray-50 transition-colors">
                      <td className="py-3 ps-4">
                        <input type="checkbox" className="border-gray-200 rounded-sm text-blue-600 focus:ring-blue-500" />
                      </td>

                      {columns.map((col, i) => (
                        <td key={i} className="px-6 py-4 whitespace-nowrap text-sm text-gray-800">
                          {row[col.accessor]}
                        </td>
                      ))}

                      {actions?.length > 0 && (
                        <td className="px-6 py-4 whitespace-nowrap text-end text-sm font-medium flex justify-end gap-2">
                          {actions.map((action, i) => (
                            <button
                              key={i}
                              onClick={() => action.onClick(row)}
                              className={`inline-flex items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-${action.color}-600 hover:text-${action.color}-800 focus:outline-hidden disabled:opacity-50`}
                            >
                              {action.label}
                            </button>
                          ))}
                        </td>
                      )}
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>

            {/* Pagination */}
            <div className="py-2 px-4">
              <nav className="flex items-center justify-center space-x-1" aria-label="Pagination">
                <button
                  onClick={handlePrevPage}
                  disabled={currentPage === 1}
                  className="p-2.5 min-w-10 inline-flex justify-center items-center rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50"
                >
                  «
                </button>

                {Array.from({ length: totalPages }, (_, i) => (
                  <button
                    key={i}
                    onClick={() => setCurrentPage(i + 1)}
                    className={`min-w-10 flex justify-center items-center py-2.5 text-sm rounded-full ${
                      currentPage === i + 1
                        ? "bg-blue-100 text-blue-700 font-semibold"
                        : "text-gray-800 hover:bg-gray-100"
                    }`}
                  >
                    {i + 1}
                  </button>
                ))}

                <button
                  onClick={handleNextPage}
                  disabled={currentPage === totalPages}
                  className="p-2.5 min-w-10 inline-flex justify-center items-center rounded-full text-gray-800 hover:bg-gray-100 disabled:opacity-50"
                >
                  »
                </button>
              </nav>
            </div>

          </div>
        </div>
      </div>
    </div>
  );
}

export default Table;
