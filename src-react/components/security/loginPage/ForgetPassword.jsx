import { MoveRight } from "lucide-react";
import Button from "../../ui/Button";
import Container from "../../ui/Container";
import Input from "../../ui/Input";

export function ForgetPassword(props) {
    return (
        <Container className="flex flex-col items-center justify-center w-full h-full md:h-auto md:w-auto border-transparent rounded-t-lg

 md:rounded-lg md:p-8">
            <form
                onSubmit={props.handleForgot}
                className=" items-center w-auto justify-center text-sm font-semibold min-w-[340px] "
            >
                <h3 className="font-bold text-primary-text pb-20 justify-self-center md:pb-8 md:justify-self-start">
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
                        className="h-10 my-2 w-full bg-background"
                    />                
                <p className="text-secondary-text pb-2 md:pb-0">
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
        </Container>
    );
}
