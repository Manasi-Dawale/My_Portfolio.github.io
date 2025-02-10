
<?php
/**
 * The template for displaying Author posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package ThemesCamp
 */

get_header();

if (class_exists('\ThemescampPlugin\ThemescampPlugin')) {

    (new Themescamp_Author());

}else{

    ?>

<!-- Author title -->
<div class="hubfolio-author tcg-theme">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>   <?php echo esc_html__( 'Author: ', 'hubfolio' ).'<span>'.esc_html(get_the_author_meta('display_name')).'</span>'; ?> </h1> 
            </div>
        </div>
    </div>
</div>
            
<?php 
get_template_part('template-parts/content','blog');

}

get_footer(); 
?>