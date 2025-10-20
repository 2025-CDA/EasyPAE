import React, { useState, useEffect } from 'react';
import { Search } from 'lucide-react';
import  Button  from './Button';
import Input from './Input';


function SearchBar() {


  const [datas, setDatas] = useState([]);         //la liste complète des données chargées 
  const [search, setSearch] = useState('');       // la chaîne que l'utilisateur tape dans l'input.
  const [open, setOpen] = useState(false);        //booléen pour savoir si la liste déroulante est visible.
  const [filtered, setFiltered] = useState([]);   //tableau des résultats filtrés.

  // ---------------------- Chargement des données JSON depuis 'public/data.json' ----------------------
  useEffect(() => {
    fetch('/data.json')
      .then(res => res.json()) //transforme la réponse HTTP en JSON utilisable (promesse contenant l’objet JavaScript parsé).
      .then(json => {
        const cleaned = json.map(item => ({
          Id: item.Id,
          category: item.category || '',
          name: item.name || ''
        }));
        setDatas(cleaned);
      })
      .catch(err => {
        console.error('Erreur lors du chargement du JSON:', err);
      });
  }, []);

  // ---------------------- Fonction appelée au clic sur le bouton Recherche ----------------------
  const handleSearch = () => {
    const results = datas.filter(item =>
      item.name.toLowerCase().includes(search.toLowerCase())  //Filtre les données pour ne garder que celles dont le name correspond à la recherche
    );
    setFiltered(results);         //Met à jour le tableau filtered avec ces résultats
    setOpen(true);              //Ouvre le dropdown en passant open à true.
  };

  // ---------------------- Return ----------------------
  return (
    <div className="max-w-sm relative mt-8">
      <div className="flex">
        <div className="relative flex-grow">

         <Input
            type="text"
            role="combobox"
            label=""
            withCopy={false}
            aria-expanded={open}
            aria-controls="search-results"
            aria-autocomplete="list"
            placeholder="Recherche (formation, stagiaire....)"
            className="py-3 ps-10 pe-4 w-full h-10 border border-gray-200 rounded-l-lg sm:text-sm focus:border-1"
            value={search}
            onChange={e => setSearch(e.target.value)}
            onBlur={() => setTimeout(() => setOpen(false), 150)}
          ></Input>
        </div>

        {/* Bouton de recherche */}
        <Button
          onClick={handleSearch}
          className="bg-blue-600 text-white px-4 rounded-r-lg w-12 h-11 flex items-center justify-center"
          shape="square"
        >
            <Search size={15} color={"white"} />
        </Button>
      </div>

      {/* Dropdown suggestions */}
      {open && filtered.length > 0 && (
        <div
          id="search-results"
          className="absolute z-50 w-full bg-white border border-gray-200 rounded-b-lg max-h-72 overflow-y-auto mt-1 shadow-lg"
        >
          {filtered.map(item => (
            <div
              key={item.Id}
              onMouseDown={() => {
                setSearch(item.name);
                setOpen(false);
              }}
              className="cursor-pointer px-4 py-2 hover:bg-gray-100 flex justify-between items-center"
            >
              <span>{item.name}</span>
              <span className="text-xs text-gray-500">{item.category}</span>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

export default SearchBar;
