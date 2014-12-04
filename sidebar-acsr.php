<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 */
?>
<div id="nav">
    <div id="logo" role="logo">
        <h1>
        <?php if (is_home()): ?>
            <a href="<?php echo home_url(); ?>">
                <img id="logogris" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo-web-roll.png" alt="l'atelier de création sonore radiophonique" border="0" />
                <img style="margin-top: -14px;" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo_intro.png" alt="l'atelier de création sonore radiophonique" border="0" /></a>
        <?php else : ?>
            <a href="<?php echo home_url(); ?>">
                <img id="logogris" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo-web-roll.png" alt="l'atelier de création sonore radiophonique" border="0" />
                <img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo-web.png" alt="l'atelier de création sonore radiophonique" border="0" />
            </a>
        <?php endif;?>
        </h1>
    </div>
    <nav id="menu" class="main-navigation" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
        
        <?php 
            $sticky = get_option( 'sticky_posts' );
            $args = array(
                   'post__in'  => $sticky,
                   'post_type' => 'production'
                    );
            query_posts( $args );
                
            if ( $sticky && have_posts() ) : while ( have_posts() ) : the_post();

            $audio = get_post_meta($post->ID, 'wpcf-audio', false);
            $annee = get_post_meta($post->ID, 'wpcf-annee', false)[0];
            $duree = get_post_meta($post->ID, 'wpcf-duree', false)[0];
            $genre = get_post_meta($post->ID, 'wpcf-genre', false)[0];
                    // if (get_post_meta($post->ID, 'audio', true)):
                    if($audio[0] != ''):
                        //$audio_title = wp_title( '', false, '' );
                        $audio_title = the_title('', '', false);
                        
                        $parse = explode(' --- ', $audio[0]);
                        if (count($parse)!=1) { // if there are several tracks
                            $url = $parse[1];
                        } else { // if there's only one track
                            $url = $parse[0];
                        }
                        $url = $url . "&duree=" . $duree . "&genre=" . $genre . "&annee=" . $annee;
          ?>
        
               <div id="le-son-du-mois">le son<br />du mois</div>
               <div id="audio-title"><em><a style="background: none;" href="<?php the_permalink(); ?>"><?php echo $audio_title; ?></a></em></div>
                   <?php echo "<a class='audio launcher' href='" . $url . "' data-link='".$post->ID ."' style='text-decoration: none;' title='". $audio_title ."'>"; ?>
                   <img id="launcher" style="margin-top: 13px;" src="<?php echo get_template_directory_uri(); ?>/images/play.png" alt="&#9654;" />
               </a>
        <?php
            endif;
            endwhile;
            endif;
        ?>
        
    <!-- Search Form -->
    <?php get_search_form(); ?>
    
  
    </nav><!-- #site-navigation -->

    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
    <div id="secondary" class="widget-area" role="complementary">
        <?php dynamic_sidebar('sidebar-1'); ?>
    </div><!-- #secondary -->
    <?php endif; ?>
</div> <!-- end div#nav -->

