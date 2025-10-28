import React from 'react'
import { useState } from 'react';
import CalendarDouble from '../components/calendar/CalendarDouble'
import CalendarSimplePUT from '../components/calendar/CalendarSimplePUT'
import MainLayout from '../components/layout/MainLayout'

function CalendarPage() {

// TODO: Quand acces à base de données, envoyer à Calendar double les vraies infos de bdd, y ajouter l'information de moyenne de PAE finalisées en par selectedFormation
const [multiCalendar, setMultiCalendar] = useState([
            {
                id: 1,
                title: "Formation Développeur Web",
                periodStart: new Date(2025, 2, 10), // 10 mars 2025
                periodEnd: new Date(2025, 4, 25),   // 25 mai 2025
            },
            {
                id: 2,
                title: "Formation Data Analyst",
                periodStart: new Date(2025, 5, 1),  // 1 juin 2025
                periodEnd: new Date(2025, 6, 15),   // 15 juillet 2025
            },
            {
                id: 3,
                title: "Formation DevOps",
                periodStart: new Date(2025, 8, 5),  // 5 septembre 2025
                periodEnd: new Date(2025, 9, 20),   // 20 octobre 2025
            },
            {
                id: 4,
                title: "CDA",
                periodStart: new Date(2026, 0, 5),  // 5 janvier 2025
                periodEnd: new Date(2026, 2, 27),   // 27 Mars 2025
            }
        ]);

    return (
        <MainLayout>
            <div className={'hidden md:flex'}>
                <CalendarDouble
                    multi={multiCalendar}
                    onSaveMulti={setMultiCalendar}
                />
            </div>
            <div className='md:hidden w-[80%] m-auto'>
                <CalendarSimplePUT
                    multi={multiCalendar}
                    onSaveMulti={setMultiCalendar}
                />
            </div>
        </MainLayout>
    )
}

export default CalendarPage
