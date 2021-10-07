<?php
/**
* Template Name: Create Article Page
*
* @package WordPress
* @subpackage The_Publisher_Pen
* 
*/

get_header(); 

//check if user is logged in or redirect
//if(!is_user_logged_in()){
//    $redirect = site_url(); 
//    echo "<script>window.location = '$redirect' </script>";
//}

if ( is_user_logged_in() ) {} else {
    $redirect = site_url();
    echo "<script>window.location = '$redirect' </script>";
}

$unathorized = false;
$save_failed = false;

//If Edit Article
if(isset($_GET['action']) && $_GET['action'] == 'edit'){
    $page_title = 'Edit Article';

//If Draft
}elseif(isset($_GET['action']) && $_GET['action'] == 'draft'){
     $page_title = 'Edit Draft';

}else{
     $page_title = 'Create Article';

}

//===========SAVE DRAFT ===========// 

     if(isset($_POST['submit-save-draft'])){
         
         $the_post = get_post($_GET['id']);
         $author = $the_post->post_author; 
         /*if(get_current_user_id() != $author){
             $unathorized = true;
             exit;
         }*/
         
         
        //  $post_content = str_replace("\r\n",'<br \>',trim($_POST['editordata']));
        //  $post_content = str_replace("rn",'<br \>',trim($post_content));
           
         $new_post = array(
             'ID' => $_GET['id'],
             'post_title' => wp_strip_all_tags( $_POST['post_title'] ),
             'post_status'   => 'draft',
             'post_content' => esc_sql(trim($_POST['editordata'])),
			 'post_type'     => 'post',
             );
             
    //      $new_post = array(
    //          'ID' => $_GET['id'],
    //          'post_title' => wp_strip_all_tags( $_POST['post_title'] ),
    //          'post_status'   => 'draft',
    //          'post_content' => esc_sql($_POST['editordata']),
			 //'post_type'     => 'post',
    //          );
             
            
          $new_post_id = wp_insert_post($new_post); 
          
           if($new_post_id){

            //Success
            update_field('content', $_POST['editordata'], $new_post_id);
            update_field('image_caption', $_POST['image_caption'], $new_post_id);
            update_field('references', $_POST['references'], $new_post_id);
            update_field('category', $_POST['category'], $new_post_id);
            update_field('subcategory_world', $_POST['subcategory_world'], $new_post_id);
            update_field('subcategory_us', $_POST['subcategory_us'], $new_post_id);
            update_field('subcategory_politics', $_POST['subcategory_politics'], $new_post_id);
            update_field('subcategory_local', $_POST['subcategory_local'], $new_post_id);
            update_field('subcategory_businenss', $_POST['subcategory_business'], $new_post_id);
            update_field('subcategory_technology', $_POST['subcategory_technology'], $new_post_id);
            update_field('subcategory_science', $_POST['subcategory_science'], $new_post_id);
            update_field('subcategory_health', $_POST['subcategory_health'], $new_post_id);
            update_field('subcategory_sports', $_POST['subcategory_sports'], $new_post_id);
            update_field('subcategory_arts', $_POST['subcategory_arts'], $new_post_id);
            update_field('subcategory_books', $_POST['subcategory_books'], $new_post_id);
            update_field('subcategory_style', $_POST['subcategory_style'], $new_post_id);
            update_field('subcategory_food', $_POST['subcategory_food'], $new_post_id);
            update_field('subcategory_travel', $_POST['subcategory_travel'], $new_post_id);
             
             
           
         //Upload Image
           
          // WordPress environment
            require( dirname(__FILE__) . '/../../../wp-load.php' );
             
            $wordpress_upload_dir = wp_upload_dir();
            // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
            // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
            $i = 1; // number of tries when the file with the same name is already exists
             
            $profilepicture = $_FILES['featured_image'];
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
            $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
             
            if( !empty( $profilepicture ) ){
            
             
            if( $profilepicture['error'] )
            	 //failed
                $save_failed = true;
             
            if( $profilepicture['size'] > wp_max_upload_size() )
            	 //failed
                 $save_failed = true;
             
            if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
            	 //failed
                    $save_failed = true;
             
            while( file_exists( $new_file_path ) ) {
            	$i++;
            	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
            }
             
            // looks like everything is OK
            if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
             
             
            	$upload_id = wp_insert_attachment( array(
            		'guid'           => $new_file_path, 
            		'post_mime_type' => $new_file_mime,
            		'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
            		'post_content'   => '',
            		'post_status'    => 'inherit'
            	), $new_file_path );
             
            	// wp_generate_attachment_metadata() won't work if you do not include this file
            	require_once( ABSPATH . 'wp-admin/includes/image.php' );
             
            	// Generate and save the attachment metas into the database
            	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
             
             update_field('featured_image', $upload_id, $new_post_id);
             
            }
            } 
         
            
            $redirect = site_url() . '/create-article?action=draft&id=' . $new_post_id . '&saved=true';
            echo "<script> window.location = '$redirect'; </script>";
            
        }else{
            //failed
            $save_failed = true;
            
            
        }
     }
     
