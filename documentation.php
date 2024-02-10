<?php 
/* Template Name: documentation */

get_header();

$title = get_field('titre');
$intro = get_field('introduction');
$bg_header = get_field('bg_header');
$form = get_field('shortcode_form');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

get_template_part( 'templates-parts/header-nav');?>
<header id="header" style="background:url('<?php echo $bg_url;?>');">
</header>


<section id="introduction-document">
    <div class="container">
        <div class="colg">
            <?php if($title):
            echo $title;
        endif;?>
        </div>
        <div class="cold">
            <?php if($intro):
                echo $intro;
            endif;?>
        </div>
    </div>
    </div>
</section>

<section id="formulaire-doc">

    <div class="container">
        <div class="cold">
            <?php if($form): echo do_shortcode( $form );endif;?>
        </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/disclaimer-banner' );?>
<?php get_template_part( 'templates-parts/section-nosproduits' );?>

<?php
get_footer();