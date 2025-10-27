import { LockKeyhole, Mail, MoveRight } from "lucide-react";
import Container from "../../ui/Container";
import Input from "../../ui/Input";
import Checkbox from "../../ui/Checkbox";
import Button from "../../ui/Button";


export function LoginForm(props) {

    return (
        <Container className={`${props.className || ""}`}>
            <form
                onSubmit={props.handleSubmit}
                className="text-black px-3 pb-3 w-full h-full"
            >
                <div>
                    <h3 className="font-semibold mb-5 flex justify-self-center md:justify-self-start">
                        Connectez-vous
                    </h3>
                </div>
                <div>
                    <Input
                        id="email"
                        label="Adresse email"
                        type="email"
                        placeholder="Entrez votre email"
                        value={props.email}
                        onChange={(e) => props.setEmail(e.target.value)}
                        required
                        error={props.step === "error"}
                        icon={props.iconMail == true?
                            <Mail
                                size={15}
                                color={props.step === "error" ? "red" : "grey"}
                            />:""
                        }
                        withCopy={false}
                        className={
                            props.step === "error"
                                ? "bg-[#FCE7E6] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold text-red-400 rounded-md h-10 my-2"
                                : "rounded-md placeholder-secondary-text my-2 h-10 bg-background"
                        }
                    ></Input>
                </div>
                <div className="my-5">
                    <Input
                        id="password"
                        type="password"
                        label="Mot de passe"
                        placeholder="Entrez votre mot de passe"
                        value={props.password}
                        onChange={(e) => props.setPassword(e.target.value)}
                        required
                        error={props.step === "error"}
                        icon={props.iconPassword == true?
                            <LockKeyhole
                                size={15}
                                color={props.step === "error" ? "red" : "grey"}
                            />: ""
                        }
                        withShowPassword={props.withShowPassword == true ? true : false }
                        withCopy={false}
                        className={
                            props.step === "error"
                                ? "bg-[#FCE7E6] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold  text-red-400 rounded-md my-2 h-10"
                                : "rounded-md placeholder-secondary-text my-2 h-10 bg-background"
                        }
                    />
                </div>

                {/* Bloc actions et erreur */}
                <div className="w-full">
                    {/* Texte d'erreur TOUJOURS sous les deux éléments, mobile ou desktop */}
                    {props.step === "error" && (
                        <p className="text-[#FF5F57] pb-5  text-xs font-regular mt-2 whitespace-pre-line break-words max-w-full w-full">
                            {props.errorMsg ||
                                "Votre adresse email et/ou mot de passe sont incorrectes. Veuillez vérifier vos informations."}
                        </p>
                    )}
                    <div className="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
                        {/* Mot de passe oublié */}
                        <a
                            href="#"
                            className="text-blue-500 hover:underline text-sm md:order-2"
                            onClick={() => props.setStep("forgotPassword")}
                        >
                            Mot de passe oublié ?
                        </a>
                        {/* Checkbox */}
                        <div className="font-semibold flex items-center md:order-1">
                            <Checkbox
                                className="text-xs text-primary-text"
                                label="Se souvenir de moi"
                                checked={props.remember}
                                onChange={(e) =>
                                    props.setRemember(e.target.checked)
                                }
                            />
                        </div>
                    </div>
                </div>

                <Button
                    color="blue"
                    variant="solid"
                    type="submit"
                    className="mt-6 flex items-center  bg-primary w-full py-1 pb-2"
                    shape="rounded"
                >
                    Se connecter <MoveRight size={15}/>
                </Button>
            </form>
        </Container>
    );
}
