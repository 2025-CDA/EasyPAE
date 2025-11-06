import React from "react";
import Container from "../../../components/ui/Container";
import Checkbox from "../../../components/ui/Checkbox";
import Input from "../../../components/ui/Input";
export function TrainerForm({ trainerDetails, handleTrainerDetailsChange }) {
    return (
        <Container className={"flex flex-col p-5 gap-5"}>
            <h3 className="text-primary font-semibold">Tuteur/tutrice</h3>
            {/* <Checkbox
                label={"Le tuteur est identique au responsable légal"}
                checked={trainerDetails.isTrainerSame}
                onChange={(e) =>
                    handleTrainerDetailsChange(
                        "isTrainerSame",
                        e.target.checked
                    )
                }
            /> */}
            <Input
                label="Nom"
                placeholder="Nom"
                required
                value={trainerDetails.trainerName}
                onChange={(e) =>
                    handleTrainerDetailsChange("trainerName", e.target.value)
                }
            />
            <Input
                label="Prénom"
                placeholder="Prénom"
                required
                value={trainerDetails.trainerLastName}
                onChange={(e) =>
                    handleTrainerDetailsChange(
                        "trainerLastName",
                        e.target.value
                    )
                }
            />
            <Input
                label="Mail"
                placeholder="Mail"
                required
                type="email"
                value={trainerDetails.trainerEmail}
                onChange={(e) =>
                    handleTrainerDetailsChange("trainerEmail", e.target.value)
                }
            />
            <Input
                label="Téléphone"
                placeholder="Téléphone"
                required
                type="tel"
                value={trainerDetails.trainerPhone}
                onChange={(e) =>
                    handleTrainerDetailsChange("trainerPhone", e.target.value)
                }
            />
        </Container>
    );
}
