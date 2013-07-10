<!DOCTYPE html>
<html>
<head>
<?php
// This is just to get a home address that reflects where wordpress is running,
// i.e. http://127.0.0.1:8080/wordpress
$a = split('/wp-content', $_SERVER['REQUEST_URI']);
$home = "http://" . $_SERVER['HTTP_HOST'] . $a[0];
?>
    <!--
        | | |  |   |  |   |   
        | | |  |   |  |   |   
        | | |  |===|  )- -(   
        |_|_|  |___|  |___|   
        \   /   ).(    [_]    
         \-/    \|/     U     
     hjm  '      '            

    Website design and visual identity: OSP (http://osp.constantvzw.org) and Jérôme Degive (http://picapica.be) 
    running thanks to free/libre software such as Gnu/Linux, WordPress, Vim, MySQL and many others.
    -->

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Content-Style-Type" content="text/css" />
        
    <meta name="description" content="L’acsr est un lieu de sensibilisation à la création sonore radiophonique." />
          
    <meta name="keywords" content="Atelier Création Radio Radiophonique Sonore Expérimental Module acsr Bruxelles rencontres concours phonothèque" />
    <meta name="author" content="acsr" />
        
    <meta name="category" content="Atelier, création, production, diffusion, enseignement, radiophonique" />
          
    <meta name="Publisher" content="acsr" />
    <meta name="copyright" content="acsr" />
    <meta name="robots" content="index,follow" />
    <meta name="revisit-after" content="7 days" />
    <meta name="expires" content="never" />
    <meta name="Publisher" content="acsr, Bruxelles, Belgium" />

    <meta name="Identifier-URL" content="<?php echo $home; ?>" />

    <meta name="language" content="fr" />
    <meta name="contactOrganization" content="acsr" />
    <meta name="contactCity" content="Bruxelles" />
    <meta name="contactZip" content="1210" />
    <meta name="geography" content="Bruxelles" />
    <meta name="contactState" content="Belgique" />

    <link rel="schema.dc" href="http://purl.org/dc/elements/1.1/" />
        
    <meta name="dc.title" lang="en" content="acsr" />
    <meta name="dc.description" lang="fr" content="L’acsr est un lieu de sensibilisation à la création sonore radiophonique." />
          
    <meta name="dc.language" content="fr" />
    <meta name="dc.publisher" content="acsr" />
    <meta name="dc.rights" content="2011 tous droits réservés" />
    <meta name="dc.type" content="text" />
    <meta name="dc.format" content="text/html" />

    <meta http-equiv="Content-Script-Type" content="text/javascript"  charset="utf-8"/>



<title>Atelier de Création Sonore Radiophonique - Lecteur</title>

<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $home; ?>/wp-content/themes/acsr/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $home; ?>/wp-content/themes/acsr/UniversElse/stylesheet.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo $home; ?>/wp-content/themes/acsr/style.css" />

<script src="<?php echo $home; ?>/wp-content/themes/acsr/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>

<link rel='stylesheet' id='mediaelementjs-styles-css'  href='<?php echo $home; ?>/wp-content/plugins/media-element-html5-video-and-audio-player/mediaelement/mediaelementplayer.css?ver=3.5.2' type='text/css' media='all' />
<script type='text/javascript' src='<?php echo $home; ?>/wp-content/plugins/media-element-html5-video-and-audio-player/mediaelement/mediaelement-and-player.min.js?ver=2.1.3'></script>

<style>
#header img {
    left: 25%;
}
#audio-artiste,
#audio-annee,
#audio-duree, 
#audio-genre {
    background-color: black;
    color: white;
    padding: 2px 5px;
    display: inline;
}
#audio-title {
    margin: 7px 0;
}

.mejs-container{
    margin: auto;
    background: none !important;
}
.mejs-time-rail {
    background-color: none !important;
    float: none !important;
}
.mejs-container .mejs-controls {
    background: none !important;
}
.mejs-controls .mejs-time-rail .mejs-time-loaded {
    background: #FFAA96 !important;
}
.mejs-controls .mejs-time-rail .mejs-time-current {
    background: none !important;
    left: -4px;
    font-family: "UniversElseRegular", "DejaVu Sans", Helvetica, Arial, Sans-Serif;
}
.mejs-controls div.mejs-time-rail {
    padding-top: 0 !important;
}
.mejs-controls .mejs-time-rail .mejs-time-buffering {
    background: #FFFFC0 !important;
}
.mejs-controls .mejs-time-rail .mejs-time-total {
    margin: 0 !important;
    background: yellow !important;
}

.mejs-time-total, 
.mejs-time-total * {
    height: 2px !important;
    outline: 1px solid black;
}
.mejs-time-float-corner {
    outline: 1px solid #FFAA96 !important;
    width: 0px;
    border: none !important;
    height: 10px !important;
}
.mejs-time-float,
.mejs-time-float-current {
    border: none !important;
    background: #FFFFC0 !important;
    outline: none !important;
}
</style>

<script type="text/javascript" charset="utf-8">
   // Read a page's GET URL variables and return them as an associative array.
   // from http://jquery-howto.blogspot.com/2009/09/get-url-parameters-values-with-jquery.html
   function getUrlVars()
   {
       var vars = [], hash;
       var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
       for(var i = 0; i < hashes.length; i++)
       {
           hash = hashes[i].split('=');
           vars.push(hash[0]);
           vars[hash[0]] = hash[1];
       }
       return vars;
   }

