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


get_template_part( 'templates-parts/header-nav');?>

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