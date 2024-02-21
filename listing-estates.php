<?php 
/* Template Name: Listing */

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

<?php get_template_part( 'templates-parts/section-estimation' );?>

<?php get_template_part( 'templates-parts/section-newsletter' );?>
<?php get_template_part( 'templates-parts/contact' );?>

<?php get_footer();?>

