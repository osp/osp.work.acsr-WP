<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Twelve already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

<?php
$page = (get_query_var('paged')) ? get_query_var('paged') : 1;

/* HOW TO SORT */

// These are the default options
// correspond to url /production/
$nposts = 12;
if ($_GET['format'] == 'listing') {
    $nposts = 24;
}
$args = array(  'posts_per_page' => $nposts,
                'paged' => $page,
                'post_type' => 'production',
                'orderby' => 'meta_value_num',
                'meta_key' => 'ID wpcf-annee',
                'order' => 'DESC');

/*  We allow to specify a different order through the url, i.e.
 *
 *  /production/?order=ASC
 */

if (array_key_exists('order', $_GET))  {
    $args['order'] = $_GET['order'];
}

/*  We also allow to specify a different column to order by,
 *  and in case of ordering by a meta value, which one:
 *
 *  /production/?orderby=title
 *  /production/?orderby=title&order=ASC
 *  /production/?orderby=meta_value&meta_key=wpcf-genre&order=ASC
 *
 */

if ( array_key_exists('orderby', $_GET) )  {
    $args['orderby'] = $_GET['orderby'];
    if ( $_GET['orderby'] == 'meta_value' && array_key_exists('meta_key', $_GET))  {
        $args['meta_key'] = $_GET['meta_key'];
    }
}

if ($args['orderby'] != 'meta_value') {
    unset( $args['meta_key'] );
}

query_posts($args);


/* HOW TO DISPLAY */

$format = 'detail';

if ( array_key_exists('format', $_GET) )  {
    $format = $_GET['format'];
}
function get_the_production_uri($args=array()) {
    global $format;
    global $page;
    $folder = '';

    if ( !get_option( "permalink_structure" ) ) {
        // uri starts with /?post_type=production&page=n&
        $args = array('post_type' => 'production') + $args;
        if ($page > 1) {
            $args = array('paged' => $page) + $args;
        }
    } else {
        // uri starts with /production/page/n/
        $folder = 'production/';
        if ($page > 1) {
            $folder .= 'page/' . $page . '/';
        }


    }
    if (!array_key_exists('format', $args))  {
        $args['format'] = $format;
    }
    $qstring = http_build_query($args);
    if ($qstring) {
        $qstring = '?' . $qstring;
    }

    return get_home_url() . '/' . $folder . $qstring;
}

function get_the__uri_that_switches_views() {
    global $format;
    $args = array();
    if (array_key_exists('order', $_GET))  {
        $args['order'] = $_GET['order'];
    }
    if (array_key_exists('paged', $_GET))  {
        $args['paged'] = $_GET['paged'];
    }
    if ( array_key_exists('orderby', $_GET) )  {
        $args['orderby'] = $_GET['orderby'];
        if ( $_GET['orderby'] == 'meta_value' && array_key_exists('meta_key', $_GET))  {
            $args['meta_key'] = $_GET['meta_key'];
        }
    }
    if ($format=='detail') {
        $args['format'] = 'listing';
    } elseif ($format=='listing') {
        $args['format'] = 'detail';
    }
    return get_the_production_uri($args);
}

?>
    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>

