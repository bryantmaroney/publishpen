<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 *
 */
$cookie_name = 'the-publisher-pen-view-history';
$pid = get_the_ID();

$content_post = get_post($pid);
// $content = $content_post->post_content;
// $content = apply_filters('the_content', $content);
// $content = str_replace(']]>', ']]&gt;', $content);
$content = get_post_meta($pid, 'content', true);


//check if cookie is set
if( isset($_COOKIE[$cookie_name] ) ){

    $allposts = explode(",", $_COOKIE[$cookie_name]);
    if(!in_array($pid, $allposts)) {

        //if cookie is not set for post id
        $current_views = get_field('views', $pid);
        $views = $current_views + 1;
        update_field('views', $views, $pid );

        $cookie_value = $_COOKIE[$cookie_name] . ',' . $pid;
        setcookie($cookie_name, $cookie_value, time() + (86400*30*12), '/');

    }

}else{

    //if cookie is not set
    $current_views = get_field('views', $pid);
    $views = $current_views + 1;
    update_field('views', $views, $pid );
    $cookie_value = $pid;
    setcookie($cookie_name, $cookie_value, time() + (86400*30*12), '/');

}

get_header();

// Preview Edit - Publish Function
if (isset($_GET['preview'])) {
    $previewId = $_GET['p'];
    $preview = true;
    $draftUrl = site_url() . '/create-article?action=draft&id=' . $previewId;
} else {
    $preview = false;
}

if(isset($_POST['type']) && $_POST['type'] == 'preview') {
    $previewId = $_POST['pid'];

    $post = array( 'ID' => $previewId, 'post_status' => 'publish' );
    wp_update_post($post);

    $redirect = get_the_permalink($previewId);
    echo "<script> window.location = '$redirect'; </script>";
}

// 
/* Start the Loop */
while ( have_posts() ) : the_post();

    $author_id = $post->post_author;
    $donkey = get_field('donkey');
    $elephant = get_field('elephant');
    /* 	echo $donkey;
    
        echo $elephant; */

    $uvd = $donkey + 1;
    $dvd = $donkey - 1;

    $uve = $elephant + 1;
    $dve = $elephant - 1;

    $image = get_field('featured_image');
    $pinterestimage = $image['sizes']['medium_large'];
    $pinteresturl = get_permalink();
    /* $pinteresttitle = the_title(); */

    ?>
    
<script>
//REMOVE POLITICAL ICONS FROM SINGLE
jQuery(document).ready(function(){
	console.log('test 1');
	jQuery('.content').on("scroll", function () {
		console.log('test 2');
		if (jQuery(this).scrollTop() < 950) {
		  jQuery('#icons-show').removeClass('remove-icons');
		} else {
		  jQuery('#icons-show').addClass('remove-icons');
		}
	});		
});
</script>

