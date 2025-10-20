import { useState } from 'react';
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

function CalendarSimple({ dates, shrinkable = false }) {
    // Supporte la prop dates (objet contenant periodStart et periodEnd)
    // Si dates est fourni, on l'utilise, sinon on prend periodStart/periodEnd des props (pour compatibilité)
    let periodStart = null;
    let periodEnd = null;
    if (dates && typeof dates === "object") {
        periodStart = dates.periodStart ?? null;
        periodEnd = dates.periodEnd ?? null;
    }

    if (!periodStart && !periodEnd) {
        shrinkable = false;
    }
    const [opened, setOpened] = useState(!shrinkable);
    // Immutable Date, convertir en JS Date
    const startDate = periodStart && periodStart.toDate ? periodStart.toDate() : periodStart;
    const endDate = periodEnd && periodEnd.toDate ? periodEnd.toDate() : periodEnd;

    // Date du jour
    const today = new Date();
    const todayY = today.getFullYear();
    const todayM = today.getMonth();
    const todayD = today.getDate();

    // Initialiser sur le mois/année du jour ou sur la date de début de période si présente
    const initialMonth = startDate ? startDate.getMonth() : todayM;
    const initialYear = startDate ? startDate.getFullYear() : todayY;

    const [month, setMonth] = useState(initialMonth);
    const [year, setYear] = useState(initialYear);

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

    // Fonction utilitaire pour savoir si une date est dans la période de stage

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

    return (
        <div>
            {shrinkable && (
                <div className={`w-80 pl-2 pr-2 mb-3 flex flex-col bg-white border border-gray-200 rounded-xl overflow-hidden`}>
                    {/* Affichage du J- / J+ */}
                    {jValue && (
                        <div className="mt-2 pb-5 text-center text-s font-bold text-primary-text">
                            {jValue} {jValue.startsWith("J - ") ? "avant le début de stage" : "depuis le début de stage"}
                            <div className='py-1 flex items-center gap-1 justify-center text-xs '>
                                {/* ------------------------------------------ régler le style de calendar et date du jour -------------------------------------- */}
                                <Calendar width={12}/>
                                {`${today.getDate().toString().padStart(2, "0")}/${(today.getMonth() + 1).toString().padStart(2, "0")}/${today.getFullYear()}`}
                            </div>
                            {/* Affichage de la période PAE */}
                            {startDate && endDate && (
                                <div className="pb-3 text-center text-xs font-normal text-primary-text">
                                    Période PAE du :{" "}
                                    {`${startDate.getDate().toString().padStart(2, "0")}/${(startDate.getMonth() + 1).toString().padStart(2, "0")}/${startDate.getFullYear()}`}
                                    {" "}au{" "}
                                    {`${endDate.getDate().toString().padStart(2, "0")}/${(endDate.getMonth() + 1).toString().padStart(2, "0")}/${endDate.getFullYear()}`}
                                </div>
                            )}
                            {/* Période PAE du : {periodStart} au {periodEnd} */}
                            {shrinkable && (
                                <Button
                                    width={7}
                                    height={7}
                                    onClick={() => setOpened(o => !o)}
                                    icon={<ChevronDown />}
                                />
                            )}
                            {/* -------------------------------------- A fixer qd Button prêt ---------------------------------------------- */}
                        </div>
                    )}
                </div>
            )}
            <div className={`w-80 pl-2 pr-2 flex flex-col bg-white border border-gray-200 rounded-xl overflow-hidden${opened ? '' : ' hidden'}`}>
                {/* Affichage du J- / J+ */}
                {jValue && (
                    <div className="mt-2 pb-5 text-center font-bold text-primary-text">
                        {!shrinkable &&
                            <>
                                <p className='text-3xl ' >{jValue}</p>
                                <p className='text-s ' >{jValue.startsWith("J - ") ? "avant le début de stage" : "depuis le début de stage"}</p>
                            </>
                        }
                        {shrinkable && (
                            <>
                                <Button
                                    width={7}
                                    height={7}
                                    onClick={() => setOpened(o => !o)}
                                    icon={<ChevronUp />}
                                />
                                {jValue} {jValue.startsWith("J - ") ? "avant le début de stage" : "depuis le début de stage"}
                            </>
                        )}
                    </div>
                )}
                <div className=" flex flex-col bg-white border border-gray-200 shadow-lg rounded-xl overflow-hidden">
                    <div className="p-3 space-y-0.5">

                        {/* ---------- */}
                        {/* Mois/Année */}
                        {/* ---------- */}

                        <div className="grid grid-cols-5 items-center gap-x-3 mx-1.5 pb-3">

                            {/* Précédent */}
                            <div className="col-span-1">
                                <button
                                    type="button"
                                    className="size-8 flex justify-center items-center text-primary-text hover:bg-gray-100 rounded-full disabled:opacity-50 disabled:pointer-events-none focus:outline-hidden focus:bg-gray-100"
                                    aria-label="Précédent"
                                    onClick={handlePrev}>
                                    <svg className="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1" strokeLinecap="round" strokeLinejoin="round"><path d="m15 18-6-6 6-6"/></svg>
                                </button>
                            </div>

                            {/* Mois/Année */}
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

                            {/* Suivant */}
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

                        {/* ------------------- */}
                        {/* Jours de la semaine */}
                        {/* ------------------- */}
                        <div className="flex pb-1.5">
                            {DAYS_FR.map((d) => (
                                <span key={d} className="m-px w-10 block text-center text-xs text-gray-500">
                                    {d}
                                </span>
                            ))}
                        </div>

                        {/* ------------------- */}
                        {/* Jours du calendrier */}
                        {/* ------------------- */}
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
                                        <div key={key} className="relative flex justify-center items-center">
                                            {inPeriod && currentMonth && (
                                                <div className={logoBgClass} />
                                            )}
                                            <button
                                                type="button"
                                                className={btnClass}
                                                disabled={!currentMonth}>
                                                {day}
                                            </button>
                                        </div>
                                    );
                                })}
                            </div>
                        ))}
                    </div>
                </div>
            </div>
        </div>
    );
}

export default CalendarSimple;
