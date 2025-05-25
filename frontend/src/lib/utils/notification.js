
export function showNotificacion(title, body, type) {
    //if (typeof window !== 'undefined' && typeof window.jQuery !== 'undefined' && typeof window.jQuery.Toasts !== 'undefined') {
        jQuery(document).Toasts('create', {
            title: title,
            autohide: true,
            delay: 3000, // Ajusta el delay a tu gusto
            class: 'bg-' + type, // bg-info, bg-success, bg-danger, bg-warning
            body: body
        });
    //}

}