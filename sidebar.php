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
            <a display="block" href="<?php echo home_url(); ?>">
                <img style="margin-top: -14px;" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo_intro.png" alt="l'atelier de création sonore radiophonique" border="0" /></a>
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

            if($audio[0] != ''):
                $get_artists = get_post_meta($post->ID, 'wpcf-artiste', false);
                $artists = "";
                if (!empty($get_artists)):
                    foreach($get_artists as $key => $val) {
                        $artists .= $val;
                    }
                endif;
                $annee = get_post_meta($post->ID, 'wpcf-annee', true);
                $duree = get_post_meta($post->ID, 'wpcf-duree', true);
                $genre = get_post_meta($post->ID, 'wpcf-genre', 'true');
                $audio_title = the_title('', '', false);

                $args = array( "duree" => $duree, "genre" => $genre, "annee" => $annee, "artiste" => $artists );
                $qstring = http_build_query($args);

                $parse = explode(' --- ', $audio[0]);
                if (count($parse)!=1) { // if there are several tracks
                    $url = $parse[1];
                } else { // if there's only one track
                    $url = $parse[0];
                }

                $url = $url . '&' . $qstring;
          ?>

               <div id="le-son-du-mois">le son<br />du mois</div>
               <div id="audio-title">

                    <!-- &nbsp;<?php echo $artists;?>&nbsp; -->
                    <em><a style="background: none;" href="<?php the_permalink(); ?>"><?php echo $audio_title; ?></a></em>
                </div>
                   <?php echo "<a class='audio launcher' href='" . $url . "' data-link='".$post->ID ."' style='text-decoration: none;' title='". urlencode($audio_title) ."'>"; ?>
                   <img id="launcher" style="margin-top: 13px;" src="<?php echo get_template_directory_uri(); ?>/images/play.png" alt="&#9654;" />
               </a>
        <?php
            endif; // if there is a sound
            endwhile; // all the sticky posts
            endif; // if there are sticky posts
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

