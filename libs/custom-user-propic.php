<?php
/**
 * Created by PhpStorm.
 * User: GOD
 * Date: 10/30/2019
 * Time: 5:29 PM
 */

function ajax_custom_propic_init(){
    wp_register_script('ajax-custom-propic-script', get_template_directory_uri() . '/static/js/ajax-custom-propic.js', array('jquery') );
    wp_enqueue_script('ajax-custom-propic-script');

    wp_localize_script( 'ajax-custom-propic-script', 'ajax_custom_propic_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => home_url().'/profile',
        'loadingmessage' => __('Uploading Profile Picture, please wait...')
    ));

    add_action( 'wp_ajax_ajaxCustomPropic', 'ajax_custom_propic' );
}


if (is_user_logged_in()) {
    add_action('init', 'ajax_custom_propic_init');
}

function ajax_custom_propic(){
    $arr_img_ext = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');

    if (in_array($_FILES['propic']['type'], $arr_img_ext)) {
        $upload = wp_upload_bits( $_FILES['propic']['name'], null, file_get_contents( $_FILES['propic']['tmp_name'] ) );
        $wp_filetype = wp_check_filetype( basename( $upload['file'] ), null );
        $wp_upload_dir = wp_upload_dir();
        $attachment = array(
            'guid' => $wp_upload_dir['baseurl'] .'/'. _wp_relative_upload_path( $upload['file'] ),
            'post_mime_type' => $wp_filetype['type'],
            'post_title' => preg_replace('/\.[^.]+$/', '', basename( $upload['file'] )),
            'post_content'   => '',
            'post_status'    => 'inherit'
        );
        $attach_id = wp_insert_attachment( $attachment, $upload['file']);
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        $attach_data = wp_generate_attachment_metadata( $attach_id, $upload['file'] );
        wp_update_attachment_metadata( $attach_id, $attach_data );
        update_user_meta(wp_get_current_user()->id, "be_custom_avatar", $attach_id);
        do_action( 'personal_options_update', wp_get_current_user()->id );
        echo json_encode(array('uploaded'=>true, 'message'=>__('Successfully Changed Profile Picture.')));

        wp_die();
    } else {
        echo json_encode(array('uploaded'=>false, 'message'=>__('Wrong File Type.')));
        wp_die();
    }
}

function wp_gravatar_filter($avatar, $id_or_email, $size, $default, $alt) {
    $custom_avatar =  get_the_author_meta('be_custom_avatar',$id_or_email);
    if ($custom_avatar)
        $return = get_wp_user_avatar_image($id_or_email, $size, $default, $alt);
    elseif ($avatar)
        $return = $avatar;
    else
        $return = '<img src="'.$default.'" width="'.$size.'" height="'.$size.'" alt="'.$alt.'" />';
    return $return;
}


add_filter('get_avatar', 'wp_gravatar_filter', 10, 5);


// Find avatar, show get_avatar if empty
function get_wp_user_avatar_image($id_or_email="", $size='96', $align="", $alt="", $email='unknown@gravatar.com'){

    global $avatar_default, $blog_id, $post, $wpdb, $_wp_additional_image_sizes;
    // Checks if comment
    if(is_object($id_or_email)){
        // Checks if comment author is registered user by user ID
        if($id_or_email->user_id != 0){
            $email = $id_or_email->user_id;
            // Checks that comment author isn't anonymous
        } elseif(!empty($id_or_email->comment_author_email)){
            // Checks if comment author is registered user by e-mail address
            $user = get_user_by('email', $id_or_email->comment_author_email);
            // Get registered user info from profile, otherwise e-mail address should be value
            $email = !empty($user) ? $user->ID : $id_or_email->comment_author_email;
        }

        $alt = $id_or_email->comment_author;
    } else {

        if(!empty($id_or_email)){
            // Find user by ID or e-mail address
            $user = is_numeric($id_or_email) ? get_user_by('id', $id_or_email) : get_user_by('email', $id_or_email);
        } else {
            // Find author's name if id_or_email is empty
            $author_name = get_query_var('author_name');
            if(is_author()){
                // On author page, get user by page slug
                $user = get_user_by('slug', $author_name);
            } else {
                // On post, get user by author meta
                $user_id = get_the_author_meta('ID');
                $user = get_user_by('id', $user_id);
            }
        }

        // Set user's ID and name
        if(!empty($user)){
            $email = $user->ID;
            $alt = $user->display_name;
        }
    }

    // Checks if user has avatar
    $wpua_meta = get_the_author_meta($wpdb->get_blog_prefix($blog_id).'user_avatar', $email);
    $wpua_meta = get_the_author_meta('be_custom_avatar',$email);

    // Add alignment class
    $alignclass = !empty($align) && ($align == 'left' || $align == 'right' || $align == 'center') ? ' align'.$align : ' alignnone';

    // User has avatar, bypass get_avatar
    if(!empty($wpua_meta)){
        // Numeric size use size array
        $get_size = is_numeric($size) ? array($size,$size) : $size;
        // Get image src
        $wpua_image = wp_get_attachment_image_src($wpua_meta, $get_size);
        $dimensions = is_numeric($size) ? ' width="'.$wpua_image[1].'" height="'.$wpua_image[2].'"' : "";
        // Construct the img tag

        $avatar = '<img src="'.$wpua_image[0].'"'.$dimensions.' alt="'.$alt.'" />';
    } else {
        // Get numeric sizes for non-numeric sizes based on media options
        if(!function_exists('get_intermediate_image_sizes')){
            require_once(ABSPATH.'wp-admin/includes/media.php');
        }
        // Check for custom image sizes
        $all_sizes = array_merge(get_intermediate_image_sizes(), array('original'));
        if(in_array($size, $all_sizes)){
            if(in_array($size, array('original', 'large', 'medium', 'thumbnail'))){
                $get_size = ($size == 'original') ? get_option('large_size_w') : get_option($size.'_size_w');
            } else {
                $get_size = $_wp_additional_image_sizes[$size]['width'];
            }
        } else {
            // Numeric sizes leave as-is
            $get_size = $size;
        }

        // User with no avatar uses get_avatar
        $avatar = get_avatar($email, $get_size, $default="", $alt="");
        // Remove width and height for non-numeric sizes
        if(in_array($size, array('original', 'large', 'medium', 'thumbnail'))){
            $avatar = preg_replace('/(width|height)="d*"s/', "", $avatar);
            $avatar = preg_replace("/(width|height)='d*'s/", "", $avatar);
        }
        $str_replacemes = array('wp-user-avatar ', 'wp-user-avatar-'.$get_size.' ', 'wp-user-avatar-'.$size.' ', 'avatar-'.$get_size, 'photo');
        $str_replacements = array("", "", "", 'avatar-'.$size, 'wp-user-avatar wp-user-avatar-'.$size.$alignclass.' photo');

        $avatar = str_replace($str_replacemes, $str_replacements, $avatar);
    }
    return $avatar;
}