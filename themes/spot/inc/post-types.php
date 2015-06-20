<?php 
    #hotel-POST-TYPE
    function hotel_custom_init() {
        $args = array( 
            'label'  => 'Hotel',
            'public' => true,
            'taxonomies' => array('hotel_category','hotel_tags'),
            'supports' => array( 'title', 'editor', 'hotel_tags', 'thumbnail', 'excerpt','page-attributes' ),
			'has_archive' => true,
            
        );
        register_post_type( 'hotel', $args );
    }
    add_action( 'init', 'hotel_custom_init' );

    #hotel CUSTOM TAXONMY
	function hotels_category_init() {
	register_taxonomy(
		'hotel_category',
		'hotel',
		array(
			'hierarchical' => true,
			'label' => __( 'Hotel Category' ),
			'query_var' => true,
			'rewrite' => array( 'slug' => 'hotel-category' ),
			'show_admin_column' => true,'has_archive' => true,
			)
		);
		register_taxonomy(
			'hotel_tags',
			'hotel',
			array(
				'hierarchical' => false,
				'label' => __( 'Hotel Tags' ),
				'query_var' => true,
				'show_admin_column' => true
			)
		);
	}
	add_action( 'init', 'hotels_category_init' );
	#hotel-POST-TYPE
    function amenity_custom_init() {
        $args = array( 
            'label'  => 'Amenity',
            'public' => true,
            'supports' => array( 'title', 'thumbnail' ),
			'has_archive' => true,
            
        );
        register_post_type( 'amenity', $args );
    }
    add_action( 'init', 'amenity_custom_init' );
?>