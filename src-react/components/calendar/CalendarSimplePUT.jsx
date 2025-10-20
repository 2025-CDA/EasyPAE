import { useState, useEffect } from 'react';
import './Calendar.css';
import Button from '../../ui/Button';
import { ChevronUp, Calendar, ChevronDown} from 'lucide-react';

const MONTHS_FR = [
    "Janvier", "Février", "Mars", "Avril", "Mai", "Juin",
    "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre"
];
const DAYS_FR = ["Lu", "Ma", "Me", "Je", "Ve", "Sa", "Di"];

function getDaysInMonth(month, year) {
    return new Date(year, month + 1, 0).getDate();
}

function getFirstDayOfWeek(month, year) {
    // JS: 0=dimanche, 1=lundi... On veut 0=lundi, 6=dimanche
    let day = new Date(year, month, 1).getDay();
    return (day + 6) % 7;
}

function getCalendarRows(month, year) {
    const daysInMonth = getDaysInMonth(month, year);
    const firstDay = getFirstDayOfWeek(month, year);
    const daysInPrevMonth = getDaysInMonth((month - 1 + 12) % 12, month === 0 ? year - 1 : year);

    let days = [];
    // Jours du mois précédent
    for (let i = firstDay - 1; i >= 0; i--) {
        days.push({
            day: daysInPrevMonth - i,
            currentMonth: false,
            key: `prev-${daysInPrevMonth - i}`,
            date: new Date(year, month - 1, daysInPrevMonth - i)
        });
    }
    // Jours du mois courant
    for (let i = 1; i <= daysInMonth; i++) {
        days.push({
            day: i,
            currentMonth: true,
            key: `curr-${i}`,
            date: new Date(year, month, i)
        });
    }
    // Jours du mois suivant pour compléter la grille
    let nextDay = 1;
    while (days.length < 42) { // 6 semaines * 7 jours
        days.push({
            day: nextDay,
            currentMonth: false,
            key: `next-${nextDay}`,
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

function CalendarSimplePUT({ multi = null, single = null, onSaveSingle = null, onSaveMulti = null }) {
    // Détection du mode
    const isMulti = Array.isArray(multi) && multi.length > 0;
    const isSingle = !!single && !isMulti;

    // State pour la formation sélectionnée (multi) ou single
    const [selectedFormation, setSelectedFormation] = useState(isMulti ? multi[0] : (isSingle ? single : null));
    const [localStartDate, setLocalStartDate] = useState(
        isMulti
            ? multi[0]?.periodStart
            : isSingle
                ? single.periodStart
                : null
    );
    const [localEndDate, setLocalEndDate] = useState(
        isMulti
            ? multi[0]?.periodEnd
            : isSingle
                ? single.periodEnd
                : null
    );

    // Synchroniser les dates quand on change de formation (multi)
    useEffect(() => {
        if (isMulti && selectedFormation) {
            setLocalStartDate(selectedFormation.periodStart);
            setLocalEndDate(selectedFormation.periodEnd);
        }
        if (isSingle && single) {
            setLocalStartDate(single.periodStart);
            setLocalEndDate(single.periodEnd);
        }
    }, [selectedFormation, single, isMulti, isSingle]);

    const startDate = localStartDate;
    const endDate = localEndDate;

    // Date du jour
    const today = new Date();
    const todayY = today.getFullYear();
    const todayM = today.getMonth();
    const todayD = today.getDate();

    // Initialiser sur le mois/année de début de période si présent, sinon sur le jour courant
    const initialMonth = localStartDate ? new Date(localStartDate).getMonth() : todayM;
    const initialYear = localStartDate ? new Date(localStartDate).getFullYear() : todayY;

    const [month, setMonth] = useState(initialMonth);
    const [year, setYear] = useState(initialYear);

    // Si la formation sélectionnée change (multi ou single), on recale le calendrier sur la période de début si elle existe
    useEffect(() => {
        if (localStartDate) {
            setMonth(new Date(localStartDate).getMonth());
            setYear(new Date(localStartDate).getFullYear());
        } else {
            setMonth(todayM);
            setYear(todayY);
        }
        // eslint-disable-next-line
    }, [selectedFormation, localStartDate]);

    const years = [];
    for (let y = initialYear - 2; y <= initialYear + 4; y++) {
        years.push(y);
    }

    const weeks = getCalendarRows(month, year);

    const handlePrev = () => {
        if (month === 0) {
            setMonth(11);
            setYear(year - 1);
        } else {
            setMonth(month - 1);
        }
    };

    const handleNext = () => {
        if (month === 11) {
            setMonth(0);
            setYear(year + 1);
        } else {
            setMonth(month + 1);
        }
    };

    const handleMonthChange = (e) => setMonth(Number(e.target.value));
    const handleYearChange = (e) => setYear(Number(e.target.value));

    function isInInternshipPeriod(date) {
        if (!startDate || !endDate) {
            return false;
        }
        // On ignore l'heure
        const d = new Date(date.getFullYear(), date.getMonth(), date.getDate());
        const s = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        const e = new Date(endDate.getFullYear(), endDate.getMonth(), endDate.getDate());
        return d >= s && d <= e;
    }

        // Calcul du nombre de jours avant/après la période
    let jValue = null;
    if (startDate) {
        const todayDate = new Date(todayY, todayM, todayD);
        const start = new Date(startDate.getFullYear(), startDate.getMonth(), startDate.getDate());
        const diff = Math.floor((start - todayDate) / (1000 * 60 * 60 * 24));
        if (diff > 0) {
            jValue = `J - ${diff}`;
        } else if (diff === 0) {
            jValue = "J 0";
        } else {
            // J+N depuis le début de la période
            jValue = `J + ${Math.abs(diff)}`;
        }
    }

    // Sélection de dates sur le calendrier
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

    const [showMenu, setShowMenu] = useState(false);

    return (
        <div>
            {!isMulti && isSingle &&(
                <div>
                    <p className='text-3xl font-semibold' >Période PAE</p>
                </div>
            )}
            {isMulti && (
                <div className='flex justify-between items-center' >
                    <p className='text-2xl font-semibold' >Calendrier</p>
                    <div className="relative inline-flex">
                        <button
                            type="button"
                            className="py-3 px-4 inline-flex gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-2xs hover:bg-gray-50 focus:outline-hidden focus:bg-gray-50"
                            onClick={() => setShowMenu((show) => !show)}>
                            {selectedFormation ? selectedFormation.title : "Choisir une formation"}
                            <svg className={`size-4 transition-transform ${showMenu ? "rotate-180" : ""}`} xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round"><path d="m6 9 6 6 6-6"/></svg>
                        </button>
                        {showMenu && (
                            <div className="absolute z-10 min-w-60 bg-white shadow-md rounded-lg mt-2">
                                <div className="p-1 space-y-0.5">
                                    {multi.map((formation) => (
                                        <a
                                            key={formation.id}
                                            className="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 cursor-pointer"
                                            href="#"
                                            onClick={e => {
                                                e.preventDefault();
                                                setSelectedFormation(formation);
                                                setShowMenu(false);
                                            }}
                                        >
                                            {formation.title}
                                        </a>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>
                </div>
            )}
            <div className='pb-5 pt-5 flex bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden justify-center align-center mt-8 mb-8' >
                {/* Affichage du J- / J+ */}
                {jValue && (
                    <div className="flex mt-2 pb-5 font-bold text-primary-text gap-2 items-center ">
                        <p className='text-3xl ' >{jValue}</p>
                        <p className='text-s' >{jValue.startsWith("J - ") ? "avant le début de stage" : "depuis le début de stage"}</p>
                    </div>
                )}
            </div>
            {/* Affiche le calendrier de la formation sélectionnée (multi) ou single */}
            {selectedFormation ? (
                <div>
                    {/* Affichage du calendrier */}
                    <div className=" flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden">
                        <div className="p-3 space-y-0.5">
                            {/* Mois/Année */}
                            <div className="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">
                                <div className="col-span-1">
                                    <button
                                        type="button"
                                        className="size-8 flex justify-center items-center text-primary-text hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                                        aria-label="Précédent"
                                        onClick={handlePrev}>
                                        <svg className="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                    </button>
                                </div>
                                <div className="col-span-3 flex justify-center space-around gap-2">
                                    <select
                                        value={month}
                                        onChange={handleMonthChange}
                                        className="rounded py-1 text-primary-text no-arrow text-sm bg-white">
                                        {MONTHS_FR.map((m, idx) => (
                                            <option value={idx} key={m}>{m}</option>
                                        ))}
                                    </select>
                                    <select
                                        value={year}
                                        onChange={handleYearChange}
                                        className="rounded py-1 text-primary-text no-arrow text-sm bg-white">
                                        {years.map((y) => (
                                            <option value={y} key={y}>{y}</option>
                                        ))}
                                    </select>
                                </div>
                                <div className="col-span-1 flex justify-end">
                                    <button
                                        type="button"
                                        className="size-8 flex justify-center items-center text-primary-text hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                                        aria-label="Suivant"
                                        onClick={handleNext}>
                                        <svg className="shrink-0 size-4" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"><path d="m9 18 6-6-6-6"/></svg>
                                    </button>
                                </div>
                            </div>
                            {/* Jours de la semaine */}
                            <div className="flex pb-1.5">
                                {DAYS_FR.map((d) => (
                                    <span key={d} className="m-px w-10 block text-center text-xs text-gray-500">
                                        {d}
                                    </span>
                                ))}
                            </div>
                            {/* Jours du calendrier */}
                            {weeks.map((week, i) => (
                                <div className="flex" key={i}>
                                    {week.map(({ day, currentMonth, key, date }, dayIdx) => {
                                        // Détection du premier et dernier jour de la période
                                        const isStart = startDate && date.getFullYear() === startDate.getFullYear() && date.getMonth() === startDate.getMonth() && date.getDate() === startDate.getDate();
                                        const isEnd = endDate && date.getFullYear() === endDate.getFullYear() && date.getMonth() === endDate.getMonth() && date.getDate() === endDate.getDate();
                                        const inPeriod = isInInternshipPeriod(date);

                                        // Détection du premier et dernier jour de la semaine
                                        const isFirstOfWeek = dayIdx === 0;
                                        const isLastOfWeek = dayIdx === 6;

                                        // Détection du jour courant
                                        const isToday = date.getFullYear() === todayY && date.getMonth() === todayM && date.getDate() === todayD;

                                        // Classes pour arrondir le fond logo
                                        let logoBgClass = "absolute z-0 w-10 h-10 bg-logo";
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
                                            <div key={key} className="relative flex justify-center items-center">
                                                {inPeriod && currentMonth && (
                                                    <div className={logoBgClass} />
                                                )}
                                                <button
                                                    type="button"
                                                    className={btnClass}
                                                    disabled={!currentMonth}
                                                    onClick={() => handleSelect(date)}
                                                >
                                                    {day}
                                                </button>
                                            </div>
                                        );
                                    })}
                                </div>
                            ))}
                            {/* Affichage de la période sélectionnée */}
                            {(localStartDate && localEndDate) && (
                                <div className="flex items-center justify-between gap-2 mt-4 w-full">
                                    <div className='flex flex-col items-start'>
                                        <span className="block xxs text-gray-700 font-medium">
                                            {localStartDate.toLocaleDateString()}
                                        </span>
                                        <span className='block xxs text-gray-700 font-medium'>
                                            {localEndDate.toLocaleDateString()}
                                        </span>
                                    </div>
                                    <div className='flex gap-2' >
                                        <button
                                            className="px-4 py-2 rounded-md border border-gray-300 bg-white font-semibold text-gray-700 hover:bg-gray-100 transition"
                                            onClick={() => {
                                                // Remettre les dates initiales
                                                if (isMulti && selectedFormation) {
                                                    setLocalStartDate(selectedFormation.periodStart);
                                                    setLocalEndDate(selectedFormation.periodEnd);
                                                }
                                                if (isSingle && single) {
                                                    setLocalStartDate(single.periodStart);
                                                    setLocalEndDate(single.periodEnd);
                                                }
                                            }}
                                        >
                                            Annuler
                                        </button>
                                        <button
                                            className="px-4 py-2 rounded-md bg-primary text-white font-semibold text-s hover:bg-secondary transition"
                                            onClick={() => {
                                                if (isMulti && onSaveMulti && selectedFormation) {
                                                    onSaveMulti(selectedFormation.id, localStartDate, localEndDate);
                                                }
                                                if (isSingle && onSaveSingle && single) {
                                                    onSaveSingle({
                                                        ...single,
                                                        periodStart: localStartDate,
                                                        periodEnd: localEndDate,
                                                    });
                                                }
                                            }}
                                        >
                                            Sauvegarder
                                        </button>
                                    </div>
                                </div>
                            )}
                        </div>
                    </div>
                </div>
            ) : (
                <div className="mt-4">Aucune formation sélectionnée</div>
            )}
        </div>
    )
}

export default CalendarSimplePUT
