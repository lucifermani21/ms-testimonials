<?php 
if ( ! defined( 'ABSPATH' ) ) {
     die;
}
class MS_TESTI_PLUGIN_SETTINGS extends MS_TESTIMONIALS
{
	public $setting_arr = array( 'setting_section' => 
		array(
			[ 'section_title' => 'Form Fields',
				'section_fields' => array(
					[
					'field_name' => 'Enable Star Field',
					'field_id' => 'formstar',
					'field_type' => 'checkbox',
					'field_desc' => 'If you wants to add star review dropdown on the form.',
					'field_css' => ''
					],
					[
					'field_name' => 'Enable Profile Field',
					'field_id' => 'formprofile',
					'field_type' => 'checkbox',
					'field_desc' => 'If you wants to add profile upload option on the form.',
					'field_css' => ''
					],
				),				
			],
			[ 'section_title' => 'Form Settings',
				'section_fields' => array(
					[
					'field_name' => 'Form Required Text',
					'field_id' => 'form_require',
					'field_type' => 'text',
					'field_desc' => 'Form top require text.',
					'field_placeholder' => 'The (*) fields are required.',
					'field_css' => 'width:100%;'
					],
					[
					'field_name' => 'Submit Button Text',
					'field_id' => 'btntext',
					'field_type' => 'text',
					'field_desc' => 'Form submit button text.',
					'field_placeholder' => 'Submit Your Testmonial',
					'field_css' => 'width:100%;'
					],
					[
					'field_name' => 'Form Submit Text',
					'field_id' => 'formsubmittext',
					'field_type' => 'text',
					'field_desc' => 'Form Submit Text.',
					'field_placeholder' => 'Thank You, Your Testimonial details have been submitted, please wait for approve your Testimonial.',
					'field_css' => 'width:100%;'
					],
				),				
			],
			[ 'section_title' => 'CSS Settings',
				'section_fields' => array(
					[
					'field_name' => 'Form Field Class',
					'field_id' => 'formfieldclass',
					'field_type' => 'text',
					'field_desc' => 'Form field class.',
					'field_placeholder' => 'form_testimonial',
					'field_css' => 'width:100%;'
					],
					[
					'field_name' => 'Submit Button Class',
					'field_id' => 'btnclass',
					'field_type' => 'text',
					'field_desc' => 'Form submit button class.',
					'field_placeholder' => 'btn btn-primary',
					'field_css' => 'width:100%;'
					],
				),				
			],
		),			
	);

    public function __construct()
    {        
		// Empty...
    }

    public function MS_SETTING_HOOKS()
    {
        add_action( 'admin_menu', array( $this, 'ms_admin_menu_page') );
		add_action( 'admin_init', array( $this, 'ms_settings_init' ) );
    }
	
    public function ms_admin_menu_page()
	{
		add_submenu_page(
			'edit.php?post_type='.$this->post_type.'',
			$this->setting_name, 
			'Settings',
			'manage_options', 
			$this->setting_link, 
			[$this, 'MS_plugin_setting_page'],
			5
		);
		add_submenu_page(
			'edit.php?post_type='.$this->post_type.'',
			$this->shortcode_name,
			'Shortcodes', 
			'manage_options',
			$this->shortcode_link, 
			[$this, 'MS_plugin_shortcode_page'],
			6
		);
	}
	
	public function MS_plugin_shortcode_page()
	{
		require_once plugin_dir_path( __FILE__ ) . 'plugin-shortcodes.php';
	}

	public function ms_settings_init()
	{
		$setting_array = $this->setting_arr['setting_section'];				
		foreach( $setting_array as $a => $value_data ):
			$section_fields = $value_data['section_fields'];
			foreach( $section_fields as $b => $value ):
				register_setting( $this->setting_link, 'ms_'.$value['field_id'] );
			endforeach;
		endforeach;
	}
	
	public function MS_plugin_setting_page()
	{
		if ( isset( $_GET['settings-updated'] ) ) {
			add_settings_error( 'ms_error_messages', 'ms_error_messages', __( 'Testimonial Plugin Settings Saved.', $this->setting_link ), 'updated' );
		}
		settings_errors( 'ms_error_messages' );
		?>
		<div id="MS-plugin" class="wrap">
			<h1><?php esc_html_e( 'Plugin custom settings page.', MS_TESTI_TEXT_DOMAIN ); ?></h1>
			<strong>Please check the below custom setting related to the plugin. You can check description on hover the setting title.</strong>
			<form method="POST" action="options.php">
				<?php settings_fields( $this->setting_link );
				do_settings_sections( $this->setting_link );
				
				$setting_array = $this->setting_arr['setting_section'];				
				foreach( $setting_array as $a => $value_data ):
					$section_fields = $value_data['section_fields'];?>
					<h2><?php echo $value_data['section_title']?></h2>
					<?php foreach( $section_fields as $b => $value ):?>
						<table style="width: 100%;text-align: left;margin-top:2rem;">
							<tbody>
								<?php $MS_option = get_option( 'ms_'.$value['field_id'] );?>
								<?php //var_dump($MS_option);?>
								<tr>
									<th style="width:15%;padding-bottom: 10px;"><label for="<?php echo 'ms_'.$value['field_id'];?>" title="<?php echo $value['field_desc'];?>"><?php _e( $value['field_name'], MS_TESTI_TEXT_DOMAIN ); ?></label></th>
									<td style="padding-bottom: 10px;">
										<?php if( $value['field_type'] == 'checkbox' ):?>
										<label class="switch">
											<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>[]" value="yes" style="<?php echo $value['field_css']?>" <?php echo is_array( $MS_option ) ? 'checked' : '' ;?> />
											<span class="slider round"></span>
										</label>
										<?php elseif( $value['field_type'] == 'number' ):?>						
											<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>" value="<?php echo isset( $MS_option ) != '' ? $MS_option : '';?>" style="<?php echo $value['field_css']?>" min="1" max="5`" />
										<?php else:?>								
											<input type="<?php echo $value['field_type'];?>" id="<?php echo 'ms_'.$value['field_id'];?>" name="<?php echo 'ms_'.$value['field_id'];?>" value="<?php echo isset( $MS_option ) != '' ? $MS_option : '';?>" style="<?php echo $value['field_css']?>" placeholder="<?php echo $value['field_placeholder']?>" />
										<?php endif;?>
									</td>
								</tr>
							</tbody>
						</table>
					<?php endforeach;
				endforeach;
				submit_button( 'Submit Settings' );?>
			</form>
		</div>
		<?php
	}
}
