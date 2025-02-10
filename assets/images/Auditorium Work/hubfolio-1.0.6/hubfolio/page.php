<?php
/**
 * The template for displaying pages with sidebar
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ThemesCamp 
 */

get_header();

if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

	(new Themescamp_Pages());

}else{

?>

<div class="content blog-wrapper tcg-theme">  
	<div class="container clearfix">
		 <div class="row clearfix">
			<div class="<?php if (is_active_sidebar( 'main-sidebar' )){ echo 'col-md-8';} 
				else { echo 'col-md-12';}?> blog-content">
			
					<?php get_template_part('template-parts/content','page'); ?>

				<?php if ( comments_open() ) { ?>
				   <div id="comments" class="comments clearfix"><?php comments_template(); ?></div>
				<?php } ?>
				
				<div class="spc-40 clearfix"></div>
			</div><!--/.col-md-8-->
			
			<?php get_sidebar(); ?>
		 </div><!--/.row-->
	</div><!--/.container-->
</div><!--/.blog-wrapper-->
	
<?php 

}  get_footer(); ?>