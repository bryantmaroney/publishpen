<?php
/**
* Template Name: search result Page
*
* @package WordPress
* @subpackage The_Publisher_Pen
* 
*/

get_header();

global $user_ID; 
global $wp_query;
?>

<style>
.container {
	max-width: 100%;
    margin-right: 0;
    margin-left: auto;
    width: calc(100% - 250px);
}
.searchlist-desktop {
	margin-bottom: 20px;
}
.recommend-sec {
	display: block;
	grid-template-columns: none;
}
.searchlist-items {
    display: block;
    width: calc(100% / 4);
    float: left;
    padding-right: 20px;
    margin-bottom: 20px;
}
.searchlist-items:nth-child(4n) {
	padding-right: 0;
}
.searchlist-mobile {
	display: none;
}
@media screen and (max-width: 1100px) {
	.searchlist-items {
		width: calc(100% / 3);
	}
	.searchlist-items:nth-child(3n) {
		padding-right: 0;
	}
}
@media screen and (max-width: 1023px) {
	.container {
		width: 100%;
	}
}
@media screen and (max-width: 720px) {
	.searchlist-items {
		width: calc(100% / 2);
	}
	.searchlist-items:nth-child(2n) {
		padding-right: 0;
	}
}
@media screen and (max-width: 600px) {
	.searchlist-items {
		width: 100%;
		padding-right: 0;
	}
}
@media screen and (max-width: 500px) {
	.searchlist-desktop {
		display: none;
	}
	searchlist-mobile {
		display: block;
	}
	.be-wrapper {
		background: #FFFFFF;
	}
	.searchlist-searchbox {
		display: block !important;
		margin-bottom: -40px;
		border-bottom: 4px solid #007bff;
	}
	.searchlist-searchbox input {
		width: 100%;
		border: 0;
		line-height: 50px;
		font-size: 20px;
		padding: 0 20px;
	}
	.search-pagination {
		width: 100%;
		float: left;
	}
}
</style>

<div class="searchlist-searchbox" style="display:none;">
	<form action="/" method="get">
	    <input type="text" name="s" id="search" placeholder="search.." value="<?php the_search_query(); ?>" />
	    <!--<input type="image" alt="Search" src="<?php bloginfo( 'template_url' ); ?>/images/search.png" />-->
	</form>
</div>

<section class="search-result-listing">
<div class="container">
	
<div class="recommend-sec clearfix">	

<?php 	if ( have_posts() ){
	while ( have_posts() ) : the_post(); 
	$pid = get_the_id();

	$views = get_field('views');
	if($views == 1){
		$views = $views . ' view';
	}else{
		$views = $views . ' views';
	}

?>
	
	<div class="searchlist-items filterDiv">
	
	<div id="" class="recommend-box recommend-margin">
	
	<!-- DESKTOP -->
	<div class="searchlist-desktop">
		<div class="recommend-box-inner news-card-border">
		    <div class="image-holder">
		        <a href="<?php the_permalink(); ?>" class="">
		            <img class="a-img" src="<?php $image = get_field('featured_image'); echo $image['sizes']['home-article-image']; ?>"></a>
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
		
		    </div>
		    
		    <!-- START AUTHOR NAME -->
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
									<div style="display:inline-block;">
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
									</div>	
		                            <!--( 59 reviews)-->
		                            <div style="display:inline-block;vertical-align:bottom;line-height:11px;">
				                        ( 
										    <?php
				                            if(count($postsForAuthor) > 1)
				                                echo count($postsForAuthor). ' articles';
				                            else
				                                echo count($postsForAuthor). ' article';
				                            ?>
				                        )
		                            </div>    
								</span>
		                    </h4>
		                    
		                    <p><?php the_author_meta('display_name', $author); ?></p>
		                </div>
		            </div>
		        </a>
		    </div>
		    <!-- END AUTHOR NAME -->
		    
		    <div class="text-box">
		        <span class="channel-view">
		            <a href="javascript:void(0)"><?php echo $views; ?>
		                <strong></strong> <?php echo get_the_date(); ?>
		            </a>
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
		        </span>
		        <hr>
		        <h4>
		            <a href="<?php the_permalink(); ?>"
		               class="">
		
		                <span class="news-title"><?php the_title(); ?></span>
		
		            </a>
		        </h4>
		
		        <!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
		
		        <a href="<?php the_permalink(); ?>"
		           class="pro-text">
		            <?php
		            // $ps = get_post_field('post_content', $post->ID);
		            // echo wp_strip_all_tags(wp_trim_words($ps, 255));
		            $content_post = get_post($post->ID);
		            $ps = get_post_meta($post->ID, 'content', true);
		//                                                                            $ps = get_post_field('post_content', $post->ID);
		            echo wp_strip_all_tags(wp_trim_words($ps, 255));
		            // echo the_content($post);
		            ?>
		        </a>
		    </div>
		</div>
	</div><!-- searchlist-desktop -->	
	<!-- END DESKTOP -->
	
	<!-- START MOBILE -->
	<div class="searchlist-mobile">
		<div class="recommend-box-inner news-card-border">
			<div class="mobile-image-holder">
				<img class="a-img" src="<?php $image = get_field('featured_image'); echo $image['sizes']['home-article-image']; ?>">
			</div>
			<div class="text-box edged-text-box" style="margin-top:0;">
				<h4 class="mobile-rc-title"><?php the_title();?></h4>
				<div class="mobile-author-detail">
					<?php
	                $up = get_field('profile_image', "user_$author");
	                if ($up != null && $up['sizes']['user-display'] != 'https://www.publishpen.com/wp-content/uploads/2019/06/user-icon.png') { ?>
	                    <img class="a-img" src="<?php echo $up['sizes']['user-display']; ?>" alt="avatar">
	                <?php } else {
	                    echo get_avatar($author);
	                } ?>
					<span class="author-name"><?php the_author_meta('display_name', $author); ?></span>
				</div>	
				<span class="channel-view" style="bottom:-8px;">
					<a href="" style="font-size:14px;color:#606060;font-weight:400;display:flex;">
						<?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?>
					</a>	
				</span>	
			</div><!-- text-box edged-text-box -->
		</div>
	</div><!-- searchlist-mobile -->
	<!-- END MOBILE -->
	
	
	
	
	
	</div><!-- recommend-box recommend-margin -->
	</div><!-- searchlist-items filterDiv -->                                                           	

<?php endwhile; 
	echo '<div class="search-pagination">'.paginate_links( $args ).'</div>';
 }else{ ?>

<h2>We couldn't find any results.</h2>

<?php } ?>

</div>

</div>
</section>


<?php

get_footer();

?>