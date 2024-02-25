<?php $color_bg = get_field('arriere_plan-color');?>

<section id="presentation">
    <div class="container">
        <div class="main-content" <?php if($color_bg): echo $color_bg ? "style='background:#f7f8f9;'" : '';endif;?>>
            <div class="col-g">
                <?php 
                $img = get_field('image_about','options');
                        
                echo '<span class="from-bottom">' . get_field('titre','options') . '</span>';?>
                <?php if($img):?>
                <div class="ctt_img">
                    <img src="<?php echo $img['url'];?>" alt="<?php echo $img['name'];?>" class="from-bottom" />
                </div>
                <?php endif;?>
            </div>
            <div class="col-d">
                <?php echo '<span class="from-bottom">' . get_field('texte_apropos','options') . '</span>';?>

                <?php $btn = get_field('lien_about','options');?>

                <?php if($btn) :?><a href="<?php echo $btn['url'];?>" class="cta from-bottom"><?php echo $btn['title'];?></a><?php endif;?>
            </div>
        </div>
    </div>
</section>