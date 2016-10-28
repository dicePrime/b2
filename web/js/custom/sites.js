$(document).ready(function ()
{  
    
     $("#btnNewSite").on("click", function (e)
     {      
        
        var nom = $("#nom").val();
        var region = $("#region").val();
        var nature = $("#nature").val();
        var latitude = $("#latitude").val();
        var longitude = $("#longitude").val();
        var matricule = $("#matricule").val();           
        
        var route = Routing.generate('_index_sites');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnNewSite").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_ajouter_site'),
            type: 'POST',
            data: {
                    'nom':nom,
                    'region': region,
                    'nature': nature,
                    'latitude': latitude,
                    'longitude': longitude,
                    'matricule': matricule
                  },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnNewSite").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnNewSite").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnNewSite").removeAttr('disabled');
                        }
                    });                      
                      
    });
    
    $("#btnUpdateSite").on("click", function (e)
     {                                 
        var nom = $("#nom").val();
        var region = $("#region").val();
        var nature = $("#nature").val();
        var latitude = $("#latitude").val();
        var longitude = $("#longitude").val();
        var idSite = $("#idSite").val();
        var matricule = $("#matricule").val();
        
        var route = Routing.generate('_index_sites');

        $('#reponse').html("<img class='img img-responsive' width=30 height=30 src='../../../img/ajax_loader.gif' style='display:inline'/> <span style='color:orange'>Enregistrement en cours</span>");

        $("#btnUpdateSite").attr('disabled','disabled');
           
        $.ajax({
        
            url: Routing.generate('_update_site',{'idSite': idSite} ),
            type: 'POST',
            data: {
                    'nom':nom,
                    'region': region,
                    'nature': nature,
                    'latitude': latitude,
                    'longitude': longitude,
                    'matricule': matricule                                                      
                 },
                success: function (json)
                    {                        
                           if(json['resultat'] === 'OK')
                           {
                            $('#reponse').html(
                               "<span class='ok'>" + json['message'] + "</span>");

                                $("#reponse").fadeIn(3000);
                                $("#reponse").fadeOut(3000);
                                $("#btnUpdateSite").removeAttr('disabled');
                                window.location = route;     
                            }
                            else if (json['resultat'] === 'NOK')
                            {
                               $('#reponse').html(
                                "<span class='nok'>"+ json['message'] + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnUpdateSite").removeAttr('disabled'); 
                            }
                    },
                    error: function(json){
                            
                            $('#reponse').html(
                                "<span class='nok'> Echec de l'enregistrement" + "</span>");
                            $("#reponse").fadeOut(10000);
                            $("#btnUpdateSite").removeAttr('disabled');
                        }
                    });                  
    });

   
});





