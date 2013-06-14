<?php
/**
 * The template used for displaying page content in page.php
 *
 */
?>

    <div class='post'>
        <h1 id="title-<?php the_ID(); ?>" class="project-title">
            <a href="<?php the_permalink(); ?>" title="<?php printf( esc_attr__( 'Permalink to %s', 'acsr' ), the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
                <?php the_title(); ?>
            </a>
        </h1>
        <div id="project-<?php the_ID(); ?>" class="project-content">
            <?php the_content() ?>
        </div>      
    </div>
