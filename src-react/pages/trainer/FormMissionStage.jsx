import React, { useState } from 'react'
import MainLayout from '../../components/layout/MainLayout'
import Container from '../../components/ui/Container'
import Checkbox from '../../components/ui/Checkbox'
import Input from '../../components/ui/Input';
import Button from '../../components/ui/Button';

function FormMissionStage() {

// TODO : récupérer les infos du StagiaireSelected
const [infoStagiaire, setInfoStagiaire] = useState ({
    firstName : 'Axel',
    lastName : 'Erez',
    formation : 'CDUI',
    offreFormation : '24758',
    notaMissions : ''
});
// TODO : récupérer et passer les réelles infos depuis la DB pour la formation
const [missions, setMissions] = useState ([
    {
        id : 1,
        chapitre : "Concevoir les éléments graphiques d'une interface et de supports de communication",
        sousChapitres : [
            {
                id : 1,
                content : "Réaliser des illustrations, des graphiques et des visuels",
                description : "[Illustrator, Photoshop]",
                toDo : false // booléen relié à la checkbox,
            },
            {
                id : 2,
                content : "Concevoir et/ou améliorer des interfaces graphiques et des prototypes",
                description : "Persona, scenario utilisateur, user flow, visual site map, wireframes, maquette, prototype [Figma]",
                toDo : false
            },
            {
                id : 3,
                content : "Réaliser une animation pour différents supports de diffusion",
                description : "Montage audio vidéo [Da Vinci Resolve] et motion design à partir de template [After Effects]",
                toDo : false
            },
            {
                id : 4,
                content : "Créer des supports de communication imprimés",
                description : "Mono page ou multi page raisonnable ! pas de catalogue ! [In Design]",
                toDo : false
            },
        ]
    },
    {
        id : 2,
        chapitre : "Contribuer à la gestion et au suivi d'un projet de communication numérique",
        sousChapitres : [
            {
                id : 1,
                content : "Audit UX UI avec axes d’amélioration d’interface utilisateur",
                description : "Contribuer à l’analyse UI et les basiques de l’UX d’un site existant ou de maquettes avec analyse des forces, faiblesses, opportunités et menaces",
                toDo : false // booléen relié à la checkbox,
            },
            {
                id : 2,
                content : "Contribuer à la mise en œuvre une stratégie webmarketing",
                description : "Contribuer à la collecte du besoin, reformulation, propositions via conseil, cahier des charges",
                toDo : false
            },
            {
                id : 3,
                content : "Contribuer à l’établissement d’un calendrier de publication pour les plateformes RS",
                description : "Contribuer à l’élaboration d’agenda de publication, proposition de contenus à réaliser selon les objectifs et l’audience",
                toDo : false
            },
            {
                id : 4,
                content : "Contribuer à l’établissement, l’amélioration d’une Charte Graphique et/ou la compléter.",
                description : "Logo, Identité graphique, design system élémentaire : création, développement, refonte...",
                toDo : false
            },
        ]
    },
    {
        id : 3,
        chapitre : "Réaliser, améliorer et animer des sites web",
        sousChapitres : [
            {
                id : 1,
                content : "Adapter des systèmes de gestion de contenus",
                description : "Réaliser, publier des sites web utilisant Wordpress, Elementor Pro, WooCommerce",
                toDo : false // booléen relié à la checkbox,
            },
            {
                id : 2,
                content : "Optimiser un site web",
                description : "Amélioration et refonte de sites web utilisant Wordpress, Elementor Pro, WooCommerce",
                toDo : false
            },
            {
                id : 3,
                content : "Améliorer le SEO d’un site web",
                description : "Rapports SEO, analyses, axes amelioration, actions curatives [WP Yoast SEO, screaming frog, google search console, copywriting...]",
                toDo : false
            },
        ]
    }
]);

    return (
        <MainLayout>
            <div className='ml-8' >
                <h1 className='font-semibold' >{infoStagiaire.firstName} {infoStagiaire.lastName}</h1>
                <h6 className='text-gray-600 mt-3' > Dashboard {'>'} {infoStagiaire.formation} n°{infoStagiaire.offreFormation} {'>'} {infoStagiaire.firstName} {infoStagiaire.lastName} {'>'}
                    <span className='text-primary-text font-semibold' > Editer les missions de stage</span></h6>
                <Container className={'mt-14 flex-col mb-10'}>
                    <h3 className='text-primary' >Activités proposées durant la période en entreprise</h3>
                    {missions.map((mission) => (
                        <div key={mission.id}>
                            <h6 className='font-bold text-primary mt-8 mb-2'> {mission.chapitre}</h6>
                            {mission.sousChapitres.map ((sc) => ( // sc : sous-chapitre
                                <div key={sc.id} className="flex items-baseline gap-3 mb-2 ">
                                    <input
                                        type="checkbox"
                                        className='accent-primary'
                                        checked={sc.toDo}
                                        onChange={() => {
                                            setMissions(missions =>
                                                missions.map(m =>
                                                    m.id === mission.id
                                                        ? {
                                                            ...m,
                                                            sousChapitres: m.sousChapitres.map(s =>
                                                                s.id === sc.id
                                                                    ? { ...s, toDo: !s.toDo }
                                                                    : s
                                                            )
                                                        }
                                                        : m
                                                )
                                            );
                                        }}
                                    />
                                    <div>
                                        <div className="text-lg">{sc.content}</div>
                                        <div className="text-secondary-text text-lg">{sc.description}</div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    ))}
                    <Input
                        label=''
                        placeholder='Autre'
                        value={infoStagiaire.notaMissions}
                        onChange={e =>
                            setInfoStagiaire(prev => ({
                                ...prev,
                                notaMissions: e.target.value
                            }))
                        }
                        withCopy={false}
                        className={"border-primary border-2 h-20 mt-5 mb-10"}
                    />
                    <div className='flex mb-4 text-lg gap-10'>
                        <Button className={'w-[50%]'}>Enregistrer en tant que Brouillon </Button>
                        <Button className={'w-[50%]'}>Valider</Button>
                        {/* TODO: Ajouter logique derrière les btns */}
                    </div>
                </Container>
            </div>
        </MainLayout>
    )
}

export default FormMissionStage
