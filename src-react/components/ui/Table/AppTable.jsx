import React, { useState } from "react";
import PaginationTable from "./PaginationTable";
import SearchBarTable from "./SearchBarTable";
import Table from "./Table";

function AppTable({
    //Les props à passer et les exemples de valeurs à affecter dans le composant parent

    visibilitySearchBar, // Pour afficher ou faire disparaitre la searchbar
    visibilityPagination, // Pour afficher ou faire disparaitre la paggination
    columns = [
        { key: "id", label: "IDENTIFIANT" },
        { key: "first_name", label: "PRÉNOM" },
        { key: "last_name", label: "NOM" },
        { key: "intern_member_id", label: "ID STAGIAIRE" },
        { key: "status", label: "AVANCÉE DU DOSSIER" },
        { key: "action", label: "ACTION" },
    ], // Pour afficher les données des colonnes par défaut ou récupérer celles du parent
    data = [
        {
            id: 1,
            first_name: "Jeremie",
            last_name: "Chabanais",
            intern_member_id: 125242,
            status: "Aucune demande",
        },
        {
            id: 2,
            first_name: "Saria",
            last_name: "Chabanais",
            intern_member_id: 125242,
            status: "Stagiaire a initié la demande",
        },
        {
            id: 3,
            first_name: "Aziza",
            last_name: "Chabanais",
            intern_member_id: 125242,
            status: "Transmis à l'administration",
        },
        {
            id: 4,
            first_name: "Margot",
            last_name: "Chabanais",
            intern_member_id: 125242,
            status: "Aucune demande",
        },
        {
            id: 5,
            first_name: "Arnaud",
            last_name: "Chabanais",
            intern_member_id: 125242,
            status: "Terminé",
        },
        {
            id: 6,
            first_name: "Yves",
            last_name: "Dupont",
            intern_member_id: 125243,
            status: "En attente de validation",
        },
        {
            id: 7,
            first_name: "Camille",
            last_name: "Durand",
            intern_member_id: 125244,
            status: "Terminé",
        },
        {
            id: 8,
            first_name: "Paul",
            last_name: "Martin",
            intern_member_id: 125245,
            status: "Transmis à l'administration",
        },
    ], // Pour afficher les données des datas par défaut ou récupérer celles du parent
    divAction, // Pour changer le contenu des cellules de la colonne Action
    editProps, // Pour modifier la logique du boutton "modifier" de la cellule action
    numberItemsPerPage = 3, // Pour changer le nombre d'élément par page à afficher dans le tableau
    onClickButtonHeaderOne, //Pour y mettre la logique du premier boutton du header
    classNameAppTable, // Pour changer le style de la div du composant en entier
    textTableTitle, //Pour changer le titre du tableau
    classNameThead, // Pour changer le style de l'élément Thead ex {"bg-blue-100"}
    classNameTbody, // {"divide-y divide-red-500 dark:divide-neutral-700"}
    classNameTable, // // Pour changer le stye de table ex : {"min-w-full divide-y divide-red-300"}
    classNameTableTitle, // {"text-lg text-red-500 font-extrabold mb-6 mt-4"}
    divButtonHeaderClassName, //Pour cacher ou changer le style de la div des bouttons du header{"flex flex-row justify-between items-center gap-4 mr-3"}
    textButtonOneHeader, // Pour modifier le text du boutton 1 du header
    textButtonTwoHeader, // Pour modifier le text du boutton 2 du header
    buttonHeaderOneClassName, // Pour changer le style du premier bouton du header ex de style : {"py-1 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-600 text-red-600 hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"}
    buttonHeaderTwoClassName, // Pour changer le style du premier bouton du header ex de style : {"py-1 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-red-600 text-red-600 hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"}
    visibilityButtonOneHeader, // Pour faire disparaitre le bouton 1 du header seule
    visibilityButtonTwoHeader, // Pour faire disparaitre le bouton 2 du header seule
    placeholderTextSearchBar, // Pour changer le text du placeholder de la searchBar ex : {"Chercher formateur"}
    classNameTdataBody, // {"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-800"}
    classNameTdataHead, //{"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}
    classNameTdataAction, //{"bg-red-100 px-6 py-4 whitespace-nowrap text-sm font-medium text-red-800 dark:text-neutral-800"}
}) {
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage] = useState(numberItemsPerPage); //Le nombre d'item par page appliqué par défaut dans la props à trois et à modifier si besoin dans le composant parent
    const [searchTerm, setSearchTerm] = useState("");

    // Filtrage des données selon la recherche
    const filteredData = data.filter((item) =>
        Object.values(item)
            .join(" ")
            .toLowerCase()
            .includes(searchTerm.toLowerCase())
    );

    // Pagination après filtrage
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentItems = filteredData.slice(indexOfFirstItem, indexOfLastItem);

    // const handleEdit = (id) => console.log(`Modifier l'élément ID : ${id}`)
    // const handleDelete = (id) => console.log(`Supprimer l'élément ID : ${id}`)

    //Vous pouvez changer ici la logique qui sera appliquée dans vos bouttons d'action
    const editDisplay = (id) => console.log(`Modifier l'élément ID : ${id}`);
    const handleDelete = (id) => console.log(`Supprimer l'élément ID : ${id}`);
    // S'il y a un props editProps dans App, on l'affiche sinon on affiche editDisplay
    const handleEdit = editProps !== undefined ? editProps : editDisplay;

    return (
        <div className={classNameAppTable || "flex flex-col mt-5 "}>
            <h3
                className={
                    classNameTableTitle || "text-lg font-semibold mb-4 mt-3"
                }
            >
                {textTableTitle || "Liste des stagiaires"}
            </h3>
            <div className="p-m-1.5 overflow-x-auto">
                <div className="p-1.5 min-w-full inline-block align-middle">
                    <div className="border border-gray-200 rounded-lg divide-y divide-gray-200 shadow-sm">
                        <div className="flex flex-row justify-between items-center ">
                            <div className={visibilitySearchBar}>
                                {/* SearchBar */}
                                <SearchBarTable
                                    value={searchTerm}
                                    onChange={setSearchTerm}
                                    placeholder={
                                        placeholderTextSearchBar ||
                                        "Rechercher un stagiaire..."
                                    }
                                />
                            </div>

                            {/* Div des bouttons du header */}
                            <div
                                className={
                                    divButtonHeaderClassName ||
                                    "flex flex-row justify-between items-center gap-4 mr-3"
                                }
                            >
                                <div className={visibilityButtonOneHeader}>
                                    <button
                                        type="button"
                                        className={
                                            buttonHeaderOneClassName ||
                                            "py-1 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-blue-600 text-blue-600 hover:border-blue-500 hover:text-blue-500 focus:outline-hidden focus:border-blue-500 focus:text-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:border-blue-500 dark:text-blue-500 dark:hover:text-blue-400 dark:hover:border-blue-400"
                                        }
                                        onClick={onClickButtonHeaderOne}
                                    >
                                        {textButtonOneHeader ||
                                            " +  Ajouter un stagiaire"}
                                    </button>
                                </div>

                                <div className={visibilityButtonTwoHeader}>
                                    <button
                                        type="button"
                                        className={
                                            buttonHeaderTwoClassName ||
                                            "py-1 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-hidden focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none"
                                        }
                                    >
                                        {textButtonTwoHeader ||
                                            " Archiver la formation"}
                                    </button>
                                </div>
                            </div>
                        </div>

                        {/* Table */}
                        <Table
                            data={data} //Récupère et passe les data du tableau data à l'enfant
                            columns={columns} //les data du tableau des colonnes à l'enfant
                            currentItems={currentItems} //items de la page actuelle du tableau data
                            handleEdit={handleEdit} //arrow function à exécuter au click du boutton modifier
                            handleDelete={handleDelete} //arrow function à exécuter au click du boutton supprimer
                            divAction={divAction}
                            // props concernant le style
                            classNameTbody={classNameTbody}
                            classNameThead={classNameThead}
                            classNameTable={classNameTable} // Pour changer le stye de table
                            classNameTdataBody={classNameTdataBody}
                            classNameTdataHead={classNameTdataHead}
                            classNameTdataAction={classNameTdataAction}
                        />

                        {/* Pagination */}
                        <div className={visibilityPagination}>
                            <PaginationTable
                                totalItems={filteredData.length} // Total des données filtré correspondant à la longueur du tableau des éléments filtrés contenu dans data
                                itemsPerPage={itemsPerPage} // nombre d'item ou tr par page
                                currentPage={currentPage} //le num de la page actuelle du tableau
                                onPageChange={setCurrentPage} // au changement de la page modifier les éléments de la page en cours
                            />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
}

export default AppTable;
