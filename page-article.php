<?php
/**
 * Template Name: Articles Page
 *
 * @package WordPress
 * @subpackage The_Publisher_Pen
 *
 */
session_start();
get_header();
$aid = $_GET['aid'];

$argsForAuthor = array(
    'post_type'     => 'post',
    'post_status'   => 'publish',
    'numberposts'   => -1,
    'author'        =>  $aid,
);

$postsAuthor = get_posts($argsForAuthor);
?>
<div class="padding-30">

    <section class="be-content article-detail-page">
        <div class="bg-featured-article"
             style="background:url('https://www.publishpen.com/wp-content/uploads/2019/06/publisherpen_1555533589908-768x432.jpg')">
        </div>
        <div class="author-follows">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="profile-img-author">
                            <?php
                            $up = get_field('profile_image', "user_$aid");
                            if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                ?>
                                <img class="rounded-circle"
                                     src="<?php echo $up['sizes']['user-display']; ?>"
                                     alt="avatar">
                                <?php
                            } else {

                                echo get_avatar($aid);

                            } ?>
                        </div>
                    </div>
                </div>
                <div class="row article-follows-details">
                    <div class="col-lg-7">
                        <ul class="details-author-notify">
                            <li>
                                <div class="author-name-article">
                                    <b><?php the_author_meta('display_name', $aid); ?></b>
                                    <br>
                                    <span><?php 
                                        if(count($postsAuthor) > 1) 
                                            echo count($postsAuthor). ' articles';
                                        else
                                            echo count($postsAuthor). ' article';
                                        ?></span>
                                </div>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </section>


    <section class="be-content article-detail-page-featured">
        <div class="page-detail-colum home-page-detail author-detail-posts">
            <div class="yespost-content" style="display:none;">
                <div id="feature-overflow">
                    <div class="list-heading">
                        <div class="header-contant-box">
                            <h3 class="heading-recommend-featured">This page have no articles for this category.</h3>
                        </div>
                    </div>
                </div>
            </div>
            <?php

            $args = array(
                'post_type' => 'post',
                'post_status' => 'publish',
                'posts_per_page' => 25,
                'author' => $aid,
                'paged' => $paged
            );
            $query = new WP_Query($args);
            $posts = $query->posts;

            $featureid = array_shift(array_values($posts))->ID;
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            if ($paged == 1) {

                $_SESSION["fav"] = $featureid;

            }

            ?>
            <?php
            $most_recent_post_cat = null;
            if ($posts) {
                $i = 1;
                foreach ($posts as $post) {

                    $views = get_field('views');
                    if ($views == 1) {
                        $views = $views . ' view';
                    } else {
                        $views = $views . ' views';
                    }
                    $pid = get_the_id();
                    $author = $post->post_author;
                    $donkey = get_field('donkey');
                    $elephant = get_field('elephant');
                    $uv = get_field('upvotes');
                    $dv = get_field('downvotes');

                    if ($i == 1) {
                        $pid = $_SESSION["fav"];
                        $author = $aid;
                        $donkey = get_field('donkey', $pid);
                        $elephant = get_field('elephant', $pid);
                        $uv = get_field('upvotes', $pid);
                        $dv = get_field('downvotes', $pid);
                        $most_recent_post_cat = get_field('category', $pid);
                        ?>
                        <div class="nopost-content">
                            <div id="feature-overflow" class="feature-overflow">
                                <div class="list-heading feature-heading">
                                    <img src="/wp-content/uploads/2019/09/trending.png" class="icon-yellow">
                                    <div class="header-contant-box">
                                        <h3 class="heading-recommend-featured">Most Popular</h3>
                                    </div>
                                </div>
                                <div id="fea-<?php echo $pid; ?>"
                                     class="filterDiv <?php echo get_field('category', $pid); ?> <?php if ($i == 1) {
                                         echo "feature-by-category";
                                     } else {
                                         echo "feature-by-category-select feature-by-category-other";
                                     } ?>">
                                    <div class="author-page-profile row">
                                        <div class="">
                                            <div class="col-lg-5 col-md-5 col-sm-5 ">
                                                <div class="image-author-page-user">
                                                    <a href="<?php echo get_permalink($pid); ?>">
                                                        <img class="a-img"
                                                             src="<?php $image = get_field('featured_image', $pid);
                                                             echo $image['sizes']['medium_large']; ?>">
                                                    </a>

                                                    <?php if (get_field('category', $pid) == 2 || get_field('category', $pid) == 'Politics') { ?>
                                                        <div class="donkey-elephant-main">
                                                            <ul>
                                                                <?php
                                                                if ($donkey > 10 || $elephant > 10) { ?>
                                                                    <?php
                                                                    if ($elephant * 3 <= $donkey) { ?>
                                                                        <li class="inside-icon"><a
                                                                                    href="javascript:void(0)"><img
                                                                                        class="a-img"
                                                                                        src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                                        </li>
                                                                    <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                                        <li class="inside-icon"><a
                                                                                    href="javascript:void(0)"><img
                                                                                        class="a-img"
                                                                                        src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                                        </li>
                                                                    <?php }
                                                                } ?>
                                                            </ul>
                                                        </div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
                                                <a href="<?php echo get_permalink($pid); ?>" class=""><h4
                                                            class="news-title-featured"><?php echo get_the_title($pid); ?></h4>
                                                </a>
                                                <div class="author-detail-featured">
                                                    <p><a href="/article?aid=<?php echo $author; ?>">
                                                            <?php
                                                            $up = get_field('profile_image', "user_$author");
                                                            if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                                ?>
                                                                <img class="a-img"
                                                                     src="<?php echo $up['sizes']['user-display']; ?>"
                                                                     alt="avatar">
                                                                <?php
                                                            } else {

                                                                echo get_avatar($author);

                                                            } ?>

                                                            <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a>
                                                    </p>
                                                </div>
                                                <span class="channel-view"><a
                                                            href="javascript:void(0)"><?php echo $views; ?>
                                                        <strong> . </strong><?php echo get_the_date(); ?></a></span>
                                                <a href="<?php echo get_permalink($pid); ?>">
                                                    <div class="featured-desc"><?php $ps = get_post_field('post_content', $pid);
                                                        echo wp_strip_all_tags(implode(' ', array_slice(explode(' ', $ps), 0, 70))) . '...'; ?></div>
                                                </a>
                                                <a href="<?php echo get_permalink($pid); ?>" id="readmore-author"> Read
                                                    More</a>
                                                <ul class="social-featured">
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-thumbs-up active"></i>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="javascript:void(0)">
                                                            <i class="fa fa-thumbs-up active dislike-540"></i>
                                                        </a>
                                                    </li>
                                                    <li class="dropdown">
                                                        <a href="#" id="dd-share" data-toggle="dropdown">
                                                            <i class="fa fa-share-alt active"></i>
                                                        </a>

                                                        <div aria-labelledby="dd-share"
                                                             class="dropdown-menu dd-share-expanded">
                                                            <ul class="ul-social-share-dd">
                                                                <li>
                                                                    <a href="#" onClick="facebookShareButton();">
                                                                            <span data-link="#share-facebook">
                                                                                <i class="mdi mdi-facebook"></i>
                                                                            </span>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a href="#" onClick="twitterShareButton();">
                                                                            <span data-link="#share-twitter">
                                                                                <i class="mdi mdi-twitter"></i>
                                                                            </span>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="">
                        <div class="page-contant-box">
                        <div class="recommend-sec clearfix">
                        <?php
                    } ?>

                    <?php if ($i > 1) {

                        $pid3 = array();
                        $pids[] = $post->ID;
                        $pid = $post->ID;
                        $author = $post->post_author;
                        $donkey = get_field('donkey');
                        $elephant = get_field('elephant');
                        $uv = get_field('upvotes');
                        $dv = get_field('downvotes');
                        $views = get_field('views');
                        if ($views == 1) {
                            $views = $views . ' view';
                        } else {
                            $views = $views . ' views';
                        }
                        $catarray = array();
                        $catarray[] = get_field('category');
                        ?>
                        <div id="feal-<?php echo $post->ID; ?>"
                             class="recommend-box recommend-margin desktop-home-new filterDiv <?php echo get_field('category'); ?>">

                            <div class="recommend-box-inner news-card-border ">
                                <div class="image-holder">
                                    <a href="<?php the_permalink(); ?>" class="">
                                        <img class="a-img" src="<?php $image = get_field('featured_image');
                                        echo $image['sizes']['home-article-image']; ?>"></a>
                                    <div class="like-dislike 123">

                                        <ul>
                                            <a href="#" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn">
                                                <li>
                                                    <img src="/wp-content/uploads/2019/09/like.png">
                                                    <span id="like_span_<?=$pid?>"><?php echo $uv; ?></span>
                                                </li>
                                            </a>
                                            <a href="#" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn">
                                                <li>
                                                    <img src="/wp-content/uploads/2019/09/unlike-btn.png">
                                                    <span id="dislike_span_<?=$pid?>"><?php echo $dv; ?></span>
                                                </li>
                                            </a>
                                        </ul>

                                    </div>
                                    <?php if (get_field('category') == 2 || get_field('category') == 'Politics') { ?>
                                        <div class="donkey-elephant-main">
                                            <ul>
                                                <?php
                                                if ($donkey > 10 || $elephant > 10) { ?>
                                                    <?php
                                                    if ($elephant * 3 <= $donkey) { ?>
                                                        <li class=""><a href="javascript:void(0)"><img class="a-img"
                                                                                                       src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                        </li>
                                                    <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                        <li class=""><a href="javascript:void(0)"><img class="a-img"
                                                                                                       src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                        </li>
                                                    <?php }
                                                } ?>
                                            </ul>
                                        </div>
                                    <?php } ?>
                                </div>
                                <div class="author-detail">
                                    <a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>">
                                        <div class="media">
                                            <div class="media-left">
                                                <?php
                                                $up = get_field('profile_image', "user_$author");
                                                if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                    ?>
                                                    <img class="a-img"
                                                         src="<?php echo $up['sizes']['user-display']; ?>"
                                                         alt="avatar">
                                                    <?php
                                                } else {

                                                    echo get_avatar($author);

                                                } ?>
                                            </div>
                                            <div class="media-body">
                                                <h4 class="media-heading">
										<span class="ratings">
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
                                            <!--( 59 reviews)-->
										( <?= count($postsAuthor) ?> articles)
										</span>
                                                </h4>
                                                <p><?php the_author_meta('display_name', $author); ?></p>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="text-box">
                                    <span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?>
                                            <strong></strong> <?php echo get_the_date(); ?></a></span>
                                    <hr>
                                    <h4>
                                        <a href="<?php the_permalink(); ?>" class="">
                                            <span class="news-title"><?php the_title(); ?></span>
                                        </a>
                                    </h4>


                                    <a href="<?php the_permalink(); ?>" class="pro-text"><?php
                                        $ps = get_post_field('post_content', $post->ID);
                                        echo wp_strip_all_tags(wp_trim_words($ps, 255));
                                        // echo the_content($post);
                                        ?></a>
                                </div>
                            </div>
                        </div>
                        <?php ?>


                        <!-- mobile ---------->

                        <?php if (($i % 8) == 6) { ?>

                            <div class="author-page-profile mobile-home-new mobile-home-new-big">
                                <div class="col-lg-5 col-md-5 col-sm-5 ">
                                    <div class="image-author-page-user">
                                        <a href="#">
                                            <img src="<?php $image = get_field('featured_image');
                                            echo $image['sizes']['mobile-article-large']; ?>">
                                        </a>
                                        <div class="like-dislike 123">
                                            <ul>
                                                <li class=""><a
                                                            href="javascript:void(0)" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn"><i
                                                                class="fas fa-thumbs-up home-thumbs-up"></i></a>
                                                </li>
                                                <li class=""><a
                                                            href="javascript:void(0)" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn"><i
                                                                class="fas fa-thumbs-down home-thumbs-down"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <?php if (get_field('category') == 2 || get_field('category') == 'Politics') { ?>
                                            <div class="donkey-elephant-main">
                                                <ul>
                                                    <?php
                                                    if ($donkey > 10 || $elephant > 10) { ?>
                                                        <?php
                                                        if ($elephant * 3 <= $donkey) { ?>
                                                            <li class="inside-icon">
                                                                <a href="javascript:void(0)"><img
                                                                            class="a-img"
                                                                            src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                            </li>
                                                        <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                            <li class="inside-icon">
                                                                <a href="javascript:void(0)"><img
                                                                            class="a-img"
                                                                            src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                            </li>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
                                    <a href="<?php the_permalink(); ?>" class=""><h4
                                                class="news-title-featured"><?php the_title(); ?></h4>
                                    </a>
                                    <div class="author-detail-featured">
                                        <p>
                                            <a href="/article?aid=<?php echo $author; ?>">
                                                <?php
                                                $up = get_field('profile_image', "user_$author");
                                                if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                    ?>
                                                    <img class="a-img"
                                                         src="<?php echo $up['sizes']['user-display']; ?>"
                                                         alt="avatar">
                                                    <?php
                                                } else {

                                                    echo get_avatar($author);

                                                } ?>
                                                <span class="author-name"> <?php the_author_meta('display_name', $author); ?></span>
                                            </a>
                                        </p>
                                    </div>
                                    <span class="channel-view"><a
                                                href="javascript:void(0)"><?php echo $views; ?>
                                            <strong> . </strong><?php echo get_the_date(); ?></a></span>
                                    <a href="<?php the_permalink(); ?>">
                                        <div class="featured-desc">
                                            <?php
                                            $ps = get_post_field('post_content', $pid);
                                            //echo implode(' ', array_slice(explode(' ', $ps), 0, 55));
                                            echo wp_strip_all_tags(wp_trim_words($ps, 55));
                                            ?>
                                        </div>
                                    </a>
                                    <a href="<?php the_permalink(); ?>"
                                       id="readmore-author"> READ MORE</a>

                                </div>
                            </div>

                        <?php } else if (($i % 8) == 7 || ($i % 8) == 0) { ?>
                            <?php if (($i % 8) == 7) { ?>
                                <div class="seventh-post seven-eight-post recommend-box recommend-margin mobile-home-new filterDiv <?php echo get_field('category'); ?>">

                                    <div class="recommend-box-inner news-card-border ">
                                        <div class="mobile-image-holder">
                                            <a href="<?php the_permalink(); ?>"
                                               class="">
                                                <img src="<?php $image = get_field('featured_image');
                                                echo $image['sizes']['home-article-image']; ?>"></a>
                                            <div class="like-dislike 123">
                                                <ul>
                                                    <li class=""><a
                                                                href="javascript:void(0)" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn"><i
                                                                    class="fas fa-thumbs-up home-thumbs-up"></i></a>
                                                    </li>
                                                    <li class=""><a
                                                                href="javascript:void(0)" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn"><i
                                                                    class="fas fa-thumbs-down home-thumbs-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <?php if (get_field('category') == 2 || get_field('category') == 'Politics') { ?>
                                                <div class="donkey-elephant-main">
                                                    <ul>
                                                        <?php
                                                        if ($donkey > 10 || $elephant > 10) { ?>
                                                            <?php
                                                            if ($elephant * 3 <= $donkey) { ?>
                                                                <li class=""><a
                                                                            href="javascript:void(0)"><img
                                                                                class="a-img"
                                                                                src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                                </li>
                                                            <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                                <li class=""><a
                                                                            href="javascript:void(0)"><img
                                                                                class="a-img"
                                                                                src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                                </li>
                                                            <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="text-box">
                                            <div class="">
                                                <div class="mobile-author-detail">
                                                    <p>
                                                        <a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>">
                                                            <!--<img class="mobile-a-img" src="<?php $up = get_field('profile_image', "user_$author");
                                                            echo $up['sizes']['user-thumbnail']; ?>"> -->
                                                            <?php
                                                            $up = get_field('profile_image', "user_$author");
                                                            if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                                ?>
                                                                <img class="a-img"
                                                                     src="<?php echo $up['sizes']['user-display']; ?>"
                                                                     alt="avatar">
                                                                <?php
                                                            } else {

                                                                echo get_avatar($author);

                                                            }
                                                            ?>
                                                            <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span>
                                                        </a>
                                                    </p>
                                                </div>
                                                <h4 class="mobile-rc-title"><a
                                                            href="<?php the_permalink(); ?>"
                                                            class="seven-eight-post-title"><span
                                                                class="news-title"><?php the_title(); ?></span></a>
                                                </h4>
                                                <span class="channel-view"><a
                                                            href="javascript:void(0)"><?php echo $views; ?>
                                                        <strong></strong> <?php echo get_the_date(); ?></a></span>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                            <?php } else if (($i % 8) == 0) { ?>
                                <div class="eighth-post seven-eight-post recommend-box recommend-margin mobile-home-new filterDiv <?php echo get_field('category'); ?>">

                                    <div class="recommend-box-inner news-card-border ">
                                        <div class="mobile-image-holder">
                                            <a href="<?php the_permalink(); ?>"
                                               class="">
                                                <img src="<?php $image = get_field('featured_image');
                                                echo $image['sizes']['home-article-image']; ?>"></a>
                                            <div class="like-dislike 123">
                                                <ul>
                                                    <li class=""><a
                                                                href="javascript:void(0)" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn"><i
                                                                    class="fas fa-thumbs-up home-thumbs-up"></i></a>
                                                    </li>
                                                    <li class=""><a
                                                                href="javascript:void(0)" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn"><i
                                                                    class="fas fa-thumbs-down home-thumbs-down"></i></a>
                                                    </li>
                                                </ul>
                                            </div>

                                            <?php if (get_field('category') == 2 || get_field('category') == 'Politics') { ?>
                                                <div class="donkey-elephant-main">
                                                    <ul>
                                                        <?php
                                                        if ($donkey > 10 || $elephant > 10) { ?>
                                                            <?php
                                                            if ($elephant * 3 <= $donkey) { ?>
                                                                <li class=""><a
                                                                            href="javascript:void(0)"><img
                                                                                class="a-img"
                                                                                src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                                </li>
                                                            <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                                <li class=""><a
                                                                            href="javascript:void(0)"><img
                                                                                class="a-img"
                                                                                src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                                </li>
                                                            <?php }
                                                        } ?>
                                                    </ul>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        <div class="text-box">
                                            <div class="mobile-author-detail">
                                                <p>
                                                    <a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>">
                                                        <?php
                                                        $up = get_field('profile_image', "user_$author");
                                                        if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                            ?>
                                                            <img class="a-img"
                                                                 src="<?php echo $up['sizes']['user-display']; ?>"
                                                                 alt="avatar">
                                                            <?php
                                                        } else {

                                                            echo get_avatar($author);

                                                        }
                                                        ?>
                                                        <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a>
                                                </p>
                                            </div>
                                            <h4 class="mobile-rc-title"><a
                                                        href="<?php the_permalink(); ?>"
                                                        class="seven-eight-post-title"><span
                                                            class="news-title"><?php the_title(); ?></span></a>
                                            </h4>
                                            <span class="channel-view"><a
                                                        href="javascript:void(0)"><?php echo $views; ?>
                                                    <strong></strong> <?php echo get_the_date(); ?></a></span>

                                        </div>
                                    </div>

                                </div>
                            <?php } ?>
                        <?php } else { ?>


                            <div class="recommend-box recommend-margin mobile-home-new filterDiv <?php echo get_field('category'); ?>">

                                <div class="recommend-box-inner news-card-border ">
                                    <div class="mobile-image-holder">
                                        <a href="<?php the_permalink(); ?>"
                                           class="">
                                            <img src="<?php $image = get_field('featured_image');
                                            echo $image['sizes']['home-article-image']; ?>"></a>
                                        <div class="like-dislike 123">
                                            <ul>
                                                <li class=""><a
                                                            href="javascript:void(0)" data-pid="<?=$pid?>" data-type="like" class="likedislikeBtn"><i
                                                                class="fas fa-thumbs-up home-thumbs-up"></i></a>
                                                </li>
                                                <li class=""><a
                                                            href="javascript:void(0)" data-pid="<?=$pid?>" data-type="dislike" class="likedislikeBtn"><i
                                                                class="fas fa-thumbs-down home-thumbs-down"></i></a>
                                                </li>
                                            </ul>
                                        </div>

                                        <?php if (get_field('category') == 2 || get_field('category') == 'Politics') { ?>
                                            <div class="donkey-elephant-main">
                                                <ul>
                                                    <?php
                                                    if ($donkey > 10 || $elephant > 10) { ?>
                                                        <?php
                                                        if ($elephant * 3 <= $donkey) { ?>
                                                            <li class=""><a
                                                                        href="javascript:void(0)"><img
                                                                            class="a-img"
                                                                            src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a>
                                                            </li>
                                                        <?php } elseif ($donkey * 3 <= $elephant) { ?>
                                                            <li class=""><a
                                                                        href="javascript:void(0)"><img
                                                                            class="a-img"
                                                                            src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a>
                                                            </li>
                                                        <?php }
                                                    } ?>
                                                </ul>
                                            </div>
                                        <?php } ?>
                                    </div>
                                    <div class="text-box edged-text-box">
                                        <div class="mobile-author-detail">
                                            <p>
                                                <a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>">
                                                    <?php
                                                    $up = get_field('profile_image', "user_$author");
                                                    if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                                        ?>
                                                        <img class="a-img"
                                                             src="<?php echo $up['sizes']['user-display']; ?>"
                                                             alt="avatar">
                                                        <?php
                                                    } else {

                                                        echo get_avatar($author);

                                                    }
                                                    ?>
                                                    <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a>
                                            </p>
                                        </div>
                                        <h4 class="mobile-rc-title"><a
                                                    href="<?php the_permalink(); ?>"
                                                    class=""><span
                                                        class="news-title"><?php the_title(); ?></span></a>
                                        </h4>
                                        <span class="channel-view"><a
                                                    href="javascript:void(0)"><?php echo $views; ?>
                                                <strong></strong> <?php echo get_the_date(); ?></a></span>

                                    </div>
                                </div>

                            </div>
                            <?php
                        }
                    }

                    $i++;

                }

                ?>
                </div>
                </div>
                </div>


                <?php
                echo '<div class="home-pagination"><div class=""><div class="page-contant-box pagination">';
                $big = 999999999; // need an unlikely integer

                /* Creating pagination links with created query above */

                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $query->max_num_pages
                ));

                wp_reset_postdata();
                echo "</div></div></div>";

                echo '<div class="home-pagination-cat"><div class=""><div class="page-contant-box pagination">';
                $big = 999999999; // need an unlikely integer

                /* Creating pagination links with created query above */

                echo paginate_links(array(
                    'base' => str_replace($big, '%#%', get_pagenum_link($big)),
                    'format' => '?paged=%#%',
                    'current' => max(1, get_query_var('paged')),
                    'total' => $query->max_num_pages
                ));

                wp_reset_postdata();
                echo "</div></div></div>";
            }
            ?>

        </div>

        <div class="follow-div-sidebar">
            <br><br>
            <h4>Featured Authors</h4>
            <?php
            if ($most_recent_post_cat) {
                $argsForFeaturedAuthors = array(
                    'post_type' => 'post',
                    'post_status' => 'publish',
                    'meta_key' => 'category',
                    'meta_value' => $most_recent_post_cat
                );
                $postsForFeaturedAuthors = get_posts($argsForFeaturedAuthors);
                $author_ids = [];
                $count = 1;
                foreach ($postsForFeaturedAuthors as $eachPost) {
                    if ($count <= 3 && !in_array($eachPost->post_author, $author_ids)) {
                        $author_ids[] = $eachPost->post_author;
                        $count++;

                        ?>
                        <div class="author-fea-list">
                            <div class="author-detail-featured">
                                <p>
                                    <a href="/article?aid=<?= $eachPost->post_author ?>">
                                        <?php
                                        $up = get_field('profile_image', "user_$eachPost->post_author");
                                        if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') {
                                            ?>
                                            <img class="a-img"
                                                 src="<?php echo $up['sizes']['user-display']; ?>"
                                                 alt="avatar">
                                            <?php
                                        } else {

                                            echo get_avatar($eachPost->post_author);

                                        }
                                        ?>

                                        <span class="author-name"> <?php the_author_meta('display_name', $eachPost->post_author); ?> </span>
                                    </a>
                                </p>
                                <div class="author-btn-article">
                                    <a href="/article?aid=<?= $eachPost->post_author ?>" class="btn btn-follows">View
                                        Articles</a>
                                </div>
                            </div>
                        </div>
                        <?php
                    }
                }
            }

            ?>
        </div>

    </section>
</div>
<!--</div>-->

<?php
echo "<script>";

echo 'jQuery(".btn").click(function(){';

foreach ($feas as $fea) {

    echo 'if($("#fea-' . $fea . '").hasClass("show")){';

    //echo 'jQuery("#fea-'.$fea.'").hasClass("show",function(){jQuery("#feal-'.$fea.'").hide();});';
    echo '$("#feal-' . $fea . '").hide();';

    echo '}';

}
echo '});';
echo "</script>";
get_footer();
?>
<script>
    jQuery(document).ready(function ($) {

        $('.feature-article-ht1').addClass("mactive");

    });

</script>