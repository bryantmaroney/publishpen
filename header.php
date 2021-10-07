<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage The_Publisher_pen
 * @since 1.0.0
 */

wp_enqueue_script("jquery");

global $user_ID;

$user = wp_get_current_user();
$username = $user->display_name;
$cat = $_GET['cat'];
?>

<?php

?>

<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>Publish Pen</title>
    <meta name="google-site-verification" content="n7XlLm_ksFD4ay7lj31jH5-T-ahvOxm6aZAmltdZnNA" />

    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-142601612-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'UA-142601612-1');
    </script>


    <?php if(is_singular()){

        $currentpost = get_post();
        $currentpostid = $currentpost->ID;

        ?>

        <!-- Facebook and Linkedin Origin-Graph -->
        <meta prefix="og:http://ogp.me/ns#" name="title" property="og:title" content="<?php the_title(); ?>" />
        <meta prefix="og:http://ogp.me/ns#" name="image" property="og:image" content="<?php $image = get_field('featured_image'); echo $image['sizes']['medium_large']; ?>" />
        <meta prefix="og:http://ogp.me/ns#" name="description" property="og:description" content='<?php echo the_field("content", $currentpostid); ?>' />
        <meta property="og:url" content="<?php the_permalink(); ?>" />

        <!-- Twitter -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="<?php the_title(); ?>">
        <meta class="twitter-desc" name="twitter:description" content='<?php echo the_field("content", $currentpostid); ?>'>
        <meta name="twitter:image" content="<?php $image = get_field('featured_image'); echo $image['sizes']['medium_large']; ?>">


    <?php }else{ ?>

        <!-- Facebook and Linkedin Origin-Graph -->
        <meta prefix="og:http://ogp.me/ns#" name="title" property="og:title" content="The Publisher Pen">
        <meta prefix="og:http://ogp.me/ns#" name="image" property="og:image" content="">
        <meta prefix="og:http://ogp.me/ns#" name="description" property="og:description" content="The Publisher Pen">

        <!-- Twitter -->
        <meta name="twitter:card" content="summary">
        <meta name="twitter:title" content="The Publisher Pen">
        <meta name="twitter:description" content="The Publisher Pen">
        <meta name="twitter:image" content="">

    <?php } ?>

    <link rel="apple-touch-icon" sizes="180x180" href="<?php echo get_template_directory_uri(); ?>/static/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?php echo get_template_directory_uri(); ?>/static/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo get_template_directory_uri(); ?>/static/favicon/favicon-16x16.png">
    <meta name="msapplication-TileColor" content="#da532c">

    <meta name="theme-color" content="#ffffff">
    <!--<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet">
        -->
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery-ui.css">

    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/g_font.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/summer/summernote.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/css/custom.css">

    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/css/fontawesome.min.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/font/flaticon.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/css/jquery.scrollbar.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/perfect-scrollbar/css/perfect-scrollbar.css">
    <link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/material-design-icons/css/material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/datatables/datatables.net-bs4/css/dataTables.bootstrap4.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/datatables/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/morrisjs/morris.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/summernote/summernote-bs4.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/bootstrap-slider/css/bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/select2/css/select2.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/dropzone/dropzone.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/lib/jquery.magnific-popup/magnific-popup.css">
    <link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/static/beagle/assets/css/app.css">

    <!--Main Style Sheet-->
    <link href="<?php echo get_template_directory_uri(); ?>/static/css/style.css" rel="stylesheet">
    <link href="<?php echo get_template_directory_uri(); ?>/static/css/modify.css" rel="stylesheet">
    <?php wp_head(); ?>
</head>

