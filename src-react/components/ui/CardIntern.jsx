import React from "react";
import Container from "../../components/ui/Container";
import Test from "../../assets/profile.jpg";
import Avatar from "./Avatar";
import Button from "./Button";

function CardIntern({
    name,
    role,
    internNumber,
    email,
    courseName,
    courseNumber,
    trainerName,
    startDateInternship,
    endDateInternship,
    className,
    avatarUrl, // choisir une valeur de façon dynamique, selon ce qui est disponible
    onEdit, // Handler callback (optionnel)
    buttonLabel, // Label custom
    extra, // Slot pour info(s) additionnelle(s)
    showButton = false, // Par défaut le bouton s’affiche
}) {
    return (
        <Container
            className={`flex flex-col font-medium w-full  lg:flex-row gap-6   ${className}`}
        >
            {/* -------------------------------Div donner de stagiare  -------------------------*/}
            <div className="w-full flex flex-col">
                {/* ----Header avec avatar et nom---- */}
                <div className="flex items-center w-full">
                    <Avatar
                        size="sm"
                        url={Test || avatarUrl}
                        className="outline-hidden mr-2"
                    />
                    <h3>
                        {name}
                        {role && <span className="text-gray-600">{role}</span>}
                    </h3>
                </div>
                {/* ------Détails du stagiaire-------- */}
                <div className="flex flex-col gap-2 mb-3">
                    {internNumber && <h5>N° stagiaire : {internNumber}</h5>}
                    {email && <h5>Email : {email}</h5>}
                    {(courseName || courseNumber) && (
                        <h5>
                            Formation : {courseName}{" "}
                            {courseNumber && `n°${courseNumber}`}
                        </h5>
                    )}
                    {trainerName && <h5>Formateur : {trainerName}</h5>}
                    {startDateInternship && endDateInternship && (
                        <h5>{`Période de stage : du ${startDateInternship} au ${endDateInternship}`}</h5>
                    )}
                    {extra}
                </div>
            </div>

            {/* ------------------ Div Bouton d'édition------------------------- */}
            {showButton && (
                <div className="lg:w-1/3 flex flex-col items-center justify-center gap-2">
                    <Button
                        className="w-full lg:w-[60%]"
                        variant="outline"
                        onClick={onEdit}
                    >
                        {buttonLabel}
                    </Button>
                </div>
            )}
        </Container>
    );
}

export default CardIntern;
