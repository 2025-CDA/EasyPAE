import CompanyForm from "./CompanyForm";
import { LegalRepresentativeForm } from "./LegalRepresentativeForm";
import { TrainerForm } from "./TrainerForm";

export default function CompanyDetails({ formState, updateSection }) {
    return (
        <form className={"flex flex-col md:flex-row border-0 gap-5"} action="">
            <CompanyForm
                companyDetails={formState.company}
                handleCompanyDetailsChange={(key, value) =>
                    updateSection("company", key, value)
                }
            />
            <div className="flex flex-col gap-5 md:w-[35%]">
                <LegalRepresentativeForm
                    legalRep={formState.legalRep}
                    handleLegalRepChange={(key, value) =>
                        updateSection("legalRep", key, value)
                    }
                />
                <TrainerForm
                    trainerDetails={formState.trainer}
                    handleTrainerDetailsChange={(key, value) =>
                        updateSection("trainer", key, value)
                    }
                />
            </div>
        </form>
    );
}
