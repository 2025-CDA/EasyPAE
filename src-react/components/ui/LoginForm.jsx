import { useState } from "react";
import Label from "./Label";
import Button from "./Button";
import Input from "./Input";
import { LogIn, Mail, LockKeyhole, MoveRight } from "lucide-react";
import Checkbox from "./Checkbox";
import Container from "./Container";

function LoginForm({ initialStep = "login", className }) {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [provisionalPassword, setProvisionalPassword] = useState("");
    const [errorMsg, setErrorMsg] = useState("");
    const [remember, setRemember] = useState(false);
    const [step, setStep] = useState(initialStep); // 'login' | 'error' | 'firstConnect' | 'forgotPassword'



    // useEffect(() => { setStep(initialStep); }, [initialStep]);
    // Handler de soumission classique
        const handleSubmit = (e) => {
            e.preventDefault();
            // Appel API ici, gestion du résultat
            // Si erreur → setStep('error')
            // Si première connexion → setStep('firstConnect')
        };

         // Handler pour recup mdp oublié
        const handleForgot = (e) => {
            e.preventDefault();
        // Traitement ici
        };

    // Handlers pour chaque étape

    return (
        <div className=" p-5">
            {step === "login" || step === "error" ? (
                <Container className="w-full xl:w-auto max-w-md xl:max-w-xl border-hidden xl:border xl:shadow-xl xl:rounded-lg xl:p-8">
                    <form
                        onSubmit={handleSubmit}
                        className="text-black min-w-[350px] w-full px-3 pt-3 pb-10"
                    >
                        <div>
                            <h3 className="font-semibold mb-5 flex justify-self-center xl:justify-self-start">
                                Connectez-vous
                            </h3>
                        </div>
                        <div>
                            <Input
                                id="email"
                                label="Votre email"
                                type="email"
                                placeholder="Entrez votre email"
                                value={email}
                                onChange={(e) => setEmail(e.target.value)}
                                required
                                error={step === "error"}
                                icon={
                                    <Mail
                                        size={15}
                                        color={
                                            step === "error" ? "red" : "grey"
                                        }
                                    />
                                }
                                withCopy={false}
                                className={
                                    step === "error"
                                        ? "bg-[#ff5f5740] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold text-red-400 rounded-xl my-2"
                                        : "rounded-xl placeholder-secondary-text my-2"
                                }
                            ></Input>
                        </div>
                        <div className="my-5">
                            <Input
                                id="password"
                                type="password"
                                label="Mot de passe"
                                placeholder="Entrez votre mot de passe"
                                value={password}
                                onChange={(e) => setPassword(e.target.value)}
                                required
                                error={step === "error"}
                                icon={
                                    <LockKeyhole
                                        size={15}
                                        color={
                                            step === "error" ? "red" : "grey"
                                        }
                                    />
                                }
                                withShowPassword
                                withCopy={false}
                                className={
                                    step === "error"
                                        ? "bg-[#ff5f5740] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold  text-red-400 rounded-xl my-2"
                                        : "rounded-xl placeholder-secondary-text my-2 "
                                }
                            />
                        </div>

                        {/* Bloc actions et erreur */}
                        <div className="w-full mt-4">
                            {/* Texte d'erreur TOUJOURS sous les deux éléments, mobile ou desktop */}
                            {step === "error" && (
                                <p className="text-red-400 pb-5 text-sm font-semibold mt-2 whitespace-pre-line break-words max-w-full w-full">
                                    {errorMsg ||
                                        "Votre adresse email et/ou mot de passe sont incorrectes.\nVeuillez vérifier vos informations."}
                                </p>
                            )}
                            <div className="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-2">
                                {/* Mot de passe oublié */}
                                <a
                                    href="#"
                                    className="text-blue-500 hover:underline text-sm xl:order-2"
                                    onClick={() => setStep("forgotPassword")}
                                >
                                    Mot de passe oublié ?
                                </a>
                                {/* Checkbox */}
                                <div className="font-semibold flex items-center text-sm xl:order-1">
                                    <CheckBox
                                        className="text-xs text-primary-text"
                                        label="Se souvenir de moi"
                                        checked={remember}
                                        onChange={(e) =>
                                            setRemember(e.target.checked)
                                        }
                                    />
                                </div>
                            </div>
                        </div>

                        <Button
                            color="blue"
                            variant="solid"
                            type="submit"
                            className="mt-6 flex items-center gap-2 bg-primary"
                            shape="rounded"
                        >
                            Se connecter <MoveRight />
                        </Button>
                    </form>
                </Container>
            ) : null}
            {step === "firstConnect" && (
                <form
                    className="text-sm font-semibold min-w-[400px] w-full" /* handler ici */
                >
                    <h3 className="font-semibold mb-8">Première Connexion</h3>
                    <Input
                        id="provisional-password"
                        label="Mot de passe provisoire"
                        type="password"
                        placeholder="Mot de passe provisoire"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required={false}
                        withShowPassword
                        withCopy={false}
                        className="my-3 w-15 h-10"
                    />
                    <p className="text-secondary-text text-md">
                        Entrez le mot de passe reçu par email afin de vous{" "}
                        <br />
                        connecter
                    </p>
                    <div className="w-xs">
                        <a href="/">
                            <Button
                                color="blue"
                                type="submit"
                                className="mt-2 flex items-center gap-2"
                                shape="rounded"
                            >
                                Créer mon compte <MoveRight size={12} />
                            </Button>
                        </a>
                    </div>
                </form>
            )}
            {step === "forgotPassword" && (
                <form
                    onSubmit={handleForgot}
                    className="text-sm font-semibold min-w-[400px] w-full"
                >
                    <h3 className="font-bold text-primary-text pb-8">
                        Mot de passe oublié
                    </h3>
                    <Input
                        id="recover-email"
                        label="Email"
                        type="email"
                        placeholder="votre@email.com"
                        value={email}
                        onChange={(e) => setEmail(e.target.value)}
                        required={false}
                        withCopy={false}
                        className="h-10 my-2"
                    />
                    <p className="text-secondary-text">
                        Entrez l'adresse mail associée à votre compte pour
                        modifier <br /> votre mot de passe
                    </p>
                    <Button
                        color="blue"
                        variant="solid"
                        type="submit"
                        className="mt-2 pb-2 w-sm"
                        shape="rounded"
                    >
                        Récupérer mon compte <MoveRight size={10} />
                    </Button>
                </form>
            )}

            </div>
    );
}

export default LoginForm;
