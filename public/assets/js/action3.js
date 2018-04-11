$(".objets img").click(function() {

    if($(".objets img").hasClass("actifb3-1")){
        if($(".objets img").hasClass("actifb3-2")){
            if($(".objets img").hasClass("actifb3-3")){
                if($(this).hasClass("actifb3-1")){
                    $(this).removeClass("actifb3-1");
                    console.log("Enlever carte 1");

                }
                else if($(this).hasClass("actifb3-2")){
                    $(this).removeClass("actifb3-2");
                    console.log("Enlever carte 2");

                }
                else if($(this).hasClass("actifb3-3")){
                    $(this).removeClass("actifb3-3");
                    console.log("Enlever carte");

                }
                else {
                    $("input").prop("checked", false);
                    $(".objets img").removeClass("actifb3-2");
                    $(".objets img").removeClass("actifb3-1");
                    $(".objets img").removeClass("actifb3-3");
                    $(this).toggleClass("actifb3-1");

                    console.log("Ne pas placer carte");
                }
            }else {
                $(this).toggleClass("actifb3-3");
                console.log("Carte 1 prise, Carte 2 prise, Carte 3 non prise : placée ");
            }

        }
        else {
            if($(this).hasClass("actifb3-1")){
                $(this).removeClass("actifb3-1");
                console.log("Enlever carte 1");

            }
            else if($(this).hasClass("actifb3-2")){
                $(this).removeClass("actifb3-2");
                console.log("Enlever carte 2");

            }
            else if($(this).hasClass("actifb3-3")){
                $(this).removeClass("actifb3-3");
                console.log("Enlever carte");

            }
            else {
                $(this).toggleClass("actifb3-2");
                console.log("Carte 1 prise, Carte 2 non prise : placée ");
            }
        }

    }

    else{
        if($(this).hasClass("actifb3-1")){
            $(this).removeClass("actifb3-1");
            console.log("Enlever carte");

        }
        else if($(this).hasClass("actifb3-2")){
            $(this).removeClass("actifb3-2");
            console.log("Enlever carte");

        }
        else if($(this).hasClass("actifb3-3")){
            $(this).removeClass("actifb3-3");
            console.log("Enlever carte");

        }
        else {
            console.log("Carte 1 non prise : placée ");
            $(this).toggleClass("actifb3-1");
        }


    }

});

