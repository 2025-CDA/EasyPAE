import Container from "../../components/ui/Container";
import Input from ".././ui/Input";

function InfoFormCompanyPae({ data, onChange }) {  // Ajout des props data et onChange
    // Fonction pour gérer les changements : met à jour l'état via onChange
    const handleChange = (field, value) => {
        onChange({ ...data, [field]: value });  // Met à jour le champ spécifique dans l'objet data
    };

    return (
        <Container className="flex flex-col w-full overflow-hidden gap-3 pl-5 border-hidden">
            <h1 className="text-primary font-semibold">L'entreprise accueil</h1>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Nom de l'entreprise :
                </p>
                <div className="flex-1 w-full ml-7">
                    <Input
                        id="companyName"
                        label={false}
                        type="text"
                        placeholder="Nom de l'entreprise"
                        required={false}
                        withCopy={false}
                        className=""
                        value={data.companyName}  // Valeur contrôlée depuis data
                        onChange={(e) => handleChange('companyName', e.target.value)}  // Met à jour via handleChange
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Adresse physique :
                </p>
                <div className="flex-1 w-full ml-11">
                    <Input
                        id="companyAddress"
                        label={false}
                        type="text"
                        placeholder="Entrez une adresse physique (ex. : 123 Rue de la Paix, 75001 Paris)"
                        required={false}
                        withCopy={false}
                        className=""
                        value={data.companyAddress}  // Valeur contrôlée
                        onChange={(e) => handleChange('companyAddress', e.target.value)}  // Met à jour
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
                        label={false}
                        type="email"
                        placeholder='exemple@exemple.fr'
                        required={false}
                        withCopy={false}
                        className=""
                        value={data.companyMail}  // Valeur contrôlée
                        onChange={(e) => handleChange('companyMail', e.target.value)}  // Met à jour
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Nom du contact :
                </p>
                <div className="flex-1 w-full ml-13">
                    <Input
                        id="tutorName"
                        label={false}
                        type="text"  // Changé de "email" à "text" car c'est un nom
                        placeholder='Nom du tuteur'
                        required={false}
                        withCopy={false}
                        className=""
                        value={data.tutorName}  // Valeur contrôlée
                        onChange={(e) => handleChange('tutorName', e.target.value)}  // Met à jour
                    />
                </div>
            </div>
        </Container>
    );
}

export default InfoFormCompanyPae;