
import TomSelect from "tom-select";

J(document).ready(function () {
    "use strict";

    // Show slide over
    let addRoutingSettingSlide = null;
    let editRoutingSettingSlide = null;

    Livewire.on('addRoutingSettingModal', data => {

        if ( addRoutingSettingSlide === null ) {
            addRoutingSettingSlide = tailwind.Modal.getOrCreateInstance(document.querySelector("#add-routing-setting"));
        }

        if ( data === "close" ) {
            addRoutingSettingSlide.hide();
        }
        else {
            addRoutingSettingSlide.show();
        }
    })

    Livewire.on('editRoutingSettingModal', data => {
        if ( editRoutingSettingSlide === null ) {
            editRoutingSettingSlide = tailwind.Modal.getOrCreateInstance(document.querySelector("#edit-routing-setting"));
        }

        if ( data === "close" ) {
            editRoutingSettingSlide.hide();
        }
        else {
            editRoutingSettingSlide.show();
        }
    })


    Livewire.on('notify-error', data => {
        console.log("error:: " + data);

        let errEl = $("#validation-error");
        errEl.html(data);

    })

})
