<section id="contact">
    <div class="container from-bottom">
        <?php 
            $subtitle = get_field('sub_contact','options');
            $title = get_field('titre-contact','options');
            $form = get_field('shortcode_form','options');
            $descr_Ctt = get_field('descr-contact','options');

        ?>
        <?php if($subtitle):?><p class="subtitle"><?php echo $subtitle;?></p><?php endif;?>
        <?php if($title):?><?php echo $title;?><?php endif;?>
        <span class="separator"></span>
        <?php if($descr_Ctt):?><?php echo $descr_Ctt;?><?php endif;?>

    </div>
    <div class="container container-form">
        <?php echo do_shortcode( $form );?>
    </div>
</section>