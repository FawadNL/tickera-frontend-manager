<?php
/*
Plugin Name: Tickera - Frontend Manager addon
Plugin URI: http://tickera.com/
Description: With this addon, the userrole "Editor" can now publish and edit events from the frontend. Now its possible to have your community create events for and by themselves. You can enable this feature by placing the shortcode [event_dashboard] into any page you like.
Please note that you also need a WooCommerce Frontend Product manager as well if you do tickets via woocommerce.
Author: Fawad Tiemoerie
Author URI: https://appency.nl
Version: 1.0.0
 */

register_activation_hook(__FILE__, 'tc_install');
register_deactivation_hook(__FILE__, 'tc_deactivation');
register_uninstall_hook(__FILE__, 'tc_uninstall');

global $wpdb, $wp_version;

$prifix = $wpdb->prefix;
function tc_install() {

}
function tc_deactivation() { }
function tc_uninstall() { }
function event_dashboard_func() {

global $wpdb; global $wp;


$user_id = get_current_user_id();
$user_meta=get_userdata($user_id);
$user_roles = $user_meta->roles;
$user_role = $user_roles[0];
$postCount = 0;

$siteUrl = site_url();
$pageUrl = home_url( $wp->request );
$addEvent = $pageUrl.'/?actionEvent='.base64_encode('addEvent');


if($user_role == 'editor'){	


if(isset($_REQUEST['actionEvent'])){
	
$post_id = ($_REQUEST['actionEvent']) ? base64_decode($_REQUEST['actionEvent']) : '' ;
$condition_check = base64_decode($_REQUEST['actionEvent']);

if(isset($_POST['event_submit'])){
	

	$event_title = $_POST['event_title'];
	$event_start = $_POST['event_start'];
	$event_start_time = $_POST['event_start_time'];
	$event_end = $_POST['event_end'];
	$event_end_time = $_POST['event_end_time'];
	$event_location = $_POST['event_location'];
	$tc_content_editor = $_POST['tc_content_editor'];
	$tc_term_editor = $_POST['tc_term_editor'];
	$show_ticket = $_POST['show_ticket'];
	$hide_event = $_POST['hide_event'];
	
	$event_cat = $_POST['mychecky'];
	
	$isdraft = $_POST['event_draft'];
	$publish = ($isdraft == 'yes') ? 'draft' : 'publish';
	$post_id = wp_insert_post( array(
                    'post_status' => $publish,
                    'post_author' => $user_id,
                    'post_type' => 'tc_events',
                    'post_title' => $event_title,
                    'post_content' => $tc_content_editor,
                ) );
	
	wp_set_post_terms($post_id, $event_cat, 'event_category');
	
	$db_start_date = $event_start.' '.$event_start_time;
	$db_end_date = $event_end.' '.$event_end_time;
	update_post_meta($post_id, 'event_draft', $isdraft );
	update_post_meta($post_id, 'event_description_front', $tc_content_editor );
	update_post_meta($post_id, 'event_presentation_page', $post_id );
	update_post_meta($post_id, 'event_date_time', $db_start_date);
	update_post_meta($post_id, 'event_end_date_time',  $db_end_date);
	update_post_meta($post_id, 'event_location', $event_location );
	update_post_meta($post_id, 'event_terms', $tc_term_editor );
	update_post_meta($post_id, 'hide_event_after_expiration', $hide_event );
	update_post_meta($post_id, 'show_tickets_automatically', $show_ticket );

	
			
	if ($_FILES['event_logo']) {
		
		image_uploading($_FILES['event_logo'], 'event_logo_file_url', $post_id);
	}
	if ($_FILES['sponsors_logo']) {
		
		image_uploading($_FILES['sponsors_logo'], 'sponsors_logo_file_url', $post_id);
	}
	if ($_FILES['featured_image_event']) {
		
		image_uploading($_FILES['featured_image_event'], '_thumbnail_id', $post_id, 'featured_image_event');
	}
	

echo '<script>window.location.href = "'.$pageUrl.'/?actionEvent='.base64_encode($post_id).'";</script>';
}

// Update Query

if(isset($_POST['event_update_submit'])){
	
	$post_id = $_POST['update_id'];
	$event_title = $_POST['event_title'];
	$event_start = $_POST['event_start'];
	$event_start_time = $_POST['event_start_time'];
	$event_end = $_POST['event_end'];
	$event_end_time = $_POST['event_end_time'];
	$event_location = $_POST['event_location'];
	$tc_content_editor = $_POST['tc_content_editor'];
	$tc_term_editor = $_POST['tc_term_editor'];
	$show_ticket = $_POST['show_ticket'];
	$hide_event = $_POST['hide_event'];

	$event_cat = $_POST['mychecky'];

	$isdraft = $_POST['event_draft'];
	$publish = ($isdraft == 'yes') ? 'draft' : 'publish';
	
	$my_post = array(

	   'ID' =>  $post_id,
	   'post_title'    => $event_title,
	   'post_content'  => $tc_content_editor,
	   'post_status' => $publish,
	   'post_author'   => $user_id,
	);
	


wp_update_post( $my_post );

	wp_set_post_terms($post_id, $event_cat, 'event_category');
	
	$db_start_date = $event_start.' '.$event_start_time;
	$db_end_date = $event_end.' '.$event_end_time;
	update_post_meta($post_id, 'event_draft', $isdraft );
	update_post_meta($post_id, 'event_description_front', $tc_content_editor );
	update_post_meta($post_id, 'event_presentation_page', $post_id );
	update_post_meta($post_id, 'event_date_time', $db_start_date);
	update_post_meta($post_id, 'event_end_date_time',  $db_end_date);
	update_post_meta($post_id, 'event_location', $event_location );
	update_post_meta($post_id, 'event_terms', $tc_term_editor );
	update_post_meta($post_id, 'hide_event_after_expiration', $hide_event );
	update_post_meta($post_id, 'show_tickets_automatically', $show_ticket );
	
	if ($_FILES['event_logo']) {
		
		image_uploading($_FILES['event_logo'], 'event_logo_file_url', $post_id);
	}
	if ($_FILES['sponsors_logo']) {
		
		image_uploading($_FILES['sponsors_logo'], 'sponsors_logo_file_url', $post_id);
	}
	if ($_FILES['featured_image_event']) {
		
		image_uploading($_FILES['featured_image_event'], '_thumbnail_id', $post_id, 'featured_image_event');
	}
	
	
}




$post_title = get_the_title($post_id);	

$post_content = get_post_meta($post_id, 'event_description_front',true );
$event_datee = get_post_meta($post_id, 'event_date_time', true );
$event_dateex = explode(' ',$event_datee);
$event_date = $event_dateex[0];
$event_date_time = $event_dateex[1];
$event_endd = get_post_meta($post_id, 'event_end_date_time', true );
$event_endex = explode(' ',$event_endd);
$event_end = $event_endex[0];
$event_end_time = $event_endex[1];
$event_location = get_post_meta($post_id, 'event_location', true );
$event_terms = get_post_meta($post_id, 'event_terms', true );
$hide_event = get_post_meta($post_id, 'hide_event_after_expiration', true );
$show_tickets = get_post_meta($post_id, 'show_tickets_automatically', true );
$event_draft = get_post_meta($post_id, 'event_draft', true );

$event_logo = get_post_meta($post_id, 'event_logo_file_url', true);
$sponsors_logo = get_post_meta($post_id, 'sponsors_logo_file_url', true);

$id1 = get_post_meta($post_id, '_thumbnail_id', true);
$featured_image =  wp_get_attachment_url($id1);


$check_show_tickets = ($show_tickets == '1') ? 'checked="checked"' : '' ;	
$check_hide_event = ($hide_event == '1') ? 'checked="checked"' : '' ;	
$check_event_draft = ($event_draft == 'yes') ? 'checked="checked"' : '' ;	

$event_logo_img = ($event_logo) ? '<img style="margin-top: 10px;" src="'.$event_logo.'">' : '';
$sponsors_logo_img = ($sponsors_logo) ? '<img style="margin-top: 10px;" src="'.$sponsors_logo.'">' : '';
$featured_event_image = ($featured_image) ? '<img style="margin-top: 10px;" src="'.$featured_image.'">' : '';


$category_checked = get_the_terms($post_id, 'event_category');

$term_content = $event_terms;
$term_editor_id = 'tc_term_editor';
	
$content = $post_content;
$editor_id = 'tc_content_editor';
$settings =   array(

    'media_buttons' => true, // show insert/upload button(s)
    'textarea_name' => $editor_id, // set the textarea name to something different, square brackets [] can be used here
    'textarea_rows' => get_option('default_post_edit_rows', 10), // rows="..."
    'tabindex' => '',
    'editor_css' => '', //  extra styles for both visual and HTML editors buttons, 
    'editor_class' => '', // add extra class(es) to the editor textarea
    'teeny' => false, // output the minimal editor config used in Press This
    'dfw' => false, // replace the default fullscreen with DFW (supported on the front-end in WordPress 3.4)
    'tinymce' => true, // load TinyMCE, can be used to pass settings directly to TinyMCE using an array()
    'quicktags' => false // load Quicktags, can be used to pass settings directly to Quicktags using an array()
);

	$data = '<div><a  style="float:right;background: #222;padding: 8px;color: #fff;" href="'.$pageUrl.'">Back List</a></div><div><a  style="float:right;background: #222;padding: 8px;color: #fff;margin-right: 15px;" href="'.$addEvent.'">Create Event</a></div>';
	
	$data .= '<form class="form-inline" action="" method="post" enctype="multipart/form-data"><div class="form-group-tc"><input type="text" name="event_title" class="form-control-tc" id="event_title" placeholder="Event Title" value="'.$post_title.'" ></div><div class="form-group-tc"><div class="col-tc-6"><div class="col-tc-6"><input type="text" name="event_start" class="form-control-tc" id="event_start" placeholder="Event Start Date" value="'.$event_date.'" ></div><div class="col-tc-6" style="float:right;"><input type="text" name="event_start_time" class="form-control-tc" id="event_start_time" placeholder="Event Start Time" value="'.$event_date_time.'" ></div></div><div class="col-tc-6" style="float: right;"><div class="col-tc-6"><input type="text" name="event_end" class="form-control-tc" id="event_end" placeholder="Event Start End" value="'.$event_end.'"></div><div class="col-tc-6" style="float: right;"><input type="text" name="event_end_time" class="form-control-tc" id="event_end_time" placeholder="Event Start End" value="'.$event_end_time.'"></div></div><div class="clear-tc"></div></div><div class="form-group-tc"><input type="text" name="event_location" class="form-control-tc" id="event_location" placeholder="Event Location" value="'.$event_location.'" ></div><div class="form-group-tc"><div class="col-tc-4" style="border: 1px solid #bbb; padding: 8px 10px;"><label>Event Logo</label><input type="file" name="event_logo" class="form-control-tc" id="event_logo" value="'.$event_logo.'"> '.$event_logo_img.' </div><div class="col-tc-4" style="border: 1px solid #bbb; padding: 8px 10px;"><label>Sponsors Logo</label><input type="file" name="sponsors_logo" class="form-control-tc" id="sponsors_logo" value="'.$sponsors_logo.'"> '.$sponsors_logo_img.' </div><div class="col-tc-4" style="border: 1px solid #bbb; padding: 8px 10px; float: right;"><label>Featured Image</label><input type="file" name="featured_image_event" class="form-control-tc" id="featured_image_event" value="'.$featured_image.'" /> '.$featured_event_image.' </div></div><div class="form-group-tc content_editor"><p id="content_editor">Event Description</p>'.wp_editor( $content, $editor_id, $settings = array()).'</div><div class="form-group-tc"><p id="term_editor">Term of Use</p>'.wp_editor( $term_content, $term_editor_id, $settings = array()).'</div><div class="form-group-tc"><div class="col-tc-4"><input type="checkbox" '.$check_show_tickets.' name="show_ticket" class="form-checkbox-tc" id="show_ticket" value="1" >Show Tickets Automatically</div><div class="col-tc-4"><input type="checkbox" name="hide_event" class="form-checkbox-tc" id="hide_event" '.$check_hide_event.' value="1">Hide event after expiration</div><div class="col-tc-4"><input type="checkbox" name="event_draft" class="form-checkbox-tc" id="event_draft" '.$check_event_draft.' value="yes">Event Draft Mode</div></div><div class="form-group-tc"><h4>Event Categories</h4></div>';
	
	$data .= '<div class="form-group-tc">';
	$categories = get_categories(array('taxonomy' => 'event_category', 'hide_empty'=> 0));  
$tt = 0;
	foreach($categories as $category) {  
		
		if($category_checked[$tt]->term_id == $category->term_id){
			
			$data .= "<input checked='checked' type='checkbox' name='mychecky[]' value='$category->term_id' /><span style='margin-right: 10px;'>$category->cat_name</span>";  
		$tt++;	
		}else{
			
			$data .= "<input type='checkbox' name='mychecky[]' value='$category->term_id' /><span style='margin-right: 10px;'>$category->cat_name</span>";  
		}
	
	}
	$data .= '</div>';
	
	if($condition_check == 'addEvent'){
		$data .= '<div class="form-group-tc"><input type="submit" name="event_submit" class="btn btn-default btn-tc" value="Submit" /></div><div class="clear-tc"></div></form>';
	}else{
		$data .= '<div class="form-group-tc"><input type="hidden" name="update_id" value="'.$post_id.'" /><input type="submit" name="event_update_submit" class="btn btn-default btn-tc" value="Update" /></div><div class="clear-tc"></div></form>';
	}

	





	
}else{

if(isset($_REQUEST['actionRemove'])){
	global $wpdb;
	$postUpdateid = base64_decode($_REQUEST['actionRemove']);
	$up_post = array(

	   'ID' =>  $postUpdateid,
	   'post_status' => 'trash',
	   'post_author'   => $user_id,
	);

wp_update_post( $up_post );
}

$data = '<div><a href="'.$addEvent.'" style="float:right;background: #222;padding: 8px;color: #fff;" >Create Event</a></div><h5>List All Events</h5><div class="container"><table class="table table-striped"><thead><tr><th>Event Name</th><th>Satrt Date</th><th>End Date</th><th>Location</th><th>Post Status</th><th>Action</th></tr></thead><tbody>';

if ( get_query_var('paged') ) $paged = get_query_var('paged');
if ( get_query_var('page') ) $paged = get_query_var('page');



$args = array(
    'post_type' => 'tc_events',
    'posts_per_page' => 10,
	'author' =>  $user_id,
	'orderby'       =>  'post_date',
    'order'         =>  'DESC',
	'post_status' => array('publish', 'draft'),
    'paged' => $paged
    
);
$query = new WP_Query($args);
	if ( $query->have_posts() ) :
	while ( $query->have_posts() ) : $query->the_post();	
	
		$postCount = 1;
		$id = get_the_ID();
		$postStatus = get_post_status();
		$event_date = get_post_meta($id, 'event_date_time', true );
		$event_end = get_post_meta($id, 'event_end_date_time', true );
		$event_location = get_post_meta($id, 'event_location', true );
		
		$data .= '<tr><td><a href="'.get_permalink().'"> '.get_the_title().'</a></td><td>'.$event_date.'</td><td>'.$event_end.'</td><td>'.$event_location.'</td><td>'.ucfirst($postStatus).'</td><td><a href="'.$pageUrl.'/?actionEvent='.base64_encode($id).'">Edit</a> / <a href="'.$pageUrl.'/?actionRemove='.base64_encode($id).'">Remove</a></td></tr>';
		
	endwhile; wp_reset_postdata(); endif;
	

	
	$data .= ($postCount == 0) ? '<tr><td>No Event Found</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr>' : '';


	$data .= '</tbody></table></div>';

}
echo '<style>#wpadminbar { display:none;} .tc-shortcode-builder-button{ display:none !important;}</style>';	
}else{

	$data = '<h1>No Access This Page</h1>';
}


return  $data;
}
add_shortcode( 'event_dashboard', 'event_dashboard_func' );

