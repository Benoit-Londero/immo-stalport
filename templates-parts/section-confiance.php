<section id="confiance">
    <div class="container">

        <span class="from-bottom"><?php echo get_field('titre_conf','options');?></span>
        <span class="from-bottom"><?php echo get_field('introduction_conf','options');?></span>

        <div class="table_qualite">
            <?php 
            if(have_rows('qualites','options')) :
                while(have_rows('qualites','options')): the_row();?>
                    <div class="card_qualite from-bottom">
                        <?php 
                            $img = get_sub_field('icone');
                            $title = get_sub_field('titre');
                            $texte = get_sub_field('description');
                        ?>

                        <?php if($img):?><img src="<?php echo $img['url'];?>" alt="<?php echo $img['name'];?>" /><?php endif;?>
                        <?php if($title):?><h4><?php echo $title;?></h4><?php endif;?>
                        <?php if($texte):?><p><?php echo $texte;?></p><?php endif;?>
                    </div>
            <?php endwhile;
            endif;?>
        </div>

        <?php $clink = get_field('cta_conf','options');?>
        <?php if($clink):?><span class="cta"><a href="<?php echo $clink['url'];?>"><?php echo $clink['title'];?></a></span><?php endif;?>
    </div>
</section>