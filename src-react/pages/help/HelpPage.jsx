import { FrequentlyAsked } from "./FrequentlyAsked";
import { ThemeItem } from "./ThemeItem";
import React from "react";
import MainLayout from "../../components/layout/MainLayout";
import SearchBar from "../../components/ui/SearchBar";
import { FileText, GraduationCap, Building2, File } from "lucide-react";
import Breadcrumbs from "../../components/ui/Breadcrumb";

function HelpPage() {
    return (
        <MainLayout withSearchbar={false}>
            <h1 className="ml-5 font-semibold">Aides</h1>
            <h6 className="ml-5 mb-5 text-secondary-text">
                Ici vous retrouverez toutes les réponses à vos interrogations.
            </h6>

            <div className="flex w-full md:m-5 ">
                <SearchBar className={"w-[90%] md:w-[80%]"} />
            </div>

            <div className="mt-6 m-5">
                <h5 className="font-semibold">Fréquemment demandées</h5>

                <div className=" mt-5 flex flex-row gap-5 justify-center overflow-x-auto p-4 snap-x snap-mandatory">
                    <FrequentlyAsked
                        color={"green"}
                        description={
                            "Où puis-je télécharger la fiche de renseignement ?"
                        }
                    />
                    <FrequentlyAsked
                        color={"green"}
                        description={
                            "Comment remplir la fiche de renseignement ?"
                        }
                    />
                    <FrequentlyAsked
                        color={"green"}
                        description={"Comment suivre l'avancée des signatures"}
                    />
                    <FrequentlyAsked
                        color={"green"}
                        description={
                            "Comment sont organisés les heures en entreprise ?"
                        }
                    />
                </div>
            </div>

            <div className="mt-6 m-5">
                <h5 className="font-semibold">Thèmes</h5>

                <div className="flex flex-col gap-5 mt-5 justify-center font-semibold">
                    <ThemeItem
                        description={"articles"}
                        NArticles={2}
                        icon={<FileText strokeWidth={1} />}
                        titre={"Fiche de renseignement"}
                    />
                    <ThemeItem
                        description={"articles"}
                        NArticles={6}
                        icon={<GraduationCap strokeWidth={1} />}
                        titre={"Stagiaires"}
                    />
                    <ThemeItem
                        description={"articles"}
                        NArticles={4}
                        icon={<Building2 strokeWidth={1} />}
                        titre={"Entreprises"}
                    />
                    <ThemeItem
                        description={"articles"}
                        NArticles={10}
                        icon={<File strokeWidth={1} />}
                        titre={"Fonctionnement"}
                    />
                </div>
            </div>
        </MainLayout>
    );
}

export default HelpPage;
