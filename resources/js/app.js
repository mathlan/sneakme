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

});
