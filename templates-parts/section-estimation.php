<section id="estimation">
    <div class="container">
        <?php
            $surtitre_est = get_field('surtitre_estimation');
            $titre_est = get_field('titre_estimation');
            $cta_est = get_field('cta_estimation');?>

            <div class="colg">

            <?php
            if($surtitre_est): echo '<h3>'.$surtitre_est.'</h3>';endif;
            if($titre_est): echo $titre_est;endif;?>

            </div>
            <div class="cold">
                <?php if($cta_est): echo '<a href="'.$cta_est['url'].'" class="cta-border">'.$cta_est['title'].'</a>';endif;?>
            </div>
    </div>
</section>