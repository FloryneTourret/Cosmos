$(".objets img").click(function() {

    if($(".objets img").hasClass("actifb2-1")){
        if($(".objets img").hasClass("actifb2-2")){
            if($(this).hasClass("actifb2-1")){
                $(this).removeClass("actifb2-1");
                console.log("Enlever carte 1");

            }
            else if($(this).hasClass("actifb2-2")){
                $(this).removeClass("actifb2-2");
                console.log("Enlever carte 2");

            }
            else {
                $("input").prop("checked", false);
                $(".objets img").removeClass("actifb2-2");
                $(".objets img").removeClass("actifb2-1");
                $(this).toggleClass("actifb2-1");

                console.log("Ne pas placer carte");
            }

        }
        else {
            if($(this).hasClass("actifb2-1")){
                $(this).removeClass("actifb2-1");
                console.log("Enlever carte 1");

            }
            else if($(this).hasClass("actifb2-2")){
                $(this).removeClass("actifb2-2");
                console.log("Enlever carte 2");

            }
            else {
                $(this).toggleClass("actifb2-2");
                console.log("Carte 1 prise, Carte 2 non prise : placée ");
            }
        }

    }

    else{
        if($(this).hasClass("actifb2-1")){
            $(this).removeClass("actifb2-1");
            console.log("Enlever carte");

        }
        else if($(this).hasClass("actifb2-2")){
            $(this).removeClass("actifb2-2");
            console.log("Enlever carte");

        }
        else {
            console.log("Carte 1 non prise : placée ");
            $(this).toggleClass("actifb2-1");
        }


    }

});

