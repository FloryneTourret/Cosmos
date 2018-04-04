$(document).ready(function() {
    $("#submitchat").submit(function (e) {
        e.preventDefault();
        $("#chat ul").children().delay(3000).fadeOut();
        console.log('bien valide');
    });

});
