import { ForgetPassword } from "../../components/security/loginPage/ForgetPassword";
import { FirstConnection } from "../../components/security/loginPage/FirstConnection";
import { LoginForm } from "../../components/security/loginPage/LoginForm";
import { useState } from "react";
import logoNameFullWhite from "../../assets/LogoNameFullWhite.png";
import ManWorkingComputer from "../../assets/Man-working-computer.png";
import useWindowSize from "../../hooks/useWindowSize";
import Container from "../../components/ui/Container";
import axios from "axios";
import useAxios from "../../hooks/useAxios";
import { redirect } from "react-router-dom";
import { useAuthContext } from "../../store/auth_context/authContext";

function LoginPage({ initialStep = "login", className }) {
    const [email, setEmail] = useState("");
    const [password, setPassword] = useState("");
    const [errorMsg, setErrorMsg] = useState("");
    const [remember, setRemember] = useState(false);
    const [step, setStep] = useState(initialStep); // 'login' | 'error' | 'firstConnect' | 'forgetPassword' | 'mailSent'
    const { width } = useWindowSize();
    const isMobile = width < 768;

    const { signIn } = useAuthContext();
    async function handleLogin(e) {
        e.preventDefault();
        signIn(email, password);
    }

    return (
        <div className="flex w-screen min-h-screen h-screen flex-col md:flex-row bg-primary min-w-screen overflow-hidden">
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
            <div className="flex flex-col flex-[2] lg:flex-[1] items-center md:justify-center md:border md:w-2/3 lg:1/2 rounded-t-[50px] md:rounded-t-[0px] border-background md:border-hidden bg-logo">
                {step === "firstConnect" && (
                    <h3 className="font-semibold pt-8 md:pb-5">
                        Première Connexion
                    </h3>
                )}
                {step === "forgetPassword" && (
                    <h3 className="font-semibold pt-8 md:pb-5">
                        Mot de passe oublié
                    </h3>
                )}
                <div className="flex-1 flex md:flex-0 md:flex items-center justify-center w-full">
                    {step === "login" || step === "error" ? (
                        <LoginForm
                            email={email}
                            setEmail={setEmail}
                            password={password}
                            setPassword={setPassword}
                            errorMsg={errorMsg}
                            remember={remember}
                            setRemember={setRemember}
                            step={step}
                            setStep={setStep}
                            handleSubmit={handleLogin}
                            iconMail={!isMobile}
                            iconPassword={!isMobile}
                            withShowPassword={!isMobile}
                            className="
    w-[90%] md:min-h-[35vh]   md:w-[60%] lg:w-[70%] xl:w-[55%] border-hidden md:mt-0 md:border md:shadow-md md:rounded-lg text-sm md:bg-background"
                        ></LoginForm>
                    ) : null}
                    {step === "firstConnect" && (
                        <FirstConnection
                            password={password}
                            setPassword={setPassword}
                        ></FirstConnection>
                    )}
                    {step === "forgetPassword" && (
                        <ForgetPassword
                            email={email}
                            setEmail={setEmail}
                            handleForgot={handleForgot}
                            className="w-[75%]"
                        ></ForgetPassword>
                    )}
                    {step === "mailSent" && (
                        <Container className=" mx-10 border-t-4 border-t-blue-600 bg-background">
                            <div>
                                <h4 className="pb-2 font-semibold">
                                    Email envoyé
                                </h4>
                                <p>
                                    Si une adresse email correspond à un compte
                                    existant, un lien de réinitialisation du mot
                                    de passe vient d’être envoyé. Pensez à
                                    vérifier vos spams ou courriers
                                    indésirables.
                                </p>
                            </div>
                        </Container>
                    )}
                </div>

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

export default LoginPage;
