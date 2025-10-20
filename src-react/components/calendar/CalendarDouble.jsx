import { useState, useEffect } from 'react';
import './Calendar.css';

// ----------------------
// Constantes pour labels
// ----------------------
const MONTHS_FR = [
    "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
    "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
];
const DAYS_FR = ["Lu", "Ma", "Me", "Je", "Ve", "Sa", "Di"];

// --------------------------------------
// Fonctions utilitaires pour le calendrier
// --------------------------------------
function getDaysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
}

function getFirstDayOfWeek(month, year) {
    let day = new Date(year, month, 1).getDay();
    return (day + 6) % 7;
}

// Génère la structure des semaines pour un mois donné
function getCalendarRows(month, year) {
    const daysInMonth = getDaysInMonth(month, year);
    const firstDay = getFirstDayOfWeek(month, year);
    const daysInPrevMonth = getDaysInMonth((month - 1 + 12) % 12, month === 0 ? year - 1 : year);

    let days = [];
    // Jours du mois précédent pour compléter la première semaine
    for (let i = firstDay - 1; i >= 0; i--) {
        days.push({
        day: daysInPrevMonth - i,
        currentMonth: false,
        date: new Date(year, month - 1, daysInPrevMonth - i)
        });
    }
    // Jours du mois courant
    for (let i = 1; i <= daysInMonth; i++) {
        days.push({
        day: i,
        currentMonth: true,
        date: new Date(year, month, i)
        });
    }
    // Jours du mois suivant pour compléter la grille (6 semaines)
    let nextDay = 1;
    while (days.length < 42) {
        days.push({
            day: nextDay,
            currentMonth: false,
            date: new Date(year, month + 1, nextDay)
        });
        nextDay++;
    }
    // Découper en semaines
    let weeks = [];
    for (let i = 0; i < days.length; i += 7) {
        weeks.push(days.slice(i, i + 7));
    }
    return weeks;
}

/**
 * CalendarDouble : calendrier double avec sélection de formation à gauche (multi)
 * multi : array d'objets { id, title, periodStart, periodEnd }
 * onSaveMulti : callback pour sauvegarder les dates d'une formation
 */
