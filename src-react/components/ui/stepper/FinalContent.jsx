
function FinalContent ({content = [
    {
        bool: true, description: "lorem ipsum"
    }
]})  {
    return (
        <>
        
            {content.map((item, i) => (
                        <div data-hs-stepper-content-item={`{isFinal: ${item.bool}}`}>

                <FinalStepContent key={i} bool={item.bool} description={item.description}/>
                </div>
            ))}
        </>
        
)}


export default FinalContent

function FinalStepContent({bool, description}) {

    if (!bool) return null;
    return (
        <div className="p-4 h-48 bg-gray-50 flex justify-center items-center border border-dashed border-gray-200 rounded-xl dark:bg-neutral-800 dark:border-neutral-700">
        <h3 className="text-gray-500 dark:text-neutral-500">
          {description || "Final content"}
        </h3>
      </div>
    )    
}