$(document).ready(function ()
{  
    
     $("#btnNewSociete").on("click", function (e)
     {      
        
        var nom = $("#nom").val();
        var email1 = $("#email1").val();
        var email2 = $("#email2").val();
        var telephone1 = $("#telephone1").val();
        var telephone2 = $("#telephone2").val();
           
        
        var route = Routing.generate('_index_societes');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnNewSociete").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_ajouter_societe'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'email1':email1,
                    'email2': email2,
                    'telephone1':telephone1,
                    'telephone2': telephone2
                  },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnNewSociete").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnNewSociete").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnNewSociete").removeAttr('disabled');
                        }
                    });                      
                      
    });
    
    $("#btnUpdateSociete").on("click", function (e)
     {                                 
          var nom = $("#nom").val();
        var email1 = $("#email1").val();
        var email2 = $("#email2").val();
        var telephone1 = $("#telephone1").val();
        var telephone2 = $("#telephone2").val();
        var idSociete = $("#idSociete").val();
        
        var route = Routing.generate('_index_societes');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnUpdateSociete").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_update_societe',{'idSociete': idSociete} ),
            type: 'POST',
            data: {
                    'nom':nom,
                    'email1':email1,
                    'email2': email2,
                    'telephone1':telephone1,
                    'telephone2': telephone2,
                    'idSociete':idSociete                                                       
                 },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnUpdateSociete").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnUpdateSociete").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnUpdateSociete").removeAttr('disabled');
                        }
                    });                  
    });

   
});





