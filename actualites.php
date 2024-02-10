<?php 
/* Template Name: actualités */

get_header();

$title = get_field('titre');
$intro = get_field('introduction');
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


<section id="introduction">
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

    <div class="container">
        <div class="grid_articles">
            <?php 
            $args = array(
                    'post_type' => 'post',
                    'posts_per_page'=> -1,
                    'post_statut' => 'publish'
            );

            $query = new WP_Query( $args );

            if($query->have_posts()):
                while($query->have_posts()): $query->the_post();?>
            <a href="<?php the_permalink();?>" class="red">
                <div class="card_article from-bottom"
                    style="background:url('<?php if(has_post_thumbnail()) : the_post_thumbnail_url(); endif;?>');   ">

                    <h3><?php the_title();?></h3>

                </div>
            </a><?php
                endwhile;
            endif;
            
            wp_reset_postdata();?>
        </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/section-cta-contact' );?>
<?php get_template_part( 'templates-parts/section-nosproduits' );?>

<section id="assurance">
    <div class="container">
        <?php get_template_part( 'templates-parts/section-assurance' );?>
    </div>
</section>

<?php

get_template_part( 'templates-parts/contact' );

get_footer();