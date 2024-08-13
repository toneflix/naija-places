import Notify from "simple-notify";
import swal from "sweetalert";

export const notify = (text: string) => {
    new Notify({
        text,
        position: "bottom left",
        showCloseButton: false,
        showIcon: false,
    });
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
