<?php
	##################################################################################################################################
	#### Testimonial Shortcode ####

	// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
	add_shortcode( 'testimonial', 'naw_testimonial_shortcode' );
	function naw_testimonial_shortcode( $atts ) {
		ob_start();
		
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'postid' => '',
			'type' => 'testimonial',
			'order' => '',
			'orderby' => '',
			'posts' => 1,
			'category' => '',
			'tag'=> '',
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'p' => $postid,
			'post_type' => $type,
			'order' => $order,
			'orderby' => $orderby,
			'posts_per_page' => $posts+1,
			'category_name' => $category,
			'tag->name' => $tag,
		);
		$query = new WP_Query( $options );
		global $post;
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			<div class="media">
				
				   <?php while ( $query->have_posts() ) : $query->the_post(); ?>
							<?php
							//echo $tag;
							$tags = wp_get_post_tags($post->ID);
							foreach ($tags as $posttag)
							{
								//echo $posttag->name;
								if (strcasecmp($posttag->name, $tag) == 0)
								{
							?>
										<?php if (has_post_thumbnail( $post->ID ) ): ?>
										<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); ?>
										
										<img class="media-object pull-left" src="<?php echo $image[0]; ?>" alt="<?php echo get_the_title( $post->ID ); ?>">
									  <?php endif; ?>
									<div class="media-body">
										<div class="media-heading"><?php //global $more;    // Declare global $more (before the loop).
																		//$more = 0;       // Set (inside the loop) to display content above the more tag.
																the_content(); ?>
										</div>
									</div>
								<?php
								}
							}?>
					<?php endwhile; ?>
				
				<?php wp_reset_query(); ?>
			</div>
		<?php
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	}

	//[testimonial tag='sage hrms' posts='1']
	########################################################################################################################
	###### Posts Shortcodes ######
	
	// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
	add_shortcode( 'list-posts', 'naw_post_shortcode' );
	function naw_post_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'post',
			'posts' => 1,
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'posts_per_page' => $posts,
		);
		$query = new WP_Query( $options );
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			<ul class="box">
			   <?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<li style="list-style:none; line-height:2;"><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
				<?php endwhile; ?>
			</ul>
		<?php
			$output = ob_get_clean();
			return $output;
		}
	}
	//[list-posts type="press" posts="5"]
	##########################################################################################
	##### Actions Shortcode #####

	add_shortcode( 'add_actions', 'naw_action_shortcode' );
	function naw_action_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'calltoaction',
			'order' => 'date',
			'orderby' => 'title',
			'posts' => -1,
			'category' => '',
			'tag' => '',
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'order' => $order,
			'orderby' => $orderby,
			'posts_per_page' => $posts,
			'category_name' => $category,
			'tag' => $tag,
		);
		$query = new WP_Query( $options );
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			<div class="panel panel-default">
				
				   <?php while ( $query->have_posts() ) : $query->the_post(); ?>
		   
				   <div class="panel-heading">
							<h2 class="panel-title"> <?php the_title();?></h2>
						</div>
						<div class="panel-collapse">
							<div class="panel-body">
								<?php the_content(); ?>
							</div>
						</div>
		<?php endwhile; ?>
			</div>
		<?php
			$output = ob_get_clean();
			return $output;
		}
	}
	#########################################################################################################
	##### Quote #####
	function naw_shortcode_quote( $atts, $content = null ) {
	// [quote quote_footer="Author Name"] Content [/quote]
		extract(shortcode_atts(array(
		"quote_footer" => 'Author Name',
		), $atts));
	
		$return = '<blockquote>'. do_shortcode($content);
		$return .= '<footer>' .$quote_footer. '</footer></blockquote>';
		return $return;
	}
	add_shortcode('quote', 'naw_shortcode_quote');
	
	#############################################################################################################
	##### Link Button ######
	function naw_shortcode_button( $atts, $content = null ) {
	// [linkbutton type='primary' link="#" size="btn-sm,btn-lg,btn-xs"] Download [/linkbutton]
		extract(shortcode_atts(array(
		"type" => 'primary',
		"link" => '#',
		"size" => 'btn-sm'
		), $atts));
		return '<a class="btn btn-'.$type.' ' .$size.'" href="'.$link.'" role="button">' . do_shortcode($content) . '</a>';
	
	}
	add_shortcode('linkbutton', 'naw_shortcode_button');
	
	#############################################################################################################
	##### PDF Icon 32px ######
	add_shortcode('pdficon', 'naw_shortcode_pdficon');
	function naw_shortcode_pdficon( $atts) {
	// [pdficon link="#" align='left']
		ob_start();
		extract(shortcode_atts(array(
		"link" => '#',
		"align"=> 'left'
		), $atts));
		return '<a href="'.$link.'" class="pdflink" target="_blank" style="margin-right: 10px;"><img class="size-full wp-image-1949 pdf-icon" alt="pdf-icon32" src="/uploads/2015/01/pdf_icon32.png" width="32" height="32" /></a>';
	$myvariable = ob_get_clean();
			return $myvariable;
	
	}
	
	#############################################################################################################
	##### PDF Icon 18px ######
	add_shortcode('pdficon18', 'naw_shortcode_pdficon18');
	function naw_shortcode_pdficon18( $atts) {
	// [pdficon18 link="#" align='left']
		ob_start();
		extract(shortcode_atts(array(
		"link" => '#',
		"align"=> 'left'
		), $atts));
		return '<a href="'.$link.'" class="pdflink" target="_blank"><img class="size-full wp-image-1949 pdf-icon" alt="pdf-icon18" src="/uploads/2015/01/pdf_icon18.png" width="18" height="18" /></a>';
	$myvariable = ob_get_clean();
			return $myvariable;
	
	}
