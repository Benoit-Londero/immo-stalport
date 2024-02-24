<?php 
/* Template Name: contact */

get_header();

$surtitre = get_field('surtitre');
$titre = get_field('titre');
$intro = get_field('intro');
$form = get_field('formulaire');
$contact = get_field('contact');
$surModif = get_field('surtitre_modif');
$text_modif = get_field('text_modif');

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
        <div class="colg">
            <?php if($surtitre) : echo '<h2 class="red upp bold">'.$surtitre.'</h2>';endif;?>
            <?php if($titre) : echo $titre;endif;?>
        </div>
        <div class="cold">
            <?php if($form) : echo do_shortcode($form);endif;?>
        </div>
        <?php if($contact) : echo ($contact);endif;?>
    </div>
</section>
<section id="modif">
    <div class="container">
        <?php if($surModif) : echo '<h2 class="red upp bold">'.$surModif.'</h2>';endif;?>
        <?php if($text_modif) : echo $text_modif;endif;?>
    </div>
</section>

<?php get_footer();