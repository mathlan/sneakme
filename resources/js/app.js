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


let accessToken = localStorage.getItem('userToken');

//! CONNEXION
// Message de connexion au clic sur l'icône
const userIcon = document.querySelector('.fa-user');
userIcon.onclick= function () {
    //* Incrémentation de l'ID réponse (pour nouvelle réponse)
    answerNumber++;

    const connectElement = document.createElement('div');
    connectElement.className = 'bot-side';
    connectElement.innerHTML = `
         <div id="chatMsgConnect" class="bot-msg productDiv centered" data-answer="${answerNumber}" style="min-width: 100%;">
             <p class="addProductTitle">Connexion</p></br>
             <div class="connectDiv">
                 <p class="productLabel">Email: </p>
                 <input type="email" id="email" name="email"></br>
                 <p class="productLabel">Mot de passe: </p>
                 <input type="password" id="password" name="password"></br>
             </div>
         </div>`;

    // On ajoute l'élément au conteneur
    const chatMessagesContainer = document.querySelector("#chat-messages");
    chatMessagesContainer.appendChild(connectElement);

    //* Bouton ajout
    const connectBtn = document.createElement("button");
    connectBtn.textContent = "Valider"; // Contenu de la balise texte
    connectBtn.classList.add("addProductBtn");
    // On récupère l'id de la bulle "produit" générée pour que quand l'utilisateur commande cela se fasse bien depuis la bonne div
    connectBtn.addEventListener('click', function() {
        connectUser();
    });
    chatMsgConnect.appendChild(connectBtn);

    //* Son "pop" & auto scroll
    updateChatFeatures()
}

function connectUser() {
    //* Incrémentation de l'ID réponse (pour nouvelle réponse)
    answerNumber++;

    let email = document.getElementById("email").value;
    let password = document.getElementById("password").value;
    let newCo = { 'email': email, 'password': password };

    let method = "POST";
    let url = "api/connectUser";

/*    let jsonToken = localStorage.getItem('userToken');
    let userToken = JSON.parse(jsonToken);
    let accessToken = userToken.token;*/

    fetch(url, {
        method: method,
        headers: {
            "Authorization": "Bearer " + accessToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(newCo)
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error: ' + response.status);
            }
        })
        .then(data => {
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">' + data.answer + '</p></div></div>');
            if (data.auth == true) {
                localStorage.setItem('userToken', data.api_token);
            }
        })
        .catch(error => {
            console.log(error);
        });

    // Affichage du panier dans une nouvelle bulle (voir: fonction)
    // displayCart();
    updateChatFeatures();
}

//! CHATBOT
function updateChatFeatures() { //? Fonctionnalités à appliquer à chaque réponse du bot
    // Joue un petit son à chaque réponse
    myAudio.play();
    // Repositionnement automatique de la barre de défilement en bas
    let chatContainer = document.getElementById("chat-container");
    chatContainer.scrollTop = chatContainer.scrollHeight;
}

