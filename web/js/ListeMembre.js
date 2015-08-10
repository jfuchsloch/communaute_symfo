
$(document).ready(function(){

 console.log("test");

 setInterval(function(){

    $.ajax({
        type: "POST",
        dataType:"json"
    }).done(function(resultat)
    {
        console.log("ajax fin post");
        console.log(resultat);
        $("#lstNbConnectes").html("") ;
        $("#lstNbConnectes").empty().append(resultat);
        
    })} , 1000);

    
    setInterval(function(){

        $.ajax({
            type: "GET",
            dataType:"json"

        }).done(function(resultat)
        {
            console.log("ajax fin get");
            
            console.log(resultat);
            
          $("#listeMembreConnectes").html("") ;
           $("#listeMembreConnectes").empty().append(resultat);
        })} , 1000);

        



    console.log("fin");

});