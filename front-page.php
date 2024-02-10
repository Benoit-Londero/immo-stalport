<?php get_header();?>

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

        <div class="swiper-button-prev swiper-button"></div>
        <div class="swiper-button-next swiper-button"></div>
    </div>
</section>

<?php get_template_part( 'templates-parts/section-card-services' );?>

<section id="section_nosproduits">
    <div class="container">
        <?php get_template_part( 'templates-parts/section-nosproduits' );?>

    </div>
</section>


<?php get_template_part( 'templates-parts/section-mots-president' );?>

<?php get_template_part( 'templates-parts/section-confiance' );?>

<section id="disclaimer">
    <?php 
        $disbg = get_field('background');
        $title = get_field('titre_disclaimer');
        $disdesc = get_field('description_disclaimer');
        $linkdis = get_field('link_disclaimer');
    ?>

    <div class="container from-bottom">
        <img src="<?php echo $disbg['url'];?>" />
        <div class="box-content from-right">
            <?php echo $title;?>
            <?php echo $disdesc;?>
        </div>
    </div>
</section>

<section id="statistique">
    <div class="container">

        <div class="col-g">
            <?php $products = get_field('products');

            if(have_rows('produits_frontPage')):
                while(have_rows('produits_frontPage')) : the_row();
                    $icon = get_sub_field('icone_produits');
                    $txt = get_sub_field('texte_produits');

            ?>
            <div class="product_front from-left"><?php
                    if($icon):?>
                <img src="<?php echo $icon['url'];?>" alt="<?php echo $icon['title'];?>" />
                <?php endif;
                
                ?><div class="txt"><?php
                echo $txt;?>
                </div>
            </div><?php

            endwhile;
            endif;?>

        </div>
        <div class="col-d">
            <?php 
            $imgStats = get_field('img_statistique');
            $descStats = get_field('description_stats');
            $dmdOffre = get_field('demandez_une_offre');
            $imgOffre = get_field('img_statistique');?>

            <div class="block_stats">

                <?php if($imgStats):?>
                <img class="from-right" src="<?php echo $imgStats['url'];?>" alt="<?php echo $imgStats['title'];?>" />
                <?php endif;?>

                <span class="from-right">
                    <?php echo $descStats;?>
                </span>
            </div>

            <div class="getOffre from-right">
                <?php echo $dmdOffre;?>
            </div>
        </div>
    </div>
</section>

<?php get_template_part('templates-parts/section-cta-contact');?>

<?php get_template_part('templates-parts/disclaimer-banner');?>

<section id="actualites">
    <div class="container">
        <div class="intro_actu">
            <span class="from-left"><?php echo get_field('titre_actus');?></span>
            <span class="from-left"><?php echo get_field('texte_actus');?></span>
        </div>
        <div class="grid_articles">
            <?php 
            $args = array(
                    'post_type' => 'post',
                    'posts_per_page'=> 2,
                    'post_statut' => 'publish'
            );

            $query = new WP_Query( $args );

            if($query->have_posts()):
                while($query->have_posts()): $query->the_post();?>
            <div class="card_article from-bottom">
                <?php if ( has_post_thumbnail() ):?>
                <div class="home-thumbnail">
                    <?php the_post_thumbnail();?>
                </div>
                <?php endif;?>
                <h3><?php the_title();?></h3>

                <a href="<?php the_permalink();?>" class="red from-bottom">Découvrir</a>
            </div><?php
                endwhile;
            endif;
            
            wp_reset_postdata();?>
        </div>
        <div class="view_more">
            <a href="#" class="cta bgBlue from-bottom">Voir tout</a>
        </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/contact' );?>

<?php get_footer();?>