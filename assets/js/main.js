// main.js
$(document).ready(function() {
    $(document).on('click', '.rate', function(e){
        e.preventDefault();

        var btn = $(this);
        var val = btn.data('value');
        var container = btn.closest('.rating');
        var id = container.data('id');
        var type = container.data('type');
        var messageDiv = container.siblings('.rating-message'); // sélectionne le div pour le message

        if(!id || !val || !type) {
            messageDiv.text("Données invalides pour la notation.").removeClass('text-success').addClass('text-danger');
            return;
        }

        $.ajax({
            url: '/Dicophp/rate.php', // chemin correct depuis la racine
            type: 'POST',
            data: {
                id_mot: id,
                note: val,
                type: type
            },
            dataType: 'json',
            success: function(resp){
                if(resp.success) {
                    messageDiv.text(resp.message).removeClass('text-danger').addClass('text-success');
                } else {
                    messageDiv.text(resp.message || "Impossible d'enregistrer la note.").removeClass('text-success').addClass('text-danger');
                }
            },
            error: function(xhr){
                messageDiv.text("Erreur serveur : " + xhr.status).removeClass('text-success').addClass('text-danger');
            }
        });
    });
});