<article class="post">
            <header class="archive-header">
                <h1 class="productions-achevees"><?php
                    if ( is_day() ) :
                        printf( __( 'Daily Archives: %s', 'acsr' ), '<span>' . get_the_date() . '</span>' );
                    elseif ( is_month() ) :
                        printf( __( 'Monthly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'acsr' ) ) . '</span>' );
                    elseif ( is_year() ) :
                        printf( __( 'Yearly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'acsr' ) ) . '</span>' );
                    else :
                        _e( 'Productions achevées', 'acsr' );?>

                    <?php endif;
                ?></h1>

            </header><!-- .archive-header -->

    <ul id="resort">
        <li><a href="<?php echo get_the_production_uri(); ?>" <?php if ($args['meta_key'] == 'wpcf-annee') { echo "class='active'";} ?>>par année</a></li>
        <li><a href="<?php echo get_the_production_uri(array('orderby' => 'title', 'order' => 'ASC')) ?>" <?php if ($args['orderby'] == 'title') { echo "class='active'";} ?>>titre</a></li>
        <li><a href="<?php echo get_the_production_uri(array('orderby' => 'meta_value', 'meta_key' => 'wpcf-genre', 'order' => 'ASC')) ?>" <?php if ($args['meta_key'] == 'wpcf-genre') { echo "class='active'";} ?>>genre</a></li>

  <!-- <li><a href="<?php echo get_the_production_uri(array('orderby' => 'meta_value', 'meta_key' => 'wpcf-thematiques', 'order' => 'ASC')) ?>" <?php if ($args['meta_key'] == 'wpcf-thematiques') { echo "class='active'";} ?>>thematiques</a></li>-->


<!--<li>
 <?php the_widget( "WP_Widget_Thematique"); ?>
</li>-->





        <li><a href="<?php echo get_the_production_uri(array('orderby' => 'meta_value', 'meta_key' => 'wpcf-artiste', 'order' => 'ASC')) ?>" <?php if ($args['meta_key'] == 'wpcf-artiste') { echo "class='active'";} ?>>artiste</a></li>


        <?php if ($_GET['format'] == "listing"): ?>
        <li><a href="<?php echo get_the__uri_that_switches_views() ?>">vue pastilles</a></li>
        <?php else: ?>
        <li><a href="<?php echo get_the__uri_that_switches_views() ?>">vue liste</a></li>
        <?php endif; ?>
    </ul>

<?php $args = array(
    'show_option_all'    => 'ou sélectionner une thématique  &nbsp;&nbsp;&nbsp;  &rarr;',
    'show_option_none'   => '',
    'orderby'            => 'ID',
    'order'              => 'ASC',
    'show_count'         => 0,
    'hide_empty'         => 1,
    'child_of'           => 0,
    'exclude_tree'         => '20',
    'exclude'          => '1',
    'echo'               => 1,
    'selected'           => 0,
    'hierarchical'       => 0,
    'name'               => 'cat',
    'id'                 => '',
    'class'              => 'postform',
    'depth'              => 0,
    'tab_index'          => 0,
    'taxonomy'           => 'category',
    'hide_if_empty'      => false,
); ?>



<div id="thematiques">
    <?php wp_dropdown_categories($args ); ?>

<script type="text/javascript"><!--
    var dropdown = document.getElementById("cat");
    function onCatChange() {
        if ( dropdown.options[dropdown.selectedIndex].value > 0 ) {
            location.href = "<?php echo get_option('home');
?>/?cat="+dropdown.options[dropdown.selectedIndex].value;
        }
    }
    dropdown.onchange = onCatChange;
--></script>
</div>

<div id="prod-finies" class="<?php echo $_GET['format']; ?>">



            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                /* Include the post format-specific template for the content. If you want to
                 * this in a child theme then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
           ?>
<div id='post<?php echo $i; ?>' class="production-item">
<div class="artiste-title">
                    <?php
                    $artists = get_post_meta($post->ID, 'wpcf-artiste', false);
                    if (!empty($artists)):
                        echo "<ul class='artist'>";
                        foreach($artists as $key => $val) {
                            echo "<li><a href='/?s=". str_replace(" ", "+", $val)  ."'>" . $val . "</a></li>";
                        }
                        echo "</ul>";
                    endif;
                    ?>
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
</div>

                    <?php

                    $audio = get_post_meta($post->ID, 'wpcf-audio', false);
                    echo "<div class='clip' id='clip". $i . "'>";
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
                        if(qtrans_getLanguage()=='fr') {
                            $genre = get_post_meta($post->ID, 'wpcf-genre', 'true');
                        } elseif(qtrans_getLanguage()=='nl'){
                            $genre = get_post_meta($post->ID, 'wpcf-genre-nl', 'true');
                        }

            //$thematiques = get_post_meta($post->ID, 'wpcf-thematiques', false);


$get_thematiques  = get_post_meta($post->ID, 'wpcf-thematiques', false);
                        $thematiques = "";
                        if (($get_thematiques)!=''):
                            foreach($get_thematiques as $keyb => $valb) {
                                $thematiques .= $valb;
                            }
                        endif;




                        $audio_title = the_title('', '', false);

                        $parse = explode(' --- ', $audio[0]);
                        if (count($parse)!=1) { // if there are several tracks
                            $url = $parse[1];
                        } else { // if there's only one track
                            $url = $parse[0];
                        }

                        $args = array( "duree" => $duree, "genre" => $genre, "thematiques" => $thematiques, "annee" => $annee, "artiste" => $artists );
                        $url = $url . '&' . http_build_query($args);

                        echo "<a class='audio mini-launcher' href='" . $url . "' data-link='".$post->ID ."' style='text-decoration: none;' title='". urlencode($audio_title) ."'>";
                        echo "<img src='" . get_template_directory_uri() . "/images/petit-play.png' alt='&#9654;' />";
                        echo "</a>";
                    endif;
                        echo "</div>";
                    $i++;
?>
<div class="details">
<?php
                    if ($genre) {
                        echo '<p class="genre">' . $genre . "</p>";
                    }
            //if ($thematiques) {
                        // foreach($thematiques as $th){
                         //   echo "<p class='thematiques'> " .  $th  . "</p>";
                        //};
                   // }
// DANS LA PAGE PRODUCTION CACHE LES THEMATIQUES

//$get_thematiques = get_post_meta($post->ID, 'wpcf-thematiques', true);

//        if (($get_thematiques)!=' '):
//            foreach($get_thematiques as $keyc => $valc) {
//                $thematiques = $valc;
//echo "<p class='thematiques'> - " . $thematiques . "</p>";

//            }
 //       endif;



                    if ($duree) {
                        echo '<p class="duree">' . $duree . "</p>";
                    };

                    if ($annee) {
                        echo '<p class="annee">' . $annee . "</p>";
                    }



               //     $post_categories = wp_get_post_categories( $post->ID );
               //    if(!empty($post_categories)){
               //         foreach($post_categories as $c){
               //             echo "<p class='category'>, " . get_category( $c )->name . "</p>";
               //         }
               //    }

                    ?>
</div>
                </div>
            <?php
            endwhile;
            ?>

</div>
</article>
        <?php else : ?>
            <?php get_template_part( 'content', 'none' ); ?>
        <?php endif; ?>

        </div><!-- #content -->
    </section><!-- #primary -->


        <?php /* Display navigation to next/previous pages when applicable */ ?>
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
            <div id="nav-below" class="navigation">
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> précédent', 'acsr' ) ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( __( 'suivant <span class="meta-nav">&rarr;</span>', 'acsr' ) ); ?></div>
            </div><!-- #nav-below -->
        <?php endif; ?>

        <article class="post">

        <h1>Productions en cours</h1>
        <?php
                $my_query = new WP_Query('page_id=1144');
                while ($my_query->have_posts()) : $my_query->the_post();
                    the_content();
                endwhile;
        ?>
        </article>


<?php get_footer(); ?>
