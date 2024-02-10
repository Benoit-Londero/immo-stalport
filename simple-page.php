<?php 
/* Template Name: simple-page */

get_header();

$subtitle = get_field('subtitle-sm');
$titre = get_field('titre_page');
$intro = get_field('introduction');
$section_bleue = get_field('section_bleue');
$textCta = get_field('texte_cta');
$cta = get_field('cta');
$outro = get_field('outro');

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

<section id="simple-page">
    <div class="container">
        <div class="colg">
            <div class="intro from-bottom">
                <h2><?php if($subtitle) : echo $subtitle;endif;?></h2>
                <?php if($titre) : echo $titre;endif;?>
            </div>
        </div>
        <div class="cold">
            <div class="intro from-bottom"><?php if($intro) : echo $intro;endif;?></div>
            <?php if($textCta) :?>
            <div class="par_cta"><?php if($textCta) : echo $textCta;endif;?>
                <?php if($cta) : echo '<a href="'.$cta['url'].'" class="cta bgBlue">'. $cta['title'] .'</a>';endif;?>
            </div>
            <?php endif;?>
        </div>
    </div>
</section>

<?php if($section_bleue):?>
<section id="section_bleue">
    <div class="container">
        <div class="colg"></div>
        <div class="cold from-right">
            <?php echo $section_bleue;?>
        </div>
    </div>
</section>
<?php endif;?>

<?php if($outro):?>
<section id="outro">
    <div class="container">
        <div class="colg"></div>
        <div class="cold">
            <div class="outro from-right"><?php echo $outro;?></div>
        </div>
    </div>
</section>
<?php endif;?>

<?php get_template_part( 'templates-parts/line-separator' );?>
<?php get_template_part( 'templates-parts/section-nosproduits' );?>
<?php get_template_part( 'templates-parts/line-separator' );?>
<?php get_template_part('templates-parts/disclaimer-banner');?>
<?php get_template_part( 'templates-parts/section-confiance' );?>

<?php get_footer();