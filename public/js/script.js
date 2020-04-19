$(function () {//DOM ready

    //Affichage du nom de fichier dans le champ avatar de l'inscription après upload
    $('#registration_avatar').on('change',function(){
        //Récupérer le nom du fichier
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        console.log(fileName);
        //Insérer le nom du fichier dans le champ
        $(this).next('.custom-file-label').html(fileName);
    });


    //Affichage de la liste des pays en fonction du continent sélectionné
    //dans le module de recherche des articles pour l'administrateur
    $('#search_article_continent').on('change', function() {

        //Récupérer l'id du continent sélectionné
        var $continentID = $(this).val();
        console.log($continentID);

        //Lister toutes les balises option pour les pays
        var $countries = $('#search_article_country option');


        //Modifier la visibilité de l'option en fonction de son continent
        //Si aucun continent sélectionné, on affiche tous les pays
        if(!$continentID){

            $countries.each(function () {
                $this = $(this);
                $this.show();
            });
        }
        //Si un continent est sélectionné, on n'affiche que les pays du continent
        else {

            $countries.each(function () {
                $this = $(this);
                if($this.data('continent') == $continentID){
                    $this.show();
                } else {
                    $this.hide();
                }
            });
        }
    });


    // interception du clic
    $('.btn-content').click(function (event) {
        // éviter d'aller vers la page du lien
        event.preventDefault();

        // objet JQuery sur le lien
        var $btn = $(this);

        $.ajax({
            //method: 'get',
            url: $btn.attr('href'),
            success: function(response) {
                var $modal = $('#modal-content');

                $modal.find('.modal-body').html(response);
                $modal.modal('show');
            }
        });
    });


       });

