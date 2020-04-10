$(function () {//DOM ready

    //Affichage du nom de fichier dans le champ avatar de l'inscription après upload
    $('#registration_avatar').on('change',function(){
        //Récupérer le nom du fichier
        var fileName = $(this).val().replace('C:\\fakepath\\', "");
        console.log(fileName);
        //Insérer le nom du fichier dans le champ
        $(this).next('.custom-file-label').html(fileName);
    });

});