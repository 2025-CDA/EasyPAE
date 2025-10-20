import { useState } from "react";
import Label from "./Label"
import Button from "./Button"
import Input from "./Input"
import { LogIn , Mail, LockKeyhole, MoveRight } from "lucide-react";
import CheckBox from "./Checkbox";


function LoginForm({
    initialStep = 'login',


}) {

    const [email, setEmail] = useState('');
    const [password, setPassword] = useState('');
    const [remember, setRemember] = useState(false);
    const [provisionalPassword, setProvisionalPassword] = useState("");
    const [step, setStep] = useState(initialStep); // 'login' | 'error' | 'firstConnect' | 'forgotPassword'
    const [errorMsg, setErrorMsg] = useState('');

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

  // Handlers pour chaque étape

  return (
    <div className="gap-y-5 p-10" >
      {step === 'login' || step === 'error' ? (
        <form onSubmit={handleSubmit} className="text-black">
            <div>
                <h3 className="font-semibold my-5">Connectez-vous</h3>
            </div>
            <div>
                <Input
                    id="email"
                    label="Votre email"
                    type="email"
                    placeholder="Entrez votre email"
                    value={email}
                    onChange={e => setEmail(e.target.value)}
                    required
                    error={step === 'error'}
                    icon={<Mail size={15} color={step === 'error' ? 'red' : 'grey'} />}
                    withCopy={false}
                    className={step === 'error' ? 'bg-[#ff5f5740] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold' : ''}>
                </Input>
            </div>
            <div className='my-5'>
                <Input
                    id="password"
                    type="password"
                    label="Mot de passe"
                    placeholder="Entrez votre mot de passe"
                    value={password}
                    onChange={e => setPassword(e.target.value)}
                    required
                    error={step === 'error'}
                    icon={<LockKeyhole size={15} color={step === 'error' ? 'red' : 'grey'}/>}
                    withShowPassword
                    withCopy={false}
                    className={step === 'error' ? 'bg-[#ff5f5740] border-2 border-red-400 outline-red-400 placeholder-red-400 font-semibold  text-red-400' : ''}
                />
            </div>

            {step === 'error' && (
                <p className="text-red-400 text-sm mt-2 whitespace-pre-line font-semibold">
                    {errorMsg || 'Votre adresse email et/ou mot de passe sont incorrectes. \nVeuillez vérifier vos informations.'}
                </p>
            )}
        </div>
    );
}

export default LoginForm;