function event_list_func(){

$postData = '<section class="details-card"><div class="container"><div class="row">';

$args = array(
	'post_type' => 'tc_events',
	'posts_per_page' => 10,
	'author' =>  $user_id,
	'orderby'       =>  'post_date',
	'order'         =>  'DESC',
	'paged' => $paged
)
;
$cnt = 1;
$query = new WP_Query($args);
	if ( $query->have_posts() ) :
	while ( $query->have_posts() ) : $query->the_post();	
	
	$id = get_the_ID();
	$price = get_post_meta($id,'e_price',true);
	$startDate = get_post_meta($id,'e_start',true);
	$endDate = get_post_meta($id,'e_end',true);
	
	if($cnt%3 == '0'){
		$postData .= '<div class="row">';
	}
	
    $postData .= '<div class="col-md-4"><div class="card-content"><div class="card-img"><img src="https://placeimg.com/380/230/nature" alt=""><span><h4>heading</h4></span></div><div class="card-desc"><h3>Heading</h3><p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Laboriosam, voluptatum! Dolor quo, perspiciatis voluptas totam</p><a href="#" class="btn-card">Read</a></div></div></div>';
	
	if($cnt%3 == '0'){
		$postData .= '</div>';
	}
	
	$cnt++;
		
	endwhile; wp_reset_postdata(); endif;
	
	$postData .= '</div></div></section>';
	
	return $postData;
}
add_shortcode( 'event_list', event_list_func);

