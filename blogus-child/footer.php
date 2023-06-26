<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @package Blogus
 */
?>
<?php 
do_action('blogus_action_footer_missed_section');
?><!--==================== FOOTER AREA ====================-->
    <?php $blogus_footer_widget_background = get_theme_mod('blogus_footer_widget_background');
    $blogus_footer_overlay_color = get_theme_mod('blogus_footer_overlay_color'); 
   if($blogus_footer_widget_background != '') { ?>
    <footer class="back-img" style="background-image:url('<?php echo esc_url($blogus_footer_widget_background);?>');">
     <?php } else { ?>
    <footer> 
    <?php } ?>
        <div class="overlay" style="background-color: <?php echo esc_html($blogus_footer_overlay_color);?>;">
                <!--Start bs-footer-widget-area-->
                <?php if ( is_active_sidebar( 'footer_widget_area' ) ) { ?>
                <div class="bs-footer-widget-area">
                    <div class="container">
                        <div class="row">
                          <?php  dynamic_sidebar( 'footer_widget_area' ); ?>
                        </div>
                        <!--/row-->
                    </div>
                    <!--/container-->
                </div>
                 <?php } ?>
                
                <!--End bs-footer-widget-area-->

              <?php $hide_copyright = esc_attr(get_theme_mod('hide_copyright','true'));
                if ($hide_copyright == true ) { ?>
                <div class="bs-footer-copyright">
                    <div class="container">
                        <div class="row">
                          <?php  if ( has_nav_menu( 'footer' ) ) {
                           ?>
                            <div class="col-md-6 text-left text-xs">
                              <p class="mb-0">
                                <?php $blogus_footer_copyright = get_theme_mod( 'blogus_footer_copyright','Demo for Aventus IT Copyright &copy; 2023 All rights reserved' );
                                  echo esc_html($blogus_footer_copyright);
                                ?>
                                </p>
                            </div>
                                <div class="col-md-6 text-right text-xs">
                                  <?php wp_nav_menu( array(
                              'theme_location' => 'footer',
                              'container'  => 'nav-collapse collapse navbar-inverse-collapse',
                              'menu_class' => 'info-right',
                              'fallback_cb' => 'blogus_fallback_page_menu',
                              'walker' => new blogus_nav_walker()
                            ) ); 
                            ?>
                            </div>
                          <?php } else { ?>
                             <div class="col-md-12 text-center">
                              <p class="mb-0">
                                <?php $blogus_footer_copyright = get_theme_mod( 'blogus_footer_copyright','Demo for Aventus IT Copyright &copy; 2023 All rights reserved' );
                                  echo esc_html($blogus_footer_copyright);
                                ?>
                                 </a>
                                </p>
                            </div>
                          <?php } ?>
                            </div>
                        </div>
                    </div>
                </div> 
                <?php } ?>
            </div>
            <!--/overlay-->
        </footer>
        <!--/footer-->
    </div>
    <!--/wrapper-->
    <!--Scroll To Top-->
    <?php blogus_scrolltoup(); ?>
    <!--/Scroll To Top-->
    <!-- Modal -->
  <div class="modal fade bs_model" id="exampleModal" data-bs-keyboard="true" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></button>
        </div>
        <div class="modal-body">
          <?php get_search_form(); ?>
        </div>
      </div>
    </div>
  </div>
<!-- /Modal -->
<!-- /Scroll To Top -->
<?php wp_footer(); ?>
</body>
</html>