<?php
/**
 * The template for displaying Archive pages.
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, ACSR already
 * has tag.php for Tag archives, category.php for Category archives, and
 * author.php for Author archives.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php echo get_post_format();?><?php
                    if ( is_day() ) :
                        printf( __( 'Daily Archives: %s', 'acsr' ), '<span>' . get_the_date() . '</span>' );
                    elseif ( is_month() ) :
                        printf( __( 'Monthly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'acsr' ) ) . '</span>' );
                    elseif ( is_year() ) :
                        printf( __( 'Yearly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'acsr' ) ) . '</span>' );
                    else :
                        _e( 'Galerie photo', 'acsr' );
                    endif;
                ?></h1>
            </header><!-- .archive-header -->

            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();
            
            $tmpl = get_post_format(); // i.e. ‘image’, for content-image.php
            if (!$tmpl) {
                $tmpl = get_post_type(); // i.e. ‘galerie’, for content-galerie.php
            }
            get_template_part( 'content', $tmpl ); ?>

            <?php endwhile; ?>

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

<?php get_footer(); ?>
