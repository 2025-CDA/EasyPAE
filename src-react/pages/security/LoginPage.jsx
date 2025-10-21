import { ForgetPassword } from "../../components/security/loginPage/ForgetPassword";
import { FirstConnection } from "../../components/security/loginPage/FirstConnection";
import { LoginForm } from "../../components/security/loginPage/LoginForm";
import { useState } from "react";
import logoNameLogoWhite from "../../assets/LogoNamelogoWhite.png";

function LoginPage({ initialStep = "login", className }) {
    console.log(initialStep);
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
        <div className="flex w-screen h-screen flex-row">
            <div className="flex justify-center items-center w-1/2 bg-primary">
                <img src={logoNameLogoWhite} alt="" className="w-[50%]" />
            </div>
            <div className="flex flex-col justify-center items-center w-1/2">
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
                        handleSubmit={handleSubmit}
                    ></LoginForm>
                ) : null}
                {step === "firstConnect" && (
                    <FirstConnection
                        password={password}
                        setPassword={setPassword}
                    ></FirstConnection>
                )}
                {step === "forgotPassword" && (
                    <ForgetPassword
                        email={email}
                        setEmail={setEmail}
                        handleForgot={handleForgot}
                    ></ForgetPassword>
                )}
            </div>
        </div>
    );
}

export default LoginPage;