#############################################################################################################
##### Webinars Shortcode ######	
	add_shortcode( 'webinars', 'naw_webinars_shortcode' );
	function naw_webinars_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'product',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts' => -1,
			'category' => '',
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $posts,
			'category_name' => $category,
		);
		$pgtitle = get_post( $post )->post_title;
		$query = new WP_Query( $options );?>
		<table width='100%'>
		<?php if ( $query->have_posts() ) { 
			 while ( $query->have_posts() ) : $query->the_post(); 
				$tags_obj = wp_get_post_tags(get_the_ID());
				foreach($tags_obj as $tagA)				
				{
					$tag_name = $tagA->name;
					//compare tags with page title and exclude first one
					if(strcasecmp($tagA->name, $pgtitle) == 0)
					{
				?>
				<tr style = "border-bottom:1px solid #bdbdbd;">
					<?php	
					$nawdate = get_post_meta( get_the_ID(), '_cd_naw_date', true );
					$nawtime_s = get_post_meta( get_the_ID(), '_cd_naw_start_time', true );
					$nawtime_e = get_post_meta( get_the_ID(), '_cd_naw_end_time', true );
					echo '<td width=25%>';
						echo $nawdate .'</br>' .$nawtime_s. '-'.$nawtime_e;
					echo '</td>';
					echo '<td width=75%>';
						the_title();
						$poslink=get_permalink(get_the_ID());
						echo '<br/><a href=' . $poslink .'>Learn More/Register</a>';
					echo '</td>';
						?>
				</tr>
				
			<?php }
				}
			endwhile;?>
		</table>
			<?php wp_reset_query(); ?>
		
		   <?php
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	}
#############################################################################################################
##### Success Shortcode ######	
	add_shortcode( 'success', 'naw_success_shortcode' );
	function naw_success_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'success_story',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts' => 5,
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $posts,
		);
		$pgtitle = get_post( $post )->post_title;
		$query = new WP_Query( $options );?>
		<ul>
		<?php if ( $query->have_posts() ) { 
			 while ( $query->have_posts() ) : $query->the_post(); 
				$tags_obj = wp_get_post_tags(get_the_ID());
				foreach($tags_obj as $tagA)				
				{
					$tag_name = $tagA->name;
					//compare tags with page title
					if(strcasecmp($tagA->name, $pgtitle) == 0)
					{
				?>
				<li style = "border-bottom:1px solid #bdbdbd;">
					<?php	
						the_title();
						$poslink=get_permalink(get_the_ID());
						echo '<br/><a href=' . $poslink .'>Read more...</a>';
					?>
				</li>
				
			<?php }
				}
			endwhile;?>
		</ul>
			<?php wp_reset_query(); ?>
		
		   <?php
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	}

