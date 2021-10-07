<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package WordPress
 * @subpackage The_Publisher_Pen
 * @since 1.0.0
 */

get_header();
?>

<section class="be-content">
	<div class="main-content container-fluid" id="feature-overflow">
		<div class="list-heading">
			<div class="header-contant-box">
				<h3 class="heading-recommend-featured">Featured</h3>
			</div> 
		</div> 
		<div class="list-heading">
			<div class="header-contant-box">
			<?php if($_GET['payout_batch_id']){ ?>
				<h4><?php echo $_GET['payout_batch_id']; ?></h4>
				<h4><?php echo $_GET['tamount']; ?></h4>
				<h4><?php echo $_GET['tid']; ?></h4>
			<?php } ?>
			</div> 
		</div> 
<?php 
$cats = array("world","us","politics","local","business","technology","science","health","sports","arts","books","style","food","travel");
$i = 1;
	$feas = array();
foreach( $cats as $cat ){
  $args = array(
	 'post_type' => 'post',
	 'post_status' => 'publish',
	 'numberposts' => 1,
	 'meta_key'		=> 'category',
	'meta_value'	=> $cat
 );
 
 $posts = get_posts($args);
 ?>
 <?php

foreach($posts as $post){
/* 	echo "<pre>";
	print_r($post); */

	$feas[$i] =  $post-> ID;
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

		<div id="fea-<?php echo $post-> ID; ?>" class="filterDiv <?php echo get_field('category'); ?> af_<?php echo $post-> ID; ?> <?php if($i == 1){ echo "feature-by-category";}else{echo "feature-by-category-select feature-by-category-other";}?>">
		<div class="row author-page-profile">
				<div class="col-lg-5 col-md-5 col-sm-5 ">
				<div class="image-author-page-user">
				<a href="#">
					<img src="<?php $image = get_field('featured_image'); echo $image['sizes']['medium']; ?>">
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
								<li class="inside-icon"><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
							<?php }
							elseif( $donkey * 3 <= $elephant){ ?>
								<li class="inside-icon"><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
							<?php } }?>
						</ul>
					</div>
				<?php } ?>
				</div>
				</div>
				<div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
					<a href="<?php the_permalink(); ?>" class=""><h4 class="news-title-featured"><?php the_title(); ?></h4></a>
					<div class="author-detail-featured">				
						<p><a href="/article?aid=<?php echo $author; ?>"><img src="<?php the_field('profile_image', "user_$author"); ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p>
					</div>
					<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?><strong> . </strong><?php echo get_the_date(); ?></a></span>  
					<a href="<?php the_permalink(); ?>">
						<div class="featured-desc"><?php $ps = get_post_field('post_content', $pid); echo implode(' ', array_slice(explode(' ', $ps), 0, 55)).'...'; ?></div>
					</a>
					<a href="<?php the_permalink(); ?>" id="readmore-author"> READ MORE</a>
				</div>	
		</div> 
			<hr>
		</div> 

	
<?php 

}

$i++;
}
$feas;
/* echo "<pre>";
print_r($arr);
echo "<script>"; */

?>
		</div>
	</section>
	    <section class="be-content">
        <div class="container-fluid main-content">
		
            <div class="list-heading">
                 <div class="header-contant-box">
                     <h3 class="heading-recommend">Recommended</h3>
                 </div> 
			</div>
		
		</div>
	</section>
    
    <section class="be-content">
        <div class="main-content container-fluid">
			
            <div class="page-contant-box">
                <div class="recommend-sec clearfix">
