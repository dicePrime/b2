$(document).ready(function ()
{  
    
     $("#nouveauFournisseurForm").on("submit", function (e)
     {
       
        
        e.preventDefault();
        var nom = $("#nom").val();
        var email = $("#email").val();
        var telephone = $("#telephone").val();  
             
        
        var route = Routing.generate('index_fournisseurs');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmit").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('ajouter_fournisseur'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'email':email,
                    'telephone':telephone
                                       
                 },
                success: function (json)
                    {                        
                        
                            $('#reponse').html(
                               "<span class='ok'>" + "Fournisseur enregistré avec succès" + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnSubmit").removeAttr('disabled');
                                window.location = route;                          
                    },
                    error: function(json){
                           
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmit").removeAttr('disabled');
                        }
                    });                      
                      
    });
    
    $("#majFournisseurForm").on("submit", function (e)
     {
       
        e.preventDefault();
        var nom = $("#nom").val();
        var email = $("#email").val();
        var telephone = $("#telephone").val();  
        var idFournisseur = $("#idFournisseur").val();
             
        
        var route = Routing.generate('index_fournisseurs');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmit").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('maj_fournisseur'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'email':email,
                    'telephone':telephone,
                    'idFournisseur':idFournisseur
                 },
                success: function (json)
                    {                        
                        
                            $('#reponse').html(
                               "<span class='ok'>" + "Fournisseur modifié avec succès" + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnSubmit").removeAttr('disabled');
                                window.location = route;                          
                    },
                    error: function(json){
                           
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmit").removeAttr('disabled');
                        }
                    });                      
                      
    });

   
});