<body>
<script>
    /* jQuery( document ).ready(function($) {
        var ca = $('.content-art > p > span').html();
        
        if(ca.length > 0){
    
            $('.twitter-desc').attr("content", ca);
            $("meta[name*='description']").attr("content", ca);
            
        }else{
            
            var ca1 = $('.content-art > p').html();
            
            $('.twitter-desc').attr("content", ca1);
            $("meta[name*='description']").attr("content", ca1);
            
        }
    }); */
    //----------------------detect mobile
    setInterval(function(){
        var isMobile = window.matchMedia("only screen and (max-width: 480px)").matches;

        if (isMobile) {

            jQuery('.feature-overflow').addClass('mobile-overflow');
            jQuery('.page-detail-colum').addClass('home-page-detail-mobile');
            jQuery('.scrollbar-mobile').addClass('scrollbar-outer-mobile');
            jQuery('.page-contant-box').addClass('scrollbar-outer-mobile');
            jQuery('.scrollbar-outer-mobile').css('padding-right', '0');
            jQuery('.page-detail-colum').removeClass('scrollbar-outer-ipad');
            //jQuery('.scrollbar-outer-mobile > div').css('padding-right', '10px');
            jQuery('.author-page-profile > div').removeClass('row');

        }
        else{

            jQuery('.feature-overflow').removeClass('mobile-overflow');
            jQuery('.page-detail-colum').removeClass('home-page-detail-mobile');
            jQuery('.scrollbar-mobile').removeClass('scrollbar-outer-mobile');
            jQuery('.page-detail-colum').addClass('scrollbar-outer-ipad');
            jQuery('.page-contant-box').removeClass('scrollbar-outer-mobile');
            jQuery('.scrollbar-outer-mobile').css('padding-right', '10px');
            jQuery('.author-page-profile > div').addClass('row');

        }

        var dwidth = jQuery('.detect-width').width();
        jQuery('.dwidth').width(dwidth - 20);
        //alert(dwidth);

    }, 50);

</script>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '1910120385755907',
            cookie     : true,
            xfbml      : true,
            version    : 'v3.3'
        });

        FB.AppEvents.logPageView();

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));

</script>

<div class="content-art" style="display:none">
    <?php
    /* echo strip_tags(the_field('content', $currentpostid));  */
    $cont = the_field('content', $currentpostid);
    echo $new_string = preg_replace('/<[^>]*>/', '', $cont);
    /* echo $new_string = strip_tags($cont); */

    ?>
</div>

