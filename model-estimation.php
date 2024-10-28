<?php 
/* Template Name: Modèle Estimation */

get_header();

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

get_template_part( 'templates-parts/header-nav');?>

<header id="header" class="header-estimation" style="background:url('<?php echo $bg_url;?>');"></header>
<section id="estimation-model">
    <div id="contentToHide">
        <h2>Demander <strong>une estimation</strong></h2>
        <div class="wrapper">
            <a class="left" id="displayIframe">
                <div class="icon"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/house-laptop.svg"></div>
                <h3>Estimation en ligne</h3>
                <p><i class="fa-solid fa-chevron-right"></i> Estimation indicative en quelques clics</p>
                <p><i class="fa-solid fa-chevron-right"></i> Gratuit et sans engagement</p>
                <p><i class="fa-solid fa-chevron-right"></i> Réalisé par nos algorithmes</p>
                <p><i class="fa-solid fa-chevron-right"></i> À approuver par un expert sur place</p>
            </a>
            <a class="right" href="<?php bloginfo('url'); ?>/contact">
                <div class="icon"><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/images/handshake.svg"></div>
                <h3>Prenez rendez-vous</h3>
                <p><i class="fa-solid fa-chevron-right"></i> Réalisé par l'un de nos experts</p>
                <p><i class="fa-solid fa-chevron-right"></i> Gratuit et sans engagement</p>
                <p><i class="fa-solid fa-chevron-right"></i> Une évaluation précise et objective</p>
                <p><i class="fa-solid fa-chevron-right"></i> Un contact personnalisé avec un professionnel</p>
            </a>
        </div>

        <?php
            get_template_part( 'templates-parts/line-separator' );
            get_template_part( 'templates-parts/section-citation' );
            get_template_part( 'templates-parts/line-separator' );?>
        </div>
    </div>
    <iframe id="iframeToDisplay" src=https://lead-expert.propteo.app/?agenceUid=97c09fe2-256d-4aee-b5b6-583aa800bb27 height="100%" width="100%" style="display:none; height: 100vh; width: 100%; margin: 0; border: none"></iframe>
</section>
<?php get_footer();