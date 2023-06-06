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
let shopNumber =0;

function updateChatFeatures() { //? Fonctionnalités à appliquer à chaque réponse du bot
    // Joue un petit son à chaque réponse
    myAudio.play();
    // Repositionnement automatique de la barre de défilement en bas
    let chatContainer = document.getElementById("chat-container");
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

function displayCart() {
    let xhr = new XMLHttpRequest();
    let method = "POST";
    let url = "api/displayCart";
    xhr.open(method, url, true);
    xhr.setRequestHeader("Content-Type", "application/json");
    xhr.onload = function() {
        if (xhr.status >= 200 && xhr.status < 400) {
            let dataCart = JSON.parse(xhr.responseText);

            // Il va y avoir un nouvel affichage donc on incrémente le compteur de réponses
            answerNumber++;

            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">app.js displayCart()</p></div></div>')
            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="panier" class="showCart" data-answer="' + answerNumber + '"></div>');
            // document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="products" class="showProduct"></div>');

            // On affiche chaque produit
            for (let i = 0; i < Object.keys(dataCart.cart).length; i++) {
                console.log(dataCart.cart[i].id);
                let boxCartDiv = document.createElement('div');
                boxCartDiv.classList.add('boxCart');

                // 1er élément du grid (img)
                let boxCart1 = document.createElement('div');
                boxCart1.classList.add('boxCart1');
                boxCartDiv.appendChild(boxCart1);

                // Image du produit
                // Texte
                let img = document.createElement('img');
                img.classList.add('cartImg');
                img.src = "/storage/product/" + dataCart.cart[i].picture;
                boxCart1.appendChild(img);

                // 2ème élément du grid (titre)
                let boxCart2 = document.createElement('div');
                boxCart2.classList.add('boxCart2');
                boxCartDiv.appendChild(boxCart2);

                // Div du nom produit
                let cartName = document.createElement('div');
                cartName.classList.add('cartName');
                boxCart2.appendChild(cartName);

                // Texte (nom)
                let txtName = document.createElement('p');
                txtName.textContent = dataCart.cart[i].name;
                cartName.appendChild(txtName);

                // Div des caractéristiques du produit
                let cartFeat = document.createElement('div');
                cartFeat.classList.add('cartFeat');
                boxCart2.appendChild(cartFeat);

                // Div de la couleur du produit
                let cartColor = document.createElement('div');
                cartColor.classList.add('cartColor');
                cartFeat.appendChild(cartColor);

                // Texte (couleur)
                let txtColor = document.createElement('p');
                txtColor.textContent = dataCart.cart[i].color;
                txtColor.style.color = dataCart.cart[i].color;
                cartColor.appendChild(txtColor);

                // Div de la taille du produit
                let cartSize = document.createElement('div');
                cartSize.classList.add('cartSize');
                cartFeat.appendChild(cartSize);

                // Texte (taille)
                let txtSize = document.createElement('p');
                txtSize.textContent = dataCart.cart[i].size;
                cartSize.appendChild(txtSize);

                // 3ème élément du grid (qté)
                let boxCart3 = document.createElement('div');
                boxCart3.classList.add('boxCart3');
                boxCartDiv.appendChild(boxCart3);

                // 4ème élément du grid (del)
                let boxCart4 = document.createElement('div');
                boxCart4.classList.add('boxCart4');
                boxCartDiv.appendChild(boxCart4);



                // Incrémente les données sur la dernière div showProduct
                document.querySelectorAll('.showCart')[document.querySelectorAll('.showCart').length - 1].appendChild(boxCartDiv);
            }
            console.log(dataCart);
        } else {
            // console.log(xhrNewItem.responseText);
        }
    };
    xhr.send();
}
document.addEventListener('DOMContentLoaded', function() {
    // Gestionnaire d'évènements du form
    document.querySelector('#chat-form').addEventListener('submit', function(event) {
        event.preventDefault();
        // Récupération de l'input du form (keyword)
        let message = document.querySelector('#chat-message').value;

        // S'il y a un message -> Requête
        if (message) {
            // Incrémentation de l'ID réponse (pour nouvelle réponse)
            answerNumber++;
            /*console.log(answerNumber);*/
            // On retourne la demande de l'utilisateur
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="user-side"><div class="user-msg"><p>' + message + '</p></div></div>')
            // Envoi au serveur
            let xhr = new XMLHttpRequest();
            xhr.open('POST', 'api/chat');
            xhr.setRequestHeader('Content-Type', 'application/json');
            xhr.onload = function() {
                if (xhr.status === 200) {
                    let data = JSON.parse(xhr.responseText);
                    // Si un message a été trouvé
                    if (Object.keys(data).length != 0) {
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
                                // img.dataset.img = data.products[i].image; // Nommage de l'élément
                                img.style.cursor = 'pointer'; // Style du curseur

                                //feat Produits du catalogue cliquables (affichés dans une nouvelle bulle)
                                img.onclick= function () {
                                    // On incrémente le numéro de boutique (pour éviter de mettre à jour la première à chaque fois)
                                    shopNumber ++;

                                    //ID du produit
                                    let idProduct = data.products[i].id;

                                    //Couleurs possibles dans les choix de chaussures
                                    let colorOptions = '';
                                    for (let i = 0; i < data.colors.length; i++) {
                                        colorOptions += '<option value=' + data.colors[i] + '>' + data.colors[i] + '</option>';
                                    }

                                    //Tailles possibles dans les choix de chaussures
                                    let sizeOptions = '';
                                    for (let i = 0; i < data.sizes.length; i++) {
                                        sizeOptions += '<option value=' + data.sizes[i] + '>' + data.sizes[i] + '</option>';
                                    }

                                    // Il va y avoir un nouvel affichage donc on incrémente le compteur de réponses
                                    answerNumber++;

                                    // Affichage du produit dans une nouvelle bulle du bot + Possibilité de l'ajouter au panier
                                    document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '' +
                                        '<div class="bot-side">' +
                                        '<div id="chatMsgAdd" class="bot-msg productDiv centered" data-answer="' + answerNumber + '">' +
                                        '<p class="addProductTitle">' + data.products[i].name + '</p>' +
                                        '<img class="addProductImg" src="' + img.src + '">' +
                                        '<div class="addProductDiv">' +
                                        '<p>Couleur </p><select name="color" id="color' + shopNumber + '">' +
                                        colorOptions +
                                        '</select>' +
                                        '</div>' +
                                        '<div class="addProductDiv">' +
                                        '<p>Taille </p><select name="size" id="size' + shopNumber + '">' +
                                        sizeOptions +
                                        '</select>' +
                                        '<p>Quantité</p><input type="number" id="quantity' + shopNumber + '" name="quantity" min="0" max="10"></br>' +
                                        '</div>' +
                                        '</div>' +
                                        '</div>'
                                    );

                                    //feat Ajout au panier JS

                                    //* Stockage des items en variable
                                    let newItem = {};
                                    let size = 0;
                                    let color = "";
                                    let quantity = 0;
                                    function updateNewItem () {
                                        // Incrémentation de l'ID réponse (pour nouvelle réponse)
                                        answerNumber++;
                                        let lastSize = "size" +  shopNumber;
                                        let lastColor = "color" +  shopNumber;
                                        let lastQuantity = "quantity" +  shopNumber;

                                        size = parseInt(document.getElementById(lastSize).value);
                                        color = document.getElementById(lastColor).value;
                                        quantity = parseInt(document.getElementById(lastQuantity).value);
                                        newItem = {'size': size, 'color': color, 'quantity': quantity, 'product_id': idProduct};
                                        let xhrNewItem = new XMLHttpRequest();
                                        let method = "POST";
                                        let url = "api/addNewItem";
                                        // let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                        // xhrNewItem.setRequestHeader('X-CSRF-TOKEN', csrfToken);
                                        xhrNewItem.open(method, url, true);
                                        xhrNewItem.setRequestHeader("Content-Type", "application/json");
                                        xhrNewItem.onload = function() {
                                            if (xhrNewItem.status >= 200 && xhrNewItem.status < 400) {
                                                let data = JSON.parse(xhrNewItem.responseText);
                                                document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">' + data.name + '</p></div></div>')
                                                console.log(data);
                                            } else {
                                                // console.log(xhrNewItem.responseText);
                                            }
                                        };
                                        let jsonData = JSON.stringify(newItem);
                                        xhrNewItem.send(jsonData);
                                        displayCart();
                                        console.log(jsonData);
                                    };

                                    //* Bouton ajout
                                    /*const chatMsgAdd = document.getElementById("chatMsgAdd");*/
                                    const chatMsgAdd = document.querySelector('[data-answer="'+ answerNumber +'"]')
                                    const addBasketBtn = document.createElement("button");
                                    addBasketBtn.textContent = "Ajouter au panier"; // Contenu de la balise texte
                                    addBasketBtn.classList.add("addProductBtn");
                                    addBasketBtn.addEventListener('click', updateNewItem);
                                    chatMsgAdd.appendChild(addBasketBtn);

                                    //* Son "pop" & auto scroll
                                    updateChatFeatures()
                                }
                                // TODO end

                                boxProductDiv.appendChild(img); // Ajout à la div

                                // Ajout du texte
                                let txt = document.createElement('p'); // Création de balise p
                                txt.textContent = data.products[i].name; // Contenu de la balise texte
                                txt.classList.add('textProduct'); // Rajoute une classe
                                boxProductDiv.appendChild(txt); // Ajout à la div

                                // Incrémente les données sur la dernière div showProduct
                                document.querySelectorAll('.showProduct')[document.querySelectorAll('.showProduct').length - 1].appendChild(boxProductDiv);
                            }

                            // Agrandissement de la bulle de chat
                            let botMsg = document.querySelector('.bot-msg');
                            botMsg.style.width = '100%';

                            // Adaptation du grid selon le nombre de résultats
                            let showProduct = document.querySelector('.showProduct');
                            //TODO Taille du grid adaptée au nombre de résultats
                            showProduct.style.gridTemplateRows = 'repeat(' + data.products.length/3 +', 1fr)';
                        }

                        //? CATALOGUE
                        //* Si le json retourne des résultats de catalogue, on affiche le catalogue de marques en front
                        if (data.catalogue) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="categories" class="showProduct" data-answer="' + answerNumber + '"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.catalogue).length; i++) {
                                let boxProductDiv = document.createElement('div');
                                boxProductDiv.classList.add('boxProduct');
                                // Ajout du texte
                                let txt = document.createElement('a'); // Création de balise p
                                txt.textContent = data.catalogue[i].name; // Contenu de la balise texte
                                txt.classList.add('textProduct'); // Rajoute une classe
                                txt.onclick= function () {
                                    // Remplit automatiquement l'input avec le choix cliqué
                                    document.querySelector('#chat-message').value = data.catalogue[i].name;
                                    // Auto-clique pour envoyer l'input
                                    document.querySelector('.send-message').click();
                                }
                                txt.href = "#";
                                txt.dataset.name = data.catalogue[i].name; //Rajoute un data-set avec le nom name
                                boxProductDiv.appendChild(txt); // Ajout à la div
                                // Incrémente les données sur la dernière div showProduct
                                document.querySelectorAll('.showProduct')[document.querySelectorAll('.showProduct').length - 1].appendChild(boxProductDiv);
                            }
                        }
                        updateChatFeatures()
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
