<div id="Main_Testimonials" style="margin-bottom:20px;">
<?php do_action( 'MS_Testimonial_before_main' );?>
	<div class="testimonial">
		<?php do_action( 'MS_Testimonial_before_content' );?>
		<blockquote>
			<div class="testimonial_content"><?php the_content();?></div>
			<div class="testimonial_extra"><?php do_action( 'MS_Testimonial_extra' );?></div>
		</blockquote>
		<?php do_action( 'MS_Testimonial_after_content' );?>
	<div class="testimonial_arrow"></div>
	<?php do_action( 'MS_Testimonial_before_title' );?>
	<div class="testimonial_title"><?php the_title();?></div>
	<?php do_action( 'MS_Testimonial_after_title' );?>
	</div>
<?php do_action( 'MS_Testimonial_after_main' );?>
</div>