import React, { useState } from "react";
import Checkbox from "./Checkbox";

// return "yes" or "no"
function RadioButtonsGroup({ onChange }) {
    const [yesCheckValue, setYesCheckValue] = useState(true);
    const [noCheckValue, setNoCheckValue] = useState(false);

    function handleCheckboxValues(e) {
        const { checked, id } = e.target;
        if (id == "yes") {
            setYesCheckValue(checked);
            setNoCheckValue(!checked);
            onChange?.("yes");
        } else {
            setNoCheckValue(checked);
            setYesCheckValue(!checked);
            onChange?.("no");
        }
    }
    return (
        <div className="flex gap-x-6">
            <Checkbox
                id="yes"
                label={"Yes"}
                value={yesCheckValue}
                onChange={(e) => handleCheckboxValues(e)}
            ></Checkbox>
            <Checkbox
                id="no"
                value={noCheckValue}
                label={"No"}
                onChange={(e) => handleCheckboxValues(e)}
            ></Checkbox>
        </div>
    );
}

export default RadioButtonsGroup;
