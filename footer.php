<?php if(!is_front_page(  )):
    get_template_part( 'templates-parts/section-suiveznous' );?>

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
            <?php 
                $listKeyword = get_field('liste-keyword','options');

                if($listKeyword):
                    echo $listKeyword;
                endif;
            ?>
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

<?php endif;

wp_footer(); ?>