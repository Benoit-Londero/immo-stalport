<section id="section-cta-contact">
    <div class="container">
        <?php 
        $img = get_field('image_section_pdt');
        $blue = get_field('fond_bleu');
        $txt = get_field('contenu_bloc_pdt');
        $cta = get_field('cta_section_pdt');
    ?>

        <?php if($img):?>
        <div class="bloc_img from-left">
            <img src="<?php echo $img['url'];?>" alt="<?php echo $img['title'];?>" />
        </div>
        <?php endif;?>
        <div class="content_section-cta  <?php echo $blue == true ? 'bgBlue' : '';?> from-bottom">
            <?php if($txt): echo $txt;endif;?>
            <?php if($cta):?>
            <a href="<?php echo $cta['url'];?>" class="cta <?php echo $blue == true ? '' : 'bgBlue';?> from-bottom">
                <?php echo $cta['title'];?>
            </a>
            <?php endif;?>
        </div>
    </div>
</section>