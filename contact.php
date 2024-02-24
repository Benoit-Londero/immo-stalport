<?php 
/* Template Name: contact */

get_header();

$titre = get_field('titre');
$intro = get_field('intro');
$form = get_field('formulaire');

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

<section id="contact-content">
    <div class="container">
            <?php if($titre) : echo $titre;endif;?>
            <?php if($form) : echo do_shortcode($form);endif;?>
    </div>
</section>

<?php get_template_part('templates-parts/contact');?>

<?php get_footer();