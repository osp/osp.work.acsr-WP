<?php
/**
 * The template for displaying Tag pages.
 *
 * Used to display archive-type pages for posts in a tag.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php printf( __( 'Tag Archives: %s', 'acsr' ), '<span>' . single_tag_title( '', false ) . '</span>' ); ?></h1>

            <?php if ( tag_description() ) : // Show an optional tag description ?>
                <div class="archive-meta"><?php echo tag_description(); ?></div>
            <?php endif; ?>
            </header><!-- .archive-header -->

            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                /* Include the post format-specific template for the content. If you want to
                 * this in a child theme then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
                get_template_part( 'content', get_post_format() );

            endwhile;
            ?>

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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
