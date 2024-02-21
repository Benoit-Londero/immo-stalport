<?php
/* Template Name: a-propos */

get_header();

$bg_header = get_field('bg_header');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

get_template_part( 'templates-parts/header-nav');?>

<header id="header" style="background:url('<?php echo $bg_url;?>');">
</header>

<section id="introduction">
    <div class="container">
        <?php 
        $title = get_field('titre');
        $subtitle = get_field('subtitle');
        $textExp = get_field('texte_explicatif');
        $cta = get_field('cta-contact');
        ?>

        <div class="colg">
            <div class="intro from-bottom">
                <?php if($title) : echo $title; endif;?>
            </div>
        </div>

        <div class="cold">
            <div class="intro from-bottom"><?php if($intro) : echo $intro;endif;?></div>
            <?php if($textExp) :?>
            <div class="par_cta"><?php if($textExp) : echo $textExp;endif;?>
                <?php if($cta) : echo '<a href="'.$cta['url'].'" class="cta">'.$cta['title'].'</a>';endif;?>
            </div>
            <?php endif;?>
        </div>
    </div>
</section>

<section id="service_cp">
    <div class="container">
        <div class="colg">
            <?php 
            
            $title_service = get_field('title_service');
            $text_service = get_field('text_service');
            $cta_service = get_field('cta_service');

            if($title_service): echo $title_service;endif;
            if($text_service): echo $text_service;endif;
            if($cta_service): echo '<a href="'.$cta_service['url'].'">'.$cta_service['title'].'</a>';endif;
            
            ?>
        </div>
        <div class="cold">
            <div class="swiper swiper-about">
                <div class="swiper-wrapper">
                    <?php $galerie = get_field('galerie'); 
                    if($galerie):
                    foreach($galerie as $g):?>
                        <div class="swiper-slide">
                            <img src="<?php echo $g['url'];?>" alt="<?php echo $g['title'];?>"/>
                        </div>
                    <?php endforeach;
                    endif;?>
                </div>

                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>
        </div>
</section>

<section id="highlights">
    <?php
        $titreMea = get_field('titre-mea');
        $texteMea = get_field('texte-mea');
        $imgMea = get_field('image-mea');
    ?>

    <img src="<?php if($imgMea): echo $imgMea['url'] ;endif;?>" alt=""/>
</section>

<section id="txt_highlights">
    <div class="container">
        <div class="cold">
            <?php if($titreMea): echo $titreMea; endif;?>
            <?php if($texteMea): echo $texteMea; endif;?>
        </div>
    </div>
    
</section>

<section id="citation">
    <?php get_template_part( 'templates-parts/section-citation' );?>
</section>

<?php $parallax = get_field('image');?>
<section id="photo_separator" style="background-image: url('<?php if($parallax): echo $parallax['link'];endif;?>');"></section>

<?php get_template_part( 'templates-parts/contact' );?>

<?php get_footer();