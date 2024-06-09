<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Immobiliere Stalport</title>

    <link rel="stylesheet" href="https://use.typekit.net/ovg4lmv.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

    <div id="scrollToTop">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="#ffffff" d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
        </svg>
    </div>

    <!--<div class="cta cta-estimation">
        <?php 
            $legende = get_field('legende','options');
            $liens_es = get_field('liens_estim','options');
        ?>

        <a href="<?php echo $liens_es['url'];?>"><?php echo $legende;?></a>
    </div>-->

    <?php wp_body_open(); ?>