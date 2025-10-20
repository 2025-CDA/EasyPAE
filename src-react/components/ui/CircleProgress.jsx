import React from 'react';


function CircleProgress({ statusPae }) {
  // Dictionnaire qui vas répértorier toutes les valeurs possibles qu'on aura défini au préalable
  const statusMap = {
    // Permet d'ajouter d'autre état au besoin selon ce que le back vas nous envoyer comme données.
    "0%": { percentage: 99, color: '#DC2626' },
    "25%": { percentage: 75, color: '#F97316' },
    "50%": { percentage: 50, color: '#FBBF24' },
    "75%": { percentage: 25, color: '#A3E635' },
    "100%": { percentage: 0, color: '#16A34A' },
    "5%" : { percentage : 95, color: 'blue'},
    "Pas commencé": { percentage: 100, color: '#DC2626' },
  };

  /* Vérifie si la valeur de statusPae correspond à une des clé dans le dictionnaire sinon par default 
 initie le cercle de progression à 0.
  */

  const { percentage = 95, color = '#DC2626' } = statusMap[statusPae] || {};

  return (
    <div style={{ width: "51.84px", height: "51.84px" }}>
      <div className="relative">
        <svg className="size-full -rotate-90" viewBox="0 0 36 36" xmlns="http://www.w3.org/2000/svg">
          <circle cx="18" cy="18" r="16" fill="none"  strokeWidth="2" />
          <circle
            cx="18"
            cy="18"
            r="16"
            fill="none"
            stroke={color}
            strokeWidth="4"
            strokeDasharray="100"
            strokeDashoffset={percentage}
            strokeLinecap="round"
          />
        </svg>
        <div className="absolute top-1/2 start-1/2 transform -translate-y-1/2 -translate-x-1/2">
          <span className="text-center font-medium" >{statusMap[statusPae] ? statusPae : "Inconnu"}</span>
        </div>
      </div>
    </div>
  );
}

export default CircleProgress;
