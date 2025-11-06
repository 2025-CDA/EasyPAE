import React from "react";
import TableHead from "./TableHead";
import TableBody from "./TableBody";

function Table({
    columns,
    //   data,
    currentItems,
    handleEdit,
    handleDelete,
    classNameTbody,
    classNameThead,
    classNameTable,
    classNameTdataBody,
    classNameTdataHead,
    classNameTdataAction,
    divAction,
    onRowClick,
}) {
    return (
        <div className="overflow-hidden">
            <table
                className={
                    classNameTable || "min-w-full divide-y divide-gray-200"
                }
            >
                <TableHead
                    columnsThead={columns}
                    classNameThead={classNameThead}
                    classNameTdataHead={classNameTdataHead}
                />

                <TableBody
                    dataInTbody={currentItems}
                    columnsTbody={columns}
                    onEdit={handleEdit}
                    onDelete={handleDelete}
                    divAction={divAction}
                    classNameTbody={classNameTbody}
                    classNameTdataBody={classNameTdataBody}
                    classNameTdataAction={classNameTdataAction}
                />
            </table>
        </div>
    );
}

export default Table;
