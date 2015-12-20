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
        <div class="row hotel-header">
        	<div class="col-sm-3 h_img">
        		THUMB
        	</div>
        	<div class="col-sm-9 h_header">
        		<h1 class="hotel-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
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
			</div>
			</div>

        	
   </div>
	
</article><!-- #post-## -->
