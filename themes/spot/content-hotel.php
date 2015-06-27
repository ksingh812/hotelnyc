<?php
/**
 * Theme: Flat Bootstrap
 * 
 * The template used for displaying page content in page.php
 *
 * @package flat-bootstrap
 */
?>

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
        <div class="row">
        	<div class="col-sm-3 h_img">
        		<?php the_post_thumbnail(); 
        			//echo $hotel_thumbnail;
        			if (!empty($hotel_thumbnail)) : $imgurl = $hotel_thumbnail; endif;
					echo '<img src="'.$imgurl.'" style="width:100%; height:auto;""/>';
        		?>
        		
        	</div>
        	<div class="col-sm-9 h_header">
        		<h1><?php the_title(); ?>
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
        			<div class"checkavailablity">
        				<a href="http://tickets.airtkt.net/hotels/hotel/?refid=5436&hotel_id=<?php echo $hotelid_ppn; ?>" target="_blank" class="btn btn-primary">CHECK AVAILBILITY</a>
        			</div>
        		<?php the_content(); ?>
        		<div class="hote_info">
        		<?php
        			//Additional Info about hotel
        			
        			if(!empty($room_count)): echo '<strong>Total Number of Rooms:</strong> '. $room_count; endif;
        			
					echo '<h3>Hotel Amenities</h3>';
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
        		<div class="googlemap">
					 <script src="https://maps.googleapis.com/maps/api/js"></script>
					<div id="map_canvas" style="width: 500px;height: 400px;"></div>
					<script>
					   var image = 'images/beachflag.png';
					    function initialize() {
						  var myLatlng = new google.maps.LatLng(<?php echo json_encode($latitude, JSON_NUMERIC_CHECK ); ?>, <?php echo json_encode($longitude, JSON_NUMERIC_CHECK ); ?>);
						  var myOptions = {
							zoom: 12,
							center:myLatlng,
							mapTypeId: google.maps.MapTypeId.ROADMAP,
							icon: image
						  }
						  
						  var map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
						  var marker = new google.maps.Marker({
						    position: myLatlng,
						    title:"Hello World!"
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
        </div>

		<?php get_template_part( 'content', 'page-nav' ); ?>

		<?php edit_post_link( __( '<span class="glyphicon glyphicon-edit"></span> Edit', 'flat-bootstrap' ), '<footer class="entry-meta"><div class="edit-link">', '</div></footer>' ); ?>

	</div><!-- .entry-content -->
	
</article><!-- #post-## -->
