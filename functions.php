<?php
/**
 * ACSR functions and definitions.
 *
 * Sets up the theme and provides some helper functions, which are used
 * in the theme as custom template tags. Others are attached to action and
 * filter hooks in WordPress to change core functionality.
 *
 * When using a child theme (see http://codex.wordpress.org/Theme_Development and
 * http://codex.wordpress.org/Child_Themes), you can override certain functions
 * (those wrapped in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before the parent
 * theme's file, so the child theme functions would be used.
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are instead attached
 * to a filter or action hook.
 *
 * For more information on hooks, actions, and filters, see http://codex.wordpress.org/Plugin_API.
 *
 */


/** TODO: remove the most possible of the 2010 cruft
 */

/**
 * Don’t show the long text that instructs the commenter about available HTML tags:
 */

function acsr_init() {
    add_filter('comment_form_defaults','acsr_comments_form_defaults');
}
add_action('after_setup_theme','acsr_init');

function acsr_comments_form_defaults($default) {
    unset($default['comment_notes_after']);
    return $default;
}

// Replaces the excerpt "more" text by a link
function new_excerpt_more($more) {
       global $post;
    return '<a class="moretag" href="'. get_permalink($post->ID) . '">[...]</a>';
}
add_filter('excerpt_more', 'new_excerpt_more');

function acsr_post_player() {
   global $post;
   $audio = get_post_meta($post->ID, 'wpcf-audio', false);
   // most posts without audio have Array( ), but some posts have Array ( [0] => )
   if(!empty($audio) and $audio[0]) {
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

        $get_thematiques = get_post_meta($post->ID, 'wpcf-thematiques', true);
        $thematiques = "";
        if (($get_thematiques)!=' '):
            foreach($get_thematiques as $keyc => $valc) {
                $thematiques .= $valc;
            }
        endif;

        $audio_title = the_title('', '', false);
        $args = array( "duree" => $duree, "genre" => $genre, "thematiques" => $thematiques, "annee" => $annee, "artiste" => $artists );
        $qstring = http_build_query($args);

        sort($audio);
        $single = count($audio) == 1; // There is only one audio clip
        echo '<div id="playlist" class="clip' . ($single ? " single" : "") . '">';
        $count = 0;
        foreach($audio as $key => $val) {
            $parsed = explode(' --- ', $val);
            if (count($parsed)!=1) { // if the audio field also includes a title, seperated from the url by ---
                echo '<a class="audio" href="';
                echo $parsed[1] . '&' . $qstring . '" data-link="'.$post->ID .'" title="'. $parsed[0] .'">' . $parsed[0];
                if ($count==0){
                    echo '<img class="play" src="' . get_template_directory_uri() . '/images/' . ($single ? "" : "petit-") . 'play.png" style="margin-top: -3px;" alt="&#9654;" /> ';
                }
                echo '</a> ';
                $count ++;
            } else { // if the audio field contains just the url */
                echo '<a class="audio" href="';
                echo $val . '&' . $qstring .'" data-link="' . $post->ID . '" title="' . get_the_title() . '"><img class="play" src="' . get_template_directory_uri() . '/images/' . ($single ? "" : "petit-") . 'play.png" alt="&#9654;" />';
                echo "</a> ";
            }
        }
        echo "</div>";
    }


   $annee = get_post_meta($post->ID, 'wpcf-annee', true);
   if($annee != '') echo "<p style=\"line-height:25px\"><strong>" . $annee . "</strong>";

   $duree = get_post_meta($post->ID, 'wpcf-duree', true);
   if($duree != '') echo " <strong>" . $duree . "</strong>";

   // $post_categories = wp_get_post_categories( $post->ID );
   //if(!empty($post_categories)){
   //     foreach($post_categories as $c){
   //         echo "<strong>" . get_category( $c )->name . "</strong>";
   //     }
  // }

    if (get_post_meta($post->ID, 'wpcf-genre', true)):
    echo "<strong>Genre :</strong>";
        echo get_post_meta($post->ID, 'wpcf-genre', 'true') . "</p>";
    endif;
/*$thematiques = get_post_meta($post->ID, 'wpcf-thematiques', true);
if (!empty($thematiques)) {
                echo "<strong> Thématiques: </strong>";
         foreach ( $thematiques as $item) :
echo "$item; ";
endforeach;

            }*/

}


