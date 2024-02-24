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
        $titre = get_field('titre');
        $intro = get_field('intro');
        $form = get_field('formulaire');
        $bg_header = get_field('bg_header');
    ?>
    <?php if($title):?><?php echo $title;?><?php endif;?>
    <span class="separator"></span>
    <?php if($descr_Ctt):?><?php echo $descr_Ctt;?><?php endif;?>

    </div>
    <div class="container container-form">
        <?php echo do_shortcode( $form );?>
</div>

<?php get_footer();