<?php
if ( ! defined( 'ABSPATH' ) ) {
     die;
}
class MS_TESTIMONIALS
{	
	public $post_type_name  = "Testmonial";
	public $post_taxonomy_name  = "Testmonial Type";
	public $post_type  = "ms_testimonial";
	public $taxonomy   = "ms_testi_type";
    public $shortcode_post  = "ms_testimonial";
	public $Shortcode_form  = "ms_testimonial_form";
    public $setting_name  = "Testmonial Setting";
    public $setting_link  = "ms_testimonial_setting";
    public $shortcode_name  = "Testmonial Shortcode";
    public $shortcode_link  = "ms_testimonial_shortcode";
	
	public $meta_fields_array = array(
		[
			'field_name' => 'Email Address',
			'field_type' => 'email',
			'field_id' => 'email',
			'desc' => 'Add your email address.',
			'placeholder' => 'info@domain.com'
		],
		[
			'field_name' => 'Stars Rating',
			'field_type' => 'select',
			'field_id' => 'star_rating',
			'desc' => 'Add star rating for the post.',
			'option' => [ '1','2', '3', '4', '5' ],
			'placeholder' => '1'
		],
	);
	
	public function __construct()
	{
		//echo "Test";
	}
	
	public function MS_HOOKS()
	{
		add_action( 'init', [ $this, 'MS_custom_postype' ] );
		add_action( 'admin_head', [ $this, 'MS_plugin_admin_custom_scripts' ] );
		add_shortcode( $this->shortcode_post, [ $this, 'MS_shortcode_post_function' ] );
		add_shortcode( $this->Shortcode_form, [ $this, 'MS_Shortcode_form_function' ] );
		add_action( 'wp_enqueue_scripts', [ $this, 'MS_testimonial_custom_scripts' ] );
		add_action( 'add_meta_boxes', array( $this, 'ms_testimonial_register_meta_box' ) );
        add_action( 'save_post', array( $this, 'ms_testimonial_register_meta_box_save' ) );
		add_action( 'MS_Testimonial_form_button_text', [ $this, 'MS_btn_text' ] );
		add_action( 'MS_Testimonial_form_button_class', [ $this, 'MS_btn_class' ] );
		add_action( 'MS_Testimonial_form_field_class', [ $this, 'MS_field_class' ] );
		add_action( 'MS_Testimonial_Form_before', [ $this, 'MS_Testimonial_Form_require_text' ], 10 );
		add_action( 'MS_Testimonial_Form_after', [ $this, 'MS_Testimonial_Form_submit_text' ] );
	}
	
	public function MS_plugin_admin_custom_scripts()
	{
		$plugin_URL = MS_TESTI_EDITING__URL.'inc/css/plugin-admin.css';
        $version = filemtime( MS_TESTI_EDITING__DIR.'inc/css/plugin-admin.css' );
		wp_register_style( 'MS_plugin_admin', MS_TESTI_EDITING__URL.'inc/css/plugin-admin.css', array(), $version, 'all' );
		wp_enqueue_style( 'MS_plugin_admin' );
	}
	
	public function MS_testimonial_custom_scripts()
	{
		wp_register_style( 'MS_plguin_custom', MS_TESTI_EDITING__URL.'inc/css/plguin_custom.css', array(), filemtime( MS_TESTI_EDITING__DIR.'inc/css/plguin_custom.css' ), 'all' );
		wp_enqueue_style( 'MS_plguin_custom' );
		
		wp_enqueue_script( 'custom-script', MS_TESTI_EDITING__URL.'inc/js/plguin_custom.js', array('jquery_validate'), filemtime( MS_TESTI_EDITING__DIR.'inc/js/plguin_custom.js' ), true );
		
		wp_enqueue_script('jquery_validate', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.3/jquery.validate.min.js', array('jquery'), '1.19.3');
		wp_enqueue_script('jquery_validate_unobtrusive', 'https://cdnjs.cloudflare.com/ajax/libs/jquery-validation-unobtrusive/3.2.12/jquery.validate.unobtrusive.min.js', array('custom-script'), '3.2.12');
	}
	
	public function MS_pagination($wp_query, $echo = true )
	{
		$big = 999999999;
		$pages = paginate_links( array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => '?paged=%#%',
				'current' => max( 1, get_query_var('paged') ),
				'total' => $wp_query->max_num_pages,
				'type'  => 'array',
				'prev_next'   => true,
				'prev_text'    => __('« Prev'),
				'next_text'    => __('Next »'),
			)
		);
		if( is_array( $pages ) ) {
			$paged = ( get_query_var('paged') == 0 ) ? 1 : get_query_var('paged');
			$pagination = '<ul class="pagination justify-content-center">';
			foreach ( $pages as $page ) {
				$page = str_replace('page-numbers','page-link', $page);
				$pagination .= "<li class='page-item ".( strpos( $page, 'current' ) !== false ? "active" : "" )."'>$page</li>";
			}
			$pagination .= '</ul>';
			if ( $echo ) {
				echo $pagination;
			} else {
				return $pagination;
			}
		}
	}
	
