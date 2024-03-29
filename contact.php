<?php 
/* Template Name: contact */

get_header();

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

get_template_part( 'templates-parts/header-nav');?>

<header id="header" style="background:url('<?php echo $bg_url;?>');">
</header>
<section id="contact">
    <div class="container from-bottom">
    <?php
        $titre = get_field('titreContact');
        $intro = get_field('introContact');
        $form = get_field('formulaire');
        $bg_header = get_field('bg_header');
    ?>
    <?php if($titre):?><?php echo $titre;?><?php endif;?>
    <span class="separator"></span>
    <?php if($intro):?><?php echo $intro;?><?php endif;?>

    </div>
    <div class="container container-form">
        <?php echo do_shortcode( $form );?>
</div>
</section>

<?php get_footer();