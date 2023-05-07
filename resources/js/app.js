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
            /*console.log(answerNumber);*/
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
                        /*console.log(data);*/
                        /*console.log(typeof message + ' ' + message);*/
                        if (data) {
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">' + data.name + '</p></div></div>')
                        } else {
                            //Si aucun message n'a été trouvé
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg"' + answerNumber + '"><p class="bot-answer">Merci de reformuler votre demande.</p></div></div>');
                        }

                        //? PRODUITS
                        //* Si le json retourne une liste de produits on les affiche en front
                        if (data.products.length != 0) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="products" class="showProduct"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.products).length; i++) {
                                let boxProductDiv = document.createElement('div'); // Rajoute une div
                                boxProductDiv.classList.add('boxProduct'); // Rajoute une classe
/*                                boxProductDiv.textContent = data.products[i].name;*/

                                // Ajouter une image
                                let img = document.createElement('img'); // Création de l'image
                                img.src = "/storage/product/" + data.products[i].image; // Définition de la source de l'image
                                boxProductDiv.appendChild(img); // Ajout à la div

                                // Ajout du texte
                                let txt = document.createElement('p'); // Création de balise p
                                txt.textContent = data.products[i].name; // Contenu de la balise texte
                                txt.classList.add('textProduct'); // Rajoute une classe
                                boxProductDiv.appendChild(txt); // Ajout à la div

                                // Agrandissement de la bulle de chat
                                let botMsg = document.querySelector('.bot-msg');
                                botMsg.style.width = '100%';

                                // Adaptation du grid selon le nombre de résultats
                                let showProduct = document.querySelector('.showProduct');
                                showProduct.style.gridTemplateRows = 'repeat(' + (data.products.length/3) +', 1fr)';

                                // Incrémente les données sur la dernière div showProduct
                                document.querySelectorAll('.showProduct')[document.querySelectorAll('.showProduct').length - 1].appendChild(boxProductDiv);
                            }
                        }

                        /*<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/25/Chat_roux_%C3%A0_pelage_court..jpg/240px-Chat_roux_%C3%A0_pelage_court..jpg">*/

                        //? CATALOGUE
                        //* Si le json retourne des résultats de catalogue, on affiche le catalogue de marques en front
                        if (data.catalogue) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="categories" class="showProduct"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.catalogue).length; i++) {
                                let boxProductDiv = document.createElement('div');
                                boxProductDiv.classList.add('boxProduct');
                                // Ajout du texte
                                let txt = document.createElement('a'); // Création de balise p
                                txt.textContent = data.catalogue[i].name; // Contenu de la balise texte
                                txt.classList.add('textProduct'); // Rajoute une classe
                                txt.href = "#";
                                txt.dataset.name = data.catalogue[i].name; //Rajoute un data-set avec le nom name
                                boxProductDiv.appendChild(txt); // Ajout à la div
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
            let jsonMessage = JSON.stringify({ keyword: message });
            xhr.send(jsonMessage);
            // On vide l'input pour la prochaine requête
            document.querySelector('#chat-message').value = '';
        }
    });
});

/*
document.addEventListener('DOMContentLoaded', function() {
    let categories = document.querySelector('#categories');
    if (categories) {
        categories.addEventListener('click', function(event) {
            event.preventDefault();
            console.log("Ok");
        });
    } else {console.log("Nok");}
});
*/
