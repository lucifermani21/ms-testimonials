<?php 

function MS_Testimonial_Form_Handle(){
	$obj = new MS_TESTIMONIALS;
	$post_type = $obj->post_type;
	
	if( isset( $_POST['ms_testimonial_form_submit']  ) ){
		if ( isset( $_POST['first_name'] ) ) {
			$first_name = $_POST['first_name'];
		}
		
		if ( isset( $_POST['last_name'] ) ) {
			$last_name = $_POST['last_name'];
		}
		
		if ( isset( $_POST['your_email'] ) ) {
			$your_email = $_POST['your_email'];
		}
		
		if ( isset( $_POST['your_starrating'] ) ) {
			$your_starrating = $_POST['your_starrating'];
		}
		if ( isset( $_POST['your_testimonial'] ) ) {
			$your_testimonial = $_POST['your_testimonial'];
		}
		
		if ( isset( $_FILES['your_profile'] ) ) {
			$your_profile = $_FILES['your_profile'];
		}
		
		if ( isset( $_POST['current_page_ID'] ) ) {
			$current_page_ID = $_POST['current_page_ID'];
		}
		
		//$post_tags = $_POST['post_tags'];
		
		$new_testimonial_post = array(
			'post_title'    => $first_name.' '.$last_name,
			'post_content'  => $your_testimonial,
			//'post_category' => array($_POST['cat']),
			//'tags_input'    => array($post_tags),				
			'post_status'   => 'draft',
			'post_type' => $post_type,
		);
		
		$post_id = wp_insert_post( $new_testimonial_post );

		update_post_meta($post_id, 'ms_testimonial_email', $your_email);
		update_post_meta($post_id, 'ms_testimonial_star_rating', $your_starrating);
		
		if( !empty( $_FILES['your_profile'] ) ){
			#Profile Image upload.
			if ( ! function_exists( 'wp_crop_image' ) ) {
				include( ABSPATH . 'wp-admin/includes/image.php' );
			}
			
			$file = $your_profile['tmp_name'];
			$filename = $your_profile['name'];
			
			$upload_file = wp_upload_bits( $filename, null, file_get_contents($file) );
			
			if ( !$upload_file['error'] ) {				
				$filetype = wp_check_filetype( $filename, null );
				$wp_upload_dir = wp_upload_dir();
				
				$attachment = array( 
					'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
					'post_mime_type' => $filetype['type'],
					'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
					'post_content'   => '',
					'post_status'    => 'inherit',
					'post_parent'    => $post_id
				);
				
				$attach_id = wp_insert_attachment( $attachment, $upload_file['file'], $post_id );				
				$attach_data = wp_generate_attachment_metadata( $attach_id, $upload_file['file'] );
				wp_update_attachment_metadata( $attach_id, $attach_data );
				set_post_thumbnail( $post_id, $attach_id );
			}
		}
		$page_link = get_the_permalink( $current_page_ID );
		header('Location: '.$page_link.'/?success=1' );
		die();
	}		
}
add_action( 'admin_post_ms-form-submit', 'MS_Testimonial_Form_Handle' );
add_action( 'admin_post_nopriv_ms-form-submit', 'MS_Testimonial_Form_Handle' );