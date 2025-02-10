<div class="img-pagination">
    <?php $hubfolio_prevPost = get_previous_post();
    if($hubfolio_prevPost) {?>
        <div class="pagi-nav-box previous">
            <?php $hubfolio_prevthumbnail = get_the_post_thumbnail($hubfolio_prevPost->ID, array(150,150) ); $hubfolio_prev = esc_html__('Previous post', 'hubfolio'); ?>
            <?php previous_post_link('%link',"<div class='img-pagi'><i class='lnr lnr-arrow-left'></i> 
            $hubfolio_prevthumbnail</div>  <div class='imgpagi-box'><p>$hubfolio_prev</p> <h4 class='pagi-title'>%title</h4> </div>"); ?> 
        </div>

    <?php } $hubfolio_nextPost = get_next_post();  
    if($hubfolio_nextPost) { ?>
        <div class="pagi-nav-box next">
            <?php $hubfolio_nextthumbnail = get_the_post_thumbnail($hubfolio_nextPost->ID, array(150,150) ); $hubfolio_next = esc_html__('Next post', 'hubfolio'); ?>
            <?php next_post_link('%link',"<div class='imgpagi-box'><p>$hubfolio_next</p><h4 class='pagi-title'>%title</h4> </div> <div class='img-pagi'><i class='lnr lnr-arrow-right'></i>
            $hubfolio_nextthumbnail</div> "); ?>
        </div>
    <?php } ?>
</div><!--/.img-pagination-->