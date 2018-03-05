$(document).ready(function() {
    if (window.location.hash !== "") {
        var location = window.location.hash;
        var iframe = $(location).find("iframe");
        $(location).addClass("open");
        if (iframe.length > 0) {
            var player = new Vimeo.Player(iframe);
            player.play();
        }
    }

    var event = "click";

    $(".c-client .l-grid__item").on(event, function() {
        var iframe = $(this).find("iframe");
        $(this)
            .siblings()
            .removeClass("open");
        $(this).toggleClass("open");
        if ($(this).hasClass("open")) {
            if (iframe.length > 0) {
                var player = new Vimeo.Player(iframe);
                player.play();
            }
        } else {
            if (iframe.length > 0) {
                var player = new Vimeo.Player(iframe);
                player.stop();
            }
        }
    });
});
