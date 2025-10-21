import { MoveRight } from "lucide-react";
import Button from "../../ui/Button";
import Container from "../../ui/Container";
import Input from "../../ui/Input";

export function FirstConnection(props) {
    return (
        <Container className="w-full xl:w-auto max-w-md xl:max-w-xl border-hidden xl:border xl:shadow-xl xl:rounded-lg xl:p-8">
            <form
                className="text-sm font-semibold min-w-[400px] w-full"
                /* handler ici */
            >
                <h3 className="font-semibold mb-8 justify-self-center xl:justify-self-start">
                    Première Connexion
                </h3>
                <Input
                    id="provisional-password"
                    label="Mot de passe provisoire"
                    type="password"
                    placeholder="Mot de passe provisoire"
                    value={props.password}
                    onChange={(e) => props.setPassword(e.target.value)}
                    required={false}
                    withShowPassword
                    withCopy={false}
                    className="my-3 w-15 h-10 "
                />
                <p className="text-secondary-text text-md ">
                    Entrez le mot de passe reçu par email afin de vous <br />
                    connecter
                </p>
                <div className="w-xs">
                    <a href="/">
                        <Button
                            color="blue"
                            type="submit"
                            className="mt-2 flex items-center gap-2 w-full"
                            shape="rounded"
                        >
                            Créer mon compte <MoveRight size={12} />
                        </Button>
                    </a>
                </div>
            </form>
        </Container>
    );
}
