$(document).ready(function() {
    $("form.formsite").hide();
    $(".backchatactive").click(function() {
        $(".backchatactive").toggleClass("backchat");
        $("form.formsite").toggle();
    });
});