#############################################################################################################
########################### Newsletter Shortcode ############################################################
	add_shortcode( 'newsletter', 'naw_newsletter_shortcode' );
	function naw_newsletter_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'mailings',
			'orderby' => 'date',
			'order' => 'DESC',
			'posts' => 5,
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'orderby' => $orderby,
			'order' => $order,
			'posts_per_page' => $posts,
		);
		$pgtitle = get_post( $post )->post_title;
		$query = new WP_Query( $options );?>
		<ul>
		<?php if ( $query->have_posts() ) { 
			 while ( $query->have_posts() ) : $query->the_post(); 
				$tags_obj = wp_get_post_tags(get_the_ID());
				foreach($tags_obj as $tagA)				
				{
					$tag_name = $tagA->name;
					//compare tags with page title
					if(strcasecmp($tagA->name, $pgtitle) == 0)
					{
				?>
				<li style = "border-bottom:1px solid #bdbdbd;">
					<?php	
						the_title();
						$poslink=get_permalink(get_the_ID());
						echo '<br/><a href=' . $poslink .'>Read more...</a>';
					?>
				</li>
				
			<?php }
				}
			endwhile;?>
		</ul>
			<?php wp_reset_query(); ?>
		
		   <?php
			$myvariable = ob_get_clean();
			return $myvariable;
		}
	}


#############################################################################################################
##### Tabs Shortcode ######	
	function naw_shortcode_tabs($atts, $content = null) {
	// [tabs style=""]  [tab title="TAB_NAME"] CONTENT [/tab]  [tab title="TAB_NAME"] CONTENT [/tab]  [tab title="TAB_NAME"] CONTENT [/tab][/tabs]

      if (isset($GLOBALS['tabs_count'])) $GLOBALS['tabs_count']++;
      else $GLOBALS['tabs_count'] = 0;
      extract(shortcode_atts(array(
          'tabtype' => 'nav-tabs',
          'style' => 'style1',
          'tabdirection' => '', ), $atts));

      preg_match_all('/tab title="([^\"]+)"/i', $content, $matches, PREG_OFFSET_CAPTURE);

      $tab_titles = array();
      if (isset($matches[1])) {
          $tab_titles = $matches[1];
      }

      $output = '';

      if (count($tab_titles)) {
          $output .= '<div class="tabbable tabs_'.$style.' tabs-'.$tabdirection.'"><ul class="nav '.$tabtype.'" id="custom-tabs-'.rand(1, 100).'">';

          $i = 0;
          foreach($tab_titles as $tab) {
              if ($i == 0) $output .= '<li class="active">';
              else $output .= '<li>';

              $output .= '<a href="#custom-tab-'.$GLOBALS['tabs_count'].'-'.sanitize_title($tab[0]).'"  data-toggle="tab">'.$tab[0].'</a></li>';
              $i++;
          }

          $output .= '</ul>';
          $output .= '<div class="tab-content">';
          $output .= do_shortcode($content);
          $output .= '</div></div>';
      } else {
          $output .= do_shortcode($content);
      }

      return $output;
  }

  function naw_shortcode_tab($atts, $content = null) {

      if (!isset($GLOBALS['current_tabs'])) {
          $GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
          $state = 'active';
      } else {

          if ($GLOBALS['current_tabs'] == $GLOBALS['tabs_count']) {
              $state = '';
          } else {
              $GLOBALS['current_tabs'] = $GLOBALS['tabs_count'];
              $state = 'active';
          }
      }

      $defaults = array('title' => 'Tab');
      extract(shortcode_atts($defaults, $atts));
      return '<div id="custom-tab-'.$GLOBALS['tabs_count'].'-'.sanitize_title($title).'" class="tab-pane '.$state.'">'.do_shortcode($content).'</div>';
  }

  add_shortcode('tabs', 'naw_shortcode_tabs');
  add_shortcode('tab', 'naw_shortcode_tab');

#############################################################################################################
##### Separator ######	
add_shortcode('separator', 'naw_shortcode_separator');
function naw_shortcode_separator( $atts) {
	// [separator]
	return '<hr>';
	
}
  
#############################################################################################################
##### Demo Icon ######
	add_shortcode('demo', 'naw_shortcode_demo');
	function naw_shortcode_demo( $atts) {
	// [demo link="#" title='Title' position='top or left']
		$myvariable = '<span class="glyphicon glyphicon-facetime-video shortcode-glyph"></span>';
			return $myvariable;
	}
