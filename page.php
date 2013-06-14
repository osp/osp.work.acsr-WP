<?php
/**
 * The template for displaying all pages.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site will use a
 * different template.
 *
 */

get_header(); ?>

<div id="primary" class="site-content">
        <div id="content" role="main">

            <?php 
            // first we display the requested page, but only if it has content:
            
            while ( have_posts() ) : the_post();
                if(!get_the_content()) {
                    break;
                }
                get_template_part( 'content', 'page' );
            endwhile; // end of the loop.

            // then we find its children:
            $parent_id = get_the_ID();
            $args = array(
                'numberposts' => -1,
                'order' => 'ASC',
                'orderby' => 'menu_order',
                'post_parent' => $parent_id,
                'post_type' => 'page',
                
            );
            query_posts($args);
            
            // end we display them as well:
            while ( have_posts() ) : the_post();
                get_template_part( 'content', 'page' );
            endwhile; // end of the loop.

            ?>
        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
