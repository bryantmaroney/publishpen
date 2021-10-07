<?php
/**
 * Created by PhpStorm.
 * User: GOD
 * Date: 11/28/2019
 * Time: 10:30 PM
 */

function ajax_like_init(){
    wp_register_script('ajax-like-script', get_template_directory_uri() . '/static/js/ajax-like-script.js', array('jquery') );
    wp_enqueue_script('ajax-like-script');

    wp_localize_script( 'ajax-like-script', 'ajax_like_object', array(
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
    ));

    // Enable the user with no privileges to run ajax_like() in AJAX
    add_action( 'wp_ajax_nopriv_ajaxlike', 'ajax_like' );
    add_action( 'wp_ajax_ajaxlike', 'ajax_like' );
}

// Execute the action only if the user isn't logged in

    add_action('init', 'ajax_like_init');


function ajax_like() {
    $post_id = intval( $_POST['post_id'] );
    $post_type = $_POST['post_type'];

    if( filter_var( $post_id, FILTER_VALIDATE_INT ) ) {

        $article = get_post( $post_id );
        $output_count = 0;

        if( !is_null( $article ) ) {
            if($post_type == 'like') {
                $count = get_post_meta( $post_id, 'upvotes', true );
                if( $count == '' ) {
                    update_post_meta( $post_id, 'upvotes', '1' );
                    $output_count = 1;
                } else {
                    $n = intval( $count );
                    $n++;
                    update_post_meta( $post_id, 'upvotes', $n );
                    $output_count = $n;
                }
            } else if($post_type == 'dislike') {
                $count = get_post_meta( $post_id, 'downvotes', true );
                if( $count == '' ) {
                    update_post_meta( $post_id, 'downvotes', '1' );
                    $output_count = 1;
                } else {
                    $n = intval( $count );
                    $n++;
                    update_post_meta( $post_id, 'downvotes', $n );
                    $output_count = $n;
                }
            }

        }
    }

    $output = array( 'count' => $output_count, 'status' => true );
    echo json_encode( $output );
    exit();
}
