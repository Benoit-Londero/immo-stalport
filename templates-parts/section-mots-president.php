<section id="mot_president">
    <div class="container">
        <div class="columns">
            <div class="col-g">
                <?php $img = get_field('image_nossolutions','options');?>
                <?php if($img):?>
                <img src="<?php echo $img['url'];?>" alt="<?php echo $img['name'];?>" class="from-left" />
                <?php endif;?>
            </div>
            <div class="col-d from-right">
                <?php echo get_field('texte_du_president','options');?>
            </div>
        </div>
    </div>

    <div class="separator"></div>
</section>