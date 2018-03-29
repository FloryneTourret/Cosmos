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

  $(".b1").hide();
  $(".b2").hide();
  $(".b3").hide();
  $(".b4").hide();
  
  $("#action1").click(function() {
    $(".b1").show();
  });
  $(".b1 #annuler").click(function() {
    $(".b1").hide();

  });

  $("#action2").click(function() {
    $(".b2").show();
  });
  $(".b2 #annuler2").click(function() {
    $(".b2").hide();

  });

  $("#action3").click(function() {
    $(".b3").show();
  });
  $(".b3 #annuler3").click(function() {
    $(".b3").hide();


  });


  $("#action4").click(function() {
    $(".b4").show();
  });
  $(".b4 #annuler3").click(function() {
    $(".b4").hide();


  });

  
});
