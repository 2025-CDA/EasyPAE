import Container from "../../components/ui/Container";
import Input from ".././ui/Input";

function InfoFormInternPae({ data, onChange }) {
    return (
        <Container className="flex flex-col w-full overflow-hidden gap-3 p-5 border-hidden">
            <h2 className="text-primary font-semibold">Mes informations</h2>
            <div className="flex md:flex-row flex-col w-full items-start ">
                {" "}
                <p className="font-semibold whitespace-nowrap ">
                    Prénom :
                </p>{" "}
                <div className="flex-1 w-full md:ml-7">
                    <Input
                        id="firstNameIntern"
                        label=""
                        type="text"
                        value={data.firstNameIntern}
                        onChange={onChange}
                        disabled
                    />
                </div>
            </div>
            <div className="flex md:flex-row flex-col w-full items-start">
                <p className="font-semibold  whitespace-nowrap mb-2">Nom :</p>
                <div className="flex-1 w-full md:ml-12.5">
                    <Input
                        id="lastNameIntern"
                        label=""
                        type="text"
                        onChange={onChange}
                        value={data.lastNameIntern}
                        disabled
                    />
                </div>
            </div>
            <div className="flex md:flex-row flex-col w-full items-start">
                <p className="font-semibold whitespace-nowrap mb-2">Email :</p>
                <div className="flex-1 w-full md:ml-12">
                    <Input
                        id="emailIntern"
                        label=""
                        type="email"
                        onChange={onChange}
                        value={data.mailIntern}
                        disabled
                    />
                </div>
            </div>
            <div className="flex md:flex-row flex-col w-full items-start">
                <p className=" font-semibold whitespace-nowrap mb-2">
                    Formation :
                </p>
                <div className="flex w-full md:ml-4">
                    <p className="text-secondary-text">
                        {data.nameCourse} N°{data.nbCourse}
                    </p>
                </div>
            </div>
            <h4 className="text-primary font-bold">Période en entreprise</h4>
            <div className="flex  md:flex-row flex-col w-full  items-start gap-4 pl-2">
                <p className=" font-semibold mr-8">Dates :</p>
                <p className="text-secondary-text">
                    Du {data.startDateInternship} au {data.endDateInternship}
                </p>
            </div>
        </Container>
    );
}

export default InfoFormInternPae;