/** AJOUTER CATEGORY POUR LES PRODICTIONS**/
add_action( 'init', 'register_cpt_production' );

function register_cpt_production() {

    $labels = array(
        'name' => _x( 'production', 'production' ),
        'singular_name' => _x( 'production', 'production' ),
        'add_new' => _x( 'Ajouter', 'production' ),
        'add_new_item' => _x( 'Ajouter un production', 'production' ),
        'edit_item' => _x( 'Editer un productions', 'production' ),
        'new_item' => _x( 'Nouveau productions', 'production' ),
        'view_item' => _x( 'Voir le productions', 'production' ),
        'search_items' => _x( 'Rechercher un productions', 'production' ),
        'not_found' => _x( 'Aucun produit trouvé', 'production' ),
        'not_found_in_trash' => _x( 'Aucun productions dans la corbeille', 'production' ),
        'parent_item_colon' => _x( 'productions parent :', 'production' ),
        'menu_name' => _x( 'productions', 'production' ),
    );

    $args = array(
        'labels' => $labels,
        'hierarchical' => false,
        'description' => 'Les productions de ma boutique.',
        'supports' => array( 'title', 'editor', 'thumbnail', 'custom-fields', 'revisions' ),
        'taxonomies' => array( 'category', 'post_tag' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,

        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );

    register_post_type( 'production', $args );
}

function acsr_setup() {
    /*
     * Makes ACSR available for translation.
     *
     * Translations can be added to the /languages/ directory.
     * If you're building a theme based on ACSR, use a find and replace
     * to change 'acsr' to the name of your theme in all the template files.
     */
    load_theme_textdomain( 'acsr', get_template_directory() . '/languages' );

    // This theme styles the visual editor with editor-style.css to match the theme style.
    add_editor_style();

    // Adds RSS feed links to <head> for posts and comments.
    add_theme_support( 'automatic-feed-links' );

    // This theme supports a variety of post formats.
    add_theme_support( 'post-formats', array( 'aside', 'image', 'link', 'quote', 'status' ) );

    // This theme uses wp_nav_menu() in one location.
    register_nav_menu( 'primary', __( 'Primary Menu', 'acsr' ) );

    /*
     * This theme supports custom background color and image, and here
     * we also set up the default background color.
     */
    add_theme_support( 'custom-background', array(
        'default-color' => 'e6e6e6',
    ) );

    // This theme uses a custom image size for featured images, displayed on "standard" posts.
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 442, 9999 ); // Unlimited height, soft crop
}
add_action( 'after_setup_theme', 'acsr_setup' );

/**
 * Enqueues scripts and styles for front-end.
 *
 * @since ACSR 1.0
 */
function acsr_scripts_styles() {
    global $wp_styles;

    /*
     * Adds JavaScript to pages with the comment form to support
     * sites with threaded comments (when in use).
     */
    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    /*
     * Adds JavaScript for handling the navigation menu hide-and-show behavior.
     */
    wp_enqueue_script( 'acsr-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '1.0', true );

    /*
     * Loads our main stylesheet.
     */
    wp_enqueue_style( 'acsr-style', get_stylesheet_uri() );

    /*
     * Loads the Internet Explorer specific stylesheet.
     */
    wp_enqueue_style( 'acsr-ie', get_template_directory_uri() . '/css/ie.css', array( 'acsr-style' ), '20121010' );
    $wp_styles->add_data( 'acsr-ie', 'conditional', 'lt IE 9' );
}
add_action( 'wp_enqueue_scripts', 'acsr_scripts_styles' );

/**
 * Creates a nicely formatted and more specific title element text
 * for output in head of document, based on current view.
 *
 * @since ACSR 1.0
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string Filtered title.
 */
function acsr_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;

    // Add the site name.
    $title .= get_bloginfo( 'name' );

    // Add the site description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    // Add a page number if necessary.
    if ( $paged >= 2 || $page >= 2 )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'acsr' ), max( $paged, $page ) );

    return $title;
}
add_filter( 'wp_title', 'acsr_wp_title', 10, 2 );

