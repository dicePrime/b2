$(document).ready(function ()
{  
    
     $("#btnSubmitNewUser").on("click", function (e)
     {      
        
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

        $("#btnSubmitNewUser").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_ajouter_utilisateur'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'cuid':cuid,
                    'email':email,
                    'role':role,
                    'regions': regions
                                       
                 },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnSubmitNewUser").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmitNewUser").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmitNewUser").removeAttr('disabled');
                        }
                    });                      
                      
    });
    
    $("#btnUpdateUser").on("click", function (e)
     {                                 
        var nom = $("#nom").val();
        var cuid = $("#cuid").val();
        var email = $("#email").val();
        var role = $("#role").val();
        var idUtilisateur = $("#idUtilisateur").val();
        var regions = [];
        
        
        $('#regions :selected').each(function(i, selected){ 
          regions[i] = $(selected).text(); 
        });
        
        console.log(regions); 
             
        
        var route = Routing.generate('_index_utilisateurs');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnSubmitNewUser").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_update_utilisateur',{'idUtilisateur': idUtilisateur} ),
            type: 'POST',
            data: {
                    'nom':nom,
                    'cuid':cuid,
                    'email':email,
                    'role':role,
                    'regions': regions,
                    'idUtilisateur':idUtilisateur                                       
                 },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnSubmitNewUser").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmitNewUser").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnSubmitNewUser").removeAttr('disabled');
                        }
                    });                  
    });

   
});