<style>
.goog-display {
	padding: 10px;
	width: 100%;
	background: #EEEEEE;
	margin-bottom: 25px;
}	
</style>   
    
    
    <div class="be-content video-detail-page">
        <section class="page-manager">
            <div class="video-detail">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="page-manager-inner">
                                <div class="row">
                                    <div class="page-detail-colum" id="article-inner-page">
                                        <div class="scroll-wrapper content scrollbar-outer left-panel detect-width" style="position: relative;">
                                            <div class="content scrollbar-outer left-panel scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 152px;background: white;">
                                                <div class="video-detail-left">
                                                    <div class="image-holder">

                                                        <img src="<?php $image = get_field('featured_image'); echo $image['sizes']['medium_large']; ?>" alt="" class="img-fluid img-mobile-article">
                                                        <div id="disappear-vote">
                                                            <div id="icons-show" style="display:block">
                                                                <?php if( get_field('category') == 2 || get_field('category') == 'Politics' ) { ?>
                                                                    <div class=" bias-inner hideme-left">
                                                                        <a href="#" id="uvdonkey"><img id="mob-left" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_icon_circle.png'; ?>"></a>
                                                                        <a href="#" id="dvdonkey"><img id="mob-left" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_background.png'; ?>"></a>
                                                                    </div>
                                                                    <div class="bias-inner hideme-right">
                                                                        <a href="#" id="uvelephant"><img id="mob-right" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_icon_circle.png'; ?>"></a>
                                                                        <a href="#" id="dvelephant"><img id="mob-right" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_background.png'; ?>"></a>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="video-socail">
                                                            <div class="video-socail-main">
                                                                <div class="video-socail-inner">
                                                                    <ul>
                                                                        <li><a href="javascript:void(0)" onclick="facebookShareButton();"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_facebook_icon.png" alt=" " class="img-fluid"></span></a></li>
                                                                        <li><a href="javascript:void(0)" onclick="twitterShareButton();"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_twitter_icon.png" alt=" " class="img-fluid"></span></a></li>
                                                                        <li><a href="javascript:void(0)" onclick="linkedinShareButton();"><span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_linkedin_icon.png" alt=" " class="img-fluid"></span></a></li>
                                                                        <li><a data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php echo $pinterestimage; ?>&description=<?php the_title() ?>" onclick="window.open(this.href, 'windowName', 'width=1000, height=700, left=24, top=24, scrollbars, resizable'); return false;"><span><img src="/wp-content/uploads/2019/12/pinterest-logo.png" data-pin-shape="round" alt=" " class="img-fluid"></span></a></li>


                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-header card-header-divider detect-scroll">
                                                        <h3 class="article-title"><?php the_title(); ?></h3>
                                                    </div>
                                                    <div class="social-box-1">
                                                        <div class="author-div-name">
                                                            <div class="detail-user-info">
                                                                <!--<img src="<?php $up = get_field('profile_image', "user_$author_id"); echo $up['sizes']['user-display']; ?>" class="user-pic">-->
                                                                <?php
                                                                $up = get_field('profile_image', "user_$author_id");
                                                                if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                                    ?>
                                                                    <img class="a-img"
                                                                         src="<?php echo $up['sizes']['user-display']; ?>"
                                                                         alt="avatar">
                                                                    <?php
                                                                } else {

                                                                    echo get_avatar($author_id);

                                                                } ?>

                                                                &nbsp;&nbsp;
                                                                <div class="user-detail-info">
                                                                    <a href="<?php echo site_url() ?>/article?aid=<?php echo $author_id; ?>" class="user-name"><?php the_author(); ?></a> <!-- <span>posted <?php echo get_the_date(); ?></span> -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="author-div-view views-weeks" >
                                                            <div class="views-gd"> <?php
                                                                $viewCount = get_field('views', $pid);

                                                                if($viewCount > 1)
                                                                    echo get_field('views', $pid).' views';
                                                                else
                                                                    echo get_field('views', $pid).' view';
                                                                ?>
                                                                <strong class="center-dot">.</strong> <?php
                                                                $date1 = new DateTime(get_the_date().get_the_time());
                                                                $date2 = new DateTime(date("M d,Y H:i:s"));
                                                                $interval = $date1->diff($date2);

                                                                
                                                                $Difference["Hours"] = $interval->h;
                                                                $Difference["Weeks"] = floor($interval->days/7);
                                                                $Difference["Days"] = $interval->days % 7;
                                                                $Difference["Months"] = $interval->m;

                                                                if($Difference["Weeks"] < 1) {
                                                                    if($interval->d < 1 && $Difference["Hours"] > 1) {
                                                                        echo round($Difference["Hours"]).' hours ago';
                                                                    } else if($interval->d < 1 && $Difference["Hours"] < 1) {
                                                                        echo 'Posted less than 1 hour ago';
                                                                    } else {
                                                                        echo $interval->d.' days ago';
                                                                    }
                                                                } else if($interval->days < 30) {
                                                                    $dd = $interval->days;
                                                                    $we = $dd / 7;
                                                                    echo round($we).' weeks ago';
                                                                } else if($interval->days >= 30) {
                                                                    echo $Difference["Months"].' months ago';
                                                                } else if($interval->days > 365) {
                                                                    echo round($interval->days/365).' years ago';
                                                                }

                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/>
                                                
                                                <div class="text-box">
                                                    <div class="text-inner">
                                                        <p><?php the_content(); ?></p><br><br>
                                                        <!--<p><?php echo $content; ?></p><br><br>-->
                                                    </div>
                                                </div>

                                                <?php if (!$preview) {?>
                                                    <div class="detail-like-strip dwidth" style="display:none;">
                                                        <ul>
                                                            <li class="like-li">
                                                                <a href="javascript:void(0)" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn">
                                                                    <i class="fa fa-thumbs-up unactive"></i>
                                                                    <i class="fa fa-thumbs-up active"></i>
                                                                    <!--<span>upvote</span>-->
                                                                </a>
                                                            </li>
                                                            <li class="dislike-li">
                                                                <a href="javascript:void(0)" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn">
                                                                    <i class="fa fa-thumbs-up unactive dislike-540"></i>
                                                                    <i class="fa fa-thumbs-up active dislike-540"></i>
                                                                    <!--<span>downvote</span>-->
                                                                </a>
                                                            </li>
                                                            <li class="dropdown share-li">
                                                                <a href="#" id="dd-share" data-toggle="dropdown">
                                                                    <i class="fa fa-share-alt unactive"></i>
                                                                    <i class="fa fa-share-alt active"></i>
                                                                </a>

                                                                <div aria-labelledby="dd-share" class="dropdown-menu dd-share-expanded">
                                                                    <ul class="ul-social-share-dd">
                                                                        <!--<li>-->
                                                                        <!--   <a href="#" onClick = "facebookShareButton();">-->
                                                                        <!--        <span data-link="#share-facebook">-->
                                                                        <!--            <i class="mdi mdi-facebook"></i>-->
                                                                        <!--        </span>-->
                                                                        <!--    </a>-->
                                                                        <!--</li>-->
                                                                        <!--<li>-->
                                                                        <!--    <a href="#" onClick = "twitterShareButton();">-->
                                                                        <!--        <span data-link="#share-twitter">-->
                                                                        <!--            <i class="mdi mdi-twitter"></i>-->
                                                                        <!--        </span>-->
                                                                        <!--    </a>-->
                                                                        <!--</li>-->
                                                                        <li>
                                                                            <a href="javascript:void(0)" onclick="facebookShareButton();">
                                                                                <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_facebook_icon.png" alt=" " class="img-fluid"></span>
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a href="javascript:void(0)" onclick="twitterShareButton();">
                                                                                <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_twitter_icon.png" alt=" " class="img-fluid"></span>
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a href="javascript:void(0)" onclick="linkedinShareButton();">
                                                                                <span><img src="<?php echo get_template_directory_uri(); ?>/assets/images/social_linkedin_icon.png" alt=" " class="img-fluid"></span>
                                                                            </a>
                                                                        </li>

                                                                        <li>
                                                                            <a data-pin-do="buttonPin" href="https://www.pinterest.com/pin/create/button/?url=<?php echo get_permalink(); ?>&media=<?php echo $pinterestimage; ?>&description=<?php the_title() ?>" onclick="window.open(this.href, 'windowName', 'width=1000, height=700, left=24, top=24, scrollbars, resizable'); return false;">
                                                                                <span><img src="/wp-content/uploads/2019/09/social-pinterest.png" data-pin-shape="round" alt=" " class="img-fluid"></span>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </li>
                                                            <!--<li class="dropdown">
                                                                <a href="#" id="dd-politics" data-toggle="dropdown" class="dots-icon">
                                                                    <i class="fal fa-ellipsis-h-alt unactive"></i>
                                                                    <i class="fas fa-ellipsis-h active"></i>
                                                                </a> 
                                                                
                                                                <div aria-labelledby="dd-politics" class="dropdown-menu">
                                                                    <a href="javascript:void(0)" class="dropdown-item">Political Bias</a> 
                                                                        <span><a href="mailto:thepublisherpen@gmail.com?Subject=Report Inappropriate Content" class="dropdown-item">inappropriate content</a></span>
                                                                </div>
                                                            </li>-->
                                                        </ul>
                                                    </div>

                                                <?php } else {?>
                                                    <div class="preview-footer dwidth">
                                                        <ul class="preview-footer-buttons">
                                                            <li>
                                                                <button class="btn btn-primary" type="button" id="gotoEditBtn">
                                                                    Edit
                                                                </button>
                                                            </li>
                                                            <li>
                                                                <input class="btn btn-primary" type="button" value="Publish" id="publishBtn"/>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                <?php }?>

                                            </div>
                                        </div>

                                        <!-- <div class="scroll-element scroll-x scroll-scrolly_visible" style="">
                                             <div class="scroll-element_outer">
                                                 <div class="scroll-element_size"></div>
                                                     <div class="scroll-element_track"></div>
                                                         <div class="scroll-bar" style="width: 86px;"></div>
                                             </div>
                                         </div>
                                         <div class="scroll-element scroll-y scroll-scrolly_visible" style="">
                                             <div class="scroll-element_outer">
                                                 <div class="scroll-element_size"></div>
                                                     <div class="scroll-element_track"></div>
                                                         <div class="scroll-bar" style="height: 4px; top: 0px;"></div>
                                             </div>
                                         </div> -->
                                    </div>
                                </div>

                                <div class="trending-inner-page">
                                    <!-- <div class="no-pd-rt page-detail-colum-small trending-inner-page"> -->
                                    <div class="card-header card-header-divider"><h3>Trending Article</h3></div>
                                    <div class="content">
                                        <div class="scroll-wrapper video-detail-right scrollbar-outer" style="position: relative; overflow:auto !important;">
                                            <div class="video-detail-right scrollbar-outer scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 107px;">


                                                <?php get_template_part('template/related', 'post'); ?>

                                            </div>
                                            <!-- <div class="scroll-element scroll-x scroll-scrolly_visible" style="">
                                                 <div class="scroll-element_outer">
                                                     <div class="scroll-element_size"></div>
                                                         <div class="scroll-element_track"></div>
                                                             <div class="scroll-bar" style="width: 86px;"></div>
                                                 </div>
                                             </div>
                                             <div class="scroll-element scroll-y scroll-scrolly_visible" style="">
                                                 <div class="scroll-element_outer">
                                                     <div class="scroll-element_size"></div>
                                                         <div class="scroll-element_track"></div>
                                                             <div class="scroll-bar" style="height: 5px; top: 0px;"></div>
                                                   </div>
                                                 </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    </section>
    </div>

    <form style="display: none;" id="preview-publish" method="POST">
        <input type="hidden" name="pid" value="<?=$previewId?>">
        <input type="hidden" name="type" value="preview">
    </form>

