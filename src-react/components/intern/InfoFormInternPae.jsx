import Container from "../../components/ui/Container";
import Input from ".././ui/Input";

function InfoFormInternPae() {
    return (
        <Container className="flex flex-col w-full overflow-hidden">
            {" "}
            {/* Masque les scrollbars horizontale et verticale */}
            <h1 className="text-primary font-semibold">Mes informations</h1>
            {/* Labels avec w-20 pour responsive, écart uniforme */}
            <div className="flex flex-col md:flex-row w-full items-center md:items-start">
                {" "}
                {/* Changé en flex-col sur mobile pour éviter overflow horizontal */}
                <p className="w-full md:w-20 whitespace-nowrap mb-2 md:mb-0">
                    Prénom :
                </p>{" "}
                {/* Ajusté pour mobile */}
                <div className="flex-1 w-full md:ml-4">
                    <Input
                        id="prenom"
                        label={false}
                        type="text"
                        placeholder="Entrez votre prénom"
                        required={false}
                        withCopy={false}
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-col md:flex-row w-full items-center md:items-start">
                <p className="w-full md:w-20 whitespace-nowrap mb-2 md:mb-0">
                    Nom :
                </p>
                <div className="flex-1 w-full md:ml-4">
                    <Input
                        id="nom"
                        label={false}
                        type="text"
                        placeholder="Entrez votre nom"
                        required={false}
                        withCopy={false}
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-col md:flex-row w-full items-center md:items-start">
                <p className="w-full md:w-20 whitespace-nowrap mb-2 md:mb-0">
                    Email :
                </p>
                <div className="flex-1 w-full md:ml-4">
                    <Input
                        id="email"
                        label={false}
                        type="email"
                        placeholder="Entrez votre email"
                        required={false}
                        withCopy={false}
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-col md:flex-row w-full items-center md:items-start">
                <p className="w-full md:w-20 whitespace-nowrap mb-2 md:mb-0">
                    Formation :
                </p>
                <div className="flex-1 w-full md:ml-4">
                    <Input
                        id="formation"
                        label={false}
                        type="text"
                        placeholder="Entrez votre formation"
                        required={false}
                        withCopy={false}
                        className=""
                    />
                </div>
            </div>
            <h3 className="text-primary font-bold">Période en entreprise</h3>
            <div className="flex flex-col md:flex-row w-full items-center md:items-start">
                <p className="w-full md:w-20 whitespace-nowrap mb-2 md:mb-0">
                    Dates :
                </p>
            </div>
        </Container>
    );
}

export default InfoFormInternPae;
