<?php
/**
 * The sidebar containing the main widget area.
 *
 * If no active widgets in sidebar, let's hide it completely.
 *
 */
?>
<div id="nav">
    <div id="logo" role="logo">
        <h1><a href="<?php echo home_url(); ?>">
            <img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo-web.png" alt="l'atelier de création sonore radiophonique" border="0" />
        </a></h1>
    </div>
    <nav id="menu" class="main-navigation" role="navigation">
        <?php wp_nav_menu(array('theme_location' => 'primary', 'menu_class' => 'nav-menu')); ?>
    </nav><!-- #site-navigation -->
    <?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
        <div id="secondary" class="widget-area" role="complementary">
            <?php dynamic_sidebar('sidebar-1'); ?>
        </div><!-- #secondary -->
    <?php endif; ?>
</div> <!-- end div#nav -->

