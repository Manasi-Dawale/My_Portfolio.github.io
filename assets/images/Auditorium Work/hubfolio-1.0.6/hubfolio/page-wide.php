<?php
/*
* Template Name: Page Wide
* Description:Page wide without sidebar
*/

get_header();

if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

	(new Themescamp_Pages());

}else{


?>
	
<div class="content blog-wrapper tcg-theme">  
	<div class="container clearfix">
		<div class="row clearfix">
			<div class="col-md-12 blog-content">
			
					<?php get_template_part('template-parts/content','page'); ?>

				<?php if ( comments_open() ) { ?>
				   <div id="comments" class="comments clearfix"><?php comments_template(); ?></div>
				<?php } ?>
				
				<div class="spc-40 clearfix"></div>
			</div><!--/.col-md-12-->
			
		</div><!--/.row-->
	</div><!--/.container-->
</div><!--/.blog-wrapper-->
	
<?php 

}

get_footer(); ?>