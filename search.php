<?php
/**
 * The template for displaying Search Results pages.
 *
 */

get_header(); ?>

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>

            <header class="page-header">
                <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'acsr' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
            </header>


            <?php /* Start the Loop */ ?>
            <?php while ( have_posts() ) : the_post();
                $tmpl = get_post_format(); // i.e. ‘image’, for content-image.php
                if (!$tmpl) {
                    $tmpl = get_post_type(); // i.e. ‘galerie’, for content-galerie.php
                }
                echo '<h1>' . $tmpl . '</h1>';
                get_template_part( 'content', $tmpl ); ?>
                
            <?php endwhile; ?>

        <?php else : ?>

            <article id="post-0" class="post no-results not-found">
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'acsr' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php _e( 'Sorry, but nothing matched your search criteria. Please try again with some different keywords.', 'acsr' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            </article><!-- #post-0 -->

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

<?php get_footer(); ?>
