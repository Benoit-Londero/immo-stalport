<footer>
    <div class="container">
        <div class="footer-top">
            <div class="col">
                <?php $logo = get_field('logo_footer','options');?>
                <img src="<?php echo $logo['url'];?>" alt="<?php echo $logo['title'];?>" />
            </div>

            <?php 
            $i = 1;
            if(have_rows('widgets_footer','options')) : 
                while(have_rows('widgets_footer','options')) : the_row();?>
            <div class="col col_<?php echo $i;?>">
                <h4><?php echo get_sub_field('titre_colonne');?></h4>
                <?php $links = get_sub_field('liens_menu');?>

                <ul>
                    <?php foreach($links as $link):?>
                    <li><a href="<?php echo $link->guid;?>"><?php echo $link->post_title;?></a></li>
                    <?php endforeach;?>
                </ul>
            </div>
            <?php
                $i++;
                endwhile;
            endif;?>

            <div class="col rs_footer">
                <?php $socials = get_field('reseaux_sociaux','options');
                
                if(have_rows('reseaux_sociaux','options')):
                    while(have_rows('reseaux_sociaux','options')) : the_row();
                        $icone = get_sub_field('icone');
                        $url = get_sub_field('url');

                        echo '<a href="'.$url.'"><img src="'.$icone['url'].'" alt="'. $icone['name'] . '"/></a>';
                    endwhile;
                endif;?>
            </div>
        </div>
    </div>
    <div class="footer_middle">
        <?php $query = new WP_Query(
                    array(
                        'post_type' => 'page',
                        'posts_per_page' => -1
                    ));
            $allLinks = $query->posts;


            foreach ($allLinks as $links):
             echo '<a href="#">'.$links->post_title.'</a>';
            endforeach;

            wp_reset_postdata();?>

    </div>
    <div class="footer_bottom">
        <div class="container desktop">
            <a href="">Cookies</a>
            <div>
                <?php echo get_field('copyright','options');?>
            </div>
            <a href="">Confidentialité</a>
        </div>

        <div class="container mobile">
            <div class="links">
                <a href="">Cookies</a>
                <a href="">Confidentialité</a>
            </div>

            <div class="copyright">
                <?php echo get_field('copyright','options');?>
            </div>
        </div>
    </div>
</footer>

<?php wp_footer(); ?>