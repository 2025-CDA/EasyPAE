import { MoveRight } from "lucide-react";
import Button from "../../ui/Button";
import Container from "../../ui/Container";
import Input from "../../ui/Input";

export function ForgetPassword(props) {
    return (
        <Container className="w-full xl:w-auto max-w-md xl:max-w-xl border-hidden xl:border xl:shadow-xl xl:rounded-lg xl:p-8">
            <form
                onSubmit={props.handleForgot}
                className="text-sm font-semibold min-w-[400px] w-full"
            >
                <h3 className="font-bold text-primary-text pb-20 justify-self-center xl:pb-8 xl:justify-self-start">
                    Mot de passe oublié
                </h3>
                <Input
                    id="recover-email"
                    label="Email"
                    type="email"
                    placeholder="votre@email.com"
                    value={props.email}
                    onChange={(e) => props.setEmail(e.target.value)}
                    required={false}
                    withCopy={false}
                    className="h-10 my-2"
                />
                <p className="text-secondary-text pb-2 xl:pb-0">
                    Entrez l'adresse mail associée à votre compte pour modifier{" "}
                    <br /> votre mot de passe
                </p>
                <Button
                    color="blue"
                    variant="solid"
                    type="submit"
                    className="mt-2 pb-2 w-sm"
                    shape="rounded"
                >
                    Récupérer mon compte <MoveRight size={12} />
                </Button>
            </form>
            ;
        </Container>
    );
}
