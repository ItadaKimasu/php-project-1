function showError(field, message, placeholder) {
    if (!message) {
        $(".input_field:has(#" + field + ")")
        .addClass("is-valid")
        .removeClass("is-invalid");
        $("#" + field)
        .attr("placeholder", placeholder);
    } else {
        $(".input_field:has(#" + field + ")")
        .addClass("is-invalid")
        .removeClass("is-valid");
        $("#" + field)
        .attr("placeholder", message);
    }
}


function removeValidationClasses(form) {
    $(form).each(function(){
        $(form).find('.input_field').removeClass('is-valid is-invalid');
    });
}


function showMessage(type, message) {
    return `
    <div class="alert alert-${type} alert-dismissible fade show" role="alert">
        <strong>${message}</strong>

    <button 
        type="button" 
        class="btn-close" 
        data-bs-dismiss="alert" 
        aria-label="Close"
    >
    </button>

    </div>`;
}