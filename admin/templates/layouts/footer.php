        <?php perch_collection('quotes', [
        'sort' => '_id',
        'sort-order' => 'rand',
            'count' => 1
        ]); ?>
        <div class="bg--neutral--darkest">
            <div class="l-container">
                <footer class="c-footer">
                    <div class="c-footer__copyright">
                        <p>&copy; <?php echo date('y');?> purple door media ltd. registered in england<br />
                        company registration number: 07905574 | vat no: 134 7341 25</p>
                    </div>
                    <div class="c-footer__contact">
                    <p>
                        <a href="mailto:info@purpledoormedia.com">
                            <svg class="icon--email" viewbox="0 0 90 66" style="width: 13px; height: 10">
                                <use xlink:href="#mail"></use>
                            </svg>&nbsp; info@purpledoormedia.com</a><br />
                            <svg class="icon--phone" viewbox="0 0 90 90" style="width: 10px; height: 10px">
                                <use xlink:href="#phone"></use>
                            </svg>&nbsp; 01273 276637<br />
                            <a href="https://vimeo.com/purpledoor" target="_blank">
                            <svg class="icon--vimeo" viewbox="0 0 10 8.667" style="width: 13px; height: 10px">
                                <use xlink:href="#vimeo"></use>
                            </svg>&nbsp; vimeo
                        </a>
                    </p>
                    </div>
                </footer>
            </div>
        </div>

    </div><!--/#page -->
    
    <script src="/dist/js/scripts.min.js?<?php echo time();?>"></script>
    <script>

        document.addEventListener("domcontentloaded", function() { initialisemediaplayer(); }, false);
        var mediaplayers;
        function initialisemediaplayer() {
   mediaplayers = $('.c-video');
   $(mediaplayers).each(function(i, video){
        video.controls = false;
   });
   
//    mediaplayer.controls = false;
}
function toggleplaypause(i) {
   var 
   btn = document.getElementById('Btn'+ i);
   mediaplayer = document.getElementById('Video'+ i);
   mediaplayers = $('.c-video');
   $(mediaplayers).each(function(item, video){
        if($(video)[0].getAttribute('id') !== 'Video'+ i){
            $(video)[0].pause();
        }
   });
   if (mediaplayer.paused || mediaplayer.ended) {
      btn.title = 'pause';
      btn.innerHTML = '<i class="la la-pause"></i>';
      btn.classname = 'pause';
      mediaplayer.play();
   }
   else {
      btn.title = 'play';
      btn.innerHTML = '<i class="la la-play"></i>';
      btn.classname = 'play';
      mediaplayer.pause();
   }
}

function toggleaudio(i) {
   var 
   btn = document.getElementById('MuteBtn'+ i);
   mediaplayer = document.getElementById('Video'+ i);
   if (mediaplayer.muted) {
      btn.title = 'mute';
      btn.innerHTML = '<i class="la la-volume-off"></i>';
      btn.classname = 'mute';
      mediaplayer.muted = false;
   }
   else {
      btn.title = 'unmute';
      btn.innerHTML = '<i class="la la-volume-up"></i>';
      btn.classname = 'unmute';
      mediaplayer.muted = true;
   }
}

function goFullScreen(i){
    var 
   btn = document.getElementById('FullScreenBtn'+ i);
   mediaplayer = document.getElementById('Video'+ i);
   if (mediaplayer.requestFullscreen) {
    mediaplayer.requestFullscreen();
    } else if (mediaplayer.msRequestFullscreen) {
    mediaplayer.msRequestFullscreen();
    } else if (mediaplayer.mozRequestFullScreen) {
    mediaplayer.mozRequestFullScreen();
    } else if (mediaplayer.webkitRequestFullscreen) {
    mediaplayer.webkitRequestFullscreen();
    }
}

</script>
</body>
</html>