<?php endwhile;  // End of the loop.

?>

    <script>
		/*
        setInterval(function(){

            // var x = jQuery(".detect-scroll").offset();
            var y = jQuery(".image-holder").offset().top - jQuery(window).scrollTop();


            if( y < 125 ) {
                // alert(x.top);
                jQuery('#icons-show').fadeIn();

            }
            if( y > 125 ) {
                // alert(x.top);
                jQuery('#icons-show').fadeOut();

            }

        }, 500);
        */

        jQuery(".hideme-right").hover(function(){

            jQuery('#uvelephant').hide();
            jQuery('#dvelephant').show();

        }, function(){
            jQuery('#uvelephant').show();
            jQuery('#dvelephant').hide();
        });
        jQuery('.hideme-right').click(function() {
            $('#disappear-vote').hide();
        });

        jQuery(".hideme-left").hover(function(){

            jQuery('#uvdonkey').hide();
            jQuery('#dvdonkey').show();

        }, function(){
            jQuery('#uvdonkey').show();
            jQuery('#dvdonkey').hide();
        });
        jQuery('.hideme-left').click(function() {
            $('#disappear-vote').hide();
        });

        //Ajax for voting elephant and donkey
        //-----------------Donkey-----------------------------------
        jQuery('#dvdonkey').click(function(e) {

            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action:'newbid',pid:<?php echo $pid; ?>, vd:<?php echo $uvd;?>},
                success: function(msg){
                    /*             jQuery('#dvdonkey').show();
                                jQuery('#uvdonkey').hide(); */
                    $('#disappear-vote').fadeOut();
                    /* location.reload(); */
                }
            });

            jQuery('#dvdonkey').show();
            jQuery('#uvdonkey').hide();
            /* $('#disappear-vote').fadeOut(); */

        });


        //----------------Elephant-----------------------------------
        jQuery('#dvelephant').click(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action:'newbid',pid:<?php echo $pid; ?>, ve:<?php echo $uve;?>},
                success: function(msg){
                    /*             jQuery('#uvelephant').hide();
                                jQuery('#dvelephant').show(); */
                    $('#disappear-vote').fadeOut();
                    /* location.reload(); */
                }
            });
            jQuery('#uvelephant').hide();
            jQuery('#dvelephant').show();
            /* $('#disappear-vote').fadeOut(); */


        });
        //-----------------Donkey-----------------------------------
        jQuery('#uvdonkey').click(function(e) {

            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action:'newbid',pid:<?php echo $pid; ?>, vd:<?php echo $uvd;?>},
                success: function(msg){
                    /*             jQuery('#dvdonkey').show();
                                jQuery('#uvdonkey').hide(); */
                    $('#disappear-vote').fadeOut();
                    /* location.reload(); */
                }
            });

            jQuery('#dvdonkey').show();
            jQuery('#uvdonkey').hide();
            /* $('#disappear-vote').fadeOut(); */

        });


        //----------------Elephant-----------------------------------
        jQuery('#uvelephant').click(function(e) {
            e.preventDefault();
            jQuery.ajax({
                type: "POST",
                url: ajaxurl,
                data: {action:'newbid',pid:<?php echo $pid; ?>, ve:<?php echo $uve;?>},
                success: function(msg){
                    /*             jQuery('#uvelephant').hide();
                                jQuery('#dvelephant').show(); */
                    $('#disappear-vote').fadeOut();
                    /* location.reload(); */
                }
            });
            jQuery('#uvelephant').hide();
            jQuery('#dvelephant').show();
            /* $('#disappear-vote').fadeOut(); */


        });

        jQuery("#publishBtn").click(function () {
            $("#preview-publish").submit();
        });

        jQuery("#gotoEditBtn").click(function() {
            window.open("<?=$draftUrl?>","_blank");
        });

    </script>

<?php
get_footer();

