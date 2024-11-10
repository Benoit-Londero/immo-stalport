<?php get_template_part( 'templates-parts/section-suiveznous' );?>

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
                    <?php 
                    $socials = get_field('reseaux_sociaux','options');
                    $adresse = get_field('adresse_footer','options');
                    
                    if(have_rows('reseaux_sociaux','options')):
                        while(have_rows('reseaux_sociaux','options')) : the_row();
                            $icone = get_sub_field('icone');
                            $url = get_sub_field('url');

                            echo '<a href="'.$url.'"><img src="'.$icone['url'].'" alt="'. $icone['name'] . '"/></a>';
                        endwhile;
                    endif;?>

                    <?php echo $adresse;?>  
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

        <?php 
            $cookies = get_field('cookies','options');
            $confidentialite = get_field('confidentialité','options');
            ?>
        <div class="footer_bottom">
            <div class="container desktop">
                <a href="<?php if($cookies):echo $cookies['url'];endif;?>">Cookies</a>
                <div>
                    <?php echo get_field('copyright','options');?>
                </div>
                <a href="<?php if($confidentialite):echo $confidentialite['url'];endif;?>">Confidentialité</a>
            </div>

            

            <div class="container mobile">
                <div class="links">
                    <a href="<?php if($cookies):echo $cookies['url'];endif;?>">Cookies</a>
                    <a href="<?php if($confidentialite):echo $confidentialite['url'];endif;?>">Confidentialité</a>
                </div>

                <div class="copyright">
                    <?php echo get_field('copyright','options');?>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" type="text/javascript"></script>
    <script src="https://kit.fontawesome.com/53b095485a.js" crossorigin="anonymous" defer></script>

    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="<?php echo get_template_directory_uri();?>/dist/main.js"></script>

<?php wp_footer(); 