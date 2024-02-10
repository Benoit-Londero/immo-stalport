<?php $color_bg = get_field('arriere_plan-color');?>

<div class="main-content" <?php if($color_bg): echo $color_bg ? "style='background:#f7f8f9;'" : '';endif;?>>
    <div class="col-g">
        <?php 
        $img = get_field('image_about','options');
                
        echo '<span class="from-bottom">' . get_field('introduction','options') . '</span>';?>
        <?php if($img):?>
        <img src="<?php echo $img['url'];?>" alt="<?php echo $img['name'];?>" class="from-bottom" />
        <?php endif;?>
    </div>
    <div class="col-d">
        <?php echo '<span class="from-bottom">' . get_field('texte_apropos','options') . '</span>';?>

        <?php $btn = get_field('lien_about','options');?>

        <a href="<?php if($btn) : $btn['url'];?>" class="cta from-bottom"><?php echo $btn['title']; endif;?></a>
    </div>
</div>