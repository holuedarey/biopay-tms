(function () {
    function show(id) {
        let slider = tailwind.Modal.getOrCreateInstance(document.querySelector(id));
        slider.show()
    }

    show('#create-kyc-level');

})()
