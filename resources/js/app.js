import './bootstrap';

window.addEventListener('DOMContentLoaded', function() {
    // BTN BOT
    document.querySelectorAll('.chatbot-bulle').forEach(function(element) {
        element.addEventListener('click', function() {
            document.querySelector('.chatbot-page').classList.toggle('open');
            document.querySelector('.chatbot-bulle').classList.toggle('up');
            document.querySelector('.message-taping-zone').classList.toggle('on');
        });
    });

    document.querySelector('.chat-header .fa-xmark').addEventListener('click', function() {
        document.querySelector('.chatbot-page').classList.toggle('open');
        document.querySelector('.chatbot-bulle').classList.toggle('up');
        document.querySelector('.message-taping-zone').classList.toggle('on');
    });

    document.querySelector('.send-message').addEventListener('click', function() {
        document.querySelector(".send-message i").classList.add('animation-send');
        setTimeout(function () {
            document.querySelector(".send-message i").classList.remove('animation-send');
        }, 4000);
    });

    document.querySelector('#btnGet').addEventListener('click', function () {
        getUserCountry();
    });
});

/* API CHATBOT */
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire d'évenements du form
    document.querySelector('#chat-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Récupération de l'input du form (keyword)
        var message = document.querySelector('#chat-message').value;
        // console.log(message);
        document.querySelector('#chat-messages').insertAdjacentHTML('beforeend', '<div><strong>' + message + '</strong></div>')
        // S'il y a un message -> Requête
        if (message) {
            // Envoi au serveur
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/chat');
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    // Si un message a été trouvé
                    if (Object.keys(data).length != 0) {
                        // Pour les tests en console
                        console.log(data);
                        console.log(typeof message + ' ' + message);
                        document.querySelector('#chat-messages').insertAdjacentHTML('beforeend', '<div>' + data.name + '</div>')
                        var showProductDiv = document.createElement('div');
                        showProductDiv.classList.add('showProduct');
                        document.querySelector('#chat-messages').appendChild(showProductDiv);
                        if (data.catalogue) {
                            for (let i = 0; i < Object.keys(data.catalogue).length; i++) {
                                var boxProductDiv = document.createElement('div');
                                boxProductDiv.classList.add('boxProduct');
                                boxProductDiv.textContent = data.catalogue[i].name;
                                document.querySelector('.showProduct').appendChild(boxProductDiv);
                            }
                        }
                    } else {
                        //Si aucun message n'a été trouvé
                        document.querySelector('#chat-messages').insertAdjacentHTML('beforeend', '<div>Merci de reformuler votre demande.</div>');
                    }
                } else {
                    console.error('Request failed. Error: ' + xhr.status);
                }
            };
            // Il faut bien envoyer les data formatées en json {keyword: data}
            var jsonMessage = JSON.stringify({ keyword: message });
            xhr.send(jsonMessage);
            // On vide l'input pour la prochaine requête
            document.querySelector('#chat-message').value = '';
        }
    });
});
/*$(function(){// BTN BOT
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

});*/



