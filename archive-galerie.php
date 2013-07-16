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

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>
            <header class="archive-header">
                <h1 class="archive-title"><?php
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
            while ( have_posts() ) : the_post();?>
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
                    <?php endif; // is_single() ?>
                </header><!-- .entry-header -->

                <?php if ( is_search() ) : // Only display Excerpts for Search ?>
                    <div class="entry-summary">
                        <?php the_excerpt(); ?>
                    </div><!-- .entry-summary -->
                <?php else : ?>
                    <div class="entry-content">
                        <?php the_excerpt(); ?>

                        <?php
                            $args = array( 'post_type' => 'attachment', 'posts_per_page' => 1, 'post_status' =>'any', 'post_parent' => $post->ID ); 
                            $attachments = get_posts($args);
                        ?>
                            <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'acsr' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><img src="<?php echo wp_get_attachment_image_src( $attachments[0]->ID , "large")[0]; ?>" class="first-image" alt="" /></a>

                    </div><!-- .entry-content -->
                <?php endif; ?>

            </article><!-- #post -->
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
