<section id="disclaimer_banner">
    <?php 
    $bgBanner = get_field('arriere-plan_banner','options');
    $txtBanner = get_field('texte_banner','options');
    $imgBanner = get_field('image_banner','options');
    $ctaBanner = get_field('cta_banner','options');
    ?>

    <div class="container from-left"
        style="background:url('<?php echo $bgBanner['url'];?>') no-repeat;background-size:cover;">
        <div class="colg">
            <?php echo $txtBanner;?>
        </div>
        <div class="cold">
            <?php if($imgBanner):?>
            <img src="<?php echo $imgBanner['url'];?>" alt="<?php echo $imgBanner['title'];?>" />
            <?php endif;?>
            <a href="<?php echo $ctaBanner['url'];?>" class="cta bgBlue"><?php echo $ctaBanner['title'];?></a>
        </div>
    </div>
</section>