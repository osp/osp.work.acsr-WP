$(document).ready(function(){

    // Show on which page we are:
    $(".nav-menu li a").each(function() {
        if ( $(this).attr('href') == document.location.href ) {
            $(this).addClass("active");
        };
    }); 

    // Rename Language ISO CODE
    $("ul.qtrans_language_chooser .lang-fr a").text("FR");
    $("ul.qtrans_language_chooser .lang-nl a").text("NL");

    // removes black hover on images
    $("img").parent().css("background", "none"); 

    // Random position of background image
    top1 = Math.floor(Math.random() * 200);
    left1 = Math.floor(Math.random() * 600);
    $("img#texture").css({top: top1 + 'px' , left: left1 + 'px'});
    top2 = Math.floor(Math.random() * 100);
    left2 = Math.floor(Math.random() * 600);
    $("img#dessin").css({top: top2 + 'px' , left: left2 + 'px'});

    // Show/Hide Projects
    $("h1.project-title").click(function(e){
        e.preventDefault();
        $(this).next().slideToggle('easeInOutQuint');
    });

    // Show/Hide resources
    $("h1.resource-title").click(function(e){
        e.preventDefault();
        $(this).next().slideToggle('easeInOutQuint');
    });

    // Rollover logo
    //$("img#logo").hover(
        //function(){
            //$(this).attr("src", "/wp-content/themes/acsr/images/logos/acsr-logo-roll.png");
        //}, function(){
            //$(this).attr("src", "/wp-content/themes/acsr/images/logos/acsr-logo.png");
    //});

    // Rollover Play/Pause button
    $("img#launcher").hover(
        function(){
            if(!play) {
                $(this).attr("src", "/wp-content/themes/acsr/images/play-roll.png");
            } else {
                $(this).attr("src", "/wp-content/themes/acsr/images/pause-roll.png");
            }
        }, function(){
            if(!play) {
                $(this).attr("src", "/wp-content/themes/acsr/images/play.png");
            } else {
                $(this).attr("src", "/wp-content/themes/acsr/images/pause.png");
            }
    });
    $("a.mini-launcher img").hover(
        function(){
            $(this).attr("src", "/wp-content/themes/acsr/images/petit-play-roll.png");
        }, function() {
            $(this).attr("src", "/wp-content/themes/acsr/images/petit-play.png");
    });
    
    // Toggle Play/Pause button
    var play = false;
    $("img#launcher").click(function(e){
        e.preventDefault();
        if (play) {
           $f(0).pause();
           $(this).attr("src", "/wp-content/themes/acsr/images/play.png");
           play = false;
        }
        else {
           $("a#player").css("display", "block");
           $f(0).play();
           $(this).attr("src", "/wp-content/themes/acsr/images/pause.png");
           play = true;
        }
    });
    
    // Play audio file from a playlist
    $("a.audio").click(function(e){
        e.preventDefault();
        /*
        var index = $(this).parent().attr('id').replace("clip", "");
        $("div.active").removeClass('active');
        $(this).parent().parent().addClass('active'); // Blackens corresponding div.production-item
        $f(0).stop();
        $f(0).getClip(index);
        $f(0).play();
        play = true;
        $("img#launcher").attr("src", "/wp-content/themes/acsr/images/pause.png");
        $("div#audio-title").text($(this).attr("title"));  
        */
        url = $(this).attr("href");
        title = $(this).attr("title");
        postID = $(this).attr("data-link");
        url = "/wp-content/themes/acsr/player.php?audio=" + url + '&title="' + title + '"&postID=' + postID,'lecteur acsr','height=200,width=150';
        popup = window.open(url);
    });
    
});
