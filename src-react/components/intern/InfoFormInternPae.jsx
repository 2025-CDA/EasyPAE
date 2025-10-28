import Container from "../../components/ui/Container";
import Input from ".././ui/Input";

function InfoFormInternPae({firstNameIntern, mailIntern, nameCourse,nbCourse,startDateInternship,endDateInternship,lastNameIntern,data}) {
    return (
        <Container className="flex flex-col w-full overflow-hidden gap-3 pl-5 border-hidden">
            {" "}
            {/* Masque les scrollbars horizontale et verticale */}
            <h1 className="text-primary font-semibold">Mes informations</h1>
            {/* Labels avec w-20 pour responsive, écart uniforme */}
            <div className="flex flex-row w-full items-start pl-2">
                {" "}
                {/* Changé en flex-col sur mobile pour éviter overflow horizontal */}
                <p className="font-semibold self-center whitespace-nowrap mb-">
                    Prénom :
                </p>{" "}
                {/* Ajusté pour mobile */}
                <div className="flex-1 w-full ml-7">
                    <Input
                        id="firstNameIntern"
                        label={false}
                        type="text"
                        placeholder={false}
                        required={false}
                        withCopy={false}
                        disabled
                        value={data.firstNameIntern}
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Nom :
                </p>
                <div className="flex-1 w-full ml-12.5">
                    <Input
                        id="lastNameIntern"
                        label={false}
                        type="text"
                        placeholder={false}
                        value={data.lastNameIntern}
                        required={false}
                        withCopy={false}
                        disabled
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className="font-semibold self-center whitespace-nowrap mb-2">
                    Email :
                </p>
                <div className="flex-1 w-full ml-12">
                    <Input
                        id="emailIntern"
                        label={false}
                        type="email"
                        value={data.mailIntern}
                        placeholder={false}
                        required={false}
                        withCopy={false}
                        disabled
                        className=""
                    />
                </div>
            </div>
            <div className="flex flex-row w-full items-start pl-2">
                <p className=" font-semibold self-center whitespace-nowrap mb-2">
                    Formation :
                </p>
                <div className="flex w-full ml-4">
                    <p className="text-secondary-text font-medium">{data.nameCourse} N°{data.nbCourse}</p>
                    
                </div>
            </div>
            <h3 className="text-primary font-bold">Période en entreprise</h3>
            <div className="flex  self-center flex-row w-full  items-start gap-4 pl-2">
                <p className=" mb-2 font-semibold mr-2">
                    Dates : 
                </p>
                <p className='text-secondary-text font-semibold'>Du {data.startDateInternship} au {data.endDateInternship}</p>
            </div>
        </Container>
    );
}

export default InfoFormInternPae;
