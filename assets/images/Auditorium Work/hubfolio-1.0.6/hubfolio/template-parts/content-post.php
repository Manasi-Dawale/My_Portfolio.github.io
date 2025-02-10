

<!--Post default-->      

<div class="content blog-wrapper">  
	<div class="container clearfix">
		<div class="row clearfix">
		<div class=" col-md-8 blog-content">

				<!--BLOG POST START-->
				<?php while (have_posts()) : the_post(); ?>

					<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post'); ?>>
						<?php  
							if ( get_post_meta($post->ID, 'post_format', true) == ''){ the_post_thumbnail(); } 

							if ( get_post_meta($post->ID, 'post_format', true) == '' && has_post_thumbnail()){
							echo'<div class="spc-30 clearfix"></div>';
							}
						?> 

 						<h3 class="entry-title"><?php the_title(); ?></h3> 

						<ul class="post-detail">
							<li><i class="lnr lnr-user fw-600"></i> <?php the_author_posts_link(); ?> </li>
							<li><i class="lnr lnr-history"></i> <?php echo get_the_date(); ?> </li> 
			 				 <?php if(has_category()) { ?> 
			  				<li><i class="lnr lnr-book"></i> <?php the_category(', '); ?></li>
			  				<?php if(get_the_tag_list()) { ?>
  							<li><i class="lnr lnr-tag"></i><?php the_tags('', ', '); ?></li> 
  							<?php }?>
			  				<li>
			  					<i class="lnr lnr-bubble"></i> 
			  					<?php 
			  					if(get_comments_number()==1){
			  					echo esc_attr($post->comment_count).esc_attr__(' Comment','hubfolio'); 
			  					}else{
		  						echo esc_attr($post->comment_count).esc_attr__(' Comments','hubfolio'); 
		  						}

			  					?>
			  				</li>  
			  				<?php }?> 
			  					
		  				</ul>

		  				<div class="spc-20 clearfix"></div>

		  				<?php the_content(); ?>
		  				<div class="spc-20 clearfix"></div>
		  				<div class="post-pager clearfix">
							<?php wp_link_pages(); ?>
						</div>

							<?php   if ( !post_password_required() ) { //only show comment if post not password protected

							// If comments are open or we have at least one comment, load up the comment template.
							   if (  comments_open() || get_comments_number()) :
								   comments_template();

						   endif; }?>

					</article><!--/.blog-post-->
					<!--BLOG POST END-->    
				<?php endwhile; ?>
					<div class="img-pagination">
						<?php $hubfolio_prevPost = get_previous_post();
						if($hubfolio_prevPost) {?>
							<div class="pagi-nav-box previous">
								<?php $hubfolio_prevthumbnail = get_the_post_thumbnail($hubfolio_prevPost->ID, array(150,150) ); $hubfolio_prev = esc_html__('Previous post', 'hubfolio'); ?>
								<?php previous_post_link('%link',"<div class='img-pagi'><i class='lnr lnr-arrow-left'></i> 
								$hubfolio_prevthumbnail</div>  <div class='imgpagi-box'><p>$hubfolio_prev</p> <h4 class='pagi-title'>%title</h4> </div>"); ?> 
							</div>

						<?php } $hubfolio_nextPost = get_next_post();  
						if($hubfolio_nextPost) { ?>
							<div class="pagi-nav-box next">
								<?php $hubfolio_nextthumbnail = get_the_post_thumbnail($hubfolio_nextPost->ID, array(150,150) ); $hubfolio_next = esc_html__('Next post', 'hubfolio'); ?>
								<?php next_post_link('%link',"<div class='imgpagi-box'><p>$hubfolio_next</p><h4 class='pagi-title'>%title</h4> </div> <div class='img-pagi'><i class='lnr lnr-arrow-right'></i>
								$hubfolio_nextthumbnail</div> "); ?>
							</div>
						<?php } ?>
					</div><!--/.img-pagination-->

			</div><!--/.blog-content-->

			<!--SIDEBAR (RIGHT)-->
			<?php
			 get_sidebar();
			 wp_reset_postdata(); 
			 ?>

		</div><!--/.row-->   
	</div><!--/.container-->
</div><!--/.blog-wrapper-->
