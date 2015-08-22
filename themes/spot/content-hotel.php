<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The template used for displaying page content in page.php
 *
 * @package flat-bootstrap
 */
?>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/inc/SliderJQuery.js"></script>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

	<div class="entry-content">
		<?php
			$hotelid_ppn = get_post_meta( $post->ID, 'hotelid_ppn', true );

			$hotel_address = get_post_meta( $post->ID, 'hotel_address', true );
	        $city = get_post_meta( $post->ID, 'city', true );  
			$state_code = get_post_meta( $post->ID, 'state_code', true );
			$country = get_post_meta( $post->ID, 'country', true );

			$latitude = get_post_meta( $post->ID, 'latitude', true );
			$longitude = get_post_meta( $post->ID, 'longitude', true );
	        $area_id = get_post_meta( $post->ID, 'area_id', true );  
			$postal_code = get_post_meta( $post->ID, 'postal_code', true );


			$star_rating = get_post_meta( $post->ID, 'star_rating', true );
			$low_rate = get_post_meta( $post->ID, 'low_rate', true );
			$currency_code = get_post_meta( $post->ID, 'currency_code', true );
			$review_rating = get_post_meta( $post->ID, 'review_rating', true );

			$room_count = get_post_meta( $post->ID, 'room_count', true );
			$check_in = get_post_meta( $post->ID, 'check_in', true );
			$check_out = get_post_meta( $post->ID, 'check_out', true );
			$star_rating = get_post_meta($post->ID, 'star_rating', true);

			$amenity_codes = get_post_meta( $post->ID, 'amenity_codes', true );
			$hotel_thumbnail = get_post_meta($post->ID, 'hotel_thumbnail', true);
			?>
        <div class="row hotel-header">
        	<div class="col-sm-5 h_img">
        		<?php 
  					global $wpdb;
					$photos = $wpdb->get_results("select * from wp_hotels_photos where hotelid_ppn = ". $hotelid_ppn, ARRAY_A);
					//var_dump ($photos);?>
					<div>
			            <div class="NoPaddingMarging">
			                <div id="MainDiv">
				                <?php
				                	$i=0;
				                	foreach ($photos as $m)
									{
										if ($i<1)
										{
											echo '<img src="'.$m[photo_url].'" alt="'.get_the_title().'" id="MainImage"/>';
										}
										$i++;
									}
				                
				                ?>
				                <div id="child">
				                    <img id="Next" src="<?php echo get_stylesheet_directory_uri(); ?>/images/RightArrow.png" class="img-responsive NextButton"/>
				                    <img id="Previous" src="<?php echo get_stylesheet_directory_uri(); ?>/images/LeftArrow.png" class="img-responsive PreButton"/>
				                </div>
			                </div>
			                <div id="slider">
			                    <ul class="slides">
								<?php
								foreach($photos as $row)
								{
									echo '<li class="NoPaddingMarging slide"><img src="'.$row["photo_url"].'"/></li>';
								}
			        			?>
			        			</ul>
			                </div>
			            </div>
			        </div>
        	</div>
        	<div class="col-sm-7 h_header">
        		<h1 class="hotel-title"><?php the_title(); ?>
        			<?php if (!empty($star_rating)){ $star = intval($star_rating); } 
        				for ($i =0; $i<$star; $i++)
        				{
        					echo '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>&nbsp;';
        				}
        			?>
        		</h1>
    			<?php 
    				if(!empty($hotel_address)): echo '<p class="h_address small">'.$hotel_address; endif;
    				if(!empty($city)): echo ', '.$city; endif;
					if (!empty($state_code)): echo ', '.$state_code; endif;
					if (!empty($postal_code)): echo ' '.$postal_code; endif;
					if (!empty($country)): echo ', '. $country. '</p>'; endif;
					if (!empty($review_rating)): echo '<p class="small">Review Rating: <strong>'.$review_rating.'</strong> out of 10. &#09;'; endif;
					if (!empty($low_rate) && !empty($currency_code)): echo 'Low Rate: <strong>'.$low_rate.' '.$currency_code.'</strong></p>'; endif;
    			?>
        	<div id="js_enter_dates" class="rs_enter_dates rs_highlight_box rs_property__section">
	    	    <div class="rs_highlight_box__header">ENTER YOUR DATES</div>
		   		<form class="formhotel" name="hotel" action="http://tickets.airtkt.net/hotels/hotel/" method="GET">
				  <div class="rs_enter_dates__input_container rs_enter_dates__input_container--date">
			      	<input type="text" id="CheckIn" class="rs_input--u datepicker" placeholder="Check in" name="check_in" autosuggest="off" title="Enter your check in date." value="Check in">
			     </div>
			     <div class="rs_enter_dates__input_container rs_enter_dates__input_container--even rs_enter_dates__input_container--date">	
			     	<input type="text" id="CheckOut" class="rs_input--u datepicker" placeholder="Check out" name="check_out" autosuggest="off" title="Enter your check out date." value="Check out">
			     </div>
			     <div class="rs_enter_dates__input_container rs_enter_dates__input_container--select">       
			            <select id="rs_enter_dates__rooms" data-rs_ga_track="[&quot;change&quot;,[&quot;Searchbox - hotel page&quot;, &quot;Rooms&quot;]]" title="Number of Rooms" name="rooms" class="rs_select_skin_activated">
			                <option value="1" selected="selected">1 Room</option>
			                <option value="2">2 Rooms</option>
			                <option value="3">3 Rooms</option>
			                <option value="4">4 Rooms</option>
			              </select>
		          </div>
		          <div class="rs_enter_dates__input_container rs_enter_dates__input_container--even rs_enter_dates__input_container--select">
			    	<div class="rs_select_skin rs_input--u">
			            <select id="rs_enter_dates__adults" name="adults" class="rs_select_skin_activated">
			               <option value="1">1 Guest</option>
			               <option value="2" selected="selected">2 Guests</option>
			               <option value="3">3 Guests</option>
			               <option value="4">4 Guests</option>
			             </select>
			         </div>
			    </div>
			    <input type="hidden" name="hotel_id" value="<?php echo $hotelid_ppn; ?>">
			    <input type="hidden" name="refid" value="5436">
				<input type="hidden" name="varid" value="">
				<input type="hidden" name="refclickid" value="">
				<input type="hidden" name="phone_agent" value="">
				<input type="hidden" name="onrates" value="1">
				<button id="rs_enter_dates__submit" type="submit" class="rs_button">Check Availability</button>
				
			</form>
			</div>
			</div>
			</div>

        	
   </div>
   <div class="row hote-desc">
   		<div class="col-md-8 hotel-description">
        					<!-- Nav tabs -->
		  <ul class="nav nav-tabs" role="tablist">
		    <li role="presentation" class="active"><a href="#HotelDescription" aria-controls="Hotel Description" role="tab" data-toggle="tab">Hotel Description</a></li>
		    <li role="presentation"><a href="#HotelAmenities" aria-controls="Hotel Amenities" role="tab" data-toggle="tab">Hotel Amenities</a></li>
		  </ul>

		  <!-- Tab panes -->
		  <div class="tab-content">
				    <div role="tabpanel" class="tab-pane active" id="HotelDescription">
						<?php 
							the_content(); 
						?>
					</div>
				    <div role="tabpanel" class="tab-pane" id="HotelAmenities">
						<?php
							//Additional Info about hotel
							
							//if(!empty($room_count)): echo '<strong>Total Number of Rooms:</strong> '. $room_count; endif;
							
							//echo '<h3>Hotel Amenities</h3>';
							$ams = explode("^", $amenity_codes);
							//var_dump ($ams);
							
							$args = array( 'posts_per_page' => -1,'post_type' => 'amenity' );
							$myposts = get_posts( $args );
							echo '<ul class="amenities">';
							foreach ($myposts as $p)
							{
								//echo $p->post_name;
								if (in_array($p->post_name, $ams))
								{
									echo '<li>'.ucfirst($p->post_title).'</li>';
								}
							}
							echo '</ul>';
							wp_reset_postdata();
						?>
					</div>
				 </div>
		       </div>
		<div class="col-md-4">
			<div class="googlemap">
			 <script src="https://maps.googleapis.com/maps/api/js"></script>
			<div id="map_canvas" style="width: 400px;height: 400px;"></div>
			<script>
			   var image = 'http://bookhotels.nyc/wp/wp-content/themes/spot/images/hotel.png';
			   var lat = <?php echo $latitude; ?>;
			   var lon = <?php echo $longitude; ?>;
			    function initialize() {
				  var myLatlng = new google.maps.LatLng(lat, lon);
				  var myOptions = {
					zoom: 15,
					center: myLatlng,
					mapTypeId: google.maps.MapTypeId.ROADMAP,
					icon: image
				  }
				 
				  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
				  var marker = new google.maps.Marker({
				    position: myLatlng,
				    icon: image
				});
				marker.setMap(map);
				}

				function loadScript() {
				  var script = document.createElement("script");
				  script.type = "text/javascript";
				  script.src = "http://maps.google.com/maps/api/js?sensor=false&callback=initialize";
				  document.body.appendChild(script);
				  initialize();
				}

				window.onload = loadScript;
			</script>
			</div>
		</div>
	</div>

		<?php get_template_part( 'content', 'page-nav' ); ?>

		<?php edit_post_link( __( '<span class="glyphicon glyphicon-edit"></span> Edit', 'flat-bootstrap' ), '<footer class="entry-meta"><div class="edit-link">', '</div></footer>' ); ?>

	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
