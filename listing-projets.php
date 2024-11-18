<?php 
/* Template Name: Listing Projet */

get_header();

$bg_header = get_field('bg_header');

$titre = get_field('titre');
$intro = get_field('intro');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

$idBien = $_GET['prefill'];
$refBien = $_GET['idbien'];

if($idBien == NULL) :
  $idBien = 0;
endif;

get_template_part( 'templates-parts/header-nav');?>

<header id="header" style="background:url('<?php echo $bg_url;?>');">
</header>

<section id="title_listing">
     <div class="container from-bottom">
          <?php if($titre):?><?php echo $titre;?><?php endif;?>
          <span class="separator"></span>
          <?php if($intro):?><?php echo $intro;?><?php endif;?>
    </div>
</section>

<section id="listingEstates">
    <div class="container">
          <div class="whise-list-biens">
               <?php get_template_part( 'templates-parts/whise/listProjets' );?>
          </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/section-cta-contact' );?>
<?php get_template_part( 'templates-parts/line-separator' );?>
<?php get_template_part( 'templates-parts/section-citation' );?>
<?php get_template_part( 'templates-parts/line-separator' );?>
     
<?php $parallax = get_field('image_parallax');
     if($parallax):?>
          <section id="photo_separator" style="background-image: url('<?php echo $parallax['url'];?>');"></section>
     <?php endif;?>

<?php get_template_part( 'templates-parts/section-newsletter' );?>
<?php get_footer();?>

