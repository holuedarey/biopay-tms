import {createIcons, icons} from "lucide";
import Tabulator from "tabulator-tables";
import xlsx from "xlsx";

J(document).ready(function () {
    // Show slide over
    let editGroupSlide = null;

    Livewire.on('editFeeModal', data => {
        let modal = $('div#edit-fee')

        if ( editGroupSlide === null ) {
            editGroupSlide = tailwind.Modal.getOrCreateInstance(document.querySelector("#edit-fee"));
        }

        if ( data === "close" ) {
            editGroupSlide.hide();
        }
        else {
            modal.find('h2.slide-over-title').html("Edit Fee for '" + data['title'] + "'")
            editGroupSlide.show();
        }
    })

})