function image_uploading($files, $key, $post_id, $event_image_type = ''){
	
require_once( ABSPATH . 'wp-admin/includes/image.php' );
require_once( ABSPATH . 'wp-admin/includes/file.php' );
require_once( ABSPATH . 'wp-admin/includes/media.php' );

	if ($files['name']) {

		$file = array(
			'name'     => $files['name'],
			'type'     => $files['type'],
			'tmp_name' => $files['tmp_name'],
			'error'    => $files['error'],
			'size'     => $files['size']
		);

		$upload_overrides = array( 'test_form' => false );
		$upload = wp_handle_upload($file, $upload_overrides);


		// $filename should be the path to a file in the upload directory.
		$filename = $upload['file'];


		// Check the type of tile. We'll use this as the 'post_mime_type'.
		$filetype = wp_check_filetype( basename( $filename ), null );

		// Get the path to the upload directory.
		$wp_upload_dir = wp_upload_dir();
		
		// Prepare an array of post data for the attachment.
		$attachment = array(
			'guid'           => $wp_upload_dir['url'] . '/' . basename( $filename ), 
			'post_mime_type' => $filetype['type'],
			'post_title'     => preg_replace( '/\.[^.]+$/', '', basename( $filename ) ),
			'post_content'   => '',
			'post_status'    => 'inherit'
		);

		// Insert the attachment.
		$attach_id = wp_insert_attachment( $attachment, $filename, $post_id );

		// Make sure that this file is included, as wp_generate_attachment_metadata() depends on it.
		require_once( ABSPATH . 'wp-admin/includes/image.php' );

		// Generate the metadata for the attachment, and update the database record.
		$attach_data = wp_generate_attachment_metadata( $attach_id, $filename );
		wp_update_attachment_metadata( $attach_id, $attach_data );
		
		if($event_image_type == 'featured_image_event'){
			update_post_meta($post_id, $key, $attach_id);
		}else{
			$image_path = $wp_upload_dir['url'] . '/' . basename( $filename );
			update_post_meta($post_id,$key,$image_path);
		}
		


	   // array_push($galleryImages, $attach_id);

	}
}

add_action('wp_enqueue_scripts', 'callback_for_setting_up_scripts');
function callback_for_setting_up_scripts() {
    
    wp_enqueue_style( 'tcc-style', plugin_dir_url( __FILE__ ).'css/style-tc.css' );
    wp_enqueue_style( 'tcc-style2', 'http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css' );
    wp_enqueue_script( 'tcc-script', plugin_dir_url( __FILE__ ).'js/script-tc.js', array('jquery', 'another_script'), '1.0.0', true );
    wp_enqueue_script( 'tcc-script1', plugin_dir_url( __FILE__ ).'js/jquery.timepicker.js', array('jquery', 'another_script'), '1.0.0', true );
    wp_enqueue_script( 'tcc-script2', 'https://code.jquery.com/ui/1.12.1/jquery-ui.js', array('jquery', 'another_script'), '1.0.0', true );
}

function my_error_notice() {
$ticktra_tc = get_option('tc_version', true);
if($ticktra_tc == ''){
?>
<div class="error notice"><p><?php _e( "Tickera is required for Tickera Frontend Manager add-on", "https://appency.com" ); ?></p></div>
<?php
}
}
add_action( 'admin_notices', 'my_error_notice' );

?>