<?php
 
 $args = array(
	 'post_type' => 'post',
	 'post_status' => 'publish',
	 'numberposts' => -1
 );
 
 $posts = get_posts($args);


	if ( $posts ) {
		
		$i = 1;

		foreach($posts as $post){
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


<?php


?>
                   <?php ?>
					 <div id="feal-<?php echo $post-> ID; ?>" class=" a_<?php echo $post-> ID; ?> recommend-box recommend-margin desktop-home-new filterDiv <?php echo get_field('category'); ?>" >
							 
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
							  <div class="text-box">
								  <h4>
									 <a href="<?php the_permalink(); ?>" class="">
										  <span class="news-title"><?php the_title(); ?></span> 

										  <strong class="dots-img"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;"><g class="style-scope yt-icon"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" class="style-scope yt-icon"></path></g></svg></strong>

									  </a>
									</h4>
									<div class="author-detail">				
									<p><a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>"><img src="<?php the_field('profile_image', "user_$author"); ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p></div>
									<!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
									<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?></a></span>
									<a href="<?php the_permalink(); ?>" class="pro-text"><?php echo get_the_content('','', $post); ?></a>
								</div>
							</div>
						</div>
<?php ?>


	<!-- mobile ---------->

	<?php if( ($i % 4) == 0) { ?>

			<div class="row author-page-profile mobile-home-new mobile-home-new-big">
						<div class="col-lg-5 col-md-5 col-sm-5 ">
							<div class="image-author-page-user">
							<a href="#">
								<img src="<?php $image = get_field('featured_image'); echo $image['sizes']['medium']; ?>">
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
											<li class="inside-icon"><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/donkey_star1.png'; ?>"></a></li>
										<?php }
										elseif( $donkey * 3 <= $elephant){ ?>
											<li class="inside-icon"><a href="javascript:void(0)"><img src="<?php echo get_template_directory_uri() . '/assets/images/elephant_star1.png'; ?>"></a></li> 
										<?php } }?>
									</ul>
								</div>
							<?php } ?>
							</div>
						</div>
						<div class="col-lg-7 col-md-7 col-sm-7 detail-fetured">
							<a href="<?php the_permalink(); ?>" class=""><h4 class="news-title-featured"><?php the_title(); ?></h4></a>
							<div class="author-detail-featured">				
								<p><a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>"><img src="<?php the_field('profile_image', "user_$author"); ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p>
							</div>
							<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?><strong> . </strong><?php echo get_the_date(); ?></a></span>  
							<a href="<?php the_permalink(); ?>">
								<div class="featured-desc">
									<?php 
										$ps = get_post_field('post_content', $pid); 
										echo implode(' ', array_slice(explode(' ', $ps), 0, 55)); 
										//echo wp_strip_all_tags(wp_trim_words($ps, 30));
									?>
								</div>
							</a>
							<a href="<?php the_permalink(); ?>" id="readmore-author"> READ MORE</a>
						</div>
			</div>


	<?php } else { ?>


			 <div class="recommend-box recommend-margin mobile-home-new filterDiv <?php echo get_field('category'); ?>">
					 
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
					  <div class="text-box">
						  <h4>
							 <a href="<?php the_permalink(); ?>" class="">
								  <span class="news-title"><?php the_title(); ?></span> 

								  <strong class="dots-img"><svg viewBox="0 0 24 24" preserveAspectRatio="xMidYMid meet" focusable="false" class="style-scope yt-icon" style="pointer-events: none; display: block; width: 100%; height: 100%;"><g class="style-scope yt-icon"><path d="M12 8c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2zm0 2c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2zm0 6c-1.1 0-2 .9-2 2s.9 2 2 2 2-.9 2-2-.9-2-2-2z" class="style-scope yt-icon"></path></g></svg></strong>

							  </a>
							</h4>
							<div class="author-detail">				
							<p><a href="<?php echo site_url() ?>/article?aid=<?php echo $author; ?>"><img src="<?php the_field('profile_image', "user_$author"); ?>"> <span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></p></div>
							<!--<div class="author-detail"><a href="javascript:void(0)"><span class="author-name"> <?php the_author_meta('display_name', $author); ?> </span></a></div> -->
							<span class="channel-view"><a href="javascript:void(0)"><?php echo $views; ?> <strong></strong> <?php echo get_the_date(); ?></a></span>
							<a href="<?php the_permalink(); ?>" class="pro-text"><?php echo get_the_content('','', $post); ?></a>
						</div>
					</div>
				</div>

<?php 
}


?>
<?php
$i++;

 }
 ?>     	</div>
        </div>
    </div>
	<div class="modal-button">
<button type="button" class="btn btn-primary btn-paid" data-toggle="modal" data-target="#getpaid">
  Get Paid
</button>


<div class="modal fade" id="getpaid" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
     <form action="/" method="get">
		<div class="form-group">
		<label for="exampleInputEmail1">Email address</label>
		<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
		</div>
	 </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Get Paid</button>
      </div>
    </div>
  </div>
</div>
</div>
</section>
<?php
	}
get_footer();
?>
<script>
jQuery(document).ready(function($) {
    // hide all the events
    $("div[class^='af_']").click(function() {
		alert($(this).attr('class'));
    });
});
</script>
<?php 