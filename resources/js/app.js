import './bootstrap';

$(function(){// BTN BOT
    $('.chatbot-bulle').click(function() {
        $('.chatbot-page').toggleClass('open');
        $('.chatbot-bulle').toggleClass('up');
        $('.message-taping-zone').toggleClass('on');

    });
    $('.chat-header .fa-xmark').click(function() {
        $('.chatbot-page').toggleClass('open');
        $('.chatbot-bulle').toggleClass('up');
        $('.message-taping-zone').toggleClass('on');
    });
    $('.send-message').click(function() {
        $(".send-message i").addClass('animation-send');
        setTimeout(function () {
            $(".send-message i").removeClass('animation-send');
        }, 4000);
    });

    $('#btnGet').click(function () {
        getUserCountry()
    })

});

/* API CHATBOT */
$(document).ready(function() {
    // Gestionnaire d'évenements du form
    $('#chat-form').submit(function(event) {
        event.preventDefault();
        // Récupération de l'input du form (keyword)
        var message = $('#chat-message').val();
        // console.log(message);
        $('#chat-messages').append('<div><strong>' + message + '</strong></div>')
        // S'il y a un message -> Requête
        if (message) {
            // Envoi au serveur
            $.ajax({
                url: 'api/chat',
                method: 'POST',
                dataType: 'json',
                // Il faut bien envoyer les data formatées en json {keyword: data}
                data: { keyword: message },
                // Display de la réponse (name)
                success: function(data) {
                    // Si un message a été trouvé
                    if (Object.keys(data).length != 0) {
                        // Pour les tests en console
                        console.log(data);
                        console.log(typeof message + ' ' + message);
                        $('#chat-messages').append('<div><strong>' + data.name + '</strong></div>');
                    } else {
                        //Si aucun message n'a été trouvé
                        $('#chat-messages').append('<div>Merci de reformuler votre demande.</div>');
                    }
                },
/*                error: function(xhr, status, error) {
                    alert('Error: ' + error);
                }*/
            });
            // On vide l'input pour la prochaine requête
            $('#chat-message').val('');
        }
    });
});


