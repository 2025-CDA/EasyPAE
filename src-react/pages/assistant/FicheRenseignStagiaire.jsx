import React from 'react'
import { Copy } from 'lucide-react';






function FicheRenseignStagaire() {
   return (
       <div className="border-2 border-gray-200 rounded-lg p-4 bg-white  mx-2 my-3">


           <h3 className=" text-primary mb-4">
               STAGIAIRE :AXEL MARTIN Axel Martin
           </h3>
           {/* ----------------- Fiche stagiaire-------------------- */}
           <div className="grid grid-cols-3 gap-x-4 gap-y-3 text-sm">


               {/* -------Informations personnelles---------- */}
               <div className="col-span-3 font-bold text-primary">Informations personnelles</div>
      
               <div className="primary-text font-bold">Prénom :</div>
               <div className="text-gray-400">Axel</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Nom :</div>
               <div className="text-gray-400">Martin</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Email :</div>
               <div className="text-gray-400">axel.cdui@gmail.com</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Formation :</div>
               <div className="text-gray-400">CDUI N°247548</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               {/* Période */}
               <div className="col-span-3 font-bold text-blue-700 mt-2">Période en entreprise</div>
      
               <div className="primary-text font-bold">Dates</div>
               <div className="text-gray-400">Du 10 Novembre au 24 Décembre 2025</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               {/* Entreprise */}
               <div className="col-span-3 font-bold text-blue-700 mt-2">L’entreprise d’accueil</div>
      
               <div className="primary-text font-bold">Nom de l'entreprise :</div>
               <div className="text-gray-400">ViveCom'</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Adresse physique :</div>
               <div className="text-gray-400">123 Rue 33000 Bordeaux</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Mail contact :</div>
               <div className="text-gray-400">tuteur@vivecom.fr</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
      
               <div className="primary-text font-bold">Nom du contact :</div>
               <div className="text-gray-400">Alice ROSSE</div>
               <div className="flex items-center justify-center">
                   <Copy className="text-gray-400" size={18} />
               </div>
           </div>




       </div>
     );
}


export default FicheRenseignStagaire
