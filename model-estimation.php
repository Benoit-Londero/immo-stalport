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

<header id="header" style="background:url('<?php echo $bg_url;?>');"></header>
<section id="estimation">
    <iframe src=https://lead-expert.propteo.app/?agenceUid=97c09fe2-256d-4aee-b5b6-583aa800bb27 height="100%" width="100%" style="width: 100vw; height: 100vh; display: block; margin: 0; border: none"></iframe>
</section>

<?php get_footer();