	public function MS_custom_postype()
	{
		$args = array(
            'labels'             => array(
				'name'                  => _x( $this->post_type_name, 'Post type general name', MS_TESTI_TEXT_DOMAIN ),
				'singular_name'         => _x( $this->post_type_name, 'Post type singular name', MS_TESTI_TEXT_DOMAIN ),
				'menu_name'             => _x( $this->post_type_name, 'Admin Menu text', MS_TESTI_TEXT_DOMAIN ),
				'name_admin_bar'        => _x( $this->post_type_name, 'Add New on Toolbar', MS_TESTI_TEXT_DOMAIN ),
				'add_new'               => __( 'Add New', MS_TESTI_TEXT_DOMAIN ),
				'add_new_item'          => __( 'Add New '.$this->post_type_name.'', MS_TESTI_TEXT_DOMAIN ),
				'new_item'              => __( 'New '.$this->post_type_name.'', MS_TESTI_TEXT_DOMAIN ),
				'edit_item'             => __( 'Edit '.$this->post_type_name.'', MS_TESTI_TEXT_DOMAIN ),
				'view_item'             => __( 'View '.$this->post_type_name.'', MS_TESTI_TEXT_DOMAIN ),
				'all_items'             => __( 'All '.$this->post_type_name.'s', MS_TESTI_TEXT_DOMAIN ),
				'search_items'          => __( 'Search '.$this->post_type_name.'', MS_TESTI_TEXT_DOMAIN ),
				'parent_item_colon'     => __( 'Parent '.$this->post_type_name.':', MS_TESTI_TEXT_DOMAIN ),
				'not_found'             => __( 'No '.$this->post_type_name.' found.', MS_TESTI_TEXT_DOMAIN ),
				'not_found_in_trash'    => __( 'No '.$this->post_type_name.' found in Trash.', MS_TESTI_TEXT_DOMAIN ),
				'featured_image'        => _x( $this->post_type_name.' Image', '', MS_TESTI_TEXT_DOMAIN ),
				'set_featured_image'    => _x( 'Set profile image', '', MS_TESTI_TEXT_DOMAIN ),
				'remove_featured_image' => _x( 'Remove profile image', '', MS_TESTI_TEXT_DOMAIN ),
				'use_featured_image'    => _x( 'Use as profile image', '', MS_TESTI_TEXT_DOMAIN ),
				'archives'              => _x( $this->post_type_name.' archives', '', MS_TESTI_TEXT_DOMAIN ),
				'insert_into_item'      => _x( 'Insert into '.$this->post_type_name.'', '', MS_TESTI_TEXT_DOMAIN ),
				'uploaded_to_this_item' => _x( 'Uploaded to this '.$this->post_type_name.'', '', MS_TESTI_TEXT_DOMAIN ),
				'filter_items_list'     => _x( 'Filter '.$this->post_type_name.' list', '', MS_TESTI_TEXT_DOMAIN ),
				'items_list_navigation' => _x( $this->post_type_name.' list navigation', '', MS_TESTI_TEXT_DOMAIN ),
				'items_list'            => _x( $this->post_type_name.' list', '', MS_TESTI_TEXT_DOMAIN ),
			),
            'description'        => $this->post_type_name.' custom post type.',
            'public'             => true,
            'publicly_queryable' => true,
            'show_ui'            => true,
            'show_in_menu'       => true,
            'query_var'          => true,
            'menu_icon'          => MS_TESTI_EDITING__URL.'inc/img/posttype_icon.png',
            'rewrite'            => array( 'slug' => $this->post_type ),
            'capability_type'    => 'post',
            'has_archive'        => true,
            'hierarchical'       => false,
            'menu_position'      => 21,
            'supports'            => array( 'title', 'editor', 'thumbnail', 'revisions', 'custom-fields', ), 
            'show_in_rest'       => true
        );          
		register_post_type( $this->post_type, $args );
        $args = array(
            'labels' => array(
				'name'              => _x( $this->post_taxonomy_name, 'taxonomy general name', MS_TESTI_TEXT_DOMAIN ),
				'singular_name'     => _x( $this->post_taxonomy_name, 'taxonomy singular name', MS_TESTI_TEXT_DOMAIN ),
				'search_items'      => __( 'Search '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'all_items'         => __( 'All '.$this->post_taxonomy_name.'s', MS_TESTI_TEXT_DOMAIN ),
				'view_item'         => __( 'View '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'parent_item'       => __( 'Parent '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'parent_item_colon' => __( 'Parent '.$this->post_taxonomy_name.':', MS_TESTI_TEXT_DOMAIN ),
				'edit_item'         => __( 'Edit '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'update_item'       => __( 'Update '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'add_new_item'      => __( 'Add New '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'new_item_name'     => __( 'New '.$this->post_taxonomy_name.' Name', MS_TESTI_TEXT_DOMAIN ),
				'not_found'         => __( 'No '.$this->post_taxonomy_name.' Found', MS_TESTI_TEXT_DOMAIN ),
				'back_to_items'     => __( 'Back to '.$this->post_taxonomy_name.'', MS_TESTI_TEXT_DOMAIN ),
				'menu_name'         => __( $this->post_taxonomy_name, MS_TESTI_TEXT_DOMAIN ),
			),
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'query_var'         => true,
            'rewrite'           => array( 'slug' => $this->taxonomy ),
            'show_in_rest'      => true,
        );    
        register_taxonomy( $this->taxonomy, $this->post_type, $args );
        flush_rewrite_rules();  
	}
	
	public function MS_shortcode_post_function( $args )
	{
		ob_start();
		$post_show = isset($args['show']) ? $args['show'] : 10;
		$page = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$arr_cat = isset( $args['type'] ) ? $args['type'] : '';
		$post_order = isset( $args['order'] ) ? $args['order'] : 'DESC';
		$post_orderby = isset( $args['orderby'] ) ? $args['orderby'] : 'date';
		$options = array( 'post_type' => $this->post_type, 'posts_per_page' => $post_show , 'order' => $post_order, 'orderby' => $post_orderby, 'paged' => $page );
		if(isset($args['type']) && $args['type'] != ""){
			$options['tax_query'] = array(
				array(
					'taxonomy' => $this->taxonomy,
					'terms' => explode( ',', $arr_cat ),
					'field' => 'slug',
					'operator' => 'IN'
				)
			);
		};
		$html = '';
		$query = new WP_Query( $options );		
		if($query->have_posts()):
		$html = '<div id="MS_Testmonial" class="Main_post_box">';
		while ($query->have_posts()): $query->the_post();
		global $post;	
		$html .= '';
		$theme_file = get_template_directory().'/ms_testimonial/shortcode_testimonial.php';
		if( file_exists( $theme_file ) ):
			include( $theme_file );
		else:
			include( MS_TESTI_EDITING__DIR.'templates/shortcode_testimonial.php' );
		endif;
		$html .= '';		
		endwhile;
		$html .= '</div>';
		else:
		$html .= '<p>Coming Soon...</p>';
		endif;
		$ob_get_clean = ob_get_clean();
        $html .= $ob_get_clean;        
		$html .= '<div class="text-center">'.$this->MS_pagination($query, false).'</div>';
		wp_reset_postdata();
		return $html;
	}
	
	public function MS_Shortcode_form_function( $args )
	{
		ob_start();		
		$html = '';
		$html .= '';
		$theme_file = get_template_directory().'/ms_testimonial/shortcode_testimonial_form.php';
		if( file_exists( $theme_file ) ):
			include( $theme_file );
		else:
			include( MS_TESTI_EDITING__DIR.'templates/shortcode_testimonial_form.php' );
		endif;
		$html .= '';
		$ob_get_clean = ob_get_clean();
        $html .= $ob_get_clean;
		return $html;
	}
	
	public function ms_testimonial_register_meta_box()
	{
		add_meta_box( 
            'ms_testimonial_extra', 
            __( 'Testmonial Extra Fields', '' ), 
            [ $this, 'MS_callback_function' ], 
            $this->post_type , 
            'advanced', 
            'default',
        );
	}
	
	public function MS_callback_function( $post )
	{
		?>
		<div class="main_meta_box_fields">
			<table class="admin_table" style="width:100%">
				<tbody>
					<?php foreach( $this->meta_fields_array as $k => $vlaue ):
						get_post_meta( $post->ID, 'ms_testimonial_'.$vlaue['field_id'], true );
						//var_dump( get_post_meta( $post->ID, 'ms_testimonial_'.$vlaue['field_id'], true ) );
						if( $vlaue['field_type'] == 'select' ):
							$selected = get_post_meta( $post->ID, 'ms_testimonial_'.$vlaue['field_id'], true );?>
							<tr>
								<td style="width:22%;"><label for="<?php echo $vlaue['field_id'];?>" title="<?php echo $vlaue['desc'];?>"><?php echo $vlaue['field_name'];?></label></td>
								<td>
									<select id="<?php echo $vlaue['field_id'];?>" name="ms_testimonial_<?php echo $vlaue['field_id'];?>" style="width: 100%;">
										<?php foreach( $vlaue['option'] as $a ):?>
										<option value="<?php echo $a;?>" <?php echo $selected == $a ? 'selected' : '';?>><?php echo $a;?></option>
										<?php endforeach?>
									</select>
								</td>
							</tr>
							<?php else:?>
							<tr>
								<td style="width:22%;"><label for="<?php echo $vlaue['field_id'];?>" title="<?php echo $vlaue['desc'];?>"><?php echo $vlaue['field_name'];?></label></td>
								<td><input type="<?php echo $vlaue['field_type'];?>" id="<?php echo $vlaue['field_id'];?>" name="ms_testimonial_<?php echo $vlaue['field_id'];?>" value="<?php echo ( get_post_meta( $post->ID, 'ms_testimonial_'.$vlaue['field_id'], true ) ) != '' ? get_post_meta( $post->ID, 'ms_testimonial_'.$vlaue['field_id'], true ) : '';?>" placeholder="<?php echo $vlaue['placeholder'];?>" style="width: 100%;"></td>
							</tr>
						<?php endif;
					endforeach;?>
				</tbody>
			</table>
		</div>
		<?php 
	}	
	
	public function ms_testimonial_register_meta_box_save( $post_id )
	{
		foreach( $this->meta_fields_array as $k => $vlaue ){
			$save_value = 'ms_testimonial_'.$vlaue['field_id'];
			if ( isset( $_POST[ $save_value ] ) )
				update_post_meta( $post_id, $save_value, $_POST[ $save_value ] );
		}
	}
	
	public function MS_btn_text()
	{
		$ms_btntext = get_option( 'ms_btntext' );
		echo ($ms_btntext !='' ? $ms_btntext : 'Submit Your Testmonial');
	}	
	
	public function MS_btn_class()
	{
		$ms_btnclass = get_option( 'ms_btnclass' );
		echo ($ms_btnclass !='' ? $ms_btnclass : 'btn btn-primary');
	}
	
	public function MS_field_class()
	{
		$ms_formfieldclass = get_option( 'ms_formfieldclass' );
		echo ($ms_formfieldclass !='' ? $ms_formfieldclass : 'form_testimonial');
	}
	
	public function MS_Testimonial_Form_require_text()
	{
		$form_require = get_option( 'ms_form_require' );
		echo '<h4>'.( $form_require !='' ? $form_require : 'The (*) fields are required.' ).'</h4>';
	}
	
	public function MS_Testimonial_Form_submit_text(){
		if( $_GET[ 'success' ] == '1' ):
			$formsubmittext = get_option( 'ms_formsubmittext' );
			echo '<div class="form_message">'.( $formsubmittext != '' ? $formsubmittext : 'Thank You, Your Testimonial details have been submitted, please wait for approve your Testimonial.' ).'</div>';
		endif;
	}
	
}