import React from "react";
import Container from "../../components/ui/Container";
import Avatar from "./Avatar";
import Button from "./Button";

function CardCompany({
    companyName,
    adresse,
    tutorEmail,
    tel,
    tutorName,
    className,
    avatar,
}) {
    const conditionTutorName = tutorName || "[aucune donnée renseignée]";

    return (
        <Container
            className={`flex flex-col font-medium w-full ${className} p-5`}
        >
            <h3 className="font-medium mb-4">Entreprise d'accueil</h3>
            {!avatar && (
                <h4 className="font-bold text-primary ">{companyName}</h4>
            )}
            {avatar && (
                <div className="flex items-center">
                    <Avatar
                        size="sm"
                        url={avatar}
                        className="outline-hidden mr-3"
                    />
                    <p>{companyName}</p>
                </div>
            )}

            <div className="flex flex-col gap-2 mb-3">
                <p>Adresse : {adresse} </p>
                <p>Mail contact : {tutorEmail} </p>
                {tel && <p>N° téléphone : {tel} </p>}
                <p>Nom du tuteur : {conditionTutorName} </p>
            </div>
        </Container>
    );
}

export default CardCompany;
