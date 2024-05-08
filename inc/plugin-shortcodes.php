<?php 
if ( ! defined( 'ABSPATH' ) ) {
     die;
}
$obj = new MS_TESTIMONIALS;
$pluign_name = $obj->post_type_name;
$pluign_shortcode = $obj->shortcode_post;
$pluign_shortcode_form = $obj->Shortcode_form;
?>
<div id="MS_PLUGIN" class="wrap">
    <h1><?php echo $pluign_name;?> Plugin Shortcodes</h1>
    <hr/>
	<h3>1. You can use <mark>[<?php echo $pluign_shortcode;?>]</mark> code for the pages to show all <?php echo $pluign_name;?>.</h3>
	<h3>2. You can use <mark>[<?php echo $pluign_shortcode_form;?>]</mark> code display the Form for <?php echo $pluign_name;?>.</h3>
	<h3>3. You can use <mark>[<?php echo $pluign_shortcode;?> type="slug, slug2"]</mark> code for the inner pages to show specific Type of <?php echo $pluign_name;?>.</h3>
    <h3>4. You can use <mark>[<?php echo $pluign_shortcode;?> show="2"]</mark> shortcode for show numbers of posts.</h3>
    <h3>5. You can use <mark>[<?php echo $pluign_shortcode;?> order="DESC"]</mark> shortcode for set posts orders. Exp: <mark>"ASC", "DESC"</mark></h3>
    <h3>6. You can use <mark>[<?php echo $pluign_shortcode;?> orderby="date"]</mark> shortcode for set posts orderby. Exp: <mark>"none", "ID", "title", "name", "menu_order"</mark>.</h3>
	<hr/>
	<h3>1. The <?php echo $pluign_name;?> Post view template can be overridden by copying it to yourtheme/ms_testimonial/shortcode_testimonial.php.</h3>
	<h3>2. The <?php echo $pluign_name;?> Form template can be overridden by copying it to yourtheme/ms_testimonial/shortcode_testimonial_form.php.</h3>
</div>