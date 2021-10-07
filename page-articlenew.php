<?php
/**
* Template Name: Articles Page
*
* @package WordPress
* @subpackage The_Publisher_Pen
* 
*/
get_header();
$aid = $_GET['aid'];
?>
  
<?php
                     
	$args = array(
		'post_type'     => 'post',
		'post_status'   => 'publish',
		'numberposts'   => -1,
		'author'        =>  $aid,
	 );
                     
    $posts = get_posts($args);
?>
<section class="be-content author-user-display">
	<div class="main-content  container-fluid">
	<div class="row">
	<div class="col-lg-9 circle-author">
	<div class="author-detail-title" style="background:url(<?php $up = get_field('profile_image', "user_$aid"); echo $up['sizes']['user-display']; ?>);">
	</div>
	<div class="author-channel">
	<h3><?php echo get_the_author_meta('display_name', $aid); ?></h3>
	</div>
	</div>
	</div>
</section>

 
<?php
           
if ( $posts ) {
                $i = 1;
foreach($posts as $post){
/* 	echo "<pre>";
	print_r($post); */
    $views = get_field('views');
    if($views == 1){
        $views = $views . ' view';
    }else{
        $views = $views . ' views';
    }
    $pid = get_the_id();
    $author = $post->post_author;
	$donkey = get_field('donkey');
	$elephant = get_field('elephant');
	$uv = get_field('upvotes');
	$dv = get_field('downvotes');
?>

<!--Single Article -->
<?php
if($i == 1){
?>
<!-- <section class="be-content">

	<div class="main-content container-fluid" id="feature-overflow">
		<div class="row author-page-profile">
		<div class="col-lg-5 col-md-5 col-sm-5 ">
			<div class="image-author-page-user">
				<img src="<?php $image = get_field('featured_image'); echo $image['sizes']['medium_large']; ?>">
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
								<li class=""><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
							<?php }
							elseif( $donkey * 3 <= $elephant){ ?>
								<li class=""><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
							<?php } }?>
						</ul>
					</div>
				<?php } ?>
			</div>
		</div>
		<div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
			<a href="<?php the_permalink(); ?>" class=""><h4 class="news-title-featured"><?php the_title(); ?></h4></a>
			<span class="channel-view" id="views-details">
			<a href="javascript:void(0)" class="related-views"><?php echo $views; ?><strong> . </strong> <?php echo get_the_date(); ?> </a>
			</span>
			<a href="<?php the_permalink(); ?>">
			<div class="featured-desc ets">
			<p><?php $ps = get_post_field('post_content', $pid); echo wp_strip_all_tags(implode(' ', array_slice(explode(' ', $ps), 0, 70))).'...'; ?></p>
			</div>
			</a>
			<a href="<?php the_permalink(); ?>" id="readmore-author"> READ MORE</a>
		</div>
		</div>
		<hr>
	</div>
</section> -->
    <section class="be-content">
        <div class="main-content container-fluid">
			
            <div class="page-contant-box">
                 <div class="recommend-sec clearfix">
<?php
}

/* if($i >= 2){ */
if($i >= 1){
?>

 <div class="recommend-box recommend-margin filterDiv <?php echo get_field('category'); ?>">
 		 
     <div class="recommend-box-inner news-card-border ">
        <div class="image-holder">
             <a href="<?php the_permalink(); ?>" class="">
                 <img src="<?php $image = get_field('featured_image'); echo $image['sizes']['medium']; ?>"></a>
                       <div class="like-dislike 123">
                            <ul>
                                <li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-up home-thumbs-up"></i></a></li> 
                                <li class=""><a href="javascript:void(0)"><i class="fas fa-thumbs-down home-thumbs-down"></i></a></li>
                            </ul>
                        </div>
                    <?php echo $img_url; ?>
                    <?php if( get_field('category') == 2 || get_field('category') == 'Politics' ) { ?>
                        <div class="donkey-elephant-main">
                            <ul>
                                <?php 
								if($donkey > 10 || $elephant > 10){ ?>
								<?php
								if( $elephant * 3 <= $donkey){ ?>
									<li class=""><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
								<?php }
								elseif( $donkey * 3 <= $elephant){ ?>
									<li class=""><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
								<?php } }?>
                            </ul>
                        </div>
                    <?php } ?>
          </div> 
		  	<div class="author-detail">				
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
			</div>
			<div class="text-box">
			<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?></a></span>
			<hr>
			<h4>
			<a href="<?php the_permalink(); ?>" class="">


			<!--<strong class="dots-img"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;"><g class="style-scope yt-icon"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" class="style-scope yt-icon"></path></g></svg></strong>-->
	        <span class="news-title"><?php the_title(); ?></span> 
			</a>
			</h4>
			<!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
			
		
			<a href="<?php the_permalink(); ?>" class="pro-text"><?php echo get_the_content('','', $post); ?></a>
			</div>
        </div>
    </div>

<!-- / End Single Article -->
<?php 
		
}
$i++; 
}

}
?>

                   </div>
           
            </div>
        </div>
    </section>

<?php
get_footer();