#############################################################################################################
##### Contact Icon ######
	add_shortcode('contact', 'naw_shortcode_contact');
	function naw_shortcode_contact( $atts) {
	// [contact link="#" title='Title' position='top or left']
		$myvariable = '<span class="glyphicon glyphicon-envelope shortcode-glyph"></span>';
			return $myvariable;
	
	}
  
#############################################################################################################
##### Contact Icon ######
	add_shortcode('support', 'naw_shortcode_support');
	function naw_shortcode_support( $atts) {
	// [support link="#" title='Title' position='top or left']
		$myvariable = '<span class="glyphicon glyphicon-user shortcode-glyph"></span>';
			return $myvariable;
	}

#############################################################################################################
##### Email Icon ######
	add_shortcode('email', 'naw_shortcode_email');
	function naw_shortcode_email( $atts) {
	// [email]
		$myvariable = '<span class="glyphicon glyphicon-envelope shortcode-glyph"></span>';
			return $myvariable;
	
	}
#############################################################################################################
##### Phone Icon ######
	add_shortcode('phone', 'naw_shortcode_phone');
	function naw_shortcode_phone( $atts) {
	// [phone link="#" title='Title' position='top or left']
		$myvariable = '<span class="glyphicon glyphicon-earphone shortcode-glyph"></span>';
			return $myvariable;
	
	}
