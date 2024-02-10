<section id="aboutus">
    <div class="swiper-mobile">
        <div class="swiper-resp">
            <div class="swiper-wrapper">
                <?php if(have_rows('services','options')): while(have_rows('services','options')): the_row();?>

                <?php 
                        $img = get_sub_field('background_service');
                        $link = get_sub_field('lien_service');?>

                <div class="swiper-slide card from-bottom"
                    style="background:url(<?php if($img): echo $img['url']; endif;?>) center;background-size:cover;">
                    <a href="<?php if($link):echo $link['url'];endif;?>">
                        <h4><?php echo get_sub_field('nom_service');?></h4>
                    </a>
                </div>

                <?php endwhile;
            endif;?>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="grid">
            <?php if(have_rows('services','options')): 
                while(have_rows('services','options')): the_row();?>
            <?php 
            $img = get_sub_field('background_service');
            $link = get_sub_field('lien_service');?>

            <a href="<?php echo $link['url'];?>">
                <div class="card from-bottom"
                    style="background:url(<?php if($img): echo $img['url']; endif;?>) center;background-size:cover;">
                    <h4><?php echo get_sub_field('nom_service');?></h4>
                </div>
            </a>
            <?php endwhile;
            endif;?>
        </div>

        <?php if(is_front_page()):
            get_template_part( 'templates-parts/section-assurance' );
        endif;?>
    </div>
</section>