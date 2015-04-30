<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package flat-bootstrap
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
<script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
<script type="text/javascript" src="http://secure.rezserver.com/public/js/searchbox/searchbox.min.js"></script>
<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700' rel='stylesheet' type='text/css'>

 
<script type="text/javascript">
 
$(document).ready(function(){
    $("#sb_searchformMain").searchbox({ 
        environment: "prod", 
        hotel: { 
            elements: { 
                adults: ".adults" ,
                chk_in:".rs_chk_in, .rs_chk_in_calendar, .rs_date_chk_in",
                chk_out:".rs_chk_out, .rs_chk_out_calendar, .rs_date_chk_out" 
            } ,
            select_name: true 
        }, 
        vp: { 
            elements: { 
                chk_in:".rs_chk_in, .rs_chk_in_calendar, .rs_date_chk_in",
                chk_out:".rs_chk_out, .rs_chk_out_calendar, .rs_date_chk_out" 
            } ,
            select_name: true 
        }, 
        car: {
            elements: { 
                chk_in:".rs_chk_in, .rs_chk_in_calendar, .rs_date_chk_in",
                chk_out:".rs_chk_out, .rs_chk_out_calendar, .rs_date_chk_out" 
            } , 
            select_name: true 
        }, 
        air: {
            elements: { 
                chk_in:".rs_chk_in, .rs_chk_in_calendar, .rs_date_chk_in",
                chk_out:".rs_chk_out, .rs_chk_out_calendar, .rs_date_chk_out" 
            } , 
            select_name: true 
        },
        refid: 5436
    });
     
    var $icons = $('.rs_tabs');
    var $icons2 = $('.rs_product_icon');
    $icons.click(function(){
       $icons.removeClass('highlight_tab');
       $(this).addClass('highlight_tab');
       $icons2.removeClass("highlight_img");
       $("div", this).addClass("highlight_img");
    });
    var $icons3 = $('.rs_tabs2');
        $icons3.click(function(){
       $icons3.removeClass('highlight_tab2');
       $(this).addClass('highlight_tab2');
    });
    $(".rs_tabs2").on("click", function(){
        var product = $(this).data("product"), selector = ".sb_" + product;
        $(selector).removeClass("sb_display_none").siblings(".sb_airFormType").addClass("sb_display_none");
    });    
    $('#sb_air_multi').click(function(){
        window.location = 'http://tickets.airtkt.net/air/home/?refid=5436'
        return false;
    }); 

});
 
</script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">

	<?php do_action( 'before' ); ?>
	
	<header id="masthead" class="site-header" role="banner">

		<?php
		/**
		  * CUSTOM HEADER IMAGE DISPLAYS HERE FOR THIS THEME, BUT CHILD THEMES MAY DISPLAY
		  * IT BELOW THE NAV BAR (VIA CONTENT-HEADER.PHP)
		  */
		global $xsbf_theme_options;
		$custom_header_location = isset ( $xsbf_theme_options['custom_header_location'] ) ? $xsbf_theme_options['custom_header_location'] : 'content-header';
		if ( $custom_header_location == 'header' ) :
		?>
			<div id="site-branding" class="site-branding">
		
			<?php
			// Get custom header image and determine its size
			if ( get_header_image() ) {
			?>
				<div class="custom-header-image" style="background-image: url('<?php echo header_image() ?>'); width: <?php echo get_custom_header()->width; ?>px; height: <?php echo get_custom_header()->height ?>px;">
				<div class="container">
                <?php //if ( function_exists( 'jetpack_the_site_logo' ) ) jetpack_the_site_logo(); ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' )?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div></div>
			<?php

			// If no custom header, then just display the site title and tagline
			} else {
			?>
				<div class="container">
                <?php //if ( function_exists( 'jetpack_the_site_logo' ) ) jetpack_the_site_logo(); ?>
				<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' )?></a></h1>
				<h2 class="site-description"><?php bloginfo( 'description' ); ?></h2>
				</div>
			<?php
			} //endif get_header_image()
			?>
			</div><!-- .site-branding -->

		<?php			
		endif; // $custom_header_location
		?>			

		<?php
		/**
		  * ALWAYS DISPLAY THE NAV BAR
		  */
 		?>	
		<nav id="site-navigation" class="main-navigation" role="navigation">

			<h1 class="menu-toggle sr-only screen-reader-text"><?php _e( 'Primary Menu', 'flat-bootstrap' ); ?></h1>
			<div class="skip-link"><a class="screen-reader-text sr-only" href="#content"><?php _e( 'Skip to content', 'flat-bootstrap' ); ?></a></div>

		<?php
		// Collapsed navbar menu toggle
		global $xsbf_theme_options;
		$navbar = '<div class="navbar ' . $xsbf_theme_options['navbar_classes'] . '">'
			.'<div class="container">'
        	.'<div class="navbar-header">'
          	.'<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">'
            .'<span class="icon-bar"></span>'
            .'<span class="icon-bar"></span>'
            .'<span class="icon-bar"></span>'
          	.'</button>';

		// Site title (Bootstrap "brand") in navbar. Hidden by default. Customizer will
		// display it if user turns of the main site title and tagline.
		$navbar .= '<a class="navbar-brand" href="'
			.esc_url( home_url( '/' ) )
			.'" rel="home"><img src="/wp-content/uploads/2015/02/airtkt_logo4.png"/></a>';
		
        $navbar .= '</div><!-- navbar-header -->';

		// Display the desktop navbar
		$navbar .= wp_nav_menu( 
			array(  'theme_location' => 'primary',
			'container_class' => 'navbar-collapse collapse', //<nav> or <div> class
			'menu_class' => 'nav navbar-nav', //<ul> class
			'walker' => new wp_bootstrap_navwalker(),
			'fallback_cb' => 'wp_bootstrap_navwalker::fallback',
			'echo'	=> false
			) 
		);
		echo apply_filters( 'xsbf_navbar', $navbar );
		?>

		</div><!-- .container -->
		</div><!-- .navbar -->
		</nav><!-- #site-navigation -->

	</header><!-- #masthead -->

	<?php // Set up the content area (but don't put it in a container) ?>	
	<div id="content" class="site-content">
