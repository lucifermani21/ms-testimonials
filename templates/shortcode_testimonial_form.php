<?php do_action( 'MS_Testimonial_Form_before' );?>
<form id="MS_Testimonial_form" class="needs-validation" name="ms_testimonial_form" method="post" action="<?php echo admin_url('admin-post.php?action=ms-form-submit'); ?>" enctype="multipart/form-data">
	<div class="row">
		<div class="col mb-3">
			<label for="first-name" class="form-label">First Name*</label>
			<input type="text" data-val="true" data-val-required="The First Name you entered does not appear to be valid." id="first-name" class="form-control <?php do_action( 'MS_Testimonial_form_field_class' );?>" name="first_name" placeholder="First name" required>
			<span class="field-validation-valid" data-valmsg-for="first_name" data-valmsg-replace="true"></span>
		</div>
		<div class="col mb-3">
			<label for="last-name" class="form-label">Last Name*</label>
			<input type="text" data-val="true" data-val-required="The Last Name you entered does not appear to be valid." id="last-name" class="form-control <?php do_action( 'MS_Testimonial_form_field_class' );?>" name="last_name" placeholder="Last name" required>
			<span class="field-validation-valid" data-valmsg-for="last_name" data-valmsg-replace="true"></span>
		</div>
		<div class="col-12 mb-3">
			<label for="your-email" class="form-label">E-Mail Address*</label>
			<input type="email" data-val="true" data-val-required="The e-mail you entered does not appear to be valid." id="your-email" class="form-control <?php do_action( 'MS_Testimonial_form_field_class' );?>" name="your_email" placeholder="E-Mail Address" required>
			<span class="field-validation-valid" data-valmsg-for="your_email" data-valmsg-replace="true"></span>
		</div>
		<div class="col-12 mb-3">
			<label for="your-testimonial" class="form-label">Your Testimonial*</label>
			<textarea id="your-testimonial" data-val="true" data-val-required="The message you entered does not appear to be valid." class="form-control <?php do_action( 'MS_Testimonial_form_field_class' );?>" name="your_testimonial" placeholder="Your Testimonial..." rows="5" required></textarea>
			<span class="field-validation-valid" data-valmsg-for="your_testimonial" data-valmsg-replace="true"></span>
		</div>
		<?php $ms_formprofile = get_option( 'ms_formprofile' ); if( !empty( $ms_formprofile ) ):?>
		<div class="col-12 mb-3">
			<label for="your-profile" class="form-label">Your profile</label>
			<input type="file" id="your-profile" class="form-control <?php do_action( 'MS_Testimonial_form_field_class' );?>" name="your_profile" placeholder="Your profile" >
		</div>
		<?php endif;?>
		<?php $ms_formstar = get_option( 'ms_formstar' ); if( !empty( $ms_formstar ) ):?>
		<div class="col-12 mb-3">
			<label for="your-starrating" class="form-label" style="display:block;">Star Rating</label>
			<div class="ms-starrating">
				<input name="your_starrating" value="5" type="radio" class="star" id="r5" /><label for="r5">&#10038;</label>
				<input name="your_starrating" value="4" type="radio" class="star" id="r4" /><label for="r4">&#10038;</label>
				<input name="your_starrating" value="3" type="radio" class="star" id="r3" /><label for="r3">&#10038;</label>
				<input name="your_starrating" value="2" type="radio" class="star" id="r2" /><label for="r2">&#10038;</label>
				<input name="your_starrating" value="1" type="radio" class="star" id="r1" /><label for="r1">&#10038;</label>
			</div>
		</div>
		<?php endif;?>
		
		<div class="col-12 mb-3">
			<input type="hidden" name="current_page_ID" value="<?php echo get_the_ID();?>" />
			<button type="submit" class="<?php do_action( 'MS_Testimonial_form_button_class' );?>" name="ms_testimonial_form_submit"><?php do_action( 'MS_Testimonial_form_button_text' );?></button>
		</div>
	</div>
</form>
<?php do_action( 'MS_Testimonial_Form_after' );?>