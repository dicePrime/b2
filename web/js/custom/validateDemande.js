$(document).ready(function ()
{

    $("#nature").bind('change', NatureChangeListener);
    $("#region").bind('change', NatureChangeListener);

    $("#btnAdd").bind('click', Add);
    $(".btnDelete").bind('click', Delete);
    ///$("#btnSubmit").bind('click', Submit);
    $("#btnRejetDemande").bind('click', RejetDemande);
    $("#btnUpdateDemande").bind('click', UpdateDemande);
    $("#btnCloturer").bind('click', CloturerDemande);


    //Chaque fois qu'on insère une nouvelle ligne, elle 
    //est en fait la même que la source en retirant juste le style = 'display:none'


    var newRowHtml = initNewRowHtml();

    function initNewRowHtml()
    {
        var chaine = $("#source").html();
        return "<tr>" + chaine + "</tr>";
    }
    
    
    /**
     * La fonction utilisée pour rejeter une demande
     * @returns {undefined}
     */
    function CloturerDemande()
    {
        if ($("#commentaire").val() !== '')
        {
            var commentaire = $("#commentaire").val();
            var idDemande = $("#idDemande").val();

            var route = Routing.generate('_cloture_demande_utilisateur', {'idDemande': idDemande});

            var data = {'commentaire': commentaire};
            $("#loadingResponse").toggle();
            $('#reponse').html("<span style='color:orange'>Enregistrement en cours...</span>");

            $.ajax({
                url: route,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (json)
                {

                    if (json['resultat'] === 'OK')
                    {
                        $("#reponse").html("<span class='ok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                    else
                    {
                        $("#reponse").html("<span class='nok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                },
                error: function (json)
                {
                    $("#reponse").html("<span class='nok'> Impossible d'effectuer cette action</span>");
                    $("#loadingResponse").toggle();
                }
            });
        }
        else
        {
            alert("Vous devez renseigner un commentaire pour cloturer la demande");
            return;
        }
    }


    function NatureChangeListener()
    {

        var nature = $("#nature").val();
        var region = $("#region").val();


        var test = nature !== null || region !== null;

        if (test)
        {
            if (!nature)
            {
                nature = 'null';
            }
            if (!region)
            {
                region = 'null';
            }
            $("#site").html("<option value=''>chargement en cours ...</option>");
            $.ajax({
                url: Routing.generate('_get_site_by_region_and_nature', {'region': region, 'nature': nature}),
                type: 'POST',
                data: {},
                dataType: 'json',
                success: function (data) {

                    var donnees = "";
                    if (data)
                    {
                        donnees = "";
                        $.each(data, function (i, val) {
                            //console.log(val.nom);
                            donnees += "<option value='" + val.id + "'>" + val.nom.toUpperCase() + "</option>";

                        });
                        donnees = donnees + '</select>';
                    }



                    $("#site").html(donnees);

                }

            });
        }
    }

    function everyThingInIntervenantsIsCorrect()
    {
        var resultat = true;
        $('#intervenantsTable tr').each(function (row, tr) {


            if (row >= 2 &&
                    ($(tr).find('td:eq(2)').find('select').val() === '' ||
                            ($(tr).find('td:eq(1)').find("input").val() === '') ||
                            ($(tr).find('td:eq(0)').find("input").val() === '')
                            )
                    )
            {

                resultat = false;

            }

        });

        return resultat;
    }

    function everythingIsCorrect()
    {
        var site = $("#site").val();
        var dateDebut = $("#dateDebut").val();
        var dateFin = $("#dateFin").val();
        var descriptionTravaux = $("#descriptionTravaux").val();
        var evaluationRisques = $("#evaluationRisques").val();
        var mesuresPreventives = $("#mesuresPreventives").val();


        var conditionFormulaire = site !== null && dateDebut !== '' && dateFin !== '' &&
                descriptionTravaux !== '' && evaluationRisques !== '' &&
                mesuresPreventives !== '';
        var conditionTableau = everyThingInIntervenantsIsCorrect();

        var resultat = {'resultat': false, 'message': ""};

        if (conditionFormulaire === true && conditionTableau === true)
        {
            resultat = {'resultat': true, 'message': ""};
        }

        else
        {
            resultat = {'resultat': false, 'message': "Veuillez renseigner tous les champs obligatoires et ne laissez aucune ligne du tableau vide"};
        }

        return resultat;

    }

    /**
     * La fonction utilisée pour rejeter une demande
     * @returns {undefined}
     */
    function RejetDemande()
    {
        if ($("#commentaire").val() !== '')
        {
            var commentaire = $("#commentaire").val();
            var idDemande = $("#idDemande").val();

            var route = Routing.generate('_rejet_demande_utilisateur', {'idDemande': idDemande});

            var data = {'commentaire': commentaire};
            $("#loadingResponse").toggle();
            $('#reponse').html("<span style='color:orange'>Enregistrement en cours...</span>");

            $.ajax({
                url: route,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (json)
                {

                    if (json['resultat'] === 'OK')
                    {
                        $("#reponse").html("<span class='ok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                    else
                    {
                        $("#reponse").html("<span class='nok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                },
                error: function (json)
                {
                    $("#reponse").html("<span class='nok'> Impossible d'effectuer cette action</span>");
                    $("#loadingResponse").toggle();
                }
            });
        }
        else
        {
            alert("Vous devez renseigner un commentaire en cas de rejet");
            return;
        }
    }

    function UpdateDemande()
    {
        var validation = everythingIsCorrect();

        if (validation['resultat'] === true)
        {
            var site = $("#site").val();
            var dateDebut = $("#dateDebut").val();
            var dateFin = $("#dateFin").val();
            var descriptionTravaux = $("#descriptionTravaux").val();
            var evaluationRisques = $("#evaluationRisques").val();
            var mesuresPreventives = $("#mesuresPreventives").val();
            var numeroOT = $("#numeroOT").val();
            var intervenants = getTableValues();
            var commentaire = $("#commentaire").val();
            var idDemande = $("#idDemande").val();

            var data = {'site': site, 'dateDebut': dateDebut, 'dateFin': dateFin,
                'descriptionTravaux': descriptionTravaux, 'evaluationRisques': evaluationRisques,
                'intervenants': intervenants,
                'numeroOT': numeroOT,
                'commentaire': commentaire,
                'mesuresPreventives': mesuresPreventives};

            var route = Routing.generate('_validate_demande', {'idDemande': idDemande});
            var redirect_route = Routing.generate('_taches_utilisateur');
            $("#loadingResponse").toggle();
            $('#reponse').html("<span style='color:orange'>Enregistrement en cours...</span>");

            $.ajax({
                url: route,
                type: 'POST',
                data: data,
                dataType: 'json',
                success: function (json)
                {

                    if (json['resultat'] === 'OK')
                    {
                        $("#reponse").html("<span class='ok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                    else
                    {
                        $("#reponse").html("<span class='nok'>" + json['message'] + "</span>");
                        $("#loadingResponse").toggle();
                    }
                      window.location = redirect_route;
                },
                error: function (json)
                {
                    $("#reponse").html("<span class='nok'> Impossible d'enregistrer la demande</span>");
                    $("#loadingResponse").toggle();
                }
            });

        }
        else
        {
            $("#reponse").html("<span class='nok'>" + validation['message'] + "</span>");
        }
    }


    function Add()
    {
        $('#intervenantsTable tbody').append(newRowHtml);
        $('.btnDelete').bind('click', Delete);
    }

    function Delete()
    {
        //on recupère le parent de l'élément
        var par = $(this).parent().parent().parent();

        // on supprime ce parent (la ligne)
        par.remove();
    }

    /**
     * Cette fonction retourne la liste des réparations leurs id
     * @returns {undefined}
     */
    function getTableValues()
    {
        var tableData = new Array();
        $('#intervenantsTable tr').each(function (row, tr) {
            tableData[row] =
                    {'nom': $(tr).find('td:eq(0)').find('input').val(),
                        'contact': $(tr).find('td:eq(1)').find('input').val(),
                        'societe': $(tr).find('td:eq(2)').find('select').val()
                    };

        });
        tableData.shift();
        tableData.shift();
        return tableData;

    }


});



