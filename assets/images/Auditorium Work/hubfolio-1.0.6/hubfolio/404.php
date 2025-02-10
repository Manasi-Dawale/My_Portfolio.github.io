<?php
/*--Start 404 Error page--*/

get_header(); 

/*-- Custom 404 Error page --*/
if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

	(new Themescamp_Err());


} else {
	/*-- Default 404 Error Fallback if no options install --*/

	?>
	<div class="clearfix content page-content-wrapper tcg-theme">
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12 news-list aligncenter">
					<h2 class="error-title"><?php esc_html_e('404', 'hubfolio'); ?></h2>
					<p class="error-text"><?php esc_html_e('Oops..!!! Page not found!','hubfolio') ?></p>
					<div class="spc-40 clearboth"></div>
					<a class="error-btn" href="<?php echo esc_url ( home_url('/') ); ?>">
						<?php echo esc_html_e('Go Back Now!','hubfolio') ?>
						<span class="content-btn-align-icon-right content-btn-button-icon">
							<i class="fa fa-arrow-circle-right" aria-hidden="true"></i>
						</span>
					</a>
				</div><!--/.col-md-8-->
			</div><!--/.row-->
		</div><!--/.container-->
	</div><!--/.content-->
<?php

} 

get_footer();