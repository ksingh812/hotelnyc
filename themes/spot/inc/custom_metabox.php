<?php
	/**
	 * Initialize and Add Meta Box
	 */
	function naw_add_meta_box(){
		add_meta_box('naw_meta', 'Landing Page Billboard Options', 'cd_naw_meta_landing', 'hotel', 'advanced', 'high');	  
	}

	add_action( 'add_meta_boxes', 'naw_add_meta_box' );
	
	#LANDING PAGE OPTIONS META BOX
    function cd_naw_meta_landing( $post ){
        // Get values for filling in the inputs if we have them.
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

        // Nonce to verify intention later
        wp_nonce_field( 'save_naw_meta', 'naw_nonce' );
        ?>
        <table border="0" width="100%">
			<tr>
				<td><label for="hotelid_ppn">hotelid_ppn:</label><br/><input id="hotelid_ppn" type="text" name="hotelid_ppn" value="<?php echo $hotelid_ppn;?>"></td>
			</tr>
			<tr>
				<td>
					<label for="hotel_address">hotel_address:</label><br/><input id="hotel_address" type="text" name="hotel_address" value="<?php echo $hotel_address;?>">
				</td>
				<td>
					<label for="city">city:</label><br/><input id="city" type="text" name="city" value="<?php echo $city;?>">
				</td>
				<td>
					<label for="state_code">state_code:</label><br/><input id="state_code" type="text" name="state_code" value="<?php echo $state_code;?>">
				</td>
			</tr>
			<tr>
				
				<td>
					<label for="country">country:</label><br/><input id="country" type="text" name="country" value="<?php echo $country;?>">
				</td>
				<td>
					<label for="latitude">latitude:</label><br/><input id="latitude" type="text" name="latitude" value="<?php echo $latitude;?>">
				</td>
				<td>
					<label for="longitude">longitude:</label><br/><input id="longitude" type="text" name="longitude" value="<?php echo $longitude;?>">	
				</td>
			</tr>
				<td>
					<label for="area_id">area_id:</label><br/><input id="area_id" type="text" name="area_id" value="<?php echo $area_id;?>">
				</td>
				<td>
					<label for="postal_code">postal_code:</label><br/><input id="postal_code" type="text" name="postal_code" value="<?php echo $postal_code;?>">
				</td>
				<td>
					<label for="low_rate">low_rate:</label><br/><input id="low_rate" type="text" name="low_rate" value="<?php echo $low_rate;?>">
				</td>
				
			</tr>
			<tr>
				
				
				<td>
					<label for="currency_code">currency_code:</label><br/><input id="currency_code" type="text" name="currency_code" value="<?php echo $currency_code;?>">
				</td>
				<td>
					<label for="review_rating">review_rating:</label><br/><input id="review_rating" type="text" name="review_rating" value="<?php echo $review_rating;?>">
				</td>
				<td>
					<label for="room_count">room_count:</label><br/><input id="room_count" type="text" name="room_count" value="<?php echo $room_count;?>">
				</td>
			</tr>
			<tr>
				
				
				<td>
					<label for="check_in">check_in:</label><br/><input id="check_in" type="text" name="check_in" value="<?php echo $check_in;?>">
				</td>
				<td>
					<label for="check_out">check_out:</label><br/><input id="check_out" type="text" name="check_out" value="<?php echo $check_out;?>">
				</td>
				<td>
					<label for="star_rating">star_rating:</label><br/><input id="star_rating" type="text" name="star_rating" value="<?php echo $star_rating;?>">
				</td>
			</tr>
			<tr>
				<td>
					<label for="amenity_codes">amenity_codes:</label><br/><input id="amenity_codes" type="text" name="amenity_codes" value="<?php echo $amenity_codes;?>">
				</td>
				<td>
					<label for="hotel_thumbnail">hotel_thumbnail:</label><br/><input id="hotel_thumbnail" type="text" name="hotel_thumbnail" value="<?php echo $hotel_thumbnail;?>">
				</td>
			</tr>
		</table>
		
    <?php }

#SAVE LANDING PAGE META BOX VALUES
    function cd_naw_meta_landingsave( $id ){
        if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
        if( !isset( $_POST['naw_nonce'] ) || !wp_verify_nonce( $_POST['naw_nonce'], 'save_naw_meta' ) ) return; 
        if( !current_user_can( 'edit_post' ) ) return;
        $allowed = array(
			'p' => array(),
			'a' => array( // on allow a tags
					'href' => array(), // and those anchors can only have href attribute
					'class' => array(),
					'mailto' => array(),
					),
			'br' => array(),
			'strong' => array(),
		);        
        if( isset( $_POST['hotelid_ppn'] ) )
            update_post_meta( $id, 'hotelid_ppn', $_POST['hotelid_ppn']);
		if( isset( $_POST['hotel_address'] ) )
            update_post_meta( $id, 'hotel_address', htmlspecialchars($_POST['hotel_address']));
        if( isset( $_POST['city'] ) )
            update_post_meta( $id, 'city', $_POST['city']);
        if( isset( $_POST['state_code'] ) )
            update_post_meta( $id, 'state_code', $_POST['state_code']);
		if( isset( $_POST['country'] ) )
            update_post_meta( $id, 'country', $_POST['country']);
        if( isset( $_POST['latitude'] ) )
            update_post_meta( $id, 'latitude', $_POST['latitude']);
        if( isset( $_POST['longitude'] ) )
            update_post_meta( $id, 'longitude', $_POST['longitude']);
        if( isset( $_POST['area_id'] ) )
            update_post_meta( $id, 'area_id', $_POST['area_id']);
        if( isset( $_POST['postal_code'] ) )
            update_post_meta( $id, 'postal_code', $_POST['postal_code']);
        if( isset( $_POST['star_rating'] ) )
            update_post_meta( $id, 'star_rating', $_POST['star_rating']);
        if( isset( $_POST['low_rate'] ) )
            update_post_meta( $id, 'low_rate', $_POST['low_rate']);
        if( isset( $_POST['currency_code'] ) )
            update_post_meta( $id, 'currency_code', $_POST['currency_code']);
        if( isset( $_POST['review_rating'] ) )
            update_post_meta( $id, 'review_rating', $_POST['review_rating']);
        if( isset( $_POST['room_count'] ) )
            update_post_meta( $id, 'room_count', $_POST['room_count']);
        if( isset( $_POST['check_in'] ) )
            update_post_meta( $id, 'check_in', $_POST['check_in']);
        if( isset( $_POST['check_out'] ) )
            update_post_meta( $id, 'check_out', $_POST['check_out']);
        if( isset( $_POST['star_rating'] ) )
            update_post_meta( $id, 'star_rating', $_POST['star_rating']);
        if( isset( $_POST['amenity_codes'] ) )
            update_post_meta( $id, 'amenity_codes', $_POST['amenity_codes']);
        if( isset( $_POST['hotel_thumbnail'] ) )
            update_post_meta( $id, 'hotel_thumbnail', $_POST['hotel_thumbnail']);
        
    }
    add_action( 'save_post', 'cd_naw_meta_landingsave' );
?>