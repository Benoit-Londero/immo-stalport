<?php
/* Template Name: a-propos */

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

<section id="assurance">
    <div class="container">
        <?php get_template_part( 'templates-parts/section-assurance' );?>
    </div>
</section>

<section id="statistiques">
    <div class="container">
        <?php 
        $title = get_field('titre');
        $subtitle = get_field('subtitle');
        $textExp = get_field('texte_explicatif');
        $cta = get_field('cta-contact');
        ?>

        <?php if($subtitle) : echo '<h4>'.$subtitle.'</h4>'; endif;?>
        <?php if($title) : echo $title; endif;?>

        <div class="descr">
            <?php if($textExp) : echo $textExp;endif;?>
            <?php if($cta) : echo '<a href="'.$cta['url'].'" class="cta">'.$cta['title'].'</a>';endif;?>
        </div>

        <div class="grid_stats">
            <?php 
            if(have_rows('stats')):
                while(have_rows('stats')) : the_row();
                    $number = get_sub_field('valeurs');
                    
                    // if($number) :
                    //     if(strlen((string)$number) > 4) :
                    //         $numbRW = substr_replace((string)$number,".",2,0);
                    //     else : 
                    //         $numbRW = $number;
                    //     endif;
                    // endif;

                    $libelle = get_sub_field('libelle');?>

            <div class="block_stat from-bottom">
                <?php
                    echo '<h3 data-number="'.$number.'" class="from-left animate-number">0</h3>';
                    echo '<p>'.$libelle.'</p>';
                ?>
            </div><?php
                endwhile;
            endif;?>
        </div>
    </div>
</section>

<?php get_template_part( 'templates-parts/section-nosproduits' );?>
<?php get_template_part( 'templates-parts/section-mots-president' );?>
<?php get_template_part( 'templates-parts/contact' );?>

<?php get_footer();