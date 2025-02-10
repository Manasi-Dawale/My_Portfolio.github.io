<?php
   //custom Sidebar
if (class_exists('\ThemescampPlugin\ThemescampPlugin')) { 

	(new Themescamp_Sidebars());

} else {
	?>
	
<div class="col-md-4 sidebar fixed-sidebar sidebar-1 tcg-theme">
	<div class="theiaStickySidebar">
		<?php  if ( function_exists( 'dynamic_sidebar' ) ){ 
			if ( is_active_sidebar( 'main-sidebar' ) ) { dynamic_sidebar( 'main-sidebar' );}
		} ?>
	</div><!--  End StickySidebar  -->
</div><!--  End Sidebar  -->  

<?php
}