#############################################################################################################
##### ROW ######	
add_shortcode('row', 'naw_shortcode_row');
function naw_shortcode_row( $atts, $content = null ) {
	// [row]Content[/row]
	  extract(shortcode_atts(array(
		"id" => '',
		), $atts));
	return '<div class="row" id="' . $id .'">'.do_shortcode($content).'</div>';
	
}	
#############################################################################################################
##### One Half Column ######	
add_shortcode('one_half_column', 'naw_shortcode_two_columns');
function naw_shortcode_two_columns( $atts, $content = null ) {
	// [one_half_column]Content[/one_half_column]
	extract(shortcode_atts(array(
		"id" => '',
		), $atts));  
	return '<div class="col-sm-6 col-xs-12" id="' .$id. '">'.do_shortcode($content).'</div>';
	
}
#############################################################################################################
##### One Third Column ######	
function naw_shortcode_three_columns( $atts, $content = null ) {
	// [one_third_column] Content [/one_third_column]
	extract(shortcode_atts(array(
		"id" => '',
		), $atts));  	  
	return '<div class="col-sm-4 col-xs-12" id="' .$id. '">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('one_third_column', 'naw_shortcode_three_columns');

#############################################################################################################
##### 1/4 Column ######
function naw_shortcode_one_fourth_columns( $atts, $content = null ) {
	// [one_fourth_column] Content [/one_fourth_column]
	extract(shortcode_atts(array(
		"id" => '',
		), $atts));  	  
	return '<div class="col-sm-3 col-xs-12" id="' .$id. '">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('one_fourth_column', 'naw_shortcode_one_fourth_columns');
#############################################################################################################
##### 2/3 Column ######
function naw_shortcode_two_third_columns( $atts, $content = null ) {
	// [two_third_column] Content [/two_third_column]
	extract(shortcode_atts(array(
		"id" => '',
		), $atts));  	  
	return '<div class="col-sm-8 col-xs-12" id="' .$id. '">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('two_third_column', 'naw_shortcode_two_third_columns');
#############################################################################################################
##### 3/4 Column ######
function naw_shortcode_three_fourth_columns( $atts, $content = null ) {
	// [three_fourth_column] Content [/three_fourth_column]
	extract(shortcode_atts(array(
		"id" => '',
		), $atts));  
	return '<div class="col-sm-9 col-xs-12" id="' .$id. '">' . do_shortcode($content) . '</div>';
}
add_shortcode('three_fourth_column', 'naw_shortcode_three_fourth_columns');

#############################################################################################################
##### Whitepaper Content Shortcode ######
function naw_shortcode_whitepaper_column( $atts, $content = null ) {
	// [whitepaper] Content [/whitepaper]
		  
	return '<div class="col-sm-8 col-xs-12 whitepaper-content">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('whitepaper', 'naw_shortcode_whitepaper_column');

#############################################################################################################
##### Form Sidebar ######	
function naw_shortcode_form_column( $atts, $content = null ) {
	// [form] Content [/form]
		  
	return '<div class="col-sm-4 col-xs-12" id="form-sidebar">' . do_shortcode($content) . '</div>';
	
}
add_shortcode('form', 'naw_shortcode_form_column');

#############################################################################################################
##### Webcast Sidebar ######	
function naw_shortcode_webcast_column( $atts, $content = null ) {
	// [webcast-sidebar] Content [/webcast-sidebar]
		  
	return '<div class="col-sm-4 col-xs-12" id="form-sidebar"><div id="live-webinar-sidebar-wrapper">' . do_shortcode($content) . '</div></div>';
	
}
add_shortcode('webcast-sidebar', 'naw_shortcode_webcast_column');

#############################################################################################################
##### ROW ######	
add_shortcode('whitepaper-footer', 'naw_shortcode_whitepaper_footer');
function naw_shortcode_whitepaper_footer( $atts, $content = null ) {
	// [whitepaper-footer]Content[/whitepaper-footer]
	  
	return '<div class="col-xs-12" id="whitepaper_footer">'.do_shortcode($content).'</div>';
	
}


#########################################################################################################
##### Header Slider #####
	function naw_shortcode_slider( $atts) {
	// [slider title='Author Name' subtitle='Title of the Author' link='']
		extract(shortcode_atts(array(
		"title" => 'SERVICE TITLE',
		"subtitle" => 'Service Sub-Title',
		"link" =>'#'
		), $atts));
	
		$return = '<div class="page-custom-hero jumbotron" id="web-solutions-hero">
					<div class="container">
						<h2 class="hero-title">'.$title.'</h2><p>&nbsp;</p>
						<p class="hero-content">'.$subtitle. '</p><p>&nbsp;</p>
						<p class="hero-content"><a href="'.$link.'" class="btn btn-primary btn-lg">Learn More <span class="glyphicon glyphicon-chevron-right triggered"></span></a></p><p>&nbsp;</p>
					</div>
				</div>';
		return $return;
	}
	add_shortcode('slider', 'naw_shortcode_slider');

#########################################################################################################
##### Four Column Glyphbox #####
	function naw_shortcode_fourth_glyphbox( $atts, $content = null) {
	// [one_fourth_glyphbox icon='icon-console' title='TITLE' link='#'] CONTENT [/one_fourth_glyphbox]
		extract(shortcode_atts(array(
		"icon" => 'icon icon-console',
		"title" => 'TITLE',
		"link" =>'#'
		), $atts));
	
		$return = '<div class="col-xs-12 col-sm-6 col-md-3 section-content-glyphbox">
					<a href="'. $link . '"><span class="' . $icon .' glyph-lg"></span>
					<h4>' . $title .'</h4></a>
					<p>' . do_shortcode($content) .'</p>
				</div>';
		return $return;
	}
	add_shortcode('one_fourth_glyphbox', 'naw_shortcode_fourth_glyphbox');
	
#########################################################################################################
##### Three Column Glyphbox #####
	function naw_shortcode_third_glyphbox( $atts, $content = null) {
	// [one_third_glyphbox icon='icon-console' title='TITLE' link='#'] CONTENT [/one_third_glyphbox]
		extract(shortcode_atts(array(
		"icon" => 'icon icon-console',
		"title" => 'TITLE',
		"link" =>'#'
		), $atts));
	
		$return = '<div class="col-xs-12 col-sm-4 section-content-glyphbox">
					<a href="'. $link . '"><span class="' . $icon .' glyph-lg"></span>
					<h4>' . $title .'</h4></a>
					<p>' . do_shortcode($content) .'</p>
				</div>';
		return $return;
	}
	add_shortcode('one_third_glyphbox', 'naw_shortcode_third_glyphbox');

#########################################################################################################
##### Page Section #####
	function naw_shortcode_page_section( $atts, $content = null) {
	// [page_section id='icon-console' class='text-center' title='TITLE'] CONTENT [/page_section]
		extract(shortcode_atts(array(
		"id" => '',
		"class" => '',
		"title" => 'TITLE',
		), $atts));
		$return = '<div class="page-section '.$class.'"><h3 id="' .$id. '" class="page-section-title">'.$title.'</h3>'. do_shortcode($content) .'</div>';
		return $return;
	}
	add_shortcode('page_section', 'naw_shortcode_page_section');

/** CAROUSEL START ---
-------------------**/
	#########################################################################################################
	##### Carousel Wrapper #####
	function naw_shortcode_carousel( $atts, $content = null) {
	// [carousel slides='3'] CONTENT [/carousel]
		extract(shortcode_atts(array(
		"slides" => 3,
		"id" => 'myCarousel'
		), $atts));
	
		$return = '<div id="'. $id .'" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators"><li data-target="#'. $id .'" data-slide-to="0" class="active"></li>';
					$i=1;
				for ($i=1; $i<$slides; $i++)
				{
					$return.='<li data-target="#'. $id .'" data-slide-to="' . $i .'"></li>';
				}
				$return .= '</ol>' . do_shortcode($content);
				$return .= '<a class="left carousel-control" href="#'. $id .'" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a><a class="right carousel-control" href="#'. $id .'" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a></div>';
		return $return;
	}
	add_shortcode('carousel', 'naw_shortcode_carousel');

	#########################################################################################################
	##### Carousel Inner #####
	function naw_shortcode_inner( $atts, $content = null ) {
		// [carousel-inner] Content [/carousel-inner]
			  
		return '<div class="carousel-inner">' . do_shortcode($content) . '</div>';
		
	}
	add_shortcode('carousel-inner', 'naw_shortcode_inner');
		
	#########################################################################################################
	##### Carousel Item #####
	function naw_shortcode_item( $atts, $content = null) {
	// [carousel-item class='active' image='http://placehold.it/1920x1200&text=+' caption='Slide Caption'] CONTENT [/carousel-item]
		extract(shortcode_atts(array(
		"class" => '',
		"image" => 'http://placehold.it/1920x500&text=+',
		"caption" => 'Slide Caption',
		), $atts));
	
		$return = '<div class="item '. $class . '"> <img src="'. $image . '" alt="Slide">
		  <div class="container">
			<div class="carousel-caption">
			  <h1>' . $caption . '</h1>' . do_shortcode($content) . '
			</div>
		  </div>
		</div>';
		return $return;
	}
	add_shortcode('carousel-item', 'naw_shortcode_item');
/** CAROUSEL END -----
-------------------**/
#############################################################################################################
##### ROW-BLOCK ######	
add_shortcode('rowblock', 'naw_shortcode_row_block');
function naw_shortcode_row_block( $atts, $content = null ) {
	// [rowblock]Content[/rowblock]
	  
	return '<div class="row isotope">'.do_shortcode($content).'</div>';
	
}


########################################################################################################################
###### Postblock Shortcodes ######
	
	// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
	add_shortcode( 'postblock', 'naw_post_block_shortcode' );
	function naw_post_block_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'post',
			'posts' => 1,
			'postid' => '',
			'heading' =>''
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'posts_per_page' => $posts,
			'p' => $postid
		);
		$query = new WP_Query( $options );
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			   <?php while ( $query->have_posts() ) : $query->the_post(); ?>
					<div class=" col-md-4 col-sm-6 col-xs-12 archive-row-item">
						
				<article id="post-<?php the_ID(); ?>" <?php post_class('clearfix box'); ?> role="article">
					<header>
						<?php if (!$heading=='') { ?>
						<div class="item-heading">
							<?php echo $heading ?>
						</div>
						<?php } ?>
						<div class="item-img">
							<?php if(has_post_thumbnail()): ?><a href="<?php the_permalink(); ?>" title="<?php the_title(); ?>"><?php the_post_thumbnail('',array('class' => "attachment-$size img-responsive")); ?></a><?php endif; ?>
						</div>
						<?php 
						if ($type == 'calltoaction')
						{
						?>
							<div class="item-content">
										<h4><?php the_content(); ?></h4>
							</div>
						<?php
						}
						else
						{
						?>
							<div class="item-content">
								<h4><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
							</div>
								
							</header> <!-- end article header -->
						
							<section class="post_content">
								<?php the_excerpt(); ?>
							</section> <!-- end article section -->
						<?php } ?>
				</article> <!-- end article -->
			</div>
				<?php endwhile; ?>
		<?php
			$output = ob_get_clean();
			return $output;
		}
	}
	//[postblock type="press" posts="1"]

########################################################################################################################
###### Accordions Shortcodes ######
	function naw_shortcode_accordions( $atts, $content = null) {
	// [accordions] CONTENT [/accordions]
		extract(shortcode_atts(array(
		"class" => 'custom-class',
		), $atts));
		$id = get_the_ID();
		$return = '<div class="' .$class. ' panel-group '. $id . '" id="accordion">' . do_shortcode($content) . '</div>';
		return $return;
	}
	add_shortcode('accordions', 'naw_shortcode_accordions');
	
	function naw_shortcode_accordion( $atts, $content = null) {
	// [accordion] CONTENT [/accordion]

		extract(shortcode_atts(array(
		"title" => 'Accordion Title',
		"default" => false,
		), $atts));
		
		$titleslug = str_replace(" ", "_", $title);
		
		$return = '<div class="panel panel-default">';
		$return .=	'<div class="panel-heading">
					  <h4 class="panel-title">
						<a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#'. preg_replace('/[^A-Za-z0-9\-]/','',$titleslug) .'">'
						 . $title .'</a> </h4>
					</div>
					<div id="'.preg_replace('/[^A-Za-z0-9\-]/','',$titleslug).'" class="panel-collapse ';
					if ($default)
					{
						$return .= 'collapse in">';
					}
					else
					{
						$return .='collapse">';
					}
					
				$return .= '<div class="panel-body">'
						. do_shortcode($content) .
					 '</div></div></div>';
		return $return;
	}
	add_shortcode('accordion', 'naw_shortcode_accordion');
##########################################################################################
##### Tab Shortcode #####
	/*function naw_tab_shortcode( $atts, $content = null ){
		return '<div class="tab">'.do_shortcode($content).'</div>';
	}
	add_shortcode( 'tab', 'naw_tab_shortcode');
	

	//[tabtitle title="tab1,tab2,tab3,"]
	function naw_tabtitle_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			"title" => 'title',
			"tag" => 'tag'
			), $atts ));

		$titleArray = explode(",", $title);
		$tagArray = explode(",", $tag);
		$result ='<ul class="nav nav-tabs" role="tablist">';  		
		foreach( $titleArray as $index => $title){
			$class="";
			if($index == 0) $class = "active";
			$result .='<li class="'.$class.'"><a href="#'.$tagArray[$index].'" role="tab" data-toggle="tab">'.$title.'</a></li>';
		}
		return $result."</ul>";
	}
	add_shortcode( 'tabtitle', 'naw_tabtitle_shortcode' );
	

	//[tabcontent tag="tab1"]
	function naw_tabcontent_shortcode( $atts, $content = null ){
		extract( shortcode_atts( array(
			"tag" => tag,
			"active" => ""
			), $atts ));
		$result = '<div class="tab-pane '.$active.'" id="'.$tag.'">'.$content.'</div>';
		return $result;
	}
	add_shortcode( 'tabcontent', 'naw_tabcontent_shortcode' );*/
	

##########################################################################################
##### Tab Shortcode #####
//[partners tag='business']
	
	add_shortcode( 'partner', 'naw_partners_shortcode' );
	function naw_partners_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'partner',
			'tag' => '',
			'posts' => 12,
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array(
			'post_type' => $type,
			'tag' => $tag,
			'posts_per_page' => $posts,
		);
		$query = new WP_Query( $options );
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			<div class="row">
				   <?php while ( $query->have_posts() ) : $query->the_post(); ?>
				   <div class="col-md-1">
						<?php the_post_thumbnail('thumbnail'); ?>
					</div>
		<?php endwhile; ?>
			</div>
		<?php
			$output = ob_get_clean();
			return $output;
		}
	}
	
