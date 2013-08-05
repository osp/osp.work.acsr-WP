<?php
/**
 * The Template for displaying all single posts.
 *
 */

get_header(); ?>

    <div id="primary" class="site-content">
        <div id="content" role="main">

            <?php while ( have_posts() ) : the_post(); ?>

                <?php get_template_part( 'content', get_post_format() ); ?>

                <nav id="nav-below" class="nav-single navigation">
                    <div class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'acsr' ) . '</span> précédent' ); ?></div>
                    <div class="nav-next"><?php next_post_link( '%link', 'suivant <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'acsr' ) . '</span>' ); ?></div>
                </nav><!-- .nav-single -->

                <?php comments_template( '', true ); ?>

            <?php endwhile; // end of the loop. ?>

        </div><!-- #content -->
    </div><!-- #primary -->

<?php get_footer(); ?>
