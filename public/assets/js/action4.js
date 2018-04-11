var checkbox = document.getElementsByClassName('checkbox'),
    form = document.getElementById('formulaire'),
    ordre=[];

$(".objets img").click(function() {
    //Place 1 prise
    if($(".objets img").hasClass("actifb4-1")){
        //Place 2 prise
        if($(".objets img").hasClass("actifb4-2")){
            //Place 3 prise
            if($(".objets img").hasClass("actifb4-3")){
                //Place 4 prise
                if($(".objets img").hasClass("actifb4-4")){
                    if($(this).hasClass("actifb4-1")){

                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-3");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-1");
                        console.log("Enlever carte 1");

                        ordre=[];



                    }
                    else if($(this).hasClass("actifb4-2")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-3");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-2");
                        console.log("Enlever carte 2");

                        ordre=[];

                    }
                    else if($(this).hasClass("actifb4-3")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-3");
                        console.log("Enlever carte 3");

                        ordre=[];

                    }
                    else if($(this).hasClass("actifb4-4")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-3");

                        $(this).removeClass("actifb4-4");
                        console.log("Enlever carte 4");

                        ordre=[];

                    }
                    else {
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-3");
                        $(".objets img").removeClass("actifb4-4");
                        $(this).toggleClass("actifb4-1");

                        console.log("Ne pas placer carte");

                        ordre=[];
                    }
                }   //Place 4 non prise
                else {
                    if($(this).hasClass("actifb4-1")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-3");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-1");
                        console.log("Enlever carte 1");

                        ordre=[];

                    }
                    else if($(this).hasClass("actifb4-2")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-3");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-2");
                        console.log("Enlever carte 2");

                        ordre=[];

                    }
                    else if($(this).hasClass("actifb4-3")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-4");

                        $(this).removeClass("actifb4-3");
                        console.log("Enlever carte 3");

                        ordre=[];

                    }
                    else if($(this).hasClass("actifb4-4")){
                        $("input").prop("checked", false);
                        $(".objets img").removeClass("actifb4-1");
                        $(".objets img").removeClass("actifb4-2");
                        $(".objets img").removeClass("actifb4-3");

                        $(this).removeClass("actifb4-4");
                        console.log("Enlever carte 4");

                        ordre=[];

                    }
                    else {
                        $(this).toggleClass("actifb4-4");
                        console.log("Carte 1 prise, Carte 2 prise, Carte 3 prise, Carte 4 non prise : placée ");
                    }
                }
            }
            //Place 3 non prise
            else {
                if($(this).hasClass("actifb4-1")){
                    $("input").prop("checked", false);
                    $(".objets img").removeClass("actifb4-2");
                    $(".objets img").removeClass("actifb4-3");
                    $(".objets img").removeClass("actifb4-4");

                    $(this).removeClass("actifb4-1");
                    console.log("Enlever carte 1");

                    ordre=[];

                }
                else if($(this).hasClass("actifb4-2")){
                    $("input").prop("checked", false);
                    $(".objets img").removeClass("actifb4-1");
                    $(".objets img").removeClass("actifb4-3");
                    $(".objets img").removeClass("actifb4-4");

                    $(this).removeClass("actifb4-2");
                    console.log("Enlever carte 2");

                    ordre=[];

                }
                else if($(this).hasClass("actifb4-3")){
                    $("input").prop("checked", false);
                    $(".objets img").removeClass("actifb4-1");
                    $(".objets img").removeClass("actifb4-2");
                    $(".objets img").removeClass("actifb4-4");

                    $(this).removeClass("actifb4-3");
                    console.log("Enlever carte 3");

                    ordre=[];

                }
                else if($(this).hasClass("actifb4-4")){
                    $("input").prop("checked", false);
                    $(".objets img").removeClass("actifb4-1");
                    $(".objets img").removeClass("actifb4-2");
                    $(".objets img").removeClass("actifb4-3");

                    $(this).removeClass("actifb4-4");
                    console.log("Enlever carte 4");

                    ordre=[];

                }
                else {
                    $(this).toggleClass("actifb4-3");
                    console.log("Carte 1 prise, Carte 2 prise, Carte 3 non prise : placée ");
                }
            }


        }
        //Place 2 non prise
        else {
            if($(this).hasClass("actifb4-1")){
                $("input").prop("checked", false);
                $(".objets img").removeClass("actifb4-2");
                $(".objets img").removeClass("actifb4-3");
                $(".objets img").removeClass("actifb4-4");

                $(this).removeClass("actifb4-1");
                console.log("Enlever carte 1");

                ordre=[];

            }
            else if($(this).hasClass("actifb4-2")){
                $("input").prop("checked", false);
                $(".objets img").removeClass("actifb4-1");
                $(".objets img").removeClass("actifb4-3");
                $(".objets img").removeClass("actifb4-4");

                $(this).removeClass("actifb4-2");
                console.log("Enlever carte 2");

                ordre=[];

            }
            else if($(this).hasClass("actifb4-3")){
                $("input").prop("checked", false);
                $(".objets img").removeClass("actifb4-1");
                $(".objets img").removeClass("actifb4-2");
                $(".objets img").removeClass("actifb4-4");

                $(this).removeClass("actifb4-3");
                console.log("Enlever carte 3");

                ordre=[];

            }
            else if($(this).hasClass("actifb4-4")){
                $("input").prop("checked", false);
                $(".objets img").removeClass("actifb4-1");
                $(".objets img").removeClass("actifb4-2");
                $(".objets img").removeClass("actifb4-3");

                $(this).removeClass("actifb4-4");
                console.log("Enlever carte 4");

                ordre=[];

            }
            else {
                $(this).toggleClass("actifb4-2");
                console.log("Carte 1 prise, Carte 2 non prise : placée ");
            }
        }

    }

    //Place 1 non prise
    else{
        if($(this).hasClass("actifb4-1")){
            $("input").prop("checked", false);
            $(".objets img").removeClass("actifb4-2");
            $(".objets img").removeClass("actifb4-3");
            $(".objets img").removeClass("actifb4-4");

            $(this).removeClass("actifb4-1");
            console.log("Enlever carte 1");

            ordre=[];

        }
        else if($(this).hasClass("actifb4-2")){
            $("input").prop("checked", false);
            $(".objets img").removeClass("actifb4-1");
            $(".objets img").removeClass("actifb4-3");
            $(".objets img").removeClass("actifb4-4");

            $(this).removeClass("actifb4-2");
            console.log("Enlever carte 2");

            ordre=[];

        }
        else if($(this).hasClass("actifb4-3")){
            $("input").prop("checked", false);
            $(".objets img").removeClass("actifb4-1");
            $(".objets img").removeClass("actifb4-2");
            $(".objets img").removeClass("actifb4-4");

            $(this).removeClass("actifb4-3");
            console.log("Enlever carte 3");

            ordre=[];

        }
        else if($(this).hasClass("actifb4-4")){
            $("input").prop("checked", false);
            $(".objets img").removeClass("actifb4-1");
            $(".objets img").removeClass("actifb4-2");
            $(".objets img").removeClass("actifb4-3");

            $(this).removeClass("actifb4-4");
            console.log("Enlever carte 4");

            ordre=[];

        }
        else {

            ordre=[];

            $("input").prop("checked", false);
            console.log("Carte 1 non prise : placée ");
            $(this).toggleClass("actifb4-1");
        }


    }


    for(var i=0, len=7; i<len; i++){
        checkbox[i].onclick=function(){
            if(this.checked)
                ordre.push(this.value);
            else if((key = ordre.indexOf(this.value)) >-1 )
                ordre.splice(key,1);
            form.paires.value = '['+ordre.join(',')+']';
        };
    }

});