/**
 * Makes our wp_nav_menu() fallback -- wp_page_menu() -- show a home link.
 *
 * @since ACSR 1.0
 */
function acsr_page_menu_args( $args ) {
    if ( ! isset( $args['show_home'] ) )
        $args['show_home'] = true;
    return $args;
}
add_filter( 'wp_page_menu_args', 'acsr_page_menu_args' );

/**
 * Registers our main widget area and the front page widget areas.
 *
 * @since ACSR 1.0
 */
function acsr_widgets_init() {
    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'acsr' ),
        'id' => 'sidebar-1',
        'description' => __( 'Appears on posts and pages except the optional Front Page template, which has its own widgets', 'acsr' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'First Front Page Widget Area', 'acsr' ),
        'id' => 'sidebar-2',
        'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'acsr' ),
        'before_widget' => '<li id="%1$s" class="archive-list widget %2$s">',
        'after_widget' => '</li>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );

    register_sidebar( array(
        'name' => __( 'Second Front Page Widget Area', 'acsr' ),
        'id' => 'sidebar-3',
        'description' => __( 'Appears when using the optional Front Page template with a page set as Static Front Page', 'acsr' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'acsr_widgets_init' );

if ( ! function_exists( 'acsr_content_nav' ) ) :
/**
 * Displays navigation to next/previous pages when applicable.
 *
 * @since ACSR 1.0
 */
function acsr_content_nav( $html_id ) {
    global $wp_query;

    $html_id = esc_attr( $html_id );

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $html_id; ?>" class="navigation" role="navigation">
            <h3 class="assistive-text"><?php _e( 'Post navigation', 'acsr' ); ?></h3>
            <div class="nav-previous alignleft"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> Older posts', 'acsr' ) ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link( __( 'Newer posts <span class="meta-nav">&rarr;</span>', 'acsr' ) ); ?></div>
        </nav><!-- #<?php echo $html_id; ?> .navigation -->
    <?php endif;
}
endif;

if ( ! function_exists( 'acsr_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own acsr_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since ACSR 1.0
 */
function acsr_comment( $comment, $args, $depth ) {
    $GLOBALS['comment'] = $comment;
    switch ( $comment->comment_type ) :
        case 'pingback' :
        case 'trackback' :
        // Display trackbacks differently than normal comments.
    ?>
    <li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
        <p><?php _e( 'Pingback:', 'acsr' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'acsr' ), '<span class="edit-link">', '</span>' ); ?></p>
    <?php
            break;
        default :
        // Proceed with normal comments.
        global $post;
    ?>
    <li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
        <article id="comment-<?php comment_ID(); ?>" class="comment">
            <header class="comment-meta comment-author vcard">
                <?php
                    echo get_avatar( $comment, 44 );
                    printf( '<cite class="fn">%1$s %2$s</cite>',
                        get_comment_author_link(),
                        // If current post author is also comment author, make it known visually.
                        ( $comment->user_id === $post->post_author ) ? '<span> ' . __( 'Post author', 'acsr' ) . '</span>' : ''
                    );
                    printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
                        esc_url( get_comment_link( $comment->comment_ID ) ),
                        get_comment_time( 'c' ),
                        /* translators: 1: date, 2: time */
                        sprintf( __( '%1$s at %2$s', 'acsr' ), get_comment_date(), get_comment_time() )
                    );
                ?>
            </header><!-- .comment-meta -->

            <?php if ( '0' == $comment->comment_approved ) : ?>
                <p class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'acsr' ); ?></p>
            <?php endif; ?>

            <section class="comment-content comment">
                <?php comment_text(); ?>
                <?php edit_comment_link( __( 'Edit', 'acsr' ), '<p class="edit-link">', '</p>' ); ?>
            </section><!-- .comment-content -->

            <div class="reply">
                <?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'acsr' ), 'after' => ' <span>&darr;</span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
            </div><!-- .reply -->
        </article><!-- #comment-## -->
    <?php
        break;
    endswitch; // end comment_type check
}
endif;








