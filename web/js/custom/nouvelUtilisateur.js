$(document).ready(function ()
{    
     $("#nouvelUtilisateurForm").on("submit", function (e)
     {
        e.preventDefault();
        var nom = $("#nom").val();
        var cuid = $("#cuid").val();
        var email = $("#email").val();
        var role = $("#role").val();
        var regions = [];
        
        
        $('#regions :selected').each(function(i, selected){ 
          regions[i] = $(selected).text(); 
        });
        
        console.log(regions);
             
        
        var route = Routing.generate('_index_utilisateurs');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmit").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_ajouter_utlisateur'),
            type: 'POST',
            data: 
                {
                    'nom':nom,
                    'cuid':cuid,
                    'email':email,
                    'role':role,
                    'regions': regions
                                       
                 },
                success: function (json)
                    {                        
                        
                            $('#reponse').html(
                               "<span class='ok'>" + "Utilisateur enregistré avec succès" + "</span>");

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
    
    $("#majUtilisateurForm").on("submit", function (e)
     {
       
        e.preventDefault();
        var nom = $("#nom").val();
        var cuid = $("#cuid").val();
        var email = $("#email").val();
        var role = $("#role").val();  
        var idUtilisateur = $("#idUtilisateur").val();
             
        
        var route = Routing.generate('index_utilisateurs');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmit").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('maj_utilisateur'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'cuid':cuid,
                    'email':email,
                    'role':role,
                    'idUtilisateur':idUtilisateur                                       
                 },
                success: function (json)
                    {                        
                        
                            $('#reponse').html(
                               "<span class='ok'>" + "Utilisateur modifié avec succès" + "</span>");

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





