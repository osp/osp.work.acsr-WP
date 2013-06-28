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

<?php query_posts('posts_per_page=12&paged='.$page.'&post_type=production&orderby=meta_value&meta_key=wpcf-annee&order=DESC');?>

    <section id="primary" class="site-content">
        <div id="content" role="main">

        <?php if ( have_posts() ) : ?>

<article class="post">
            <header class="archive-header">
                <h1 class="productions-achevees"><?php
                    if ( is_day() ) :
                        printf( __( 'Daily Archives: %s', 'acsr' ), '<span>' . get_the_date() . '</span>' );
                    elseif ( is_month() ) :
                        printf( __( 'Monthly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'F Y', 'monthly archives date format', 'acsr' ) ) . '</span>' );
                    elseif ( is_year() ) :
                        printf( __( 'Yearly Archives: %s', 'acsr' ), '<span>' . get_the_date( _x( 'Y', 'yearly archives date format', 'acsr' ) ) . '</span>' );
                    else : 
                        _e( 'Productions achevées', 'acsr' );?>
   
                    <?php endif;
                ?></h1>
                
            </header><!-- .archive-header -->
            
    <ul id="resort">
        <li><a href="/?page_id=12#productions-achevees" <?php if ($annee) { echo "class='active'";} ?>>par année</a></li>
        <li><a href="/?page_id=1139#productions-achevees" <?php if ($titre) { echo "class='active'";} ?>>par titre</a></li>
        <li><a href="/?page_id=40#productions-achevees" <?php if ($genre) { echo "class='active'";} ?>>par genre</a></li>
    </ul>          
<div id="prod-finies">
  
                        
                        
            <?php
            /* Start the Loop */
            while ( have_posts() ) : the_post();

                /* Include the post format-specific template for the content. If you want to
                 * this in a child theme then include a file called called content-___.php
                 * (where ___ is the post format) and that will be used instead.
                 */
           ?>
<div id='post<?php echo $i; ?>' class="production-item">
                    <h3><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    
                    <?php 
                    if (get_post_meta($post->ID, 'wpcf-genre', true)): 
                        echo "<p>" . get_post_meta($post->ID, 'wpcf-genre', 'true') . "</p>";
                    endif;
                    
                    if (get_post_meta($post->ID, 'wpcf-annee', true)): 
                        echo "<p>" . get_post_meta($post->ID, 'wpcf-annee', 'true') . "</p>";
                    endif;
                    
                    $audio = get_post_meta($post->ID, 'wpcf-audio', false);
                    // if (get_post_meta($post->ID, 'audio', true)):
                    if($audio[0] != ''):
                        //$audio_title = wp_title( '', false, '' );
                        $audio_title = the_title('', '', false);
                        
                        $parse = explode(' --- ', $audio[0]);
                        if (count($parse)!=1) { // if there are several tracks
                            $url = $parse[1];
                        } else { // if there's only one track
                            $url = $parse[0];
                        }
                        echo "<div class='clip' id='clip". $i . "'>";
                        echo "<a class='audio mini-launcher' href='" . $url . "' style='text-decoration: none;' title='". $audio_title ."'>"; 
                        echo "<img src='/wp-content/themes/acsr/images/petit-play.png' alt='&#9654;' />";
                        echo "</a>";
                        echo "</div>";
                    endif;
                    $i++;
                    ?>
                </div>		
            <?php
            endwhile;
            ?>

</div>
</article>
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
        
        <article class="post">
        <h1>Productions en cours</h1>
        <?php
                $my_query = new WP_Query('page_id=1144');
                while ($my_query->have_posts()) : $my_query->the_post();
                    the_content();
                endwhile;
        ?>
        </article>
        
        
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function(){
            // popup player
            $("a.mini-launcher").click(function(e){
                e.preventDefault();
                url = $(this).attr("href");
                title = $(this).attr("title");
                postID = $(this).attr("data-link");
                url = "/wp-content/themes/acsr/player.php?audio=" + url + '&title="' + title + '"&postID=' + postID,'lecteur acsr','height=200,width=150';
                console.log(url);
                popup = window.open(url);
            });
        });
    </script>
        
<?php get_sidebar(); ?>
<?php get_footer(); ?>
