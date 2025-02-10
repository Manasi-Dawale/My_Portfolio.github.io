
<div class="content blog-wrapper blog-style-1">  
    <div class="container clearfix">
        <div class="row clearfix">

            <div class="col-md-8 blog-content">

                <?php while (have_posts()) : the_post(); 
                    get_template_part( 'template-parts/loop', 'post' ); 
                    endwhile ?>
                <ul class="pagination clearfix">
                    <li><?php  previous_posts_link( esc_html__( 'Previous Page', 'hubfolio' ) ); ?></li>
                    <li><?php next_posts_link( esc_html__( 'Next Page', 'hubfolio' ) ); ?> </li>
                </ul>
                <div class="spc-40 clearfix"></div>
            </div><!--/.blog-content-->
            
            <!--SIDEBAR (RIGHT)-->
			<?php get_sidebar(); ?>
            
        </div><!--/.row-->
    </div><!--/.container-->
</div><!--/.blog-wrapper-->
