import React from "react";
import Container from "../../../components/ui/Container";
import Input from "../../../components/ui/Input";
export function LegalRepresentativeForm({ legalRep, handleLegalRepChange }) {
    return (
        <Container className={"flex flex-col p-5 gap-5"}>
            <h3 className="text-primary font-semibold">Responsable légal</h3>
            <Input
                label="Nom"
                placeholder="Nom"
                required
                value={legalRep.legalRepName}
                onChange={(e) =>
                    handleLegalRepChange("legalRepName", e.target.value)
                }
            />
            <Input
                label="Prénom"
                placeholder="Prénom"
                required
                value={legalRep.legalRepLastName}
                onChange={(e) =>
                    handleLegalRepChange("legalRepLastName", e.target.value)
                }
            />
            <Input
                label="Mail"
                placeholder="Mail"
                required
                type="email"
                value={legalRep.legalRepEmail}
                onChange={(e) =>
                    handleLegalRepChange("legalRepEmail", e.target.value)
                }
            />
        </Container>
    );
}
