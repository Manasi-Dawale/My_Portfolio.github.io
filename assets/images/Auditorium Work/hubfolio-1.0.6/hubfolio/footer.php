<?php 
	/*-- Custom footer --*/
	if ( class_exists('\ThemescampPlugin\ThemescampPlugin') ) { 
				do_action( "themescamp_foot_builder" );
			}else{


		/*-- Default footer Fallback if no options install --*/
			echo '<footer class="footer tcg tcg-theme">'; 
			echo '<div class="container-fluid">';
			echo '<div class="clearboth clearfix"></div>';
			echo '<p>' . sprintf( esc_html__( 'Copyright %s by ThemesCamp All Rights Reserved.', 'hubfolio' ), date('Y') ) . '</p>';
			echo '</div>';
			echo '</footer>';
			?>
			<!--to top button-->
			<div class="progress-wrap cursor-pointer">
				<svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
				<path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
				</svg>
			</div>
		<?php
	}

wp_footer(); ?>

	</body>
</html> 