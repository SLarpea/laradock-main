import { methods } from "./defaults";
export const getRouteName = (module, method) => {
    return `${module}.${methods[method]}`;
}

export const formatDate = (string, smallTime = false) => {
    const date = new Date(string);

    const year = date.getFullYear();
    const month = (date.getMonth() + 1).toString().padStart(2, '0');
    const day = date.getDate().toString().padStart(2, '0');
    const hours = date.getHours() > 12 ? date.getHours() - 12 : date.getHours();
    const minutes = date.getMinutes().toString().padStart(2, '0');
    const ampm = date.getHours() >= 12 ? 'PM' : 'AM';

    const hourFormatted = (hours === 0) ? 12 : hours;

    if (smallTime) return `${year}-${month}-${day} <small>${hourFormatted}:${minutes} ${ampm}</small>`;
    else return `${year}-${month}-${day} ${hourFormatted}:${minutes} ${ampm}`;
}

$(document).ready(function () {
    $(".switch").click(function (e) {
        e.preventDefault();
        var $formPiece = $(this).parents(".form-peice");
        $formPiece.toggleClass("switched");
        $formPiece
            .siblings(".form-peice")
            .toggleClass("switched", !$formPiece.hasClass("switched"));
        $(this).toggleClass("active");
    });
});