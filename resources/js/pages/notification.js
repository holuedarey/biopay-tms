import Toastify from "toastify-js";
import {createIcons, icons} from "lucide";

(function () {
    const success = $("#success-notification-content"),
    error = $("#error-notification-content"),
    info = $("#info-notification-content"),
    pending = $("#pending-notification-content");
    const validation = $(".validation-msg");

    const successDuration = 3500;
    const defaultDuration = 5500;

    if(success.length) {
        callToast(success, successDuration)
    }

    if(error.length) {
        callToast(error)
    }

    if(info.length) {
        callToast(info)
    }

    if(pending.length) {
        callToast(pending)
    }


    window.addEventListener('success', event => {
        callToast2('Success', event.detail.message, successDuration)
    })

    window.addEventListener('error', event => {
        if (event.detail) {
            callToast2('Error', event.detail.message)
        }
    })

    window.addEventListener('info', event => {
        callToast2('Info', event.detail.message)
    })

    window.addEventListener('pending', event => {
        callToast2('Pending', event.detail.message)
    })

    function callToast(element, duration = defaultDuration) {
        Toastify({
            node: element.clone().removeClass("hidden")[0],
            duration: duration,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();
    }

    function callToast2(title, message, duration = defaultDuration) {
        let node = getNode(title, message);

        Toastify({
            node: $(node).clone().removeClass("hidden")[0],
            duration: duration,
            newWindow: true,
            close: true,
            gravity: "top",
            position: "right",
            stopOnFocus: true,
        }).showToast();


        setTimeout(function () {
            createIcons({
                icons,
                "stroke-width": 1.5,
                nameAttr: "data-lucide",
            });
        }, 1000)
    }

    function getNode(title, message)
    {
        let color;

        switch (title) {
            case 'Success': case 'Pending':
                color = title.toLowerCase();
                break;

            case 'Error':
                color = 'danger';
                break;

            default:
                color = 'info';
        }

        title = color === 'pending' ? 'Awaiting Approval' : title;

        return `<div id="${color}-notification-content" class="toastify-content hidden flex items-start bg-${color}/20"> <div class="mt-1">${getIcon(color)}</div> <div class="ml-4 mr-4"><div class="font-bold text-lg text-${color}">  ${title} !</div><div class="text-slate-500 mt-1 message"> ${message} </div></div></div>`;
    }

    function getIcon(color)
    {
        switch (color) {
            case 'success':
                return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check-circle text-success" data-lucide="check-circle" xmlns="http://www.w3.org/2000/svg"><path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>`

            case 'danger':
                return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="alert-triangle" class="lucide lucide-alert-triangle text-danger"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"></path><line x1="12" y1="9" x2="12" y2="13"></line><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>`

            default:
                return `<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="alert-circle" class="lucide lucide-alert-circle text-${color}"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>`
        }
    }

    if(validation.length) {
        validation.each(function() {
            Toastify({
                text: $(this).data('msg'),
                duration: 6000,
                close: true,
                stopOnFocus: true,
                style: {
                    color: '#c21919',
                    background: '#fbe9eb',
                    display: 'flex',
                    padding: '5px 25px 5px 10px'
                }
            }).showToast();
        });
    }
})()