var home;

$(document).ready(function(){
    // Find root uri (useful if deployed in a subdirectory locally):
    home = $("meta[name=Identifier-URL]").attr("content");
    
    var play = true;
    $("img#launcher").hover(
        function(){
            if(!play) {
                $(this).attr("src", home + "/wp-content/themes/acsr/images/play-roll.png");
            } else {
                $(this).attr("src", home + "/wp-content/themes/acsr/images/pause-roll.png");
            }
        }, function(){
            if(!play) {
                $(this).attr("src", home + "/wp-content/themes/acsr/images/play.png");
            } else {
                $(this).attr("src", home + "/wp-content/themes/acsr/images/pause.png");
            }
    });
    $("a.mini-launcher img").hover(
        function(){
            $(this).attr("src", home + "/wp-content/themes/acsr/images/petit-play-roll.png");
        }, function() {
            $(this).attr("src", home + "/wp-content/themes/acsr/images/petit-play.png");
    });
    // Toggle Play/Pause button
    $("img#launcher").click(function(e){
        e.preventDefault();
        if (play) {
           player.pause();
           $(this).attr("src", home + "/wp-content/themes/acsr/images/play.png");
           play = false;
        }
        else {
           $("a#player").css("display", "block");
           player.play();
           $(this).attr("src", home + "/wp-content/themes/acsr/images/pause.png");
           play = true;
        }
    });
    
    
       audio = getUrlVars()["audio"];
       annee = getUrlVars()["annee"];
       artiste = unescape(getUrlVars()["artiste"]);
       duree = getUrlVars()["duree"];
       genre = unescape(getUrlVars()["genre"]);
       title = unescape(getUrlVars()["title"]);
       postID = home + "/?page_id=" + getUrlVars()["postID"];
       $("a#popupplayer").attr("href", audio);
       $("a#popupplayer").attr("title", title);
       $("div#audio-title a").attr("href", postID);
       $("div#audio-title a").html(title);
       $("div#audio-annee").html(annee);
       $("div#audio-artiste").html(artiste);
       $("div#audio-duree").html(duree);
       $("div#audio-genre").html(genre);
       $("title").text("acsr - en lecture: " + title)
       
       $("audio#newplayer").attr("src", audio);
       
    var player = new MediaElementPlayer('#newplayer', {features: ['progress']});
    player.play();
});
</script>

<style type="text/css">
a {
    background-color: yellow; 
    color: black; 
    text-decoration: none;
}
a:hover {
    background-color: black;
    color: white;
}

</style>


</head>

<body style="text-align: center; width: 100%; font-family: 'UniversElseRegular', Deja Vu Sans, Helvetica, Arial, Sans; font-size: 13px; padding-bottom: 18px;">

    <div id="header">
        <?php
         $texturelist='';
          //$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
        // see that you don't forget about the "/" at the end 
         $texture_folder = "images/textures/";

          mt_srand((double)microtime()*1000);

          //use the directory class
         $textures = dir($texture_folder);

          //read all files from the  directory, checks if are images and ads them to a list (see below how to display flash banners)
         while ($file = $textures->read()) {
           if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))
             $texturelist .= "$file ";

         } closedir($textures->handle);

          //put all images into an array
         $texturelist = explode(" ", $texturelist);
         $no = sizeof($texturelist)-2;

         //generate a random number between 0 and the number of images
         $random = mt_rand(0, $no);
         $texture = $texturelist[$random];

        //display image
         echo '<img id="texture" src="'. $home .'/wp-content/themes/acsr/images/textures/' .$texture.'" border=0>';
        ?>
    </div>




    <div id="logo" role="logo">
        <h1><a href='/' target="_blank" style="background: none!important">
            <img id="logo" src="<?php echo $home; ?>/wp-content/themes/acsr/images/logos/acsr_logo-web.png" alt="l'atelier de création sonore radiophonique" border="0" style="margin-bottom: 18px; width: 100px"/>
        </a></h1>
    </div>
    
    <div id="audio-artiste">.</div>
    <div id="audio-title"><em><a href="#" target="_blank">.</a></em></div>
    <div id="audio-annee">.</div>
    <div id="audio-duree">.</div>
    <div id="audio-genre">.</div>
    <div>
        <img id="launcher" style="margin-top: 13px; clear: left;" src="<?php echo $home; ?>/wp-content/themes/acsr/images/pause.png" alt="&#9654;" />
    </div>
    <a id='popupplayer' class='popupplayer' href='#' title='' style="background: none; display: block; height: 17px; width: 100%; padding: 0; margin-top: 5px; margin-left: 0px;"></a>

<audio id="newplayer" style ="display: none;" src="#" width="120" height="22"></audio>


<!-- Piwik -->
<script type="text/javascript">
    var pkBaseURL = (("https:" == document.location.protocol) ? "https://stats.stdin.fr/" : "http://stats.stdin.fr/");
    document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    try {
        var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 8);
        piwikTracker.trackPageView();
        piwikTracker.enableLinkTracking();
    } catch( err ) {}
</script>
<noscript><p><img src="http://stats.stdin.fr/piwik.php?idsite=8" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->
</body>
</html>