//? AFFICHAGE PANIER
function displayCart() {
    let method = "POST";
    let url = "api/displayCart";

    fetch(url, {
        method: method,
        headers: {
            "Authorization": "Bearer " + accessToken,
            "Content-Type": "application/json"
        }
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error: ' + response.status);
            }
        })
        .then(dataCart => {
            // Il va y avoir un nouvel affichage donc on incrémente le compteur de réponses
            answerNumber++;

            console.log(dataCart);

            // Nouveau message
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '" style="min-width: 100%;"><p class="addProductTitle" style="text-align: center">Mon panier</p></div></div>')
            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="panier" class="showCart" data-answer="' + answerNumber + '"></div>');

            if (dataCart.cart.length != 0) {
                // On affiche chaque produit
                for (let i = 0; i < Object.keys(dataCart.cart).length; i++) {
                    let boxCartDiv = document.createElement('div');
                    boxCartDiv.setAttribute('box-id', dataCart.cart[i].id.toString());
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

                    // Texte (quantité)
                    let txtQty = document.createElement('p');
                    txtQty.textContent = "Qté: " + dataCart.cart[i].quantity;
                    boxCart3.appendChild(txtQty);

                    // 4ème élément du grid (del)
                    let boxCart4 = document.createElement('div');
                    boxCart4.classList.add('boxCart4');
                    boxCartDiv.appendChild(boxCart4);

                    // Bouton (supprimer)
                    let deleteCartItem = document.createElement('p');
                    let xMarkIcon = document.createElement('i');
                    xMarkIcon.className = "fa-solid fa-xmark";
                    xMarkIcon.style.cursor = 'pointer';
                    xMarkIcon.setAttribute('data-value', dataCart.cart[i].id.toString());
                    xMarkIcon.addEventListener('click', function () {
                        deleteItem(parseInt(this.getAttribute('data-value'))); // Pass the button value as an argument
                    });
                    deleteCartItem.appendChild(xMarkIcon);
                    boxCart4.appendChild(deleteCartItem);

                    // Incrémente les données sur la dernière div showProduct
                    document.querySelectorAll('.showCart')[document.querySelectorAll('.showCart').length - 1].appendChild(boxCartDiv);
                }
            } else {
                let txtNoCart = document.createElement('p');
                txtNoCart.textContent = "Vous n'avez pas d'article";
                txtNoCart.style.textAlign = "center";
                document.querySelectorAll('.showCart')[document.querySelectorAll('.showCart').length - 1].appendChild(txtNoCart);
            }
        })
        .catch(error => {
            console.log(error);
        });
}
//? COMMANDE
function orderCart(choice) {
    let method = "POST";
    let url = "api/orderCart";
    let choiceObj = { 'choice': choice };

    fetch(url, {
        method: method,
        headers: {
            "Authorization": "Bearer " + accessToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(choiceObj)
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error: ' + response.status);
            }
        })
        .then(data => {
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '" style="min-width: 100%;"><p style=" margin: 15px;">' + data.name + '</p></div></div>')
        })
        .catch(error => {
            console.log(error);
        });
}

//? SUPPRESSION D'ARTICLE
function deleteItem(itemID) {
    let itemToDelete = { 'id': itemID };

    let method = "POST";
    let url = "api/deleteItem";
    // let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    // headers['X-CSRF-TOKEN'] = csrfToken;

    fetch(url, {
        method: method,
        headers: {
            "Authorization": "Bearer " + accessToken,
            "Content-Type": "application/json"
        },
        body: JSON.stringify(itemToDelete)
    })
        .then(response => {
            if (response.ok) {
                return response.json();
            } else {
                throw new Error('Error: ' + response.status);
            }
        })
        .then(data => {
            document.querySelector('[box-id="' + itemID + '"]').style.display = "none";
        })
        .catch(error => {
            console.log(error);
        });

    // Affichage du panier dans une nouvelle bulle (voir: fonction)
    // displayCart();
    updateChatFeatures();
}

