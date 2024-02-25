<?php /* Template Name: homepage */

include 'templates-parts/whise/whise.php';
get_template_part( 'templates-parts/whise/log.php' );

$tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODc2Nzk0MX0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.Jz5Yev5Fo5qbv6fKKWFj8cXzb0xhYkI92zZjYI4PTLE');
$estatesRequest = getListEstateHome($tokenClient, getWhiseLanguageCode());

$estates = 0;
if(isset($estatesRequest->estates)){
  $estates = $estatesRequest->estates;
  $estateCount = $estatesRequest->totalCount;
}

$listDetails = getListCategory($tokenClient);

$categoryList = getAllTypeBien($listDetails->purposeAndCategory);
$subCategoryList = getSubCategory();

$baseurl = basename($_SERVER['REQUEST_URI']);
 
get_header();?>

<?php get_template_part( 'templates-parts/header-nav');?>

<section id="hero-container">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php if(have_rows('slides')):
                while(have_rows('slides')) : the_row();?>
            <?php $bg = get_sub_field('background_image');?>

            <?php if($bg):?>
            <div class="swiper-slide">
                <img src="<?php echo $bg['url'];?>" alt="bg_slider" />
                <div class="content">
                    <p class="baseline"><?php echo get_sub_field('sous-titre');?></p>
                    <?php echo get_sub_field('titre');?>
                    <a href="#" class="cta">NOS SOLUTIONS</a>
                </div>
            </div>
            <?php endif;?>
            <?php endwhile;
            endif;?>
        </div>

        <div class="swiper-pagination"></div>

    </div>
</section>

<?php get_template_part( 'templates-parts/section-assurance' );?>


<?php 
get_template_part( 'templates-parts/section-cta-contact' );
get_template_part( 'templates-parts/section-confiance');

get_template_part( 'templates-parts/section-estimation' );
get_template_part( 'templates-parts/contact' );

get_footer();?>