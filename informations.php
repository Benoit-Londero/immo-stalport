<?php 
/* Template Name: informations */

get_header();

$bg_header = get_field('bg_header');
$titre = get_field('titre');
$surtitre = get_field('surtitre');
$intro = get_field('introduction');
$section_bleue = get_field('section_bleue-infos');
$outro = get_field('outro-infos');

$def = get_field('liste_expli');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

get_template_part( 'templates-parts/header-nav');?>
<header id="header" style="background:url('<?php echo $bg_url;?>');"></header>

<?php get_template_part( 'templates-parts/section-card-services');?>

<section id="information">
    <div class="container">
        <div class="colg">
            <?php if($surtitre): echo '<h2>'.$surtitre.'</h2>';endif;?>
            <?php if($titre): echo $titre;endif;?>
        </div>
        <div class="cold">
            <?php if($intro) : echo '<span class="intro">'.$intro.'</span>';endif;?>
            <?php if($def) : echo '<span class="def">'.$def.'</span>';endif;?>
        </div>
    </div>
</section>


<section id="section_bleue">
    <div class="container">
        <div class="cold">
            <?php if($section_bleue) : echo $section_bleue;endif;?>
        </div>
    </div>
</section>

<section id="outro">
    <div class="container">
        <div class="cold">
            <?php if($outro) : echo $outro;endif;?>
        </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/line-separator' );?>
<?php get_template_part( 'templates-parts/section-nosproduits' );?>
<?php get_template_part( 'templates-parts/line-separator' );?>
<?php get_template_part('templates-parts/disclaimer-banner');?>
<?php get_template_part( 'templates-parts/section-confiance' );?>

<?php
get_footer();