<div class="be-wrapper be-fixed-sidebar">
    <div id="app">
        <div class="wrapper">


            <!-------- NAVBAR -------->
            <div class="uvote-confirm">Upvote</div>
            <div class="dvote-confirm">Upvote</div>
            <nav class="navbar navbar-expand fixed-top be-top-header">
                <div class="container-fluid">
                    <div class="be-navbar-header">
                        <a href="<?php echo site_url(); ?>" class="navbar-brand">
                            <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/10/logopubpen.png" alt="" class="img-fluid a-img">
                        </a>
                    </div>
                    <div class="page-title">
                        <div class="header-search">
                            <?php get_search_form(); ?>
                        </div>
                    </div>

                    <div class="be-right-navbar">
                        <div class="mobile-logo">
                            <a href="<?php echo site_url(); ?>">
                                <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/10/logopubpen.png" alt="" class="img-fluid logo-img-tablet">
                                <img src="<?php echo site_url(); ?>/wp-content/uploads/2019/10/logopubpen.png" alt="" class="img-fluid mobile-img">
                            </a>
                        </div>
                        <!--<div class="header-search-1"><?php get_search_form(); ?></div> -->
                        <div class="for-mobile">
                            <div class="mobile-menu">
                                <a href="#" role="button" aria-expanded="true" class="nav-link be-toggle-right-sidebar">
                                    <span class="mdi mdi-menu"></span>
                                </a>
                            </div>

                            <?php if( is_user_logged_in() ){ ?>

                                <ul class="nav navbar-nav float-right be-user-nav">
                                    <li style="padding-right:10px;">
                                        <span class="fa fa-bell"></span>
                                        <!--<span class="badge badge-notify">3</span>-->
                                    </li>
                                    <li class="nav-item dropdown avatar-dropdown">
                                        <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="nav-link dropdown-toggle">
                                            <!-- <img src="<?php echo the_field('profile_image', "user_$user_ID"); ?>" alt=""></a> -->

                                            <?php
                                            $up = get_field('profile_image', "user_$user_ID");
                                            if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                ?>
                                                <img class="a-img"
                                                     src="<?php echo $up['sizes']['user-display']; ?>"
                                                     alt="avatar">
                                                <?php
                                            } else {

                                                echo get_avatar($user_ID);

                                            } ?>

                                        </a>
                                        <div role="menu" class="dropdown-menu header-menu">
                                            <div class="user-info">
                                                <div class="user-name"><b><?php echo $username; ?></b></div>
                                            </div>


                                            <a href="<?php echo site_url() . '/profile'; ?>" class="dropdown-item">
                                                <i class="icon mdi mdi-face"></i>Profile
                                            </a>
                                            <a href="<?php echo wp_logout_url(); ?>" class="dropdown-item">
                                                <i class="icon mdi mdi-power"></i>Logout
                                            </a>
                                        </div>


                                    </li>
                                </ul>


                                <ul class="nav navbar-nav float-right be-icons-nav">
                                    <li class="nav-item" style="display: flex; justify-content: center; align-items: center; height: 60px;">
                                        <div class="header-btn-first"><a href="<?php echo site_url() . '/create-article'; ?>" class="btn btn-article my-article header-btn">Create Article</a></div>
                                        <div><a href="<?php echo site_url() . '/my-articles'; ?>" class="btn btn-article create-article header-btn">My Articles</a></div>
                                    </li>
                                </ul>


                            <?php }else{ ?>

                                <ul class="nav navbar-nav float-right be-user-nav">
                                    <li class="nav-item dropdown">
                                        <a href="#" data-toggle="modal" data-target="#login-modal" aria-expanded="false" class="nav-link dropdown-toggle">
                                            <img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/user-icon.png'; ?>" alt="Avatar">
                                        </a>
                                    </li>
                                </ul>

                                <ul class="nav navbar-nav float-right be-icons-nav">
                                    <li class="nav-item" style="display: flex; justify-content: center; align-items: center; height: 60px;">
                                        <div><a href="<?php echo site_url() . '/create-article'; ?>" data-toggle="modal" data-target="#login-modal" class="btn btn-article my-article header-btn">Create Article</a></div>
                                    </li>
                                </ul>



                            <?php } ?>


                        </div>

                    </div>
                    <div class="ipad-menu">
                        <a class="ipad-menu-link" href="#" ><i class="fas fa-bars fa-1x"></i></a>
                    </div>


                    <!-- ipad menu ----->
                    <div class="ipad-menu-toggle">
                        <nav class="ipad-right-sidemenu mobile-right-sidemenu sidebar-show-nav">
                            <div class="ipad-left-sidebar-content left-sidebar-content sidebar-content-show">
                                <div class="ipad-sidebar-scroll">
                                    <div class="left-sidebar-content" style="max-height: 100vh; overflow: auto;">
                                        <div class="hide-sidebar">
                                            <a href="#" class="icon hide-sidebar-ipad" ><span class="mdi mdi-arrow-right"></span></a>
                                        </div>
                                        <ul class="sidebar-elements">
                                            <div class="header-masthead-login mobile-version">
                                                <ul class="clearfix">
                                                    <li><a href="#" data-toggle="modal" data-target="#exampleModal">Login</a></li>
                                                    <li data-toggle="modal" data-target="#exampleModal" class="active"><a href="#">Sign up</a></li>
                                                </ul>
                                            </div>
                                            <li class="divider no-divider-top">Menu</li>
                                            <div class="guide-section-renderer pt-0">
                                                <ul id="main-menu-section-sidebar-group">
                                                    <li class="smenu <?php if(is_front_page() && $active_menu == ''){ echo 'active-sidemenu';} ?>"><a href="<?php echo site_url(); ?>"><i class="icon mdi mdi-home"></i> <span>Home</span></a></li>
                                                    <li class="smenu <?php if($active_menu == 'new'){ echo 'active-sidemenu';} ?>"><a href="<?php echo site_url() . '?sort=new'; ?>"><i class="icon mdi mdi-chart"></i> <span>New</span></a></li>
                                                    <li class="smenu <?php if($active_menu == 'hot'){ echo 'active-sidemenu';} ?>"><a href="<?php echo site_url() . '?sort=hot'; ?>"><i class="icon mdi mdi-fire"></i> <span>Hot</span></a></li>
                                                    <li class="smenu"><a href="javascript:void(0)"><i class="icon mdi mdi-power"></i> <span>Logout</span></a></li>
                                                </ul>
                                            </div>
                                            <li class="divider">Profile</li>
                                            <div class="guide-section-renderer">
                                                <ul id="profile-section-sidebar-group">
                                                    <li id="my_profile_id" class="smenu <?php if($active_menu == 'history'){ echo 'active-sidemenu';} ?>">
                                                    	<a href="<?php if(is_user_logged_in()){ echo site_url() . '?sort=history';}else{ } ?>" <?php if(is_user_logged_in()){ }else { ?>data-toggle="modal" data-target="#login-modal"<?php } ?>  class="router-link-exact-active router-link-active">
	                                                    	<i class="icon mdi mdi-time-restore"></i> <span>History</span>
	                                                    </a>
                                                    </li>
                                                    <li class="smenu <?php if($active_menu == 'favs'){ echo 'active-sidemenu';} ?>"><a href="<?php if(is_user_logged_in()){ echo site_url() . '?sort=favs'; }else{  } ?>" <?php if(is_user_logged_in()){ }else { ?>data-toggle="modal" data-target="#login-modal"<?php } ?>  class="router-link-exact-active router-link-active"><i class="icon mdi mdi-favorite"></i> <span>liked articles</span></a></li>
                                                    <li id="my_article_id" class="smenu <?php if(get_the_ID() == 13){ echo 'active-sidemenu';} ?>"><a href=" <?php if(is_user_logged_in()){ echo site_url() . '/my-articles';}else{  } ?>" <?php if(is_user_logged_in()){ }else { ?>data-toggle="modal" data-target="#login-modal"<?php } ?> class=""><i class="icon mdi mdi-file-text"></i> <span>my articles</span></a>
                                                        <!---->
                                                    </li>
                                                    <li class="smenu <?php if(get_the_ID() == 9){ echo 'active-sidemenu';} ?>"><a href="<?php if(is_user_logged_in()){ echo site_url() . '/create-article'; }else{  }?>" <?php if(is_user_logged_in()){ }else { ?>data-toggle="modal" data-target="#login-modal"<?php } ?> class="dropdown-item"><i class="icon mdi mdi-edit"></i> <span>Create</span></a>
                                                        <!---->
                                                    </li>
                                                </ul>
                                            </div>
                                            <!---->
                                            <li class="divider">Support</li>
                                            <div class="guide-section-renderer">
                                                <ul>
                                                    <li class=""><a href="/" class="router-link-exact-active router-link-active"><i class="far fa-file-alt"></i> <span>Report history</span></a></li>
                                                    <li><a href="mailto:thepublisherpen@gmail.com?Subject=Help" target="_top"><i class="icon mdi mdi-help"></i> <span>Help</span></a></li>
                                                    <li><a href="mailto:thepublisherpen@gmail.com?Subject=Send Feedback" target="_top"><i class="icon mdi mdi-comment"></i> <span>Send feedback</span></a></li>
                                                </ul>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </nav>
                    </div>


                    <!--- menu end ------>



                </div>

            </nav>
            <!---<div class="mobile-search-bar">
				<div class="container-fluid">
				<div class="header-search-mobile"><?php get_search_form(); ?></div>
				</div>
			</div>--->
            <!-------- / END NAVBAR -------->

            <!-------- OPTIONS BAR -------->
            <div class="data-world">
                <div class="data-hot">
                    <ul>
                        <li class="dropdown">
                            <a href="#" id="dd-trends" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="far fa-chart-line"></i> news </a>

                            <div aria-labelledby="dd-trends" class="dropdown-menu">
                                <a href="<?php echo site_url() . '?sort=hot'; ?>" class="dropdown-item"><i class="fal fa-fire"></i>hot</a>
                                <a href="<?php echo site_url() . '?sort=new'; ?>" class="dropdown-item active"><i class="fal fa-chart-line"></i>new</a>
                                <a href="<?php echo site_url() . '?sort=controversial'; ?>" class="dropdown-item"><i class="fal fa-bolt"></i>controversial</a>
                            </div>
                        </li>
                        <li class="dropdown">
                            <a href="#" id="dd-countries" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="far fa-map-marker-alt"></i>Location </a>

                            <div aria-labelledby="dd-countries" id="countryDropDown" class="dropdown-menu">
                                <input type="text" placeholder="Search.." id="myInput" class="dropdown-item search-country">
                                <a href="#" class="dropdown-item">Worldwide</a>
                            </div>
                        </li>

                        <li class="dropdown mobile-version tablet-version">
                            <a href="#" id="dd-mobile-categories" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><i class="fal fa-pencil"></i>Topics</a>

                            <div aria-labelledby="dd-mobile-categories" class="dropdown-menu">
                                <!--<ul class="header_category-menu">-->
                                <!--    <li><a href="#" name="all" class="dropdown-item btn  feature-article-ht1" onclick="filterSelection('all')">All</a></li>-->
                                <!--                         <li><a href="#" name="world" class="dropdown-item btn  feature-article-ht" onclick="filterSelection('World')">World</a></li>-->
                                <!--                         <li><a href="#" name="us" class="dropdown-item btn feature-article-ht" onclick="filterSelection('US')">U.S.</a></li>-->
                                <!--                         <li><a href="#" name="politics" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Politics')">Politics</a></li>-->
                                <!--                         <li><a href="#" name="local" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Local')">Local</a></li>-->
                                <!--                         <li><a href="#" name="business" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Business')">Business</a></li>-->
                                <!--                         <li><a href="#" name="technology" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Technology')">Technology</a></li>-->
                                <!--                         <li><a href="#" name="science" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Science')">Science</a></li>-->
                                <!--                         <li><a href="#" name="health" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Health')">Health</a></li>-->
                                <!--                         <li><a href="#" name="sports" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Sports')">Sports</a></li>-->
                                <!--                         <li><a href="#" name="arts" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Arts')">Arts</a></li>-->
                                <!--                         <li><a href="#" name="books" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Books')">Books</a></li>-->
                                <!--                         <li><a href="#" name="style" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Style')">Style</a></li>-->
                                <!--                         <li><a href="#" name="food" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Food')">Food</a></li>-->
                                <!--                         <li><a href="#" name="travel" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Travel')">Travel</a></li>-->
                                <!--</ul>-->
                                <a href="#" name="all" class="dropdown-item btn  feature-article-ht1" onclick="filterSelection('all')">All</a>
                                <a href="#" name="world" class="dropdown-item btn  feature-article-ht" onclick="filterSelection('World')">World</a>
                                <a href="#" name="us" class="dropdown-item btn feature-article-ht" onclick="filterSelection('US')">U.S.</a>
                                <a href="#" name="politics" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Politics')">Politics</a>
                                <a href="#" name="local" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Local')">Local</a>
                                <a href="#" name="business" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Business')">Business</a>
                                <a href="#" name="technology" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Technology')">Technology</a>
                                <a href="#" name="science" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Science')">Science</a>
                                <a href="#" name="health" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Health')">Health</a>
                                <a href="#" name="sports" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Sports')">Sports</a>
                                <a href="#" name="arts" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Arts')">Arts</a>
                                <a href="#" name="books" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Books')">Books</a>
                                <a href="#" name="style" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Style')">Style</a>
                                <a href="#" name="food" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Food')">Food</a>
                                <a href="#" name="travel" class="dropdown-item btn feature-article-ht" onclick="filterSelection('Travel')">Travel</a>
                            </div>
                        </li>

                        <li class="dropdown mobile-search-icon">
                            <a href="#" id="dd-search" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle"><span class="mdi mdi-search"></span></a>

                            <div aria-labelledby="dd-search" class="dropdown-menu">
                                <input type="text" placeholder="Search..." class="form-control">
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="data-world-right-text 123">
                    <div class="dasktop-version tablet-dasktop-version"><!--Spelling?-->
                        <div class="data-world-inner" id="myBtnContainer">
                            <ul class="">
                                <?php if ( is_front_page() && is_home() ) { ?>
                                    <li class=""><a href="<?php echo get_site_url(); ?>" name="all" class="btn  category-article <?php if ( is_front_page() && empty($cat) ) { echo 'mactive'; } ?> " onclick="filterSelection('all')">All</a></li>
                                    <?php
                                    $cats = array("world","us","politics","local","business","technology","science","health","sports","arts","books","style","food","travel");
                                    $i = 1;
                                    $feas = array();
                                    foreach( $cats as $cat ){ ?>

                                        <li class=""><a href="<?php echo get_site_url().'/?cat='.$cat; ?>" name="<?php echo $cat; ?>" class="btn category-article <?php if($_GET['cat'] == $cat ){ echo 'mactive'; } ?>"><?php echo ucwords($cat); ?></a></li>

                                    <?php } ?>

                                    <!-- <li class=""><a href="#" name="world" class="btn  feature-article-ht" onclick="filterSelection('World')">World</a></li>
                                     <li class=""><a href="#" name="us" class="btn feature-article-ht" onclick="filterSelection('US')">U.S.</a></li>
                                     <li class=""><a href="#" name="politics" class="btn feature-article-ht" onclick="filterSelection('Politics')">Politics</a></li>
                                     <li class=""><a href="#" name="local" class="btn feature-article-ht" onclick="filterSelection('Local')">Local</a></li>
                                     <li class=""><a href="#" name="business" class="btn feature-article-ht" onclick="filterSelection('Business')">Business</a></li>
                                     <li class=""><a href="#" name="technology" class="btn feature-article-ht" onclick="filterSelection('Technology')">Technology</a></li>
                                     <li class=""><a href="#" name="science" class="btn feature-article-ht" onclick="filterSelection('Science')">Science</a></li>
                                     <li class=""><a href="#" name="health" class="btn feature-article-ht" onclick="filterSelection('Health')">Health</a></li>
                                     <li class=""><a href="#" name="sports" class="btn feature-article-ht" onclick="filterSelection('Sports')">Sports</a></li>
                                     <li class=""><a href="#" name="arts" class="btn feature-article-ht" onclick="filterSelection('Arts')">Arts</a></li>
                                     <li class=""><a href="#" name="books" class="btn feature-article-ht" onclick="filterSelection('Books')">Books</a></li>
                                     <li class=""><a href="#" name="style" class="btn feature-article-ht" onclick="filterSelection('Style')">Style</a></li>
                                     <li class=""><a href="#" name="food" class="btn feature-article-ht" onclick="filterSelection('Food')">Food</a></li>
                                     <li class=""><a href="#" name="travel" class="btn feature-article-ht" onclick="filterSelection('Travel')">Travel</a></li> -->
                                <?php } else { ?>
                                    <?php $perm = get_permalink(get_the_ID()); ?>
                                    <li class=""><a href="<?php echo $perm; ?>" name="all" class="btn  category-article <?php if ( is_front_page() && empty($cat) ) { echo 'mactive'; } ?> " onclick="filterSelection('all')">All</a></li>
                                    <?php
                                    $cats = array("world","us","politics","local","business","technology","science","health","sports","arts","books","style","food","travel");
                                    $i = 1;
                                    $feas = array();
                                    foreach( $cats as $cat ){ ?>

                                        <li class=""><a href="<?php echo get_site_url().'/?cat='.$cat; ?>" name="<?php echo $cat; ?>" class="btn category-article <?php if($_GET['cat'] == $cat ){ echo 'mactive'; } ?>"><?php echo ucwords($cat); ?></a></li>

                                    <?php } ?>

                                    <!-- <li class=""><a href="<?php echo get_site_url(); ?>" name="all" class="">All</a></li>
								<li class=""><a href="<?php echo get_site_url(); ?>" name="world" class="">World</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="us" class="">U.S.</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="politics" class="">Politics</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="local" class="">Local</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="business" class="">Business</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="technology" class="">Technology</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="science" class="">Science</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="health" class="">Health</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="sports" class="">Sports</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="arts" class="">Arts</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="books" class="">Books</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="style" class="">Style</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="food" class="">Food</a></li>
                                <li class=""><a href="<?php echo get_site_url(); ?>" name="travel" class="">Travel</a></li> -->
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-------- / END OPTIONS BAR -------->

            <!-------- SIDEBAR -------->
            <?php get_template_part('template/sidebar'); ?>
            <!-------- / END SIDEBAR -------->

            <!-------- MODALS -------->
            <?php 
	            if ( is_user_logged_in() ) {
					'';
				} else {
					get_template_part('template/login'); 
				}
	        ?>
            <!-------- / END MODALS -------->


            <!-------- FOOTER.PHP-------->
            <!--</div> end wrapper-->
            <!--</div> end app-->
            <!--</div> end be-wrapper-->