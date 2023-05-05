import './bootstrap';

/* SON MESSAGE */
const myAudio = document.querySelector('#song-msg');

/*import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();*/

/* AFFICHAGE DU CHATBOT */

window.addEventListener('DOMContentLoaded', function() {
    // BTN BOT
    document.querySelectorAll('.chatbot-reduced').forEach(function(element) {
        element.addEventListener('click', function() {
            document.querySelector('.chatbot-page').classList.toggle('open');
            document.querySelector('.chatbot-reduced').classList.toggle('up');
            document.querySelector('.message-typing-zone').classList.toggle('on');
        });
    });

    document.querySelector('.chat-header .fa-xmark').addEventListener('click', function() {
        document.querySelector('.chatbot-page').classList.toggle('open');
        document.querySelector('.chatbot-reduced').classList.toggle('up');
        document.querySelector('.message-typing-zone').classList.toggle('on');
    });

    document.querySelector('.send-message').addEventListener('click', function() {
        document.querySelector(".send-message i").classList.add('animation-send');
        setTimeout(function () {
            document.querySelector(".send-message i").classList.remove('animation-send');
        }, 4000);
    });
});



/* API CHATBOT */

// ID de la réponse
let answerNumber = 0;
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire d'évènements du form
    document.querySelector('#chat-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Récupération de l'input du form (keyword)
        var message = document.querySelector('#chat-message').value;

        // S'il y a un message -> Requête
        if (message) {
            // Incrémentation de l'ID réponse (pour nouvelle réponse)
            answerNumber++;
            console.log(answerNumber);
            // On retourne la demande de l'utilisateur
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="user-side"><div class="user-msg"><p>' + message + '</p></div></div>')
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
                        if (data) {
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p>' + data.name + '</p></div></div>')
                        } else {
                            //Si aucun message n'a été trouvé
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg"' + answerNumber + '">Merci de reformuler votre demande.</p></div></div>');
                        }

                        // Si le json retourne une liste de produits on les affiche en front
                        if (data.products.length != 0) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div class="showProduct"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.products).length; i++) {
                                var boxProductDiv = document.createElement('div');
                                boxProductDiv.classList.add('boxProduct');
                                boxProductDiv.textContent = data.products[i].name;
                                // Incrémente les données sur la dernière div showProduct
                                document.querySelectorAll('.showProduct')[document.querySelectorAll('.showProduct').length - 1].appendChild(boxProductDiv);
                            }
                        }

                        // Si le json retourne des résultats de catalogue, on affiche le catalogue de marques en front
                        if (data.catalogue) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div class="showProduct"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.catalogue).length; i++) {
                                var boxProductDiv = document.createElement('div');
                                boxProductDiv.classList.add('boxProduct');
                                boxProductDiv.textContent = data.catalogue[i].name;
                                // Incrémente les données sur la dernière div showProduct
                                document.querySelectorAll('.showProduct')[document.querySelectorAll('.showProduct').length - 1].appendChild(boxProductDiv);
                            }
                        }
                        // Joue un petit son à chaque réponse
                        myAudio.play();
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



