
J(document).ready(function () {
    // Show slide over
    let editGroupSlide = null;

    Livewire.on('editGroupModal', data => {
        let modal = $('div#edit-group')

        if ( editGroupSlide === null ) {
            editGroupSlide = tailwind.Modal.getOrCreateInstance(document.querySelector("#edit-group"));
        }

        if ( data === "close" ) {
            editGroupSlide.hide();
        }
        else {
            modal.find('h2.slide-over-title').html("Edit Group '" + data['name'] + "'")
            editGroupSlide.show();
        }
    })

})
