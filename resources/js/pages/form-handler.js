import $ from 'jquery';
import {addSpinner} from "./button-spinner";

(function () {
    "use strict";

    $(document).on('submit', '.my-form', function(e) {
        e.preventDefault();

        let form = this;
        let button = $(form).find('[type=submit]');

        addSpinner(button);

        setTimeout(function () {
            form.submit();
        }, 1000)
    })
})();
