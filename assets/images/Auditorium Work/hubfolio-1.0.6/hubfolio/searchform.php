<?php
/**
 * The template for displaying search forms 
 *
 * @package themescamp-theme
 */
?>
<form role="search" method="get" id="searchform" class="searchform" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <input type="search" class="focus-input" placeholder="<?php echo esc_attr__('Type search keyword...','hubfolio'); ?>" value="<?php echo get_search_query(); ?>" name="s" />
    <input type="submit" class="searchsubmit" value="" />
</form>

