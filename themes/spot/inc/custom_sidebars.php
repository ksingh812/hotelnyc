<?php
   #REGISTER-RESOURCES-WIDGET
    if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name'=> 'Resources',
		'id' => 'resources',
        'before_widget' => '',
		'after_widget' => '',
    ));

    #REGISTER- ARCHIVE SIDEBAR
    if ( function_exists('register_sidebar') )
    register_sidebar(array(
        'name'=> 'Archive Sidebar',
		'id' => 'archive',
        'before_widget' => '',
		'after_widget' => '',
    ));
	
    register_sidebar( array(
        'name' => __( 'Footer 1', 'wpb' ),
        'id' => 'footer1',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 2', 'wpb' ),
        'id' => 'footer2',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 3', 'wpb' ),
        'id' => 'footer3',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
    register_sidebar( array(
        'name' => __( 'Footer 4', 'wpb' ),
        'id' => 'footer4',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	register_sidebar( array(
        'name' => __( 'About Net@Work', 'wpb' ),
        'id' => 'footer-about',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	register_sidebar( array(
        'name' => __( 'Resources Footer', 'wpb' ),
        'id' => 'footer-resources',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	register_sidebar( array(
        'name' => __( 'News Footer', 'wpb' ),
        'id' => 'footer-news',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	register_sidebar( array(
        'name' => __( 'Partners Footer', 'wpb' ),
        'id' => 'footer-partners',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	register_sidebar( array(
        'name' => __( 'SuccessStory Footer', 'wpb' ),
        'id' => 'footer-success-story',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	
	register_sidebar( array(
        'name' => __( 'Events Footer', 'wpb' ),
        'id' => 'footer-events',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h4 class="widget-title">',
        'after_title' => '</h4>',
    ) );
	
?>