//===========SAVE ARTICLE ===========// 

     if(isset($_POST['submit-save-article'])){
         $the_post = get_post($_GET['id']);
         $author = $the_post->post_author; 
         /*if(get_current_user_id() != $author){
             $unathorized = true;
             exit;
         }*/
         
        //  $post_content = str_replace("\r\n",'<br \>',trim($_POST['editordata']));
        //  $post_content = str_replace("rn",'<br \>',trim($post_content));
           
         $new_post = array(
             'ID' => $_GET['id'],
             'post_title' => wp_strip_all_tags( $_POST['post_title'] ),
             'post_status'   => 'publish',
             'post_content' => esc_sql(trim($_POST['editordata'])),
			 'post_type'     => 'post',
             );
             
        $new_post_id = wp_insert_post($new_post);
        
        if($new_post_id){
            //Success
            update_field('content', $_POST['editordata'], $new_post_id);
            update_field('image_caption', $_POST['image_caption'], $new_post_id);
            update_field('references', $_POST['references'], $new_post_id);
            update_field('category', $_POST['category'], $new_post_id);
            update_field('subcategory_world', $_POST['subcategory_world'], $new_post_id);
            update_field('subcategory_us', $_POST['subcategory_us'], $new_post_id);
            update_field('subcategory_politics', $_POST['subcategory_politics'], $new_post_id);
            update_field('subcategory_local', $_POST['subcategory_local'], $new_post_id);
            update_field('subcategory_businenss', $_POST['subcategory_business'], $new_post_id);
            update_field('subcategory_technology', $_POST['subcategory_technology'], $new_post_id);
            update_field('subcategory_science', $_POST['subcategory_science'], $new_post_id);
            update_field('subcategory_health', $_POST['subcategory_health'], $new_post_id);
            update_field('subcategory_sports', $_POST['subcategory_sports'], $new_post_id);
            update_field('subcategory_arts', $_POST['subcategory_arts'], $new_post_id);
            update_field('subcategory_books', $_POST['subcategory_books'], $new_post_id);
            update_field('subcategory_style', $_POST['subcategory_style'], $new_post_id);
            update_field('subcategory_food', $_POST['subcategory_food'], $new_post_id);
            update_field('subcategory_travel', $_POST['subcategory_travel'], $new_post_id);
       
            //Upload Image
           
            // WordPress environment
            require( dirname(__FILE__) . '/../../../wp-load.php' );
             
            $wordpress_upload_dir = wp_upload_dir();
            // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
            // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
            $i = 1; // number of tries when the file with the same name is already exists
             
            $profilepicture = $_FILES['featured_image'];
            $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
            $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );
             
            if( !empty( $profilepicture ) ) {
            	
             
                if( $profilepicture['error'] )
                	 //failed
                    $save_failed = true;
                 
                if( $profilepicture['size'] > wp_max_upload_size() )
                	 //failed
                    $save_failed = true;
                 
                if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
                	 //failed
                    $save_failed = true;
                 
                while( file_exists( $new_file_path ) ) {
                	$i++;
                	$new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
                }
                 
                // looks like everything is OK
                if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {
                 
                 
                	$upload_id = wp_insert_attachment( array(
                		'guid'           => $new_file_path, 
                		'post_mime_type' => $new_file_mime,
                		'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
                		'post_content'   => '',
                		'post_status'    => 'inherit'
                	), $new_file_path );
                 
                	// wp_generate_attachment_metadata() won't work if you do not include this file
                	require_once( ABSPATH . 'wp-admin/includes/image.php' );
                 
                	// Generate and save the attachment metas into the database
                	wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );
                 
                 update_field('featured_image', $upload_id, $new_post_id);
                 
                }
            }
            
            $redirect = get_the_permalink($new_post_id);
            echo "<script> window.location = '$redirect'; </script>";
            
        }else{
            //failed
            $save_failed = true;
            
            
        }
     }
    
     if(isset($_POST['preview_article'])) {
         $the_post = get_post($_GET['id']);
         $author = $the_post->post_author;

         $new_post = array(
             'ID' => $_GET['id'],
             'post_title' => wp_strip_all_tags( $_POST['post_title'] ),
             'post_status'   => 'draft',
             'post_content' => esc_sql($_POST['editordata']),
             'post_type'     => 'post',
         );


         $new_post_id = wp_insert_post($new_post);

         if($new_post_id){
             //Success
             update_field('content', $_POST['editordata'], $new_post_id);
             update_field('image_caption', $_POST['image_caption'], $new_post_id);
             update_field('references', $_POST['references'], $new_post_id);
             update_field('category', $_POST['category'], $new_post_id);
             update_field('subcategory_world', $_POST['subcategory_world'], $new_post_id);
             update_field('subcategory_us', $_POST['subcategory_us'], $new_post_id);
             update_field('subcategory_politics', $_POST['subcategory_politics'], $new_post_id);
             update_field('subcategory_local', $_POST['subcategory_local'], $new_post_id);
             update_field('subcategory_businenss', $_POST['subcategory_business'], $new_post_id);
             update_field('subcategory_technology', $_POST['subcategory_technology'], $new_post_id);
             update_field('subcategory_science', $_POST['subcategory_science'], $new_post_id);
             update_field('subcategory_health', $_POST['subcategory_health'], $new_post_id);
             update_field('subcategory_sports', $_POST['subcategory_sports'], $new_post_id);
             update_field('subcategory_arts', $_POST['subcategory_arts'], $new_post_id);
             update_field('subcategory_books', $_POST['subcategory_books'], $new_post_id);
             update_field('subcategory_style', $_POST['subcategory_style'], $new_post_id);
             update_field('subcategory_food', $_POST['subcategory_food'], $new_post_id);
             update_field('subcategory_travel', $_POST['subcategory_travel'], $new_post_id);

             //Upload Image

             // WordPress environment
             require( dirname(__FILE__) . '/../../../wp-load.php' );

             $wordpress_upload_dir = wp_upload_dir();
             // $wordpress_upload_dir['path'] is the full server path to wp-content/uploads/2017/05, for multisite works good as well
             // $wordpress_upload_dir['url'] the absolute URL to the same folder, actually we do not need it, just to show the link to file
             $i = 1; // number of tries when the file with the same name is already exists

             $profilepicture = $_FILES['featured_image'];
             $new_file_path = $wordpress_upload_dir['path'] . '/' . $profilepicture['name'];
             $new_file_mime = mime_content_type( $profilepicture['tmp_name'] );

             if( !empty( $profilepicture ) ){

                 if( $profilepicture['error'] )
                     //failed
                     $save_failed = true;

                 if( $profilepicture['size'] > wp_max_upload_size() )
                     //failed
                     $save_failed = true;

                 if( !in_array( $new_file_mime, get_allowed_mime_types() ) )
                     //failed
                     $save_failed = true;

                 while( file_exists( $new_file_path ) ) {
                     $i++;
                     $new_file_path = $wordpress_upload_dir['path'] . '/' . $i . '_' . $profilepicture['name'];
                 }

                 // looks like everything is OK
                 if( move_uploaded_file( $profilepicture['tmp_name'], $new_file_path ) ) {

                     $upload_id = wp_insert_attachment( array(
                         'guid'           => $new_file_path,
                         'post_mime_type' => $new_file_mime,
                         'post_title'     => preg_replace( '/\.[^.]+$/', '', $profilepicture['name'] ),
                         'post_content'   => '',
                         'post_status'    => 'inherit'
                     ), $new_file_path );

                     // wp_generate_attachment_metadata() won't work if you do not include this file
                     require_once( ABSPATH . 'wp-admin/includes/image.php' );

                     // Generate and save the attachment metas into the database
                     wp_update_attachment_metadata( $upload_id, wp_generate_attachment_metadata( $upload_id, $new_file_path ) );

                     update_field('featured_image', $upload_id, $new_post_id);

                 }
             }

             $previewLink = get_preview_post_link($new_post_id);

             $redirect = $previewLink;
             echo "<script> window.location = '$redirect'; </script>";

         }else{
             //failed
             $save_failed = true;
         }
     }

