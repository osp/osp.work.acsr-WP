<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 */

get_header(); ?>
        <?php if ( have_posts() ) : ?>

            <?php /* Start the Loop */ ?>
            <?php if (is_home()) {
                $page = (get_query_var('paged')) ? get_query_var('paged') : 1;
                query_posts("showposts=1&paged=$page");
            } ?>
            <?php while ( have_posts() ) : the_post(); ?>

    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
        <div class="featured-post">
            <?php _e( 'Featured post', 'acsr' ); ?>
        </div>
        <?php endif; ?>
        <header class="entry-header">
            <?php the_post_thumbnail(); ?>
            <?php if ( is_single() ) : ?>
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <?php else : ?>
            <h1 class="entry-title">
                <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'acsr' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
            </h1>
            <div class="entry-meta">
                <?php acsr_entry_meta(); ?>
                <?php edit_post_link( __( 'Edit', 'acsr' ), '<span class="edit-link">', '</span>' ); ?>
            </div><!-- .entry-meta -->
            <?php endif; // is_single() ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
            <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'acsr' ) ); ?>
            <?php wp_link_pages( array( 'before' => '<div class="page-links">' . __( 'Pages:', 'acsr' ), 'after' => '</div>' ) ); ?>
        </div><!-- .entry-content -->

    </article><!-- #post -->

            <?php endwhile; ?>

        <?php else : // if no posts ?>

            <article id="post-0" class="post no-results not-found">

            <?php if ( current_user_can( 'edit_posts' ) ) :
                // Show a different message to a logged-in user who can add posts.
            ?>
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'No posts to display', 'acsr' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'acsr' ), admin_url( 'post-new.php' ) ); ?></p>
                </div><!-- .entry-content -->

            <?php else :
                // Show the default message to everyone else.
            ?>
                <header class="entry-header">
                    <h1 class="entry-title"><?php _e( 'Nothing Found', 'acsr' ); ?></h1>
                </header>

                <div class="entry-content">
                    <p><?php _e( 'Apologies, but no results were found. Perhaps searching will help find a related post.', 'acsr' ); ?></p>
                    <?php get_search_form(); ?>
                </div><!-- .entry-content -->
            <?php endif; // end current_user_can() check ?>


            <?php // if not first ?>
            <div class="entry-summary">
                <?php //the_excerpt(); ?>        
            </div><!-- .entry-summary -->


            </article><!-- #post-0 -->

        <?php endif; // end have_posts() check ?>

        <?php /* Display navigation to next/previous pages when applicable */ ?>
        <?php if (  $wp_query->max_num_pages > 1 ) : ?>
            <div id="nav-below" class="navigation">
                <div class="nav-previous"><?php next_posts_link( __( '<span class="meta-nav">&larr;</span> précédent', 'acsr' ) ); ?></div>
                    <div class="nav-next"><?php previous_posts_link( __( 'suivant <span class="meta-nav">&rarr;</span>', 'acsr' ) ); ?></div>
            </div><!-- #nav-below -->
        <?php endif; ?>
<ul id="blog-bar">
    <?php dynamic_sidebar(2); ?>
</ul>

<?php get_footer(); ?>
