<?php
/**
 * The template for displaying posts in the Image post format
 *
 */
?>

            <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                <?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
                <div class="featured-post">
                    <?php _e( 'Featured post', 'acsr' ); ?>
                </div>
                <?php endif; ?>
                <header class="entry-header">
                    <?php if ( is_single() ) : ?>
                    <h1 class="entry-title"><?php the_title(); ?></h1>
                    <?php else : ?>
                    <h1 class="entry-title">
                        <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'acsr' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark"><?php the_title(); ?></a>
                    </h1>
                    <?php endif; // is_single() ?>
                </header><!-- .entry-header -->

                <div class="entry-content">
                    <?php the_excerpt(); ?>
                    <a href="<?php the_permalink(); ?>" title="<?php echo esc_attr( sprintf( __( 'Permalink to %s', 'acsr' ), the_title_attribute( 'echo=0' ) ) ); ?>" rel="bookmark">
                    <?php
                    // if there exists a manually selected thumbnail image,
                    // we show it—otherwise the first uploaded image for this
                    // page.
                    if ( has_post_thumbnail() ) {
                        the_post_thumbnail();
                    } else {
                        $args = array( 'post_type' => 'attachment', 'posts_per_page' => 1, 'post_status' =>'any', 'post_parent' => $post->ID ); 
                        $attachments = get_posts($args);
                    ?>
                        <img src="<?php echo reset(wp_get_attachment_image_src( reset($attachments)->ID , "large")); ?>" class="first-image" alt="" />
                    <?php
                    }
                    ?>
                    </a>
                </div><!-- .entry-content -->

            </article><!-- #post -->