/** TESTIMONIAL START ---
-------------------**/
	#########################################################################################################
	##### TESTIMONIAL Wrapper #####
	function naw_shortcode_testimonial( $atts, $content = null) {
	// [testimonial slides='3'] CONTENT [/testimonial]
		extract(shortcode_atts(array(
		"slides" => 3
		), $atts));
	
		$return = '<div id="quote-carousel" class="carousel slide" data-ride="carousel">
					<ol class="carousel-indicators"><li data-target="#quote-carousel" data-slide-to="0" class="active"></li>';
					$i=1;
				for ($i=1; $i<$slides; $i++)
				{
					$return.='<li data-target="#quote-carousel" data-slide-to="' . $i .'"></li>';
				}
				$return .= '</ol>' . do_shortcode($content);
				$return .= '</div>';
		return $return;
	}
	add_shortcode('testimonial', 'naw_shortcode_testimonial');

	#########################################################################################################
	##### Testimonial Inner #####
	function naw_testimonial_inner( $atts, $content = null ) {
		// [testimonial-inner] Content [/testimonial-inner]
			  
		return '<div class="carousel-inner">' . do_shortcode($content) . '</div>';
		
	}
	add_shortcode('testimonial-inner', 'naw_testimonial_inner');
		
	#########################################################################################################
	##### Testimonial Item #####
	function naw_testimonial_item( $atts, $content = null) {
	// [testimonial-item class='active' image='http://placehold.it/1920x1200&text=+' author='Author Name'] CONTENT [/testimonial-item]
		extract(shortcode_atts(array(
		"class" => '',
		"image" => 'http://placehold.it/1920x500&text=+',
		"author" => 'Author',
		), $atts));
	
		$return = '<div class="item '. $class . '"><blockquote>
						  <div class="row">
							<div class="col-sm-3 text-center">
							  <img class="img-circle" src="' . $image . '" style="width: 150px;height:150px;">
							</div>
							<div class="col-sm-9">
							  <p>'. do_shortcode($content) .'</p>
							  <small>'. $author . '</small>
							</div>
						  </div>
						</blockquote>
					</div>';
		return $return;
	}
	add_shortcode('testimonial-item', 'naw_testimonial_item');
