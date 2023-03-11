function showError(field, message) {
    if (!message) {
        $(".input_field:has(#" + field + ")")
        .addClass("is-valid")
        .removeClass("is-invalid");
        // .children(".invalid-feedback")
        // .text("");
    } else {
        $(".input_field:has(#" + field + ")")
        .addClass("is-invalid")
        .removeClass("is-valid");
        // .children(".invalid-feedback")
        // .text(message);
        $("#" + field)
        .attr("placeholder", message);
    }
}


function removeValidationClasses(form) {
    $(form).each(function(){
        $(form).find(':input').removeClass('is-valid is-invalid');
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