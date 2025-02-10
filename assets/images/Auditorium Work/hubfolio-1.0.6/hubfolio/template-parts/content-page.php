<?php while (have_posts()) : the_post(); ?>

	<article id="post-<?php  the_ID(); ?>" <?php  post_class('clearfix blog-post'); ?>>
		<?php  the_post_thumbnail(); ?> 
		<div class="spc-10 clearfix"></div>
		<h3 class="entry-title"><?php the_title(); ?></h3>

		<div class="spc-30 clearfix"></div>
			<?php the_content(); ?>
		<div class="clearfix"></div>
			 
		<div class="post-pager clearfix">
			<?php wp_link_pages(array(
				'before'=> '<p class"pagins">' . esc_html__( 'Pages:', 'hubfolio' ),
				'after' => '</p>')); 
			?>
		</div>
		<div class="border-post clearfix"></div>
		<div class="clearboth spc-40"></div> 
	</article><!--/.blog-post-->

<?php endwhile; ?>