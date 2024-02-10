<?php
/* Template Name: Services */

get_header();

$bg_header = get_field('background');
$title_header = get_field('titre_page');
$linkf = get_field('link_to_form');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('background');
    $bg_url = $bg_header['url'];
endif;?>

<?php get_template_part( 'templates-parts/header-nav');?>

<header id="header" style="background:url('<?php if($bg_url): echo $bg_url; endif;?>');">
</header>

<section id="intro_service">
    <div class="container">
        <div class="block_title from-bottom"
            style="background:url('<?php echo get_template_directory_uri();?>/assets/img/background_titre_service.jpg;">
            <?php if($title_header): echo $title_header; endif;?>
            <a
                href="<?php if($linkf): echo $linkf['url'];endif;?>"><?php if($linkf) : echo $linkf['title']; endif;?></a>
        </div>
        <?php
            $title_page = get_field('titre_service');
            $content_intro = get_field('introduction');
        ?>
        <div class="colg">
            <?php if($title_page):
                echo $title_page;
            endif;?>
        </div>

        <div class="cold">
            <?php if($content_intro):
                echo $content_intro;
            endif;?>
        </div>
    </div>
</section>

<section id="nos_points_fort">
    <div class="container">
        <?php get_template_part( 'templates-parts/section-pointsfort' );?>
        <?php get_template_part( 'templates-parts/section-cta-contact' );?>
        <?php get_template_part( 'templates-parts/section-nosproduits' );?>
    </div>
</section>

<section id="assurance">
    <div class="container">
        <?php get_template_part( 'templates-parts/section-assurance' );?>
    </div>
</section>

<section id="contact-service">
    <?php get_template_part( 'templates-parts/contact' );?>
</section>
<?php get_footer();