/** TESTIMONIAL END -----
-------------------**/

	#########################################################################################################
	##### Image Slider #####
	function naw_shortcode_imgslider( $atts, $content = null ) {
		// [img-slider] Content [/img-slider]
			  
		return '<div class="img-slider">' . do_shortcode($content) . '</div>';
		
	}
	add_shortcode('img-slider', 'naw_shortcode_imgslider');
	
	########################################################################################################################
	###### List Resources Shortcodes ######
	//[list-resources type="resources" taxonomy="resource_tags" tag="hrms" category="resource_type" posts="2"]
	// create shortcode with parameters so that the user can define what's queried - default is to list all blog posts
	add_shortcode( 'list-resources', 'naw_resource_shortcode' );
	function naw_resource_shortcode( $atts ) {
		ob_start();
	 
		// define attributes and their defaults
		extract( shortcode_atts( array (
			'type' => 'resources',
			'taxonomy' => 'resource_tags',
			'category' =>  'resource_type',
			'order' => 'DESC',
			'tag' => '',
			'posts' => 2,
		), $atts ) );
	 
		// define query parameters based on attributes
		$options = array
		(
			'post_type' => $type,
			'posts_per_page' => $posts,
			'order' => $order,
			'tax_query' => array
				(
					array(
						'taxonomy' => $taxonomy,
						'field'  => 'name',
						'terms' => $tag,
					)
				)
		);
		$query = new WP_Query( $options );
		// run the loop based on the query
		if ( $query->have_posts() ) { ?>
			<ul>
			<?php while( $query->have_posts()) : $query->the_post();
			$terms = wp_get_post_terms( get_the_id() ,$category);
			$event_link = get_post_meta( get_the_id(), 'event_link', true );
			?>
			
				<li><?php foreach($terms as $term) :?>
					<span class='type'><?php echo $term->name; ?>:</span>
				<?php endforeach; 
				if($event_link):?>
				<a href='<?php echo $event_link; ?>' target='_blank' title='<?php echo get_the_title() ?>'><?php echo get_the_title() ?></a>
				<?php else: ?>
				<a href='<?php echo get_post_permalink(); ?>' title='<?php echo get_the_title() ?>'><?php echo get_the_title() ?></a>
				<?php endif; ?>
				</li>
			<?php endwhile; ?>
			</ul>
		<?php
			$output = ob_get_clean();
			return $output;
			wp_reset_query();
		}
	}
	
?>