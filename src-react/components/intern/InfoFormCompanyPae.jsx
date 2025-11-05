import Container from "../../components/ui/Container";
import Input from ".././ui/Input";

function InfoFormCompanyPae({ data, onChange }) {
    // Ajout des props data et onChange

    return (
        <Container className="flex flex-col w-full overflow-hidden gap-3 pl-5 border-hidden">
            <h1 className="text-primary font-semibold">L'entreprise accueil</h1>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Nom de l'entreprise :
                </p>
                <div className="flex-1 w-full ml-5">
                    <Input
                        id="companyName"
                        label=""
                        type="text"
                        placeholder="Nom de l'entreprise"
                        required
                        value={data.companyName} // Valeur contrôlée depuis data
                        onChange={onChange} // Met à jour via handleChange
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Adresse physique :
                </p>
                <div className="flex-1 w-full ml-9">
                    <Input
                        id="companyAddress"
                        label=""
                        type="text"
                        placeholder="Entrez une adresse physique (ex. : 123 Rue de la Paix, 75001 Paris)"
                        required
                        value={data.companyAddress}
                        onChange={onChange}
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Mail contact :
                </p>
                <div className="flex-1 w-full ml-20">
                    <Input
                        id="companyMail"
                        label=""
                        type="email"
                        placeholder="exemple@exemple.fr"
                        required
                        value={data.companyMail}
                        onChange={onChange} // Met à jour
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Nom du contact :
                </p>
                <div className="flex-1 w-full ml-13">
                    <Input
                        id="contactLastName"
                        label=""
                        type="text" // Changé de "email" à "text" car c'est un nom
                        placeholder="Nom du contact"
                        required
                        value={data.contactLastName} // Valeur contrôlée
                        onChange={onChange} // Met à jour
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Prénom du contact :
                </p>
                <div className="flex-1 w-full ml-7">
                    <Input
                        id="contactFirstName"
                        label=""
                        type="text" // Changé de "email" à "text" car c'est un nom
                        placeholder="Prénom du contact"
                        required
                        value={data.contactFirstName} // Valeur contrôlée
                        onChange={onChange} // Met à jour
                    />
                </div>
            </div>
        </Container>
    );
}

export default InfoFormCompanyPae;