?> 
	
	<section class = "be-content new-post-container">
		<div class = "main-content container-fluid">
		    <div class = "row">
				<div class = "col-12">
				    <?php if(isset($_GET['saved'])) { ?>
    					<div class="alert alert-success alert-dismissible" role="alert">
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                        <div class="icon"><span class="mdi mdi-check"></span></div>
                        <div class="message"><strong>Nice work!</strong> Your draft has been saved.</div>
                        </div>
                   <?php } ?>
                   <?php if($save_failed == true){ ?>
                        <div class="alert alert-warning alert-dismissible" role="alert">
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                        <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
                        <div class="message"><strong>Oops!</strong> Something went wrong and your article was not saved.</div>
                        </div>
                   <?php } ?>
                   <?php if($unauthorized == true){ ?>
                        <div class="alert alert-danger alert-dismissible" role="alert">
                        <button class="close" type="button" data-dismiss="alert" aria-label="Close"><span class="mdi mdi-close" aria-hidden="true"></span></button>
                        <div class="icon"> <span class="mdi mdi-close-circle-o"></span></div>
                        <div class="message"><strong>Oops!</strong> This isn't your article. You cannot edit it. </div>
                       </div>
                  <?php } ?>
				</div>
			</div>
			
			<div class="row">
			    <div class="col-12">
			        <div class="card create-article-div">
                        <div class="card-header card-header-divider">
                            <h1 class="action_title"><?php echo $page_title; ?></h1>
                            <span class="card-subtitle action_sub-title mobile-move-header">Write great content and earn!</span>
						</div>
                        <div class="card-body">
                          <form enctype="multipart/form-data" method="post" class="create-article-page" id="articleActionForm">
                              
                            <div class="row">
                                <div class="col-md-6">
                                    <!--  Categories -->  
                                    <div class="form-group row">
                                      <label class="col-12">Category</label>
                                      <div class="col-12">
                                          <select name="category" id="category" class="form-control" >
                                              <option selected disabled   value=' ' >Select a category</option>
                                              <option value="World" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 0){ echo 'selected'; } ?> >World</option>
                                              <option value="U.S." <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 1){ echo 'selected'; } ?> >U.S.</option>
                                              <option value="Politics" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 2){ echo 'selected'; } ?> >Politics</option>
                                              <option value="Local" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 3){ echo 'selected'; } ?> >Local</option>
                                              <option value="Business" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 4){ echo 'selected'; } ?> >Business</option>
                                              <option value="Technology" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 5){ echo 'selected'; } ?> >Technology</option>
                                              <option value="Science" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 6){ echo 'selected'; } ?> >Science</option>
                                              <option value="Health" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 7){ echo 'selected'; } ?> >Health</option>
                                              <option value="Sports" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 8){ echo 'selected'; } ?> >Sports</option>
                                              <option value="Arts" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 9){ echo 'selected'; } ?> >Arts</option>
                                              <option value="Books" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 10){ echo 'selected'; } ?> >Books</option>
                                              <option value="Style" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 11){ echo 'selected'; } ?> >Style</option>
                                              <option value="Food" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 12){ echo 'selected'; } ?> >Food</option>
                                              <option value="Travel" <?php if(isset($_GET['id']) && get_field('category', $_GET['id']) == 13){ echo 'selected'; } ?> >Travel</option>
                                          </select>
                                          
                                        <div class="invalid-feedback category-invalid-feedback">Please choose a category.</div>
                                      </div>
                                    </div>
                                </div>
                                 <div class="col-md-6">
                                     <!--  SubCategories -->  
                                    <div class="form-group row">
                                        <?php
                                        if(isset($_GET['action'])) {
                                        ?>
                                        <label class="col-12">Subcategory</label>
                                        <?php } else {?>
                                      <label class="col-12 create-sub-category">Subcategory</label>
                                      <?php }?>
                                      <div class="col-12 sub-category-group">
                                          
                                          <!-- No Category Selected --> 
                                          <select name="subcategory_none" id="subcategoryNone" class="form-control showCatList" style="background-color: #f5f5f5; color: #8a8a8a;">
                                              <option selected disabled hidden value=''>Select a subcategory</option>
                                          </select>
                                          
                                          <!-- World -->
                                          <select name="subcategory_world" id="subcategoryWorld" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 0){ echo 'selected'; } ?> >Politics</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 1){ echo 'selected'; } ?> >Local</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 2){ echo 'selected'; } ?> >Business</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 3){ echo 'selected'; } ?> >Technology</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 4){ echo 'selected'; } ?> >Science</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 5){ echo 'selected'; } ?> >Health</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 6){ echo 'selected'; } ?> >Sports</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 7){ echo 'selected'; } ?> >Arts</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 8){ echo 'selected'; } ?> >Books</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 9){ echo 'selected'; } ?> >Style</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 10){ echo 'selected'; } ?> >Food</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_world', $_GET['id']) == 11){ echo 'selected'; } ?> >Travel</option>
                                          </select>
                                          
                                          <!-- US -->
                                           <select name="subcategory_us" id="subcategory-us" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 0){ echo 'selected'; } ?> >World Relations</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 1){ echo 'selected'; } ?> >Government</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 2){ echo 'selected'; } ?> >Politics</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 3){ echo 'selected'; } ?> >Local</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 4){ echo 'selected'; } ?> >Business</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 5){ echo 'selected'; } ?> >Technology</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 6){ echo 'selected'; } ?> >Science</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 7){ echo 'selected'; } ?> >Health</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 8){ echo 'selected'; } ?> >Sports</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 9){ echo 'selected'; } ?> >Arts</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 10){ echo 'selected'; } ?> >Books</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 11){ echo 'selected'; } ?> >Style</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 12){ echo 'selected'; } ?> >Food</option>
                                              <option value="13" <?php if(isset($_GET['id']) && get_field('subcategory_us', $_GET['id']) == 13){ echo 'selected'; } ?> >Travel</option>
                                          </select>
                                          
                                          <!-- Politics -->
                                           <select name="subcategory_politics" id="subcategory-politics" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 0){ echo 'selected'; } ?> >World</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 1){ echo 'selected'; } ?> >U.S.</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 2){ echo 'selected'; } ?> >Abortion</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 3){ echo 'selected'; } ?> >Animals</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 4){ echo 'selected'; } ?> >Civil Rights</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 5){ echo 'selected'; } ?> >Death Penalty</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 6){ echo 'selected'; } ?> >Education</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 7){ echo 'selected'; } ?> >Firearms</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 8){ echo 'selected'; } ?> >Free Trade</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 9){ echo 'selected'; } ?> >Healthcare</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 10){ echo 'selected'; } ?> >Immigration</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 11){ echo 'selected'; } ?> >Language</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 12){ echo 'selected'; } ?> >NAFTA</option>
                                              <option value="13" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 13){ echo 'selected'; } ?> >Patient Rights</option>
                                              <option value="14" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 14){ echo 'selected'; } ?> >Race Relations</option>
                                              <option value="15" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 15){ echo 'selected'; } ?> >Tobacco</option>
                                              <option value="16" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 16){ echo 'selected'; } ?> >State of the Union</option>
                                              <option value="17" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 17){ echo 'selected'; } ?> >Terrorism</option>
                                              <option value="18" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 18){ echo 'selected'; } ?> >War & Peace</option>
                                              <option value="19" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 19){ echo 'selected'; } ?> >Welfare</option>
                                              <option value="20" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 20){ echo 'selected'; } ?> >Government Budget</option>
                                              <option value="21" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 21){ echo 'selected'; } ?> >Economy</option>
                                              <option value="22" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 22){ echo 'selected'; } ?> >Global Warming</option>
                                              <option value="23" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 23){ echo 'selected'; } ?> >Energy & Oil</option>
                                              <option value="24" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 24){ echo 'selected'; } ?> >Taxes</option>
                                              <option value="25" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 25){ echo 'selected'; } ?> >LGBT</option>
                                              <option value="26" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 26){ echo 'selected'; } ?> >Homeland Security</option>
                                              <option value="27" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 27){ echo 'selected'; } ?> >Innfrastructure</option>
                                              <option value="28" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 28){ echo 'selected'; } ?> >Medical Marijuana</option>
                                              <option value="29" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 29){ echo 'selected'; } ?> >Nuclear Energy</option>
                                              <option value="30" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 30){ echo 'selected'; } ?> >Political Corruption</option>
                                              <option value="31" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 31){ echo 'selected'; } ?> >Religion</option>
                                              <option value="32" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 32){ echo 'selected'; } ?> >Censorship</option>
                                              <option value="33" <?php if(isset($_GET['id']) && get_field('subcategory_politics', $_GET['id']) == 33){ echo 'selected'; } ?> >Technology</option>
                                          </select>
                                          
                                          <!-- Local -->
                                           <select name="subcategory_local" id="subcategory-local" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 0){ echo 'selected'; } ?> >Politics</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 1){ echo 'selected'; } ?> >Business</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 2){ echo 'selected'; } ?> >Tech</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 3){ echo 'selected'; } ?> >Science</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 4){ echo 'selected'; } ?> >Health</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 5){ echo 'selected'; } ?> >Sports</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 6){ echo 'selected'; } ?> >Arts</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 7){ echo 'selected'; } ?> >Books</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 8){ echo 'selected'; } ?> >Style</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 9){ echo 'selected'; } ?> >Food</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 10){ echo 'selected'; } ?> >Travel</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 11){ echo 'selected'; } ?> >Child Abuse and Neglect</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 12){ echo 'selected'; } ?> >Crime</option>
                                              <option value="13" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 13){ echo 'selected'; } ?> >Domestic Violence</option>
                                              <option value="14" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 14){ echo 'selected'; } ?> >Drug</option>
                                              <option value="15" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 15){ echo 'selected'; } ?> >Environment</option>
                                              <option value="16" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 16){ echo 'selected'; } ?> >Ethnic Conflict</option>
                                              <option value="17" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 17){ echo 'selected'; } ?> >Hunger</option>
                                              <option value="18" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 18){ echo 'selected'; } ?> >Emergency Services</option>
                                              <option value="19" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 19){ echo 'selected'; } ?> >Inequality</option>
                                              <option value="20" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 20){ echo 'selected'; } ?> >Jobs</option>
                                              <option value="21" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 21){ echo 'selected'; } ?> >Housing</option>
                                              <option value="22" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 22){ echo 'selected'; } ?> >Poverty</option>
                                              <option value="23" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 23){ echo 'selected'; } ?> >Racism</option>
                                              <option value="24" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 24){ echo 'selected'; } ?> >Transportation</option>
                                              <option value="25" <?php if(isset($_GET['id']) && get_field('subcategory_local', $_GET['id']) == 25){ echo 'selected'; } ?> >Violence</option>
                                          </select>
                                          
                                           <!-- Business -->
                                           <select name="subcategory_business" id="subcategory-business" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 0){ echo 'selected'; } ?> >Economy</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 1){ echo 'selected'; } ?> >Markets</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 2){ echo 'selected'; } ?> >Jobs</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 3){ echo 'selected'; } ?> >Personal Finance</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 4){ echo 'selected'; } ?> >Entrepreneurship</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 5){ echo 'selected'; } ?> >A.I.</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 6){ echo 'selected'; } ?> >Social Media</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 7){ echo 'selected'; } ?> >Milennials</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 8){ echo 'selected'; } ?> >Wages</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 9){ echo 'selected'; } ?> >Learning</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_business', $_GET['id']) == 10){ echo 'selected'; } ?> >Community</option>
                                          </select>
                                          
                                           <!-- Technology -->
                                           <select name="subcategory_technology" id="subcategory-technology" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 0){ echo 'selected'; } ?> >Mobile</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 1){ echo 'selected'; } ?> >Gadgets</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 2){ echo 'selected'; } ?> >Internet</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 3){ echo 'selected'; } ?> >Virtual Reality</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 4){ echo 'selected'; } ?> >A.I.</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 5){ echo 'selected'; } ?> >Cloud Computing</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 6){ echo 'selected'; } ?> >Blockchain</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 7){ echo 'selected'; } ?> >Politics</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 8){ echo 'selected'; } ?> >Business</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 9){ echo 'selected'; } ?> >Science</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 10){ echo 'selected'; } ?> >Health</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 11){ echo 'selected'; } ?> >Social Media</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 12){ echo 'selected'; } ?> >Millennials</option>
                                              <option value="13" <?php if(isset($_GET['id']) && get_field('subcategory_technology', $_GET['id']) == 13){ echo 'selected'; } ?> >Learning</option>
                                          </select>
                                          
                                           <!-- Science -->
                                           <select name="subcategory_science" id="subcategory-science" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 0){ echo 'selected'; } ?> >World</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 1){ echo 'selected'; } ?> >U.S.</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 2){ echo 'selected'; } ?> >Politics</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 3){ echo 'selected'; } ?> >Local</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 4){ echo 'selected'; } ?> >Business</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 5){ echo 'selected'; } ?> >Technology</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 6){ echo 'selected'; } ?> >Health</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 7){ echo 'selected'; } ?> >Sports</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 8){ echo 'selected'; } ?> >Arts</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 9){ echo 'selected'; } ?> >Books</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 10){ echo 'selected'; } ?> >Style</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 11){ echo 'selected'; } ?> >Food</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_science', $_GET['id']) == 12){ echo 'selected'; } ?> >Travel</option>
                                          </select>
                                          
                                          <!-- Health -->
                                           <select name="subcategory_health" id="subcategory-health" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 0){ echo 'selected'; } ?> >Medicine</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 1){ echo 'selected'; } ?> >Healthcare</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 2){ echo 'selected'; } ?> >Mental Health</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 3){ echo 'selected'; } ?> >Nutrition</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 4){ echo 'selected'; } ?> >Fitness</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 5){ echo 'selected'; } ?> >Social Media</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 6){ echo 'selected'; } ?> >Millennials</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 7){ echo 'selected'; } ?> >Learning</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 8){ echo 'selected'; } ?> >Community</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_health', $_GET['id']) == 9){ echo 'selected'; } ?> >Jobs</option>
                                          </select>
                                          
                                          <!-- Sports -->
                                           <select name="subcategory_sports" id="subcategory-sports" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 0){ echo 'selected'; } ?> >NFL</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 1){ echo 'selected'; } ?> >NBA</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 2){ echo 'selected'; } ?> >MLB</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 3){ echo 'selected'; } ?> >NHL</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 4){ echo 'selected'; } ?> >NCAA Football</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 5){ echo 'selected'; } ?> >NCAA Basketball</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 6){ echo 'selected'; } ?> >Soccer</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 7){ echo 'selected'; } ?> >NASCAR</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 8){ echo 'selected'; } ?> >Golf</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 9){ echo 'selected'; } ?> >Tennis</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_sports', $_GET['id']) == 10){ echo 'selected'; } ?> >WNBA</option>
                                          </select>
                                          
                                          <!-- Arts -->
                                           <select name="subcategory_arts" id="subcategory-arts" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 0){ echo 'selected'; } ?> >Drawing</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 1){ echo 'selected'; } ?> >Design</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 2){ echo 'selected'; } ?> >Visual Arts</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 3){ echo 'selected'; } ?> >Music</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 4){ echo 'selected'; } ?> >Craft</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 5){ echo 'selected'; } ?> >Abstract Art</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 6){ echo 'selected'; } ?> >Painting</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 7){ echo 'selected'; } ?> >Cinematography</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 8){ echo 'selected'; } ?> >Photography</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 9){ echo 'selected'; } ?> >Movies</option>
                                              <option value="10" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 10){ echo 'selected'; } ?> >TV</option>
                                              <option value="11" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 11){ echo 'selected'; } ?> >Books</option>
                                              <option value="12" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 12){ echo 'selected'; } ?> >Theatre</option>
                                              <option value="13" <?php if(isset($_GET['id']) && get_field('subcategory_arts', $_GET['id']) == 13){ echo 'selected'; } ?> >Celebrities</option>
                                          </select>
                                          
                                          <!-- Books -->
                                           <select name="subcategory_books" id="subcategory-books" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 0){ echo 'selected'; } ?> >Romance</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 1){ echo 'selected'; } ?> >Sci-Fi</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 2){ echo 'selected'; } ?> >Fantasy</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 3){ echo 'selected'; } ?> >Mystery</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 4){ echo 'selected'; } ?> >Thriller</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 5){ echo 'selected'; } ?> >Chrime</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 6){ echo 'selected'; } ?> >Nonfiction</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 7){ echo 'selected'; } ?> >Historical</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 8){ echo 'selected'; } ?> >Young adult</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_books', $_GET['id']) == 9){ echo 'selected'; } ?> >Classics</option>
                                          </select>
                                          
                                          <!-- Style -->
                                           <select name="subcategory_style" id="subcategory-style" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 0){ echo 'selected'; } ?> >Movies</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 1){ echo 'selected'; } ?> >Music</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 2){ echo 'selected'; } ?> >TV</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 3){ echo 'selected'; } ?> >Books</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 4){ echo 'selected'; } ?> >Art</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 5){ echo 'selected'; } ?> >Celebrities</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 6){ echo 'selected'; } ?> >Fashion</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_style', $_GET['id']) == 7){ echo 'selected'; } ?> >Trending</option>
                                          </select>
                                          
                                          <!-- Food -->
                                           <select name="subcategory_food" id="subcategory-food" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 0){ echo 'selected'; } ?> >Organic</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 1){ echo 'selected'; } ?> >Recipes</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 2){ echo 'selected'; } ?> >Supplements</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 3){ echo 'selected'; } ?> >Mental Health</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 4){ echo 'selected'; } ?> >Diet</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 5){ echo 'selected'; } ?> >World Foods</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 6){ echo 'selected'; } ?> >Nutrition</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 7){ echo 'selected'; } ?> >Vegan</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 8){ echo 'selected'; } ?> >Allergies</option>
                                              <option value="9" <?php if(isset($_GET['id']) && get_field('subcategory_food', $_GET['id']) == 9){ echo 'selected'; } ?> >Food Prep</option>
                                          </select>
                                          
                                          <!-- Travel -->
                                           <select name="subcategory_travel" id="subcategory-travel" class="form-control" style="display: none;">
                                              <option selected disabled hidden style='display: none' value=''>Select a subcategory</option>
                                              <option value="0" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 0){ echo 'selected'; } ?> >Travel Blogs</option>
                                              <option value="1" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 1){ echo 'selected'; } ?> >Outdoors</option>
                                              <option value="2" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 2){ echo 'selected'; } ?> >Adventure</option>
                                              <option value="3" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 3){ echo 'selected'; } ?> >Backpacking</option>
                                              <option value="4" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 4){ echo 'selected'; } ?> >Tourism</option>
                                              <option value="5" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 5){ echo 'selected'; } ?> >Hotels</option>
                                              <option value="6" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 6){ echo 'selected'; } ?> >Bucket List</option>
                                              <option value="7" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 7){ echo 'selected'; } ?> >Local Tips</option>
                                              <option value="8" <?php if(isset($_GET['id']) && get_field('subcategory_travel', $_GET['id']) == 8){ echo 'selected'; } ?> >Tour Guide</option>
                                          </select>
                                          
                                          
                                       
                                       
                                        <div class="invalid-feedback subcategory-invalid-feedback">Please choose a subcategory.</div>
                                      </div>
                                    </div>
                                    
                                </div>
                            </div>
                              
                            
                            
                            
                              
                            <div class="form-group row">
                              <label class="col-12" for="title">Title</label>
                              <div class="col-12">
                                <input name="post_title" class="form-control" id="title" type="text" value="<?php if(isset($_GET['id'])){ echo get_post($_GET['id'])->post_title; } ?>">
                                <div class="invalid-feedback title-invalid-feedback">Please enter a title.</div>
                              </div>
                            </div>
                            
                            
                            
                        <div class="row">
                            <?php if(isset($_GET['id'])){ ?>
                            <div class="col-12"><img id="featuredImage" src="<?php if(isset($_GET['id'])){ $fe = get_field('featured_image', $_GET['id']); echo $fe['sizes']['thumbnail']; } ?>" /></div>
							<?php 
/* 							$fe = get_field('featured_image', $_GET['id']);
							echo"<pre>";
							print_r($fe['sizes']['thumbnail']);
							echo"</pre>"; */
							?>
                            <?php } ?>
                            <div class="col-md-3">
                                
                            <div class="form-group row">
                              <label class="col-12" for="featured_image">Featured Image</label>
                              <div class = "col-12 featuredImage-div">
                                <img id = "featuredImage" style="width: 100%;margin-bottom:30px;">
                              </div>

                            <div class="col-12">
                                <input class="inputfile" id="featured_image" type="file" name="featured_image" multiple="false" <?php if(!isset($_GET['id'])){ echo 'required'; } ?> >
                                <label class="" id="btn_featured_image"> <span class="article_image-upload--span"><?php if(!isset($_GET['id'])){ echo 'Upload Images'; }else{ echo 'Change image...'; } ?> <img src="<?php echo get_template_directory_uri() . '/assets/images/file-upload.png'; ?>" class="article_image-upload"></span></label>
                                <div class="invalid-feedback image-invalid-feedback">Please choose an image.</div>
                              </div>
                            </div>
                            <!--<i class="mdi mdi-upload"></i>-->
                            </div>
                            
                            <div class="col-md-9">
                                <br>
                             <div class="form-group row image-caption">
                              <label class="col-12" for="imageCaption">Image Caption</label>
                              <div class="col-12">
                                <input name="image_caption" class="form-control" id="imageCaption" value="<?php if(isset($_GET['id'])){ the_field('image_caption', $_GET['id']); } ?>" type="text">
                              </div>
                            </div>
                            
                            </div>
                        </div>
                        
                        
                            
                            <div id="editor1" style="display: none;"></div>
                            <div class="form-group row">
                              <label class="col-12" for="inputTextarea3">Content</label>
                              <div class="col-12">
                                  <textarea id="summernote" name="editordata" class="form-control"> <?php if(isset($_GET['id'])){ the_field('content', $_GET['id']); } ?></textarea>
                                 <div class="invalid-feedback content-invalid-feedback">Please enter the content of your article, minimum length is 100.</div>
                              </div>
                            </div>
                            
                             <div class="form-group row">
                              <label class="col-12" for="reference">References</label>
                              <div class="col-12">
                                <input name="references" class="form-control" id="reference" value="<?php if(isset($_GET['id'])){ the_field('references', $_GET['id']); } ?>" type="text">
                                
                              </div>
                            </div>
                            
                            <div class="form-group row">
                            <div class="col-12 submit-save-mobile">
                                <input class="btn btn-primary btn-space-form-publish" type="button"  value="Publish" id="publishBtn"/>
                                <input class="btn btn-space-func" type="submit"  name="submit-save-draft" value="Save Draft" />
                                <input class="btn btn-secondary btn-space-func" type="submit" name="preview_article" value="Preview" />
                            </div>
                          </div>
                            
                            
                            
                              </div>
                            </div>
                          </form>
                        </div>
                      </div>
			    </div>
			    

		
	</section>

