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
        <audio id="song-msg" src="{{ asset('songs/pop.mp3') }}"></audio>
    </head>
    <body>
    <section>
{{--        <?php
        var_dump(\Illuminate\Support\Facades\Auth::id());
        ?>--}}
        <div class="chatbot-reduced">
            <i class="fa-solid fa-message"></i>
        </div>
        <div class="chatbot-page">
            <div class="chat-header">
                <h1>SneakMe</h1>
                <i class="fa-solid fa-user"></i>
                <i class="fa-solid fa-bag-shopping"></i>
                <i class="fa-solid fa-xmark"></i>
            </div>
            <section id="chat-container" class="chat-container-page">
                <div id="chat-messages"></div>
            </section>
            <form id="chat-form" class="message-typing-zone">
                <input type="text" id="chat-message" placeholder="Tapez votre message">
                <button type="submit" class="send-message"><i class="fa-solid fa-paper-plane"></i></button>
            </form>
        </div>
    </section>
    </body>
</html>
