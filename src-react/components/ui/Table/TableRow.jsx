import React from "react";
import TableCellData from "./TableCellData";
import TableCellAction from "./TableCellAction";
import { useNavigate } from "react-router";

function TableRow({
    trData,
    trColumns,
    divAction,
    onEdit,
    onDelete,
    classNameTdataBody,
    classNameTdataAction,
}) {
    const navigate = useNavigate();
    // Vérifier si la colonne ayant comme key action existe dans la constante des colonnes
    const hasActionColumn = trColumns.some((col) => col.key === "action");

    return (
        <>
            {trData.map((row, index) => (
                <tr key={index}>
                    {/* On affiche d'abord les colonnes sans la colonne Action*/}

                    <TableCellData
                        tdData={row}
                        tdColumns={trColumns.filter(
                            (col) => col.key !== "action"
                        )}
                        classNameTdataBody={classNameTdataBody}
                        onClick={() => navigate(`/${row.infoFormId}`)}
                    />

                    {/* Ensuite, si une colonne "action" existe, on affiche la cellule des boutons */}

                    {hasActionColumn && (
                        <td
                            className={
                                classNameTdataAction ||
                                "px-6 py-4 whitespace-nowrap text-end text-sm font-medium"
                            }
                        >
                            <TableCellAction
                                dataRow={row}
                                keyAction={row.id}
                                onEdit={onEdit}
                                onDelete={onDelete}
                                divAction={divAction}
                            />
                        </td>
                    )}
                </tr>
            ))}
        </>
    );
}

export default TableRow;