if ( ! function_exists( 'acsr_entry_meta' ) ) :
/**
 * Prints HTML with meta information for current post: categories, tags, permalink, author, and date.
 *
 * Create your own acsr_entry_meta() to override in a child theme.
 *
 * @since ACSR 1.0
 */



function get_the_category_list2( $separator = '' ) {
    global $wp_rewrite;

    $categories = get_the_category( $post_id );
    if ( empty( $categories ) ) {
        /** This filter is documented in wp-includes/category-template.php */
        return apply_filters( 'the_category', __( 'Uncategorized' ), $separator, $parents );
    }

    $rel = ( is_object( $wp_rewrite ) && $wp_rewrite->using_permalinks() ) ? 'rel="category tag"' : 'rel="category"';

    $thelist = '';
    $thelist .= '<strong>Catégories:</strong>';
foreach((get_the_category()) as $childcat) {
if (cat_is_ancestor_of(20, $childcat)) {
$thelist .= '<a href="'.get_category_link($childcat->cat_ID).'">';
 $thelist .= $childcat->cat_name . '</a> ';
}}

 $i = 0;
/**foreach ((get_the_category()) as $childcatC) {
if (cat_is_ancestor_of(109, $childcatC))
$thelist .= '<strong>Thématiques:</strong>';
if (++$i == 1) break;
}*/


foreach((get_the_category()) as $childcatB) {
if (cat_is_ancestor_of(21, $childcatB)) {
$thelist .= '<a href="'.get_category_link($childcatB->cat_ID).'">';
 $thelist .= $childcatB->cat_name . '</a> ';
}}


    /**
     * Filter the category or list of categories.
     *
     * @since 1.2.0
     *
     * @param array  $thelist   List of categories for the current post.
     * @param string $separator Separator used between the categories.
     * @param string $parents   How to display the category parents. Accepts 'multiple',
     *                          'single', or empty.
     */
    return apply_filters( 'the_category', $thelist, $separator, $parents );
}




function acsr_entry_meta() {
    // Translators: used between list items, there is a space after the comma.
    $categories_list = get_the_category_list2( ', ' );

    // Translators: used between list items, there is a space after the comma.
    $tag_list = get_the_tag_list( '', ', ' );

    $date = sprintf( '<a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s">%4$s</time></a>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() )
    );

    // Translators: 1 is category, 2 is tag, and 3 is the date.
    if ( $tag_list ) {
        $utility_text = __( 'Posté le %3$s dans %1$s <strong>Tags</strong> %2$s.', 'acsr' );
    } elseif ( $categories_list ) {
        $utility_text = __( 'Posté le %3$s dans %1$s.', 'acsr' );
    } else {
        $utility_text = __( 'Posté le %3$s.', 'acsr' );
    }

    printf(
       $utility_text,
         $categories_list,
        $tag_list,
        $date
    );
}
endif;

/**
 * Extends the default WordPress body class to denote:
 * 1. White or empty background color to change the layout and spacing.
 * 2. Custom fonts enabled.
 * 3. Single or multiple authors.
 *
 * @since ACSR 1.0
 *
 * @param array Existing class values.
 * @return array Filtered class values.
 */
function acsr_body_class( $classes ) {
    $background_color = get_background_color();

    if ( empty( $background_color ) )
        $classes[] = 'custom-background-empty';
    elseif ( in_array( $background_color, array( 'fff', 'ffffff' ) ) )
        $classes[] = 'custom-background-white';

    // Enable custom font class only if the font CSS is queued to load.
    if ( wp_style_is( 'acsr-fonts', 'queue' ) )
        $classes[] = 'custom-font-enabled';

    if ( ! is_multi_author() )
        $classes[] = 'single-author';

    return $classes;
}
add_filter( 'body_class', 'acsr_body_class' );

function add_custom_types_to_tax( $query ) {
if( is_category() || is_tag() && empty( $query->query_vars['suppress_filters'] ) ) {

// Get all your post types
$post_types = get_post_types();

$query->set( 'post_type', $post_types );
return $query;
}
}
add_filter( 'pre_get_posts', 'add_custom_types_to_tax' );



