<?php

/* function enqueue_theme_scripts(){
    wp_enqueue_script( 'share', get_template_directory_uri() . '/static/js/custom.js', array('jquery') );
}
add_action('wp_enqueue_scripts', 'enqueue_theme_scripts' ); */
add_image_size( 'user-thumbnail', 20, 20 );
add_image_size( 'user-display', 80, 80 );
add_image_size( 'home-article-image', 349, 260 );
add_image_size( 'mobile-article-large', 590, 505 );

/*
add_action( 'register_form', 'myplugin_add_registration_fields' );

function myplugin_add_registration_fields() {

    //Get and set any values already sent
    $user_extra = ( isset( $_POST['user_extra'] ) ) ? $_POST['user_extra'] : '';
    ?>

    <p>
        <label for="user_extra"><?php _e( 'Extra Field', 'myplugin_textdomain' ) ?><br />
            <input type="text" name="user_extra" id="user_extra" class="input" value="<?php echo esc_attr( stripslashes( $user_extra ) ); ?>" size="25" /></label>
    </p>

    <?php
}
*/
add_action('acf/render_field_settings/type=text', 'add_readonly_and_disabled_to_text_field');
  function add_readonly_and_disabled_to_text_field($field) {
    acf_render_field_setting( $field, array(
      'label'      => __('Read Only?','acf'),
      'instructions'  => '',
      'type'      => 'radio',
      'name'      => 'readonly',
      'choices'    => array(
        1        => __("Yes",'acf'),
        0        => __("No",'acf'),
      ),
      'layout'  =>  'horizontal',
    ));
    acf_render_field_setting( $field, array(
      'label'      => __('Disabled?','acf'),
      'instructions'  => '',
      'type'      => 'radio',
      'name'      => 'disabled',
      'choices'    => array(
        1        => __("Yes",'acf'),
        0        => __("No",'acf'),
      ),
      'layout'  =>  'horizontal',
    ));
  }
  
function add_payouts_post_type(){
    
    $labels = array(
        'name' => 'Payouts',
        'singular' => 'Payout'
    );
    
    $args = array(
        'labels' => $labels,
        'public' => true,
        'menu_icon' => 'dashicons-money',
        'exclude_from_search' => true
    ); 
    
    register_post_type('payouts', $args);
}

add_action('init', 'add_payouts_post_type');


//Hide admin bar
function hide_admin_bar() {
    return false;
}
add_filter('show_admin_bar', 'hide_admin_bar');

//Logout redirect to home

function my_logout_page( $logout_url ) {
    return home_url( );
}
add_filter( 'logout_redirect', 'my_logout_page', 10, 2 );

/**
 * Get rid of tags on posts.
 */
function unregister_tags() {
    unregister_taxonomy_for_object_type( 'post_tag', 'post' );
}
add_action( 'init', 'unregister_tags' );

/**
 * Get rid of tags on posts.
 */
function unregister_cats() {
    unregister_taxonomy_for_object_type( 'category', 'post' );
}
add_action( 'init', 'unregister_cats' );

//Rename

function change_post_label() {
    global $menu;
    global $submenu;
    $menu[5][0] = 'Articles';
    $submenu['edit.php'][5][0] = 'Articles';
    $submenu['edit.php'][10][0] = 'New Article';
}
function change_post_object() {
    global $wp_post_types;
    $labels = &$wp_post_types['post']->labels;
    $labels->name = 'Articles';
    $labels->singular_name = 'Article';
    $labels->add_new = 'New Article';
    $labels->add_new_item = 'New Article';
    $labels->edit_item = 'Edit Article';
    $labels->new_item = 'Article';
    $labels->view_item = 'View Article';
    $labels->search_items = 'Search Articles';
    $labels->not_found = 'No Articles found';
    $labels->not_found_in_trash = 'No Articles found in Trash';
    $labels->all_items = 'All Articles';
    $labels->menu_name = 'Articles';
    $labels->name_admin_bar = 'Articles';
}
 
add_action( 'admin_menu', 'change_post_label' );
add_action( 'init', 'change_post_object' );

//Google AdSense

  
//Insert ads after second paragraph of single post content.
//add_filter('acf/load_field/key=field_5d0196baa5a9a', 'prefix_insert_post_ads');
add_filter( 'the_content', 'prefix_insert_post_ads' );

function prefix_insert_post_ads( $content ) {
     
    $ad_code = '
    <div class="goog-display">
	    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
	    <ins class="adsbygoogle"
	         style="display:block; text-align:center;"
	         data-ad-layout="in-article"
	         data-ad-format="fluid"
	         data-ad-client="ca-pub-1567375521163478"
	         data-ad-slot="6333794398"></ins>
	    <script>
	         (adsbygoogle = window.adsbygoogle || []).push({});
	    </script>
    </div>
    ';
 
    if ( is_single() && ! is_admin() ) {
        return prefix_insert_after_paragraph( $ad_code, 3, 6, $content );
    }
     
    return $field;
}
  
// Parent Function that makes the magic happen
  
function prefix_insert_after_paragraph( $insertion, $paragraph_id, $paragraph_id2, $content ) {
    $closing_p = '</p>';
    $paragraphs = explode( $closing_p, $content );
    foreach ($paragraphs as $index => $paragraph) {
 
        if ( trim( $paragraph ) ) {
            $paragraphs[$index] .= $closing_p;
        }
 
        if ( $paragraph_id == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
        
        if ( $paragraph_id2 == $index + 1 ) {
            $paragraphs[$index] .= $insertion;
        }
    }
     
    return implode( '', $paragraphs );
}

add_action('wp_head','my_ajaxurl');

function my_ajaxurl() {

$html = '<script type="text/javascript">';
$html .= 'var ajaxurl = "' . admin_url( 'admin-ajax.php' ) . '"';
$html .= '</script>';
echo $html;

}
add_action('wp_ajax_newbid', 'newbid_ajax');
add_action('wp_ajax_nopriv_newbid', 'newbid_ajax');

function newbid_ajax() {

    $post_id = $_POST['pid'];
    $dvote = $_POST['vd'];
	$evote = $_POST['ve'];

if( isset($dvote) && $dvote != " "){
    
    update_post_meta($post_id,'donkey',$dvote);

}
if(isset($evote) && $evote != " "){

	update_post_meta($post_id,'elephant',$evote);
}

    die($mybid);

}

add_action('wp_ajax_dp', 'dp_ajax');
add_action('wp_ajax_nopriv_dp', 'dp_ajax');

function dp_ajax() {
	
    $post_id = $_POST['pid'];

	if( isset($post_id) ){
		
		wp_trash_post( $post_id );

	}

    die($mybid);

}
/* add_action('wp_footer', 'reload'); 
function reload() {
   if(empty($_GET['status'])){
		$actual_link = "https://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
		header('Location:'.$actual_link.'?status=1');
		exit;
	}
} */

function wpa_content_filter( $content ) {
    // run your code on $content and
    $content = stripslashes($content);
    return $content;
}
// add_filter( 'the_content', 'wpa_content_filter' );
// add_filter( 'get_the_content', 'wpa_content_filter' );

require_once( get_template_directory() . '/libs/custom-ajax-auth.php' );
require_once( get_template_directory() . '/libs/custom-user-propic.php' );
require_once( get_template_directory() . '/libs/post-like-dislike.php' );