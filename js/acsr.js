var home;

$(document).ready(function(){

    // Find root uri (useful if deployed in a subdirectory locally):
    home = $("meta[name=Identifier-URL]").attr("content");

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

    // Rollover Play button
    $("a.launcher img").hover(
        function(){
            $(this).attr("src", home + "/wp-content/themes/acsr/images/play-roll.png");
        }, function() {
            $(this).attr("src", home + "/wp-content/themes/acsr/images/play.png");
    });
    $("a.mini-launcher img").hover(
        function(){
            $(this).attr("src", home + "/wp-content/themes/acsr/images/petit-play-roll.png");
        }, function() {
            $(this).attr("src", home + "/wp-content/themes/acsr/images/petit-play.png");
    });
    
    
    // Play audio file from a playlist
    $("a.audio").click(function(e){
        e.preventDefault();
        url = $(this).attr("href");
        title = $(this).attr("title");
        postID = $(this).attr("data-link");
        url = home + "/wp-content/themes/acsr/player.php?audio=" + url + '&title=' + title + '&postID=' + postID,'lecteur acsr','height=200,width=150';
        popup = window.open(url);
    });
    
});
