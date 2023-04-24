<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    </head>
    <body>
    <section>
        <div class="chatbot-bulle">
            <i class="fa-solid fa-message"></i>
        </div>
        <div class="chatbot-page">
            <div class="chat-header">
                <h1>SneakMe</h1>
                <i class="fa-solid fa-user"></i>
                <i class="fa-solid fa-bag-shopping"></i>
                <i class="fa-solid fa-xmark"></i>
            </div>
            <section class="chat-container-page">
                <div id="chat-messages"></div>
            </section>
            <form id="chat-form" class="message-taping-zone">
                <input type="text" id="chat-message" placeholder="Tapez votre message">
                <button type="submit" class="send-message"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </section>
    </body>
</html>

<!-- <fieldset>
    <legend>Test API Image de chat</legend>
    <input type="text" id="usernameGet" placeholder="Username">
    <button type="button" id="btnGet">Test</button>
</fieldset>

<form action="chatBot()" method="post">
    <legend>Test API</legend>
    <input name="keyword" type="text" id="usernameGet" placeholder="Username">
    <button type="submit" id="btnGet">Test</button>
</form>

<div class="testapibox">
    <div id="testapi"></div>
</div>  -->