//? RÉPONSE CHATBOT
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
            // On retourne la demande de l'utilisateur
            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="user-side"><div class="user-msg"><p>' + message + '</p></div></div>');
            // Envoi au serveur
            fetch('api/chat', {
                method: 'POST',
                headers: {
                    "Authorization": "Bearer " + accessToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ keyword: message })
            })
                .then(response => {
                    if (response.status === 200) {
                        return response.json();
                    } else {
                        throw new Error('Request failed. Error: ' + response.status);
                    }
                })
                .then(data => {
                    // Si un message a été trouvé
                    if (Object.keys(data).length !== 0) {
                        if (data) {
                            console.log(data);
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">' + data.name + '</p></div></div>');
                        } else {
                            // Si aucun message n'a été trouvé
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">Merci de reformuler votre demande.</p></div></div>');
                        }

                        //? PRODUITS
                        //* Si le json retourne une liste de produits on les affiche en front
                        if (data.products.length != 0) {
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="products" class="showProduct"></div>');
                            // On affiche chaque produit
                            for (let i = 0; i < Object.keys(data.products).length; i++) {
                                let boxProductDiv = document.createElement('div'); // Rajoute une div
                                boxProductDiv.classList.add('boxProduct'); // Rajoute une classe

                                // Ajouter une image
                                let img = document.createElement('img'); // Création de l'image
                                img.src = "/storage/product/" + data.products[i].image; // Définition de la source de l'image

                                img.style.cursor = 'pointer'; // Style du curseur

                                //? Nouvelle bulle "produit" avec son propre ID
                                //feat Produits du catalogue cliquables (affichés dans une nouvelle bulle)
                                img.onclick= function () {
                                    //* Il va y avoir un nouvel affichage donc on incrémente le compteur de réponses
                                    answerNumber++;
                                    //* On incrémente le numéro de produit affiché (pour éviter de mettre à jour le premier à chaque fois)
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

                                    //? Actualisation quantité x prix
                                    let priceQty = [];
                                    priceQty[shopNumber] = data.products[i].price;

                                    //? Affichage du produit dans une nouvelle bulle du bot + Possibilité de l'ajouter au panier
                                    const productElement = document.createElement('div');
                                    productElement.className = 'bot-side';
                                    productElement.innerHTML = `
                                        <div id="chatMsgAdd" class="bot-msg productDiv centered" data-answer="${answerNumber}" data-shop="${shopNumber}">
                                            <p class="addProductTitle">${data.products[i].name}</p>
                                            <img class="addProductImg" src="${img.src}">
                                            <div class="addProductDiv">
                                                <p class="productLabel">Couleur </p>
                                                <select name="color" id="color${shopNumber}">
                                                ${colorOptions}
                                                </select>
                                                <p class="productLabel">Taille </p>
                                                <select name="size" id="size${shopNumber}">
                                                ${sizeOptions}
                                                </select>
                                            </div>
                                            <div class="addProductDiv">
                                                <p class="productLabel">Quantité</p>
                                                <input type="number" id="quantity${shopNumber}" name="quantity" min="0" max="10">
                                                <p class="productLabel">Prix:</p>
                                                <p class="priceLabel" id="priceLabel${shopNumber}">${priceQty[shopNumber]}€</p>
                                            </div>
                                        </div>`;

                                    // On ajoute l'élément au conteneur
                                    const chatMessagesContainer = document.querySelector("#chat-messages");
                                    chatMessagesContainer.appendChild(productElement);

                                    // On récupère la quantité
                                    const quantityInput = document.getElementById(`quantity${shopNumber}`);
                                    quantityInput.addEventListener('input', () => {
                                        updatePrice(shopNumber);
                                    });

                                    function updatePrice(shopNumber) {
                                        const quantityInput = document.getElementById(`quantity${shopNumber}`);
                                        const priceLabel = document.getElementById(`priceLabel${shopNumber}`);

                                        const quantity = parseInt(quantityInput.value);
                                        const price = priceQty[shopNumber];

                                        if (!isNaN(quantity)) {
                                            const totalPrice = quantity * price;
                                            priceLabel.textContent = `${totalPrice}€`;
                                        }
                                    }

                                    //? Ajout de l'article au panier
                                    //* Stockage des items en variable
                                    let newItem = {};
                                    let size = 0;
                                    let color = "";
                                    let quantity = 0;
                                    function updateNewItem(shopID) {
                                        //* Incrémentation de l'ID réponse (pour nouvelle réponse)
                                        answerNumber++;

                                        let lastSize = "size" + shopID;
                                        let lastColor = "color" + shopID;
                                        let lastQuantity = "quantity" + shopID;

                                        size = parseInt(document.getElementById(lastSize).value);
                                        color = document.getElementById(lastColor).value;
                                        quantity = parseInt(document.getElementById(lastQuantity).value);
                                        newItem = { 'size': size, 'color': color, 'quantity': quantity, 'product_id': idProduct };

                                        let method = "POST";
                                        let url = "api/addNewItem";
                                        // let csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                                        // headers['X-CSRF-TOKEN'] = csrfToken;

                                        fetch(url, {
                                            method: method,
                                            headers: {
                                                "Authorization": "Bearer " + accessToken,
                                                "Content-Type": "application/json"
                                            },
                                            body: JSON.stringify(newItem)
                                        })
                                            .then(response => {
                                                if (response.ok) {
                                                    return response.json();
                                                } else {
                                                    throw new Error('Error: ' + response.status);
                                                }
                                            })
                                            .then(data => {
                                                document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '"><p class="bot-answer">' + data.name + '</p></div></div>');
                                            })
                                            .catch(error => {
                                                console.log(error);
                                            });

                                        // Affichage du panier dans une nouvelle bulle (voir: fonction)
                                        // displayCart();
                                        updateChatFeatures();
                                    }

                                    //* Bouton ajout
                                    const chatMsgAdd = document.querySelector('[data-answer="'+ answerNumber +'"]')
                                    const addBasketBtn = document.createElement("button");
                                    addBasketBtn.textContent = "Ajouter au panier"; // Contenu de la balise texte
                                    addBasketBtn.classList.add("addProductBtn");
                                    addBasketBtn.value = shopNumber.toString();
                                    // On récupère l'id de la bulle "produit" générée pour que quand l'utilisateur commande cela se fasse bien depuis la bonne div
                                    addBasketBtn.addEventListener('click', function() {
                                        updateNewItem(parseInt(this.value)); // Pass the button value as an argument
                                    });
                                    chatMsgAdd.appendChild(addBasketBtn);

                                    //* Son "pop" & auto scroll
                                    updateChatFeatures()
                                }

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
                            //? Taille du grid adaptée au nombre de résultats
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
                        //? PANIER (6 = "Voici votre panier")
                        if (data.id == 6) {
                            //? Affichage du panier dans une nouvelle bulle (voir: fonction)
                            displayCart();
                            updateChatFeatures()
                        }

                        //? COMMANDE (10 = "Souhaitez vous finaliser votre commande ?")
                        if (data.id == 10) {
                            // Il va y avoir un nouvel affichage donc on incrémente le compteur de réponses
                            answerNumber++;

                            // Nouveau message
                            document.querySelector("#chat-messages").insertAdjacentHTML('beforeend', '<div class="bot-side"><div class="bot-msg" data-answer="' + answerNumber + '" style="min-width: 100%;"></div></div>')
                            document.querySelector('[data-answer="' + answerNumber + '"]').insertAdjacentHTML('beforeend', '<div id="orderCart" class="orderCart" data-answer="' + answerNumber + '"></div>');

                            /*            let boxCartDiv = document.createElement('div');
                                        boxCartDiv.setAttribute('box-id', dataCart.cart[i].id.toString());
                                        boxCartDiv.classList.add('boxCart');*/

                            // Nouvelle div
                            let orderChoice = document.createElement('div');
                            orderChoice.classList.add('orderChoice');

                            // Bouton (yes)
                            let checkIcon = document.createElement('i');
                            checkIcon.className = "fa-solid fa-check fa-order fa-order-check";
                            checkIcon.style.cursor = 'pointer';
                            checkIcon.setAttribute('data-value', "true");
                            checkIcon.addEventListener('click', function () {
                                orderCart("yes");
                            });

                            // Bouton (no)
                            let cancelIcon = document.createElement('i');
                            cancelIcon.className = "fa-solid fa-xmark fa-order fa-order-cancel";
                            cancelIcon.style.cursor = 'pointer';
                            cancelIcon.setAttribute('data-value', "true");
                            cancelIcon.addEventListener('click', function () {
                                orderCart("no");
                            });

                            orderChoice.appendChild(checkIcon);
                            orderChoice.appendChild(cancelIcon);

                            // Incrémente les données sur la dernière div showProduct
                            document.querySelectorAll('.orderCart')[document.querySelectorAll('.orderCart').length - 1].appendChild(orderChoice);
                        }
                        updateChatFeatures()
                    }
                })
                .catch(error => {
                    console.error('Request failed. Error: ' + error);
                });
            // On vide l'input pour la prochaine requête
            document.querySelector('#chat-message').value = '';
        }
    });
});

/* FEATURES
* --> Chaque réponse est incrémentée
* --> Un client peut commander depuis n'importe quelle bulle "produit"
* --> Il y a un son pour chaque bulle et l'auto-scroll
* --> Le grid des produits est variable selon le nombre de produits à afficher
* --> La panier est affichable à volonté avec sa fonction */
