$(document).ready(function() {
    $(".deroule").hide();
    $(".menu img").click(function() {
        $(".menu img").toggleClass("actif");
        $(".deroule").toggle(200);
    });
});
