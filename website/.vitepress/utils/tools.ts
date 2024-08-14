import notifyAio from 'notiflix/build/notiflix-notify-aio.js';
import swal from "sweetalert";
const { Notify } = notifyAio;

export const notify = (text: string, type: 'info' | 'failure' | 'warning' | 'success' = 'success') => {
    Notify[type](text, undefined, {
        useIcon: false,
        position: 'left-bottom',
    })
}

export const confirm = (text: string, title: string = 'Confirm', buttons?: (boolean | string)[]) => {
    return new Promise((resolve, reject) => {
        swal({
            text,
            title,
            buttons,
            dangerMode: true,
        }).then(async (del) => {
            if (del) {
                resolve(del)
            }
        });
    })
}

export const copyClip = (copyText: string) => {
    navigator.clipboard.writeText(copyText);
    notify("Copied to clipboard.")
}
