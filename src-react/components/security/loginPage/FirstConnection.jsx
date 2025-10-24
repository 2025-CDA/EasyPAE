import { MoveRight } from "lucide-react";
import Button from "../../ui/Button";
import Container from "../../ui/Container";
import Input from "../../ui/Input";

    export function FirstConnection(props) {
        return (
            <Container className={`border-hidden xl:rounded-lg xl:p-8 ${props.className}`}>
                <form
                    className="text-sm font-semibold"
                    /* handler ici */
                >
                    
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
                        className="my-3 w-15 h-10 bg-background"
                    />
                    <p className="text-secondary-text md:text-[16px]">
                        Entrez le mot de passe reçu par email afin de vous <br />
                        connecter
                    </p>
                    <div className="flex justify-center w-auto">
                            <Button
                                color="blue"
                                type="submit"
                                className="mt-2 flex items-center justify-center gap-2 w-full"
                                shape="rounded"
                            >
                                Créer mon compte <MoveRight size={12} />
                            </Button>
                    </div>
                </form>
            </Container>
        );
    }
