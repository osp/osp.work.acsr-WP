<?php
/**
 * The default template for displaying content. Used for both single and index/archive/search.
 *
 */
?>

    <article id="post-<?php the_ID(); ?>"  >
    <div class="post" <?php post_class();?>>
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
            <?php /*if($audio != '') {
                   sort($audio);
                   echo "<div id='playlist' class='clip'>";
                   foreach($audio as $key => $val) {
                       $parsed = explode(' --- ', $val);
                       if (count($parsed)!=1) { // if there are several tracks
                           echo "<a class='audio' href='";
                           echo $parsed[1] . "' title='". get_the_title() ."'>" . $parsed[0];
                           echo "</a> ";
                       } else { // if there's only one track
                           echo "<a class='audio' href='";
                           echo $parsed[0] . "' data-link='".$post->ID ."' title='". get_the_title() ."'>";
                           echo "</a> ";
                       }
                    }
                    echo "</div>";
                }
                */?>
            <?php endif; // is_single() ?>
        </header><!-- .entry-header -->

        <div class="entry-content">
           <div class="entry-meta">
           <?php
                $artists = get_post_meta($post->ID, 'wpcf-artiste', false);
                if (!empty($artists)): 
                    echo "<ul class='artist'>";
                    foreach($artists as $key => $val) {
                        echo "<li><a href='/?s=". str_replace(" ", "+", $val)  ."'>" . $val . "</a></li>";
                    }
                    echo "</ul>";
                endif;



               $audio = get_post_meta($post->ID, 'wpcf-audio', false);
               
               if(!empty($audio)) {
                    $get_artists = get_post_meta($post->ID, 'wpcf-artiste', false);
                    $artists = "";
                    if (!empty($get_artists)): 
                        foreach($get_artists as $key => $val) {
                            $artists .= $val;
                        }
                    endif;
                    $annee = get_post_meta($post->ID, 'wpcf-annee', true);
                    $duree = get_post_meta($post->ID, 'wpcf-duree', true);
                    if(qtrans_getLanguage()=='fr') {
                        $genre = get_post_meta($post->ID, 'wpcf-genre', 'true');
                    } elseif(qtrans_getLanguage()=='nl'){
                        $genre = get_post_meta($post->ID, 'wpcf-genre-nl', 'true');
                    }
                    $audio_title = the_title('', '', false);
                    $args = array( "duree" => $duree, "genre" => $genre, "annee" => $annee, "artiste" => $artists );
                    $qstring = http_build_query($args);

                    sort($audio);
                    echo '<div id="playlist" class="clip">';
                    $count = 0;
                    foreach($audio as $key => $val) {
                        $parsed = explode(' --- ', $val);
                        if (count($parsed)!=1) { // if the audio field also includes a title, seperated from the url by ---
                            if ($count==0){ 
                                echo '<img class="play" src="' . get_template_directory_uri() . '/images/petit-play.png" style="margin-top: -3px;" alt="&#9654;" /> ';
                            }
                            echo '<a class="audio" href="';
                            echo $parsed[1] . '&' . $qstring . '" data-link="'.$post->ID .'" title="'. $parsed[0] .'">' . $parsed[0];
                            echo '</a> ';
                            $count ++;
                        } else { // if the audio field contains just the url */
                            echo "<a class='audio' href='";
                            echo $val . '&' . $qstring ."' data-link='".$post->ID ."' title='". get_the_title() ."'><img class='play' src='" . get_template_directory_uri() . "/images/petit-play.png' alt='&#9654;' />";
                            echo "</a> ";
                        }
                    }
                    echo "</div>";
                }
                
                
               $annee = get_post_meta($post->ID, 'wpcf-annee', true);
               if($annee != '') echo "<p><strong>" . $annee . "</strong>";

               $duree = get_post_meta($post->ID, 'wpcf-duree', true);
               if($duree != '') echo " <strong>" . $duree . "</strong>";

                $post_categories = wp_get_post_categories( $post->ID );
               if(!empty($post_categories)){
                    foreach($post_categories as $c){
                        echo "<strong>" . get_category( $c )->name . "</strong>";
                    }
               }

                if(qtrans_getLanguage()=='fr') {
                    if (get_post_meta($post->ID, 'wpcf-genre', true)): 
                        echo get_post_meta($post->ID, 'wpcf-genre', 'true') . "</p>";
                    endif;
                } elseif(qtrans_getLanguage()=='nl'){
                    if (get_post_meta($post->ID, 'wpcf-genre-nl', true)): 
                        echo get_post_meta($post->ID, 'wpcf-genre-nl', 'true') . "</p>";
                    endif;
                }
            ?>
            </div>
            <div class="prod-desc">
                <?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'acsr' ) ); ?>
            </div>
            <?php 
                if(qtrans_getLanguage()=='fr') {
                    $equipe = get_post_meta($post->ID, 'wpcf-equipe', true);
                    if($equipe != '') echo "<p class='equipe'>" . $equipe . "</p>";
                } elseif(qtrans_getLanguage()=='nl'){
                    $equipe = get_post_meta($post->ID, 'wpcf-equipe-nl', true);
                    if($equipe != '') echo "<p class='equipe'>" . $equipe . "</p>";
                }
            ?>
            <div class="more-details">
                    <?php
                        $prix = get_post_meta($post->ID, 'wpcf-prix', true);
                        if($prix != '') echo " <p>Prix&thinsp;:&nbsp;" . $prix . "</p>";

                        if(qtrans_getLanguage()=='fr') {
                            $producteur = get_post_meta($post->ID, 'wpcf-production', true);
                            if($producteur != '') echo "<p>Production&thinsp;:&nbsp;" . $producteur . "</p>";
                        } elseif(qtrans_getLanguage()=='nl'){
                            $producteur = get_post_meta($post->ID, 'wpcf-production-nl', true);
                            if($producteur != '') echo "<p>Productie&thinsp;:&nbsp;" . $producteur . "</p>";
                        }

                        $licence = get_post_meta($post->ID, 'wpcf-licence', true);
                        if($licence != '') echo "<p>Licence&thinsp;:&nbsp;" . $licence . "</p>";
                    ?>
            </div>
        </div><!-- .entry-content -->
    </div>

    <?php if ( !is_search() ) : // In Search results, don’t display all that metadata ?>
        <?php $dates = get_post_meta($post->ID, 'wpcf-dates-de-diffusion', true);
              if($dates != ''):
        ?>
        <div class="post diffusions">
                <h3>Diffusions/Séances d'écoute</h3>
                <div class='dates'>
                    <?php echo str_replace("\n", "<br />", $dates); ?>
                </div>
        </div>
        
        <?php $bio = get_post_meta($post->ID, 'wpcf-bio', true);
            if($bio != ''):
        ?>
        <div class="post">
                <?php
                    if(qtrans_getLanguage()=='fr') {
                        if($bio != '') echo "<p class='bio'>" . $bio . "</p>";
                    } elseif(qtrans_getLanguage()=='nl'){
                        $bio_nl = get_post_meta($post->ID, 'wpcf-bio-nl', true);
                        if($bio_nl != '') echo "<p class='bio'>" . $bio_nl . "</p>";
                    }
                ?>
        </div>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
    </article><!-- #post -->
