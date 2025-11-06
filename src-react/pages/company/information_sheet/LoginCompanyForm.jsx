import { useState } from "react";
import Container from "../../../components/ui/Container";
import Input from "../../../components/ui/Input";
import Button from "../../../components/ui/Button";
import useWindowSize from "../../../hooks/useWindowSize";
import logoNameFullWhite from "../../../assets/logoNameFullWhite.png";
import ManWorkingComputer from "../../../assets/Man-working-computer.png";
import useAxios from "../../../hooks/useAxios";
import { TokenManager } from '../../../helpers/TokenManager'
// import { useLocation } from "react-router-dom";


///////////////////////////////////////////////
///////////////////////////////////////////////
///////////////////////////////////////////////
///////////////////////////////////////////////
// Attentiion, le token utilisé en dur ne fonctionne pas,
// déco l'user pour passer sur un autre
// les infos comprises dedans ne comprennnent pas les infos dont on a besoin*
// a fixer
// peut etre avec tes mail company et vrai token associé
// personnellement, j'abandonne, bon courage !
///////////////////////////////////////////////
///////////////////////////////////////////////
///////////////////////////////////////////////
///////////////////////////////////////////////


export default function LoginCompanyForm() {

    const myTokenObj =  {
        "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJpYXQiOjE3NjI0MzMzNzcsImV4cCI6MTc2MjQzNjk3Nywicm9sZXMiOlsiUk9MRV9sZWdhbF9yZXByZXNlbnRhdGl2ZSIsImNvbXBhbnkiXSwiZW1haWwiOiJsZWdhbHJwZmFjZWJvb2tAZ21haWwuY29tIiwiaWQiOjIzLCJmaXJzdE5hbWUiOiJNYXJrIiwibGFzdE5hbWUiOiJadWNrZXJiZXJnIiwiZnVsbE5hbWUiOiJNYXJrIFp1Y2tlcmJlcmciLCJpc0ZpcnN0Q29ubmVjdGlvbiI6ZmFsc2UsImlwIjoiMTI3LjAuMC4xIn0.nRnbjGq1ULL7vkgzKO-WWfac9eYpu6jt1a8IzRgQHOxBK8hm0SmI-IuPx93CmFaiiEe_O8dLMkn955k9hdjZSWGAJzNb_uva-B2cpVXQfDyrnAfJtsIIVEzi9-62Ot1iosQaso5iWx9Jw1Hr73J9N-Cki0awV77CtrBZHGkzQnlmJROm9IZfIKuE_X8pym8kPLFsbIw4K85w_WzT3L39DPbuY4msauqZS2Fex69wU3zSfHvTXWFSpRVxA5CgiG8YQeuIETRTfelu2bGols16vSHpNK3Rr-l5Xg6X0nrDw-Ly1R9-I0dYc9rU_Qb0zJqWVkjs-KO79TWcxdf2ORoC-g"
    }
    const tokenManager = new TokenManager();
    tokenManager.setToken(myTokenObj.token);
    const decoded = tokenManager.decodeToken(myTokenObj.token);

    // const location = useLocation();
    // const searchParams = new URLSearchParams(location.search);
    // const tokenFromUrl = searchParams.get("token");

    // const tokenManager = new TokenManager();
    // if (tokenFromUrl) {
    //     tokenManager.setToken(tokenFromUrl);
    // }
    // const decoded = tokenFromUrl ? tokenManager.decodeToken(tokenFromUrl) : null;


    const { width } = useWindowSize();
    const isMobile = width < 768;
    const { fetchData } = useAxios();


    const [ body, setBody ] = useState({
        "infoFormId": decoded?.infoFormId ?? "",
        "firstName": decoded?.internFirstName ?? "",
        "lastName": decoded?.internLastName ?? "",
        "email": decoded?.tutorMail ?? "",
        "login": "",
        "plainPassword": "",
        "phoneNumber": "",
        "isLegalRepresentative": true,
        "siret": "",
        "companyName": decoded?.companyName ?? "",
        "companyPhoneNumber": "",
        "companyAddress": "",
        "address": "",
        "birthday": ""
    });

    const handleInputChange = (field, value) => {
        setBody(prev => ({
            ...prev,
            [field]: value
        }));
    };

    const postData = async () => {
        await fetchData(
            "POST",
            `user/companyMember`,
            body
        );
    };


    return (
        <div className="flex w-screen min-h-screen flex-col md:flex-row bg-primary min-w-screen  ">
            {/* Div bleue (première enfant) */}
            <div className="flex flex-col flex-[1] w-full bg-primary px-5">
                <div className="w-full flex-1 flex flex-col justify-center">
                    <div className="flex justify-center items-center md:block md:pt-0 mt-10 md:mt-0">
                        <img
                            src={logoNameFullWhite}
                            alt="logoNameInWhiteColor"
                            className="w-[40%] py-8 md:py-0 md:mb-20 xl:mb-20"
                        />
                    </div>

                    <div className="md:flex md:flex-col md:justify-center md:w-full md:pt-10 md:gap-8">
                        {!isMobile && (
                            <p className="text-background md:text-[30px] lg:text-[45px] xl:text-[40px] md:font-bold">
                                Gérez vos démarches en quelques clics.
                            </p>
                        )}
                        <p className="text-background text-[16px] pb-8 md:p-0 md:text-[25px] lg:text-[20px] md:mt-5 xl:mt-2">
                            Accédez facilement à vos conventions, suivez vos
                            validations et gardez une vue claire sur l'ensemble
                            de votre parcours.
                        </p>
                    </div>
                </div>

                {/* Image en bas à droite, uniquement sur desktop */}
                {!isMobile && (
                    <img
                        src={ManWorkingComputer}
                        alt="A man working on a computer"
                        className="self-end mt-auto max-w-[45%] md:max-w-[45%] lg:max-w-[30%]"
                    />
                )}
            </div>

            {/* Div blanche (deuxième enfant) */}
            <div className="flex flex-col flex-[2] lg:flex-[1] items-center scroll-y-scroll md:justify-center md:border md:w-2/3 lg:1/2 rounded-t-[50px] md:rounded-t-[0px] border-background md:border-hidden bg-logo">
                <Container className={"flex flex-col p-5 gap-5 md:w-[65%] w-[90%] my-10 bg-white"}>
                    <form
                        className="flex flex-col gap-5"
                        onSubmit={e => {
                            e.preventDefault();
                            postData();
                        }}
                    >
                        <h3 className="text-primary font-semibold">Tuteur</h3>
                        <Input
                            label="Nom"
                            placeholder="Entrez ici le nom de famille du tuteur"
                            required
                            value={body.lastName}
                            onChange={(e) =>
                                handleInputChange("lastName", e.target.value)
                            }
                        />
                        <Input
                            label="Prénom"
                            placeholder="Entrez ici le prénom du tuteur ..."
                            required
                            value={body.firstName}
                            onChange={(e) =>
                                handleInputChange("firstName", e.target.value)
                            }
                        />
                        <Input
                            label="Adresse mail"
                            placeholder="Entrez ici l'adresse mail du tuteur ..."
                            required
                            value={body.email}
                            onChange={(e) =>
                                handleInputChange("email", e.target.value)
                            }
                        />
                        <Input
                            label="Indentifiant"
                            placeholder="Entrez ici l'identifiant avec lequel le tuteur se connectera ..."
                            required
                            value={body.login}
                            onChange={(e) =>
                                handleInputChange("login", e.target.value)
                            }
                        />
                        <Input
                            label="Mot de passe"
                            placeholder="Entrez ici un mot de passe grace auquel le tuteur pourra se connecter ..."
                            required
                            value={body.plainPassword}
                            onChange={(e) =>
                                handleInputChange("plainPassword", e.target.value)
                            }
                        />
                        <Input
                            label="Numéro de téléphone"
                            placeholder="Entrez ici le numéro de téléphone de contact du tuteur ..."
                            required
                            value={body.phoneNumber}
                            onChange={(e) =>
                                handleInputChange("phoneNumber", e.target.value)
                            }
                        />
                        <Input
                            label="Adresse Postale"
                            placeholder="Entrez ici l'adresse postale du tuteur ..."
                            required
                            value={body.address}
                            onChange={(e) =>
                                handleInputChange("address", e.target.value)
                            }
                        />
                        <Input
                            label="Date de naissance"
                            placeholder="Entrez ici la date de naissance du tuteur ..."
                            required
                            type="date"
                            value={body.birthday}
                            onChange={(e) =>
                                handleInputChange("birthday", e.target.value)
                            }
                        />
                        <hr />
                        <h3 className="text-primary font-semibold">Entreprise</h3>
                        <Input
                            label="SIRET"
                            placeholder="Entrez ici le SIRET de l'entreprise ..."
                            required
                            value={body.siret}
                            onChange={(e) =>
                                handleInputChange("siret", e.target.value)
                            }
                        />
                        <Input
                            label="Raison Sociale"
                            placeholder="Entrez ici le nom de l'entreprise ..."
                            required
                            value={body.companyName}
                            onChange={(e) =>
                                handleInputChange("companyName", e.target.value)
                            }
                        />
                        <Input
                            label="Numéro de téléphone"
                            placeholder="Entrez ici le numéro de téléphone de l'entreprise ..."
                            required
                            value={body.companyPhoneNumber}
                            onChange={(e) =>
                                handleInputChange("companyPhoneNumber", e.target.value)
                            }
                        />
                        <Input
                            label="Adresse Postale de l'entreprise"
                            placeholder="Entrez ici l'adresse postale de l'entreprise ..."
                            required
                            value={body.companyAddress}
                            onChange={(e) =>
                                handleInputChange("companyAddress", e.target.value)
                            }
                        />

                        <Button
                            className={'mt-5'}
                            type="submit"
                        >Valider</Button>
                    </form>
                </Container>
                {/* Image en bas à droite, uniquement sur mobile */}
                {isMobile && (
                    <img
                        src={ManWorkingComputer}
                        alt="A man working on a computer"
                        className="self-end max-w-[30%]"
                    />
                )}
            </div>
        </div>
    );
}
