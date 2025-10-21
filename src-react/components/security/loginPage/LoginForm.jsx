import { LockKeyhole, Mail, MoveRight } from "lucide-react";
import Container from "../../ui/Container";
import Input from "../../ui/Input";
import Checkbox from "../../ui/Checkbox";
import Button from "../../ui/Button";

export function LoginForm(props) {
    return (
        <Container className="w-full xl:w-auto max-w-md xl:max-w-xl border-hidden xl:border xl:shadow-xl xl:rounded-lg xl:p-8">
            <form
                onSubmit={props.handleSubmit}
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
                        value={props.email}
                        onChange={(e) => props.setEmail(e.target.value)}
                        required
                        error={props.step === "error"}
                        icon={
                            <Mail
                                size={15}
                                color={props.step === "error" ? "red" : "grey"}
                            />
                        }
                        withCopy={false}
                        className={
                            props.step === "error"
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
                        value={props.password}
                        onChange={(e) => props.setPassword(e.target.value)}
                        required
                        error={props.step === "error"}
                        icon={
                            <LockKeyhole
                                size={15}
                                color={props.step === "error" ? "red" : "grey"}
                            />
                        }
                        withShowPassword
                        withCopy={false}
                        className={
                            props.step === "error"
                                ? "bg-[#ff5f5740] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold  text-red-400 rounded-xl my-2"
                                : "rounded-xl placeholder-secondary-text my-2 "
                        }
                    />
                </div>

                {/* Bloc actions et erreur */}
                <div className="w-full mt-4">
                    {/* Texte d'erreur TOUJOURS sous les deux éléments, mobile ou desktop */}
                    {props.step === "error" && (
                        <p className="text-red-400 pb-5 text-sm font-semibold mt-2 whitespace-pre-line break-words max-w-full w-full">
                            {props.errorMsg ||
                                "Votre adresse email et/ou mot de passe sont incorrectes.\nVeuillez vérifier vos informations."}
                        </p>
                    )}
                    <div className="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-2">
                        {/* Mot de passe oublié */}
                        <a
                            href="#"
                            className="text-blue-500 hover:underline text-sm xl:order-2"
                            onClick={() => props.setStep("forgotPassword")}
                        >
                            Mot de passe oublié ?
                        </a>
                        {/* Checkbox */}
                        <div className="font-semibold flex items-center text-sm xl:order-1">
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
                    className="mt-6 flex items-center gap-2 bg-primary w-full"
                    shape="rounded"
                >
                    Se connecter <MoveRight />
                </Button>
            </form>
        </Container>
    );
}
