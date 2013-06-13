<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 */
?>

        </div><!-- #content -->
    </div><!-- #primary -->
</div> <!-- end #container -->


<?php get_sidebar(); ?>


<div id="nav">
    <div id="logo" role="logo">
        <h1><a href='/'>
            <img id="logo" src="<?php echo get_template_directory_uri(); ?>/images/logos/acsr_logo-web.png" alt="l'atelier de création sonore radiophonique" border="0" />
        </a></h1>
    </div>
    <nav id="menu" class="main-navigation" role="navigation">
        <?php wp_nav_menu( array( 'theme_location' => 'primary', 'menu_class' => 'nav-menu' ) ); ?>
    </nav><!-- #site-navigation -->
</div> <!-- end div#nav -->



    </div><!-- #main -->


    <div id="footer" role="contentinfo">


<?php
    /* A sidebar in the footer? Yep. You can can customize
     * your footer with four columns of widgets.
     */
    get_sidebar( 'footer' );
?>

    </div><!-- #footer -->

</div><!-- #wrapper -->

<?php
    /* Always have wp_footer() just before the closing </body>
     * tag of your theme, or you will break many plugins, which
     * generally use this hook to reference JavaScript files.
     */

    wp_footer();
?>

<!-- Piwik -->
<script type="text/javascript">
    var pkBaseURL = (("https:" == document.location.protocol) ? "https://stats.stdin.fr/" : "http://stats.stdin.fr/");
    document.write(unescape("%3Cscript src='" + pkBaseURL + "piwik.js' type='text/javascript'%3E%3C/script%3E"));
</script>
<script type="text/javascript">
    try {
        var piwikTracker = Piwik.getTracker(pkBaseURL + "piwik.php", 8);
        piwikTracker.trackPageView();
        piwikTracker.enableLinkTracking();
    } catch( err ) {}
</script>
<noscript><p><img src="http://stats.stdin.fr/piwik.php?idsite=8" style="border:0" alt="" /></p></noscript>
<!-- End Piwik Tag -->

</body>
</html>
