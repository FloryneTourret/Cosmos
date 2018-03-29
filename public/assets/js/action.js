$(document).ready(function() {
  $(".action1").hide();
  $(".action2").hide();
  $(".action3").hide();
  $(".action4").hide();

  $("#action1").mouseenter(function() {
    $(".action1").show();
  });
  $("#action1").mouseleave(function() {
    $(".action1").hide();
  });

  $("#action2").mouseenter(function() {
    $(".action2").show();
  });
  $("#action2").mouseleave(function() {
    $(".action2").hide();
  });
  $("#action3").mouseenter(function() {
    $(".action3").show();
  });
  $("#action3").mouseleave(function() {
    $(".action3").hide();
  });
  $("#action4").mouseenter(function() {
    $(".action4").show();
  });
  $("#action4").mouseleave(function() {
    $(".action4").hide();
  });
  
});