function CalendarDouble({ multi, onSaveMulti }) {
    // Formation sélectionnée (par défaut la première)
    const [selectedIdx, setSelectedIdx] = useState(0);
    const selectedFormation = multi && multi.length > 0 ? multi[selectedIdx] : null;

    // Dates locales pour la formation sélectionnée
    const [localStartDate, setLocalStartDate] = useState(selectedFormation?.periodStart || null);
    const [localEndDate, setLocalEndDate] = useState(selectedFormation?.periodEnd || null);

    // Met à jour les dates locales quand on change de formation
    // ou quand multi change (ex: après sauvegarde)
    // ou quand selectedIdx change
    // ou quand la formation sélectionnée change
    useEffect(() => {
        setLocalStartDate(selectedFormation?.periodStart || null);
        setLocalEndDate(selectedFormation?.periodEnd || null);
    }, [selectedIdx, multi, selectedFormation]);

    // Initialiser le calendrier sur le mois/année de début de période si présent, sinon sur le jour courant
    const today = new Date();
    const initialMonth = localStartDate ? new Date(localStartDate).getMonth() : today.getMonth();
    const initialYear = localStartDate ? new Date(localStartDate).getFullYear() : today.getFullYear();
    const [month, setMonth] = useState(initialMonth);
    const [year, setYear] = useState(initialYear);

    // Recaler le calendrier sur la période de début si la formation sélectionnée change
    useEffect(() => {
        if (localStartDate) {
            setMonth(new Date(localStartDate).getMonth());
            setYear(new Date(localStartDate).getFullYear());
        } else {
            setMonth(today.getMonth());
            setYear(today.getFullYear());
        }
        // eslint-disable-next-line
    }, [selectedIdx, localStartDate]);

    // Liste d'années pour le select
    const years = [];
    for (let y = year - 2; y <= year + 4; y++) years.push(y);

    // Sélection de dates sur le calendrier double
    const handleSelect = (date) => {
        if (!localStartDate || (localStartDate && localEndDate)) {
            setLocalStartDate(date);
            setLocalEndDate(null);
        } else if (date < localStartDate) {
            setLocalStartDate(date);
            setLocalEndDate(null);
        } else {
            setLocalEndDate(date);
        }
    };

    // --------------------------
    // Navigation mois précédent/suivant
    // --------------------------
    const handlePrev = () => {
        if (month === 0 ) {
            setMonth(10);
            setYear(year - 1);
        } else if (month === 1 ) {
            setMonth(11);
            setYear(year - 1);
        } else {
            setMonth(month - 2);
        }
    };

    const handleNext = () => {
        if (month === 11) {
            setMonth(1);
            setYear(year + 1);
        } else if (month === 10) {
            setMonth(0);
            setYear(year + 1);
        } else {
            setMonth(month + 2);
        }
    };

    // --------------------------
    // Vérifie si une date est dans la période sélectionnée
    // --------------------------
    const isInPeriod = (date) => {
        if (!localStartDate || !localEndDate) {
            return false;
        }
        const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        const s = new Date(localStartDate.getFullYear(), localStartDate.getMonth(), localStartDate.getDate());
        const e = new Date(localEndDate.getFullYear(), localEndDate.getMonth(), localEndDate.getDate());
        return d >= s && d <= e;
    };

    // --------------------------
    // Rendu d'un calendrier simple (mois donné)
    // --------------------------
        const renderCalendar = (month, year) => {
        const weeks = getCalendarRows(month, year);
        const today = new Date();
        const todayY = today.getFullYear();
        const todayM = today.getMonth();
        const todayD = today.getDate();

        return (
            <div className="p-3 bg-white ">
                <div className="flex pb-1.5">
                    {DAYS_FR.map((d) => (
                        <span key={d} className="m-px w-10 block text-center text-xs text-gray-500">
                            {d}
                        </span>
                    ))}
                </div>
                {weeks.map((week, wi) => (
                    <div key={wi} className="flex">
                        {week.map(({ day, currentMonth, date }, di) => {
                            // Détection du premier et dernier jour de la période
                            const isStart = localStartDate && date.getFullYear() === new Date(localStartDate).getFullYear() && date.getMonth() === new Date(localStartDate).getMonth() && date.getDate() === new Date(localStartDate).getDate();
                            const isEnd = localEndDate && date.getFullYear() === new Date(localEndDate).getFullYear() && date.getMonth() === new Date(localEndDate).getMonth() && date.getDate() === new Date(localEndDate).getDate();
                            const inPeriod = isInPeriod(date);

                            // Détection du premier et dernier jour de la semaine
                            const isFirstOfWeek = di === 0;
                            const isLastOfWeek = di === 6;

                            // Détection du jour courant
                            const isToday = date.getFullYear() === todayY && date.getMonth() === todayM && date.getDate() === todayD;

                            // Classes pour arrondir le fond logo
                            let logoBgClass = "absolute z-0 w-10 h-10 bg-logo";
                            // N'afficher le bg-logo que si le jour est dans la période ET dans le mois courant
                            if (inPeriod && currentMonth && !isStart && !isEnd) {
                                if (isFirstOfWeek) {
                                    logoBgClass += " rounded-l-full";
                                }
                                if (isLastOfWeek) {
                                    logoBgClass += " rounded-r-full";
                                }
                            }
                            if (isStart && currentMonth) {
                                logoBgClass += " rounded-l-full";
                            }
                            if (isEnd && currentMonth) {
                                logoBgClass += " rounded-r-full";
                            }

                            // Classes pour le bouton principal
                            let btnClass = `size-10 flex justify-center items-center border-2 border-none text-xs rounded-full z-10
                                ${currentMonth ? "text-primary-text hover:border-primary hover:border-3 hover:border-solid" : "text-secondary-text"}
                                ${currentMonth ? "" : "disabled:opacity-50 disabled:pointer-events-none"}
                                ${isStart ? "bg-primary text-white" : ""}
                                ${isEnd ? "bg-primary text-white" : ""}
                                ${isToday ? "border-3 border-primary border-solid" : ""}
                            `;
                            if (isStart && isFirstOfWeek) {
                                btnClass += " rounded-l-full";
                            }
                            if (isEnd && isLastOfWeek) {
                                btnClass += " rounded-r-full";
                            }

                            return (
                                <div key={`${wi}-${di}`} className="relative flex justify-center items-center">
                                    {inPeriod && currentMonth && (
                                        <div className={logoBgClass} />
                                    )}
                                    <button
                                        type="button"
                                        onClick={() => handleSelect(date)}
                                        className={btnClass}
                                        disabled={!currentMonth}
                                    >
                                        {day}
                                    </button>
                                </div>
                            );
                        })}
                    </div>
                ))}
            </div>
        );
    };

    // --------------------------
    // Rendu principal du composant
    // --------------------------
        return (
        <div className="flex flex-col w-full bg-color-background shadow rounded">
            <div className="flex w-full">
                {/* Liste des formations à gauche */}
                <div className="flex flex-col min-w-[220px] border-r border-b border-gray-200 bg-gray-50 py-4 px-2">
                    {multi && multi.length > 0 ? (
                        multi.map((formation, idx) => (
                            <button
                                key={formation.id}
                                className={`text-left px-3 py-2 rounded-lg mb-1 transition font-medium text-sm ${
                                    idx === selectedIdx
                                        ? "border-2 border-primary"
                                        : "hover:text-primary"
                                }`}
                                onClick={() => setSelectedIdx(idx)}
                            >
                                {formation.title}
                            </button>
                        ))
                    ) : (
                        <div className="text-gray-400 italic">Aucune formation</div>
                    )}
                </div>
                {/* Calendrier double à droite */}
                <div className="flex-1 space-y-4 p-3 bg-white border-b border-gray-200">
                    {/* Navigation mois/année */}
                    <div className="flex items-center justify-between px-2">
                        <button
                            type="button"
                            className="size-8 flex justify-center items-center text-primary-text hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                            aria-label="Précédent"
                            onClick={handlePrev}>
                            <svg className="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                        </button>
                        <div className="flex font-regular gap-65 text-lg">
                            <span>
                                {MONTHS_FR[month]} {year}
                            </span>
                            <span>
                                {MONTHS_FR[(month + 1) % 12]} {month === 11 ? year + 1 : year}
                            </span>
                        </div>
                        <button
                            type="button"
                            className="size-8 flex justify-center items-center text-primary-text hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                            aria-label="Suivant"
                            onClick={handleNext}>
                            <svg className="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                        </button>
                    </div>

                    {/* Double calendrier côte à côte */}
                    <div className="flex gap-4">
                        {renderCalendar(month, year)}
                        {renderCalendar((month + 1) % 12, month === 11 ? year + 1 : year)}
                    </div>
                </div>
            </div>
            {/* Affichage de la période sélectionnée */}
            {(localStartDate && localEndDate) && (
                <div className="w-full flex justify-end items-center gap-2 mt-4 pr-8 pb-4">
                    <span className="block text-center xxs text-gray-700 font-medium">
                        {localStartDate.toLocaleDateString()} - {localEndDate.toLocaleDateString()}
                    </span>
                    <button
                        className="px-4 py-2 rounded-md border border-gray-300 bg-white text-xs text-gray-700 hover:bg-gray-100 transition"
                        onClick={() => {
                            setLocalStartDate(selectedFormation?.periodStart || null);
                            setLocalEndDate(selectedFormation?.periodEnd || null);
                        }}
                    >
                        Annuler
                    </button>
                    <button
                        className="px-4 py-2 rounded-md bg-primary text-white font-semibold text-xs hover:bg-secondary transition"
                        onClick={() => {
                            if (onSaveMulti && selectedFormation) {
                                onSaveMulti(selectedFormation.id, localStartDate, localEndDate);
                            }
                        }}
                    >
                        Sauvegarder
                    </button>
                </div>
            )}
        </div>
    );
}

export default CalendarDouble;
