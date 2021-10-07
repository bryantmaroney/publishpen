<?php
/**
* Template Name: new home Page
 */
session_start();
$cat = $_GET['cat'];
get_header();
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
?>
<div class="be-content video-detail-page">
    <section class="page-manager">
        <div class="video-detail">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-manager-inner">
                            <div class="row">
                                <div class="page-detail-colum home-page-detail">
								<div class="scroll-wrapper content scrollbar-outer scrollbar-mobile left-panel" style="position: relative;">
                                <div class="content scrollbar-outer left-panel scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 152px;">
								<div class="yespost-content" style="display:none;">
								<div id="feature-overflow">
								<div class="list-heading">
								<div class="header-contant-box">
								<h3 class="heading-recommend-featured">This page has no articles related to this category.</h3>
								</div>
								</div>
								</div>
								</div>
								
								<div class="nopost-content">
								<div id="feature-overflow" class="feature-overflow">
								<img src="/wp-content/uploads/2019/09/img-featured-fixed.png" class="image-featured-top-fixed">
								<div class="list-heading feature-heading">
								<div class="header-contant-box">
								<h3 class="heading-recommend-featured">Featured</h3>
								</div> 
								</div> 
								
<!--- Feature  --> 			
							<?php 
								
								if ( empty($cat) ) {
									
									$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'numberposts' => 1
									);
									$posts = get_posts($args);
								}
								/* if ( is_front_page() && isset($cat) ) { */
								if ( isset($cat) ) {
									
									$args = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'numberposts' => 1,
									'meta_key'		=> 'category',
									'meta_value'	=> $cat
									);
									$posts = get_posts($args);
									
								}
								if($posts){
								foreach($posts as $post){
								
								$_SESSION["fav"] = get_the_ID();
								
								$pid = $_SESSION["fav"];
								
								$views = get_field('views', $pid);
								if($views == 1){
								$views = $views . ' view';
								}else{
								$views = $views . ' views';
								}
								
								$author_id = get_post_field ('post_author', $pid);
								$author_name = get_the_author_meta( 'display_name' , $author_id ); 
								$donkey = get_field('donkey', $pid);
								$elephant = get_field('elephant', $pid);
								$uv = get_field('upvotes', $pid);
								$dv = get_field('downvotes', $pid);
								?>
<!-- Feature start ------------------->		

								<div id="fea-<?php echo $pid; ?>" class="filterDiv <?php echo get_field('category', $pid); ?>">
								<div class="author-page-profile row">
								<div class="">
								<div class="col-lg-5 col-md-5 col-sm-5 ">
								<div class="image-author-page-user">
								<a href="<?php echo get_permalink($pid); ?>">
								<img class="a-img" src="<?php $image = get_field('featured_image', $pid); echo $image['sizes']['medium_large']; ?>">
								</a>
								<!--<div class="like-dislike 123">
								<ul>
								<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-up home-thumbs-up"></i></a></li> 
								<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-down home-thumbs-down"></i></a></li>
								</ul>
								</div>-->

								<?php if( get_field('category', $pid) == 2 || get_field('category', $pid) == 'Politics' ) { ?>
								<div class="donkey-elephant-main">
								<ul>
								<?php 
								if($donkey > 10 || $elephant > 10){ ?>
								<?php
								if( $elephant * 3 <= $donkey){ ?>
								<li class="inside-icon"><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
								<?php }
								elseif( $donkey * 3 <= $elephant){ ?>
								<li class="inside-icon"><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
								<?php } }?>
								</ul>
								</div>
								<?php } ?>
								</div>
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
								<a href="<?php get_permalink($pid); ?>" class=""><h4 class="news-title-featured"><?php echo get_the_title($pid); ?></h4></a>
								<div class="author-detail-featured">				
								<p><a href="/article?aid=<?php echo $author_id; ?>"><img class="a-img" src="<?php $up = get_field('profile_image', "user_$author_id"); echo $up['sizes']['user-display']; ?>">
								<span class="author-name"> <?php echo $author_name; ?> </span></a></p>
								</div>
								<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?><strong> . </strong><?php echo get_the_date($pid); ?></a></span>  
								<a href="<?php echo get_permalink($pid); ?>">
								<div class="featured-desc"><?php $ps = get_post_field('post_content', $pid); echo wp_strip_all_tags(implode(' ', array_slice(explode(' ', $ps), 0, 70))).'...'; ?></div>
								</a>
								<a href="<?php echo get_permalink($pid); ?>" id="readmore-author"> Read More</a>
								<ul class="social-featured">
                                                        <li>
                                                            <a href="javascript:void(0)">
                                                                <!--<i class="fa fa-thumbs-up unactive"></i>-->
                                                                <i class="fa fa-thumbs-up active"></i>
                                                                <!--<span>upvote</span>-->
                                                            </a>
                                                        </li> 
                                                        <li>
                                                            <a href="javascript:void(0)">
                                                               <!-- <i class="fa fa-thumbs-down unactive"></i>-->
                                                                <i class="fa fa-thumbs-up active dislike-540"></i>
                                                                <!--<span>downvote</span>-->
                                                            </a>
                                                        </li>
                                                        <li class="dropdown">
                                                            <a href="#" id="dd-share" data-toggle="dropdown">
                                                               <!-- <i class="fa fa-share-alt unactive"></i>-->
                                                                <i class="fa fa-share-alt active"></i>
                                                            </a>
                                                            
                                                            <div aria-labelledby="dd-share" class="dropdown-menu dd-share-expanded">
                                                                <ul class="ul-social-share-dd">
                                                                    <li>
                                                                       <a href="#" onClick = "facebookShareButton();">
                                                                            <span data-link="#share-facebook">
                                                                                <i class="mdi mdi-facebook"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a href="#" onClick = "twitterShareButton();">
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
								
						<?php
								
							}
								}
							?>
							</div>
							</div>
								

								<?php 
								/* if ( is_front_page() && empty($cat) ) { */
								if($paged > 1){$post_per_page_value=25;}else{$post_per_page_value=24;}
								if ( empty($cat) ) {
									$args1 = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'posts_per_page' => 24,
									'post__not_in' => array($_SESSION["fav"]),
									'paged'          => $paged
									);
									$query1 = new WP_Query( $args1 );
									$posts1 = $query1->posts;
								}
								/* if ( is_front_page() && isset($cat) ) { */
								if ( isset($cat) ) {
									
									$args1 = array(
									'post_type' => 'post',
									'post_status' => 'publish',
									'posts_per_page' => 8,
									'post__not_in' => array($_SESSION["fav"]),
									'paged'          => $paged,
									'meta_key'		=> 'category',
									'meta_value'	=> $cat
									);
									$query1 = new WP_Query( $args1 );
									$posts1 = $query1->posts;	
									
								}
								$i = 1;
							
								foreach($posts1 as $post){
									
								$featureid = array_shift(array_values($posts1)) -> ID;
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								if ($paged == 1){
									
								
								
								}
								if($i == 1){
									
?>
								
								<div class="">

								<div class="page-contant-box">
								<div class="recommend-sec clearfix">
<!-- Feature end ------------------->							
								<?php } 
							
								$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
								
								
								if($i > 0){

								$pid3 = array();
								$pids[] = $post->ID;
								$pid = $post->ID;
								$author = $post->post_author;
								$donkey = get_field('donkey');
								$elephant = get_field('elephant');
								$uv = get_field('upvotes');
								$dv = get_field('downvotes');
								$views = get_field('views');
								if($views == 1){
								$views = $views . ' view';
								}else{
								$views = $views . ' views';
								}
								$catarray = array();
								$catarray[] = get_field('category');
								?>
								<?php //echo "<pre>"; print_r(get_field('profile_image', "user_$author")); ?>		
								<?php ?>
								<div id="feal-<?php echo $post-> ID; ?>" class="recommend-box recommend-margin desktop-home-new filterDiv <?php echo get_field('category'); ?>" >

								<div class="recommend-box-inner news-card-border ">
								<div class="image-holder">
								<a href="<?php the_permalink(); ?>" class="">
								<img class="a-img" src="<?php $image = get_field('featured_image'); echo $image['sizes']['home-article-image']; ?>"></a>
								   <div class="like-dislike 123">

										<ul>
											<a href="#">
											<li>
											<img src="/wp-content/uploads/2019/09/like.png"> 
											<span><?php echo $uv; ?></span>
											</li>
											</a>
											<a href="#">
											<li>
											<img src="/wp-content/uploads/2019/09/unlike-btn.png">
											<span><?php echo $dv; ?></span>
											</li>
											</a>
										</ul>

									</div>
								<?php if( get_field('category') == 2 || get_field('category') == 'Politics' ) { ?>
									<div class="donkey-elephant-main">
										<ul>
											<?php 
											if($donkey > 10 || $elephant > 10){ ?>
											<?php
											if( $elephant * 3 <= $donkey){ ?>
												<li class=""><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
											<?php }
											elseif( $donkey * 3 <= $elephant){ ?>
												<li class=""><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
											<?php } }?>
										</ul>
									</div>
								<?php } ?>
								</div> 
									<div class="author-detail">						
								<a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>">
								<div class="media">
										<div class="media-left">
										<img src="<?php $up = get_field('profile_image', "user_$author"); echo $up['sizes']['user-display']; ?>" class="media-object">
										</div>
										<div class="media-body">
										<h4 class="media-heading">
										<span class="ratings">
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star checked"></i>
										<i class="fa fa-star"></i>
										<i class="fa fa-star"></i>
										( 59 reviews)
										</span>
								       </h4>
										<p><?php the_author_meta('display_name', $author); ?></p>
										</div>
								</div>
								</a>
								</div>
								<div class="text-box">
								<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?></a></span>
								<hr>
								<h4>
								<a href="<?php the_permalink(); ?>" class="">
								  <span class="news-title"><?php the_title(); ?></span> 

								  <!--<strong class="dots-img"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;"><g class="style-scope yt-icon"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" class="style-scope yt-icon"></path></g></svg></strong>-->

								</a>
								</h4>
								
								<!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
								
								<a href="<?php the_permalink(); ?>" class="pro-text"><?php echo get_the_content('','', $post); ?></a>
								</div>
								</div>
								</div>
								<?php ?>


								<!-- mobile ---------->

								<?php if( ($i % 4) == 0) { ?>

								<div class="author-page-profile mobile-home-new mobile-home-new-big">
								<div class="col-lg-5 col-md-5 col-sm-5 ">
								<div class="image-author-page-user">
								<a href="#">
								<img src="<?php $image = get_field('featured_image'); echo $image['sizes']['mobile-article-large']; ?>">
								</a>
								<div class="like-dislike 123">
								<ul>
								<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-up home-thumbs-up"></i></a></li> 
								<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-down home-thumbs-down"></i></a></li>
								</ul>
								</div>

								<?php if( get_field('category') == 2 || get_field('category') == 'Politics' ) { ?>
								<div class="donkey-elephant-main">
								<ul>
								<?php 
								if($donkey > 10 || $elephant > 10){ ?>
								<?php
								if( $elephant * 3 <= $donkey){ ?>
									<li class="inside-icon"><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
								<?php }
								elseif( $donkey * 3 <= $elephant){ ?>
									<li class="inside-icon"><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
								<?php } }?>
								</ul>
								</div>
								<?php } ?>
								</div>
								</div>
								<div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
								<a href="<?php the_permalink(); ?>" class=""><h4 class="news-title-featured"><?php the_title(); ?></h4></a>
								<div class="author-detail-featured">				
								<p><a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>"><img class="a-img" src="<?php $up = get_field('profile_image', "user_$author"); echo $up['sizes']['user-thumbnail']; ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p>
								</div>
								<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?><strong> . </strong><?php echo get_the_date(); ?></a></span>  
								<a href="<?php the_permalink(); ?>">
								<div class="featured-desc">
								<?php 
								$ps = get_post_field('post_content', $pid); 
								//echo implode(' ', array_slice(explode(' ', $ps), 0, 55)); 
								echo wp_strip_all_tags(wp_trim_words($ps, 55));
								?>
								</div>
								</a>
								<a href="<?php the_permalink(); ?>" id="readmore-author"> READ MORE</a>
								
								</div>
								</div>


								<?php } else { ?>


								<div class="recommend-box recommend-margin mobile-home-new filterDiv <?php echo get_field('category'); ?>">

								<div class="recommend-box-inner news-card-border ">
								<div class="mobile-image-holder">
								<a href="<?php the_permalink(); ?>" class="">
								<img src="<?php $image = get_field('featured_image'); echo $image['sizes']['home-article-image']; ?>"></a>
								<div class="like-dislike 123">
								<ul>
									<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-up home-thumbs-up"></i></a></li> 
									<li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-down home-thumbs-down"></i></a></li>
								</ul>
								</div>

								<?php if( get_field('category') == 2 || get_field('category') == 'Politics' ) { ?>
								<div class="donkey-elephant-main">
								<ul>
									<?php 
									if($donkey > 10 || $elephant > 10){ ?>
									<?php
									if( $elephant * 3 <= $donkey){ ?>
										<li class=""><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
									<?php }
									elseif( $donkey * 3 <= $elephant){ ?>
										<li class=""><a href="javascript:void(0)"><img class="a-img" src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
									<?php } }?>
								</ul>
								</div>
								<?php } ?>
								</div> 
								<div class="text-box">
								<div class="mobile-author-detail">				
								<p><a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>"><img class="mobile-a-img" src="<?php $up = get_field('profile_image', "user_$author"); echo $up['sizes']['user-thumbnail']; ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p>
								</div>
								<h4 class="mobile-rc-title"><a href="<?php the_permalink(); ?>" class=""><span class="news-title"><?php the_title(); ?></span></a></h4>
								<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?></a></span>
								<!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
								<!--<span class="channel-view"><a href="javascript:void(0)"><?php //echo $views; ?> <strong></strong> <?php //echo get_the_date(); ?></a></span>
								<!-- <a href="<?php //the_permalink(); ?>" class="pro-text"><?php //echo get_the_content('','', $post); ?></a> -->
								</div>
								</div>

								</div>
								<?php 
								}
								?>
								<?php
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

								echo paginate_links( array(
								'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $query1->max_num_pages
								) );

								wp_reset_postdata();
								echo "</div></div></div>";

								echo '<div class="home-pagination-cat"><div class=""><div class="page-contant-box pagination">';
								$big = 999999999; // need an unlikely integer

								/* Creating pagination links with created query above */

								echo paginate_links( array(
								'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
								'format' => '?paged=%#%',
								'current' => max( 1, get_query_var('paged') ),
								'total' => $query1->max_num_pages
								) );

								wp_reset_postdata();
								echo "</div></div></div>";
								?> 
								<?php
								

								?>
								

								</div>
								</div>
								</div>
								
								
								<div class="no-pd-rt page-detail-colum-small desktop-home-new trending-home">
								<div class="card-header card-header-divider"><h3>Trending Article</h3></div>
								<div class="content">
								<div class="scroll-wrapper video-detail-right scrollbar-outer" style="position: relative; overflow:auto !important;">
								<div class="video-detail-right scrollbar-outer scroll-content scroll-scrolly_visible" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 107px;">
									 <?php get_template_part('template/related', 'post'); ?>
								</div>

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

<?php
echo "<script>"; 

echo 'jQuery(".btn").click(function(){';

foreach($feas as $fea){
	
	echo 'if($("#fea-'.$fea.'").hasClass("show")){';
	
	//echo 'jQuery("#fea-'.$fea.'").hasClass("show",function(){jQuery("#feal-'.$fea.'").hide();});';
	echo '$("#feal-'.$fea.'").hide();';
	
	echo'}';

}
echo '});';
echo "</script>";
get_footer();
?>
<script>
/* jQuery( document ).ready(function($) {


$('.feature-article-ht1').addClass("mactive");

}); */

</script>