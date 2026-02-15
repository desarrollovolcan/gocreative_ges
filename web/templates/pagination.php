<?php
/**
 * @Packge     : Lonyo
 * @Version    : 1.0
 * @Author     : Mthemeus
 * @Author URI : https://mthemeus.com/
 *
 */
 
    // Block direct access
    if( !defined( 'ABSPATH' ) ){
        exit();
    }

    if( !empty( lonyo_pagination() ) ) :
?>
<!-- Post Pagination -->
<div class="lonyo-pagination">

        <?php 
        
        add_filter('next_posts_link_attributes', 'posts_link_attributes');
        add_filter('previous_posts_link_attributes', 'posts_link_attributes');
        function posts_link_attributes(){
            return 'class="pagi-btn"';
        };


        ?>

        <?php
            $prev 	= '<i class="ri-arrow-left-s-line"></i>';
            $next 	= '<i class="ri-arrow-right-s-line"></i>';
            // previous
            if( get_previous_posts_link() ){
                previous_posts_link( $prev );
            }
        ?>
         <ul>
            <?php 
                echo lonyo_pagination();
            ?>
         </ul>
        <?php 
        // next
        if( get_next_posts_link() ){
            next_posts_link( $next );
        }
    ?>
</div>
<!-- End of Post Pagination -->
<?php 
    endif;