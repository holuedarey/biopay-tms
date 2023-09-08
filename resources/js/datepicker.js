import dayjs from "dayjs";
import Litepicker from "litepicker";
import {createIcons, icons} from "lucide";

(function () {
    "use strict";

    $(".datepicker").each(function () {
        let today = new Date();
        let this_year = today.getFullYear();

        let options = {
            autoRefresh: true,
            autoApply: $(this).data('auto-apply') !== 'no',
            singleMode: false,
            numberOfColumns: 2,
            numberOfMonths: 2,
            showWeekNumbers: true,
            format: "YYYY-MM-DD",
            dropdowns: {
                minYear: this_year - 60,
                maxYear: this_year,
                months: true,
                years: true,
            },
        };

        if ($(this).data("single-mode")) {
            options.singleMode = true;
            options.numberOfColumns = 1;
            options.numberOfMonths = 1;
        }

        if ($(this).data("format")) {
            options.format = $(this).data("format");
        }

        if (!$(this).val()) {
            let date = dayjs().format(options.format);
            date += !options.singleMode
                ? ` - ${dayjs().add(1, "month").format(options.format)}`
                : "";
            $(this).val(date);
        }

        new Litepicker({
            element: this,
            ...options,
            setup: (picker) => {
                picker.on('selected', (date1, date2) => {
                    let component = $(this).attr('component');
                    Livewire.emit(`litepicker${component}`, $(this).val())
                });

                picker.on('button:apply', (date1, date2) => {
                    if($(this).data('request-on-apply') === 'yes') {
                        this.closest('form').submit()
                    }
                });
            }
        });
    });
})();
