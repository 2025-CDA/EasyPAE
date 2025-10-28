import React, { useState } from 'react';
import { Copy } from 'lucide-react';

function FicheRenseignStagiaire({ withCopy = true, title = "TITRE", data = {} }) {
    // data est un objet qui contient les infos de l'intern et de la company
    const [copiedField, setCopiedField] = useState('');

    const handleCopy = (text, field) => {
        navigator.clipboard.writeText(text).then(() => {
            setCopiedField(field);
            setTimeout(() => setCopiedField(''), 3000);
        }).catch(err => {
            console.error('Erreur de copie :', err);
        });
    };

    return (
        <div className="w-full h-full">
            <h3 className="text-primary font-semibold mb-4">
                {title}
            </h3>
            {/* ----------------- Fiche stagiaire-------------------- */}
            <div className="grid grid-cols-3 gap-x-4 gap-y-3 text-sm">
                {/* -------Informations personnelles---------- */}
                <div className="col-span-3 font-bold text-primary">Informations personnelles</div>

                <div className="primary-text font-bold">Prénom :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.firstNameIntern || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center"> 
                        <Copy
                            className="text-secondary-text cursor-pointer transition-all duration-200 hover:text-primary active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.firstNameIntern || '', 'firstName')}
                        />
                        {copiedField === 'firstName' && (
                            <span className="text-green-500 text-xs ml-1">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Nom :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.lastNameIntern || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.lastNameIntern || '', 'lastName')}
                        />
                        {copiedField === 'lastName' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Email :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.mailIntern || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.mailIntern || '', 'email')}
                        />
                        {copiedField === 'email' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Formation :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{`${data.nameCourse || 'Non défini'} N°${data.nbCourse || 'Non défini'}`}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(`${data.nameCourse || ''} N°${data.nbCourse || ''}`, 'course')}
                        />
                        {copiedField === 'course' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                {/* Période */}
                <div className="col-span-3 font-bold text-blue-700 mt-2">Période en entreprise</div>

                <div className="primary-text font-bold">Dates</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{`Du ${data.startDateInternship || 'Non défini'} au ${data.endDateInternship || 'Non défini'}`}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(`Du ${data.startDateInternship || ''} au ${data.endDateInternship || ''}`, 'dates')}
                        />
                        {copiedField === 'dates' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                {/* Entreprise */}
                <div className="col-span-3 font-bold text-blue-700 mt-2">L’entreprise d’accueil</div>

                <div className="primary-text font-bold">Nom de l'entreprise :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.companyName || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.companyName || '', 'companyName')}
                        />
                        {copiedField === 'companyName' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Adresse physique :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.companyAddress || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.companyAddress || '', 'adresse')}
                        />
                        {copiedField === 'adresse' && (
                            <span className="text-green-500 text-xs ml-1">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Mail contact :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.companyMail || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.companyMail || '', 'companyEmail')}
                        />
                        {copiedField === 'companyEmail' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}

                <div className="primary-text font-bold">Nom du contact :</div>
                <div className={`text-gray-400 ${!withCopy ? 'col-span-2' : ''}`}>{data.tutorName || 'Non défini'}</div>
                {withCopy && (
                    <div className="flex items-center justify-center">
                        <Copy
                            className="text-gray-400 cursor-pointer transition-all duration-200 hover:text-blue-500 active:scale-95 active:text-green-500"
                            size={18}
                            onClick={() => handleCopy(data.tutorName || '', 'tutorName')}
                        />
                        {copiedField === 'tutorName' && (
                            <span className="text-green-500 text-xs ml-1 ">Copié</span>
                        )}
                    </div>
                )}
            </div>
        </div>
    );
}

export default FicheRenseignStagiaire;