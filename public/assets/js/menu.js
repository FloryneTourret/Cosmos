$(document).ready(function() {
  $(".deroule").hide();
  $(".menu img").click(function() {
    $(".menu img").addClass("actif");
    $(".deroule").show(260);
    $(".menu").mouseleave(function() {
      $(".menu img").removeClass("actif");
      $(".deroule").hide();
    });
  });
});
