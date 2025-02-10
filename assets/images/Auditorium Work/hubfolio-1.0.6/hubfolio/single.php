<?php 

get_header(); 

	if ( ! class_exists('\ThemescampPlugin\ThemescampPlugin') ) { 

		echo '<!-- TCG post theme -->';
		get_template_part('template-parts/content','post'); 

	}  else{

		echo '<!-- TCG post core -->';
		do_action( "themescamp_singular" );

	}

get_footer(); ?>