<script>
jQuery( document ).ready(function($) {
     $('#btn_featured_image').click(function() {
         $('#featured_image').click();
     });
        $('#featured_image').change(function(){
            previewImage(this);
        });
        
        previewImage($("#featured_image")[0]);

        function previewImage(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                
                reader.onload = function(e) {
                    $('#featuredImage').attr('src', e.target.result);
                }
                
                reader.readAsDataURL(input.files[0]);
                $("#featuredImage").css('margin-bottom','30px');
            } else {
                $("#featuredImage").css('margin-bottom','0px');
            }
        }
		$('#category').change(function(){
			// console.log();
			let selectedValue = $(this).children("option:selected").val();
			/* alert(selectedValue); */
			getSubCategory(selectedValue);
		});
		
		let selectedValue = $('#category').children("option:selected").val();
		getSubCategory(selectedValue);

                                                
function getSubCategory(selectedValue) {
	if($('#category option:selected').prop('disabled') == true){
	    console.log('no selection');
	} else {
	    console.log('yes selection');
	    
	    $( ".create-sub-category" ).css( "display", "none" );
		$( ".sub-category-group" ).find( "select" ).css( "display", "none" );
	}
	
    //$( ".create-sub-category" ).css( "display", "none" );
    //$( ".sub-category-group" ).find( "select" ).css( "display", "none" ); 
    
    if(selectedValue != " ") {
        $( ".create-sub-category" ).css( "display", "block" );
    }
    
    switch ( selectedValue ) {
        case 'World' :
            $('#subcategoryWorld').css('display', 'block');
            break;
        case 'U.S.' :
            $('#subcategory-us').css('display', 'block');
            break;
        case 'Politics' :
            
            $('#subcategory-politics').css('display', 'block');
            break;
        case 'Local' :
            $('#subcategory-local').css('display', 'block');
            break;
        case 'Business' :
            $('#subcategory-business').css('display', 'block');
            break;
        case 'Technology' :
            $('#subcategory-technology').css('display', 'block');
            break;
        case 'Science' :
            $('#subcategory-science').css('display', 'block');
            break;
        case 'Health' :
            $('#subcategory-health').css('display', 'block');
            break;
        case 'Sports' :
            $('#subcategory-sports').css('display', 'block');
            break;
        case 'Arts' :
            $('#subcategory-arts').css('display', 'block');
            break;
        case 'Books' :
            $('#subcategory-books').css('display', 'block');
            break;
        case 'Style' :
            $('#subcategory-style').css('display', 'block');
            break;
        case 'Food' :
            $('#subcategory-food').css('display', 'block');
            break;    
        case 'Travel' :
            $('#subcategory-travel').css('display', 'block');
            break;
        default: break;
        
    }
}
});
</script>


<?php


get_footer();

?>
<script src="<?php echo get_template_directory_uri(); ?>/static/js/articleActionValidation.js"></script>