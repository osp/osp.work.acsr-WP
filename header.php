<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 */
?><!DOCTYPE html>


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


<!--[if IE 7]>
<html class="ie ie7" <?php language_attributes(); ?>>
<![endif]-->
<!--[if IE 8]>
<html class="ie ie8" <?php language_attributes(); ?>>
<![endif]-->
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width" />

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

    <meta name="Identifier-URL" content="<?php echo get_home_url(); ?>" />

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

    <meta http-equiv="Content-Script-Type" content="text/javascript" />



<title><?php
    /*
     * Print the <title> tag based on what is being viewed.
     */
    global $page, $paged;

    // Add the blog name.
    bloginfo( 'name' );

    wp_title( '|', true, 'left' );

    // Add a page number if necessary:
    if ( $paged >= 2 || $page >= 2 )
        echo ' | ' . sprintf( __( 'Page %s', 'acsr' ), max( $paged, $page ) );

    ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/reset.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/UniversElse/stylesheet.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/style.css" />
<link rel="stylesheet" type="text/css" media="screen and (max-height: 600px)" href="<?php echo get_template_directory_uri(); ?>/netbook.css" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />

<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-1.10.1.min.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery-ui-1.7.2.custom.min.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo get_template_directory_uri(); ?>/js/acsr.js" type="text/javascript" charset="utf-8"></script>


<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<![endif]-->
<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>



<div id="wrapper" class="hfeed">
    <div id="header">
        <?php
         $texturelist='';
          //$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
        // see that you don't forget about the "/" at the end 
         $texture_folder = "wp-content/themes/acsr/images/textures/";

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
         echo '<img id="texture" src="'. get_template_directory_uri().'/images/textures/' .$texture.'" border=0>';




          $dessinlist='';
          //$img_folder is the variable that holds the path to the banner images. Mine is images/tutorials/
        // see that you don't forget about the "/" at the end 
         $dessin_folder = "wp-content/themes/acsr/images/dessins/";

          mt_srand((double)microtime()*1000);

          //use the directory class
         $dessins = dir($dessin_folder);

          //read all files from the  directory, checks if are images and ads them to a list (see below how to display flash banners)
         while ($file = $dessins->read()) {
           if (eregi("gif", $file) || eregi("jpg", $file) || eregi("png", $file))
             $dessinlist .= "$file ";

         } closedir($dessins->handle);

          //put all images into an array
         $dessinlist = explode(" ", $dessinlist);
         $no = sizeof($dessinlist)-2;

         //generate a random number between 0 and the number of images
         $random = mt_rand(0, $no);
         $dessin = $dessinlist[$random];

        //display image
         echo '<img id="dessin" src="'. get_template_directory_uri() .'/images/dessins/'.$dessin.'" border=0>';
         ?>

    </div>


    <div id="main">

<div id="container">
    <div id="primary" class="site-content">
        <div id="content" role="main">
