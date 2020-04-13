$(function () { // DOM ready
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
