<?php
/**
 * Theme: Flat Bootstrap
 * 
 * This template is called from other page and archive templates to display the content
 * header, which is essentially the header for the page. If there is a wide featured
 * image, it displays that with the page title and subtitle/description overlaid on it.
 * Otherwise, it just displays the text on a colored background.
 *
 * @package flat-bootstrap
 */
?>

<?php if ( have_posts() ) : ?>

	<?php 
	/**
	 * GET AND/OR INITIALIZE VARIABLES WE NEED
	 */
	 global $xsbf_theme_options;
	 global $content_width;
	 $custom_header_location = isset ( $xsbf_theme_options['custom_header_location'] ) ? $xsbf_theme_options['custom_header_location'] : 'content-header';
	 $image_url = $image_width = $image_type = null;
	 $title = $subtitle = $description = null;
	 
	/**
	 * CHECK FOR A WIDE FEATURED IMAGE OR AN UPLOADED CUSTOM HEADER IMAGE
	 */
	 // First get the featured image, if there is one
	if ( is_singular() AND has_post_thumbnail() ) {
		$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'full');
		$image_width = $featured_image[1];
	} elseif ( is_home() AND ! is_front_page() ) {
		$home_page = get_option ( 'page_for_posts' );
		if ( $home_page ) $post = get_post( $home_page );
		if ( $post ) {
			$featured_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full');
			$image_width = $featured_image[1];
		}
	}

	// If that featured image is full-width (>1170px wide), then use it
	if ( $content_width AND $image_width >= $content_width ) {
		$image_url = $featured_image[0];
		$image_type = 'featured';

	// If custom header not already displayed (via header.php), then use it here
	} elseif ( $custom_header_location != 'header' AND get_header_image() ) {
		$image_url = get_header_image();
		$image_type = 'header';
		$image_width = get_custom_header()->width;
	} //endif $image_width

	/* 
	 * GET THE TEXT TO DISPLAY ON THE IMAGE OR CONTENT HEADER SECTION 
	 */
	 
	//var_dump ( $custom_header_location, is_front_page(), is_home(), $image_type, $featured_image ); //TEST
	
	// If header image and its already been displayed (via header.php), do nothing
	////if ( is_home() AND is_front_page() AND $custom_header_location == 'header' ) {
	//if ( $custom_header_location == 'header' AND is_front_page() AND ! $image_url ) {
	if ( $custom_header_location == 'header' AND is_front_page() AND $image_type == 'header' ) {
		// Do nothing
	
	// Otherwise, if header image, then display it with the site title and description
	//} elseif ( is_home() AND is_front_page() AND $custom_header_location != 'header' ) {
	} elseif ( $custom_header_location != 'header' AND is_front_page() AND $image_type == 'header' ) {
		$title = get_bloginfo('name');
		$subtitle = get_bloginfo('description');

	} elseif ( is_home() AND is_front_page() ) {
		// Do nothing
	
	// If home page is static and we are on the blog page
	} elseif ( is_home() AND ! is_front_page() ) {
		$home_page = get_option ( 'page_for_posts' );
		if ( $home_page ) $post = get_post( $home_page );
		if ( $post ) {
			$title = $post->post_title;
		} else {
			$title = __( 'Blog', 'flat-bootstrap' );
		}
		$subtitle = get_post_meta( $home_page, '_subtitle', $single = true );

	// Otherwise if we have a featured image, try to get text from the image
	} elseif ( $image_type == 'featured' ) {
		$attachment_post = get_post( get_post_thumbnail_id() );
		if ( $attachment_post AND ( $attachment_post->post_excerpt OR $attachment_post->post_content ) ) {
			$title = $attachment_post->post_title;
			$subtitle = $attachment_post->post_excerpt;
			$description = $attachment_post->post_content;
		} elseif ( is_front_page() ) {
			$title = get_bloginfo('name');
			$subtitle = get_bloginfo('description');
		} else {
			$title = get_the_title();
			$subtitle = get_post_meta( get_the_ID(), '_subtitle', $single = true );
		}

	} elseif ( is_post_type_archive( 'jetpack-portfolio' ) OR is_tax ( 'jetpack-portfolio-type' ) OR is_tax ( 'jetpack-portfolio-tag' ) ) {
		$title = __( 'Portfolio', 'flat-bootstrap' );

		if ( is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) ) {
			$subtitle = single_term_title( null, false );
		}

	} elseif ( is_post_type_archive( 'jetpack-testimonial' ) OR $post->post_type == 'jetpack-testimonial' ) {
		$testimonial_options = get_theme_mod( 'jetpack_testimonials' );
		if ( $testimonial_options ) { 
			$title = $testimonial_options['page-title'];
		} else {
			$title = __( 'Testimonials', 'flat-bootstrap' );
		}

		if ( !is_post_type_archive( 'jetpack-testimonial' ) AND $post->post_type == 'jetpack-testimonial' ) {
			$subtitle = get_the_title();
		}

	} elseif ( is_page() OR is_single() ) { 
		$title = get_the_title();
			
	} elseif ( is_category() ) {
		$title = single_cat_title( null, false );

	} elseif ( is_tag() ) {
		$title = single_tag_title( null, false );

	} elseif ( is_author() ) {
		// Queue the first post, that way we know what author we're dealing with
		the_post();
		$title = sprintf( __( 'Author: %s', 'flat-bootstrap' ), '<span class="vcard">' . get_the_author() . '</span>' );
		// Since we called the_post() above, we need to rewind the loop back to the beginning that way we can run the loop properly, in full.
		rewind_posts();

	} elseif ( is_search() ) {
		$title = sprintf( __( 'Search Results for: %s', 'flat-bootstrap' ), '<span>' . get_search_query() . '</span>' );

	} elseif ( is_day() ) {
		$title = sprintf( __( 'Day: %s', 'flat-bootstrap' ), '<span>' . get_the_date() . '</span>' );

	} elseif ( is_month() ) {
		$title = sprintf( __( 'Month: %s', 'flat-bootstrap' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

	} elseif ( is_year() ) {
		$title = sprintf( __( 'Year: %s', 'flat-bootstrap' ), '<span>' . get_the_date( 'Y' ) . '</span>' );
	
	} elseif ( is_tax( 'post_format', 'post-format-aside' ) ) {
		$title = __( 'Asides', 'flat-bootstrap' );

	} elseif ( is_tax( 'post_format', 'post-format-image' ) ) {
		$title = __( 'Images', 'flat-bootstrap');

	} elseif ( is_tax( 'post_format', 'post-format-video' ) ) {
		$title = __( 'Videos', 'flat-bootstrap' );

	} elseif ( is_tax( 'post_format', 'post-format-quote' ) ) {
		$title = __( 'Quotes', 'flat-bootstrap' );

	} elseif ( is_tax( 'post_format', 'post-format-link' ) ) {
		$title = __( 'Links', 'flat-bootstrap' );

	} else {
		$title = __( 'Archives', 'flat-bootstrap' );

	} //endif is_home()

	/*
	 * IF TITLE THEN GET SUBTITLE, FIRST FROM THE TERM DESCRIPTION, THEN FROM OUR CUSTOM
	 * PAGE TITLE
	 */
	if ( $title AND ! $subtitle ) {
		$subtitle = term_description();
		if ( ! $subtitle ) $subtitle = get_post_meta( get_the_ID(), '_subtitle', $single = true );
	}
		
	/* 
	 * IF WE HAVE AN IMAGE, THEN DISPLAY IT WITH THE TEXT AS AN OVERLAY 
	 */
	if ( $image_url ) :

		// Set larger image size on front page
		if ( is_front_page() ) {
			$image_class = 'cover-image';
			$overlay_class = 'cover-image-overlay';
		} else {
			$image_class = 'section-image';
			$overlay_class = 'section-image-overlay';
		}
						
		// Display the image and text
		?>
		<header class="content-header-image">
			<div class="<?php echo $image_class; ?>" style="background-image: url('<?php echo $image_url; ?>'); height:750px;">
				<div class="<?php echo $overlay_class; ?>">
				<!-- SEARCH FORM START -->
				<div id="template_searchbox">
					<div id="sb_searchformMain" class="sb_searchformClear">
					<ul class="sb_searchformToggle">
						<li class="rs_tabs first_tab rs_air_tab highlight_tab" data-tab="air"><div class="rs_product_icon highlight_img" id="iconAir"></div>Flight</li>
						<li class="rs_tabs rs_hotel_tab" data-tab="hotel"><div class="rs_product_icon highlight_img" id="iconHotel"></div>Hotel</li>
						<li class="rs_tabs rs_vp_tab" data-tab="vp"><div class="rs_product_icon" id="iconVP"></div>Vacation</li>
						<li class="rs_tabs last_tab" data-tab="car"><div class="rs_product_icon" id="iconCar"></div>Car</li>
					</ul>
					<form name="hotel" class="sb_searchformClear sb_display_none sb_form sb_searchform__hotel">
						<div class="sb_searchformRow">
							<div class='label'>Where are you going?</div>
							<input name="query" class="autosuggest sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
						</div>
						<div class="sb_searchformRow sb_searchformRow--half">
							<div class="sb_searchformInputContainer sb_date_input">
								<div class='label'>Check In</div>
								<input name="check_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformRow--half--last">
							<div class="sb_searchformInputContainer sb_date_input">
								<div class='label'>Check Out</div>
								<input name="check_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
							</div>
						</div>

						<div class='rs_mobi'>
							<div class='rs_mobi_date_container rs_mobi_in'>
								<div class='rs_mobi_title'>Check in</div>
								<div class='rs_date_chk_in'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='rs_mobi_date_container rs_mobi_out'>
								<div class='rs_mobi_title'>Check out</div>
								<div class='rs_date_chk_out'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='clear'></div>
						</div>

						<div class="sb_searchformRow">
							<div class="sb_searchformInnerRow">
								<div class='label'>Rooms</div>
								<select name="rooms" class="rooms sb_searchformSelect"></select>
							</div>
							<div class="sb_searchformInnerRow no_margin">
								<div class='label'>Guests</div>
								<select name="adults" class="adults sb_searchformSelect"></select>
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformClear">
							<label class="sb_searchformLargeLabel"> </label>
							<button type="submit" class="search sb_searchformButton">Search</button>
						</div>
						<input type="hidden" name="amenity" value="13">
					</form>
					<form name="car" class="sb_searchformClear sb_display_none sb_form sb_searchform__car">
						<div class="sb_searchformRow">
							<div class='label'>Pick Up Location</div>
							<input class="sb_searchformTextInput pickup rs_autosuggest" name="rs_pu_city" autocomplete="off"  value="Enter a City or Airport" onclick="$(this).val(&quot;&quot;);" >
						</div>
						<div id="sb_searchformCarDiff" class="sb_searchformRow sb_display_none">
							<div class='label'>Drop Off Location</div>
							<input name="rs_do_city" class="dropoff sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
						</div>
						<div class="sb_searchformRow sb_searchformRow--carCheck">
							<input name="different_return" type="checkbox" id="different_return" onclick="$('#sb_searchformCarDiff').toggle()"> 
							<label for="different_return">Return at a different location?</label>
						</div>
						<div class='rs_mobi'>
							<div class='rs_mobi_date_container rs_mobi_in'>
								<div class='rs_mobi_title'>Check in</div>
								<div class='rs_date_chk_in'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='rs_mobi_date_container rs_mobi_out'>
								<div class='rs_mobi_title'>Check out</div>
								<div class='rs_date_chk_out'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='clear'></div>
						</div>
						<div class="sb_searchform__car__dates">
							<div class="sb_searchformRow">
								<div class='label'>Pick Up Date & Time</div><br/>
								<div class="sb_searchformInputContainer sb_searchformInputContainer--car sb_date_input">
									<input name="rs_pu_date" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
								</div>
								<select name="rs_pu_time" class="rs_time_in sb_searchformSelect sb_searchformSelect--car"></select>
							</div>
							<div class="sb_searchformRow car_fix no_margin">
								<div class='label'>Drop Off Date & Time</div><br/>
								<div class="sb_searchformInputContainer sb_searchformInputContainer--car sb_date_input">
									<input name="rs_do_date" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
								</div>
								<select name="rs_do_time" class="rs_time_out sb_searchformSelect sb_searchformSelect--car"></select>
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformClear">
							<button type="submit" class="search sb_searchformButton car_submit_fix">Search</button>
						</div>
						<input type="hidden" name="amenity" value="13">
					</form>
					<form name="air" class="sb_searchformClear sb_form sb_searchform__air">
						<ul class="sb_searchformToggle flight_toggle" style="margin-bottom:5px;">
							<li class="rs_tabs2 highlight_tab2" name="sb_airToggleRadio" data-product="roundTrip" class="sb_searchformRadio" id="sb_air_round">Round-Trip</li>
							<li class="rs_tabs2" name="sb_airToggleRadio" data-product="oneWay" class="sb_searchformRadio" id="sb_air_oneway">One-way</li>
							<li class="rs_tabs2" name="sb_airToggleRadio"  class="sb_searchformRadio" id="sb_air_multi">Multi-city</li>
						</ul>
						<div id="air_round_trip" class="sb_roundTrip sb_airFormType sb_searchformClear">
							<div class="sb_searchformRow sb_searchformRow--halftop">
								<div class="sb_searchformInputContainer">
									<div class='label'>Origin</div>
									<input name="rs_o_city" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--halftop--last">
								<div class="sb_searchformInputContainer">
									<div class='label'>Destination</div>
									<input name="rs_d_city" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--half">
								<div class="sb_searchformInputContainer sb_date_input">
									<div class='label'>Depart</div>
									<input name="rs_chk_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--half--last">
								<div class="sb_searchformInputContainer sb_date_input">
									<div class='label'>Return</div>
									<input name="rs_chk_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
								</div>
							</div>
							<div class='rs_mobi'>
								<div class='rs_mobi_date_container rs_mobi_in'>
									<div class='rs_mobi_title'>Check in</div>
									<div class='rs_date_chk_in'>
										<div class='rs_mobi_chk_day'>Day</div>
										<div class='rs_mobi_chk_month'>Month</div>
									</div>
								</div>
								<div class='rs_mobi_date_container rs_mobi_out'>
									<div class='rs_mobi_title'>Check out</div>
									<div class='rs_date_chk_out'>
										<div class='rs_mobi_chk_day'>Day</div>
										<div class='rs_mobi_chk_month'>Month</div>
									</div>
								</div>
								<div class='clear'></div>
							</div>
							<div class="sb_searchformRow">
								<div class="sb_searchformInnerRow">
									<div class='label'>Adults</div>
									<select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow">
									<div class='label'>Children</div>
									<select name="rs_children" class="rs_children sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow no_margin">
									<div class='label'>Cabin Class</div>
									<select name="rs_cabin" class="rs_cabin sb_searchformSelect">
										<option value=''>Economy/Coach</option>
										<option value='Business'>Business</option>
										<option value='First'>First</option>
									</select>
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformClear">
								<label class="sb_searchformLargeLabel"> </label>
								<button type="submit" class="search sb_searchformButton">Search</button>
							</div>
						</div>
						<div id="air_one_way" class="sb_display_none sb_airFormType sb_oneWay sb_searchformClear">
							<div class="sb_searchformRow sb_searchformRow--halftop">
								<div class="sb_searchformInputContainer">
									<div class='label'>Origin</div>
									<input name="rs_o_city1" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--halftop--last">
								<div class="sb_searchformInputContainer">
									<div class='label'>Destination</div>
									<input name="rs_d_city" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--half">
								<div class="sb_searchformInputContainer sb_date_input">
									<div class='label'>Depart</div>
									<input name="rs_chk_in1" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
								</div>
							</div>
							<div class='rs_mobi'>
								<div class='rs_mobi_date_container rs_mobi_in'>
									<div class='rs_mobi_title'>Check in</div>
									<div class='rs_date_chk_in'>
										<div class='rs_mobi_chk_day'>Day</div>
										<div class='rs_mobi_chk_month'>Month</div>
									</div>
								</div>
								<div class='clear'></div>
							</div>
							<div class="sb_searchformRow">
								<div class="sb_searchformInnerRow">
									<div class='label'>Adults</div>
									<select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow">
									<div class='label'>Children</div>
									<select name="rs_children" class="rs_children sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow no_margin">
									<div class='label'>Cabin Class</div>
									<select name="rs_cabin" class="rs_cabin sb_searchformSelect">
										<option value=''>Economy/Coach</option>
										<option value='Business'>Business</option>
										<option value='First'>First</option>
									</select>
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformClear">
								<label class="sb_searchformLargeLabel"> </label>
								<button type="submit" class="search sb_searchformButton">Search</button>
							</div>
						</div>
						<div id="air_multi_dest" class="sb_display_none sb_airFormType sb_multi sb_searchformClear">
							<div class="rs_multiFlightRow sb_searchformClear">
								<div class="sb_searchformRow">
									<div class="sb_searchform__flightNumber">Flight #1</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">From</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_o_city1" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half--last">
									<label class="sb_searchformLargeLabel">To</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_d_city1" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">Departure date</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_chk_in1" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
									</div>
								</div>
							</div>
							<div class="rs_multiFlightRow sb_searchformClear">
								<div class="sb_searchformRow">
									<div class="sb_searchform__flightNumber">Flight #2</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">From</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_o_city2" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half--last">
									<label class="sb_searchformLargeLabel">To</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_d_city2" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">Departure date</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_chk_in2" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
									</div>
								</div>
							</div>
							<div class="rs_multiFlightRow sb_searchformClear sb_display_none">
								<div class="sb_searchformRow">
									<div class="sb_searchform__flightNumber">Flight #3</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">From</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_o_city3" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half--last">
									<label class="sb_searchformLargeLabel">To</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_d_city3" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">Departure date</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_chk_in3" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
									</div>
								</div>
							</div>
							<div class="rs_multiFlightRow sb_searchformClear sb_display_none">
								<div class="sb_searchformRow">
									<div class="sb_searchform__flightNumber">Flight #4</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">From</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_o_city4" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half--last">
									<label class="sb_searchformLargeLabel">To</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_d_city4" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">Departure date</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_chk_in4" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
									</div>
								</div>
							</div>
							<div class="rs_multiFlightRow sb_searchformClear sb_display_none">
								<div class="sb_searchformRow">
									<div class="sb_searchform__flightNumber">Flight #5</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">From</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_o_city5" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half--last">
									<label class="sb_searchformLargeLabel">To</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_d_city5" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
									</div>
								</div>
								<div class="sb_searchformRow sb_searchformRow--half">
									<label class="sb_searchformLargeLabel">Departure date</label>
									<div class="sb_searchformInputContainer">
										<input name="rs_chk_in5" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
									</div>
								</div>
							</div>
							<div class="sb_searchformRow">
								<span><span class="sb_multiToggleIcon" data-multi_button="add">+</span></span> <span><span class="sb_multiToggleIcon" data-multi_button="remove">-</span></span>
							</div>
							<div class="sb_searchformRow sb_searchformRow--threeQuarters">
								<div class="sb_searchformInnerRow">
									<label class="sb_searchformLargeLabel">Adults:</label>
									<select name="rs_adults" class="rs_adults sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow">
									<label class="sb_searchformLargeLabel">Children:</label>
									<select name="rs_children" class="rs_children sb_searchformSelect"></select>
								</div>
								<div class="sb_searchformInnerRow">
									<label class="sb_searchformLargeLabel">Cabin Class:</label>
									<select name="rs_cabin" class="sb_searchformSelect">
										<option value=''>Economy/Coach</option>
										<option value='Business'>Business</option>
										<option value='First'>First</option>
									</select>
								</div>
							</div>
							<div class="sb_searchformRow sb_searchformRow--oneQuarter--last sb_searchformClear">
								<label class="sb_searchformLargeLabel"> </label>
								<button type="submit" class="search sb_searchformButton">Search</button>
							</div>
						</div>
						<input type="hidden" name="amenity" value="13">
					</form>
					<form name="vp" class="sb_searchformClear sb_display_none sb_form sb_searchform__vp">
						<div class="sb_searchformRow sb_searchformRow--halftop">
							<div class="sb_searchformInputContainer">
								<div class='label'>Origin</div>
								<input name="rs_o_city" class="from sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformRow--halftop--last">
							<div class="sb_searchformInputContainer">
								<div class='label'>Destination</div>
								<input name="rs_d_city" class="to sb_searchformTextInput" value="Enter a City or Airport" onclick="$(this).val('')" autocomplete="off">
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformRow--half">
							<div class="sb_searchformInputContainer sb_date_input">
								<div class='label'>Check In</div>
								<input name="rs_chk_in" class="rs_chk_in sb_searchformTextInput" value="mm/dd/yyyy">
							</div>
						</div>
						<div class="sb_searchformRow sb_searchformRow--half--last">
							<div class="sb_searchformInputContainer sb_date_input">
								<div class='label'>Check Out</div>
								<input name="rs_chk_out" class="rs_chk_out sb_searchformTextInput" value="mm/dd/yyyy">
							</div>
						</div>
						<div class='rs_mobi'>
							<div class='rs_mobi_date_container rs_mobi_in'>
								<div class='rs_mobi_title'>Check in</div>
								<div class='rs_date_chk_in'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='rs_mobi_date_container rs_mobi_out'>
								<div class='rs_mobi_title'>Check out</div>
								<div class='rs_date_chk_out'>
									<div class='rs_mobi_chk_day'>Day</div>
									<div class='rs_mobi_chk_month'>Month</div>
								</div>
							</div>
							<div class='clear'></div>
						</div>
						 <div class="sb_searchformRow">
							<div class="sb_searchformInnerRow">
								<div class='label'>Adults</div>
								<select name="rs_adults" class="rs_adults_input sb_searchformSelect"></select>
							</div>
							<div class="sb_searchformInnerRow">
								<div class='label'>Children</div>
								<select name="rs_children" class="rs_child_input sb_searchformSelect"></select>
							</div>
							<div class="sb_searchformInnerRow no_margin">
								<div class='label'>Rooms</div>
								<select name="rs_rooms" class="rooms sb_searchformSelect"></select>
							</div>
							<div id="childrens_ages"></div>
						</div>
						<div class="sb_searchformRow sb_searchformClear">
							<label class="sb_searchformLargeLabel"> </label>
							<button type="submit" class="search sb_searchformButton">Search</button>
						</div>
						<input type="hidden" name="amenity" value="13">
					</form>
				</div>
			</div>

			<script type="text/javascript">
				$(document).ready(function() {
					$(".rs_tabs").on("click", function(){
						var futureTab = $(this).data("tab"),
							$selectedForm = $(".sb_searchform__"+futureTab);
						if ($selectedForm.hasClass("sb_display_none")) {
							$selectedForm.removeClass('sb_display_none').siblings("form").addClass("sb_display_none");
						}
					});
				});
			</script>
				
				<!-- SEARCH FORM END -->
				
				</div><!-- .cover-image-overlay or .section-image-overlay -->
			</div><!-- .cover-image or .section-image -->
		</header><!-- content-header-image -->

	<?php
	/* 
	 * IF NO IMAGE, THEN DISPLAY TEXT IN CONTENT HEADER 
	 */

	elseif ( $title ) :
	?>
		<header class="content-header">
		<div class="container">
		<h1 class="page-title"><?php echo $title; ?> test</h1>
		<?php if ( $subtitle ) printf( '<h3 class="page-subtitle taxonomy-description">%s</h3>', $subtitle ); ?>
		</div>
		</header>

	<?php endif; // $image_url ?>

<?php endif; // have_posts() ?>

<a id="pagetop"></a>

<?php 
/** 
 * DISPLAY THE PAGE TOP (AFTER HEADER) WIDGET AREA
 */
get_sidebar( 'pagetop' );