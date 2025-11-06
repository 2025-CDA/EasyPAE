import React from "react";
import Container from "../../../components/ui/Container";
import Input from "../../../components/ui/Input";

export default function CompanyForm({
    companyDetails,
    handleCompanyDetailsChange,
}) {
    return (
        <Container className={"flex flex-col p-5 gap-5 md:w-[65%]"}>
            <h3 className="text-primary font-semibold">L’entreprise</h3>
            <Input
                label="Nom de l’entreprise"
                placeholder="Nom de l’entreprise"
                required
                // value={companyDetails.companyName}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyName", e.target.value)
                }
            />
            <Input
                label="Adresse de l’entreprise"
                placeholder="Adresse de l’entreprise"
                required
                value={companyDetails.companyAddress}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyAddress", e.target.value)
                }
            />
            <Input
                label="Activité"
                placeholder="Activité"
                required
                value={companyDetails.companyActivities}
                onChange={(e) =>
                    handleCompanyDetailsChange(
                        "companyActivities",
                        e.target.value
                    )
                }
            />
            <Input
                label="Téléphone"
                placeholder="Téléphone"
                required
                type="tel"
                value={companyDetails.companyPhone}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyPhone", e.target.value)
                }
            />
            <Input
                label="Mail"
                placeholder="Mail"
                required
                type="email"
                value={companyDetails.companyEmail}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyEmail", e.target.value)
                }
            />
            <Input
                label="Fax"
                placeholder="Fax"
                value={companyDetails.companyFax}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyFax", e.target.value)
                }
            />
            <Input
                label="N° SIRET"
                placeholder="N° SIRET"
                required
                value={companyDetails.companyNumber}
                onChange={(e) =>
                    handleCompanyDetailsChange("companyNumber", e.target.value)
                }
            />
        </Container>
    );
}
