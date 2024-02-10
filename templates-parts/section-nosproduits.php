<?php 
$title = get_field('titre-vosp');
$baseline = get_field('baseline-vosp');

$links = get_field('liens_vosp');

?>

<div class="section_vosp from-bottom">
    <?php 
    if($title && $baseline): echo '<span class="from-bottom">'. $title . '</span><span class="balls from-bottom"></span><h3 class="from-bottom">'.$baseline.'</span></h3>';endif;
    echo '<div class="list-btn from-bottom">';
    if($links):
        foreach ($links as $link):
            echo '<a href="' . $link->post_guid. '" class="cta-border from-bottom">' . $link->post_title . '</a>';
        endforeach;
    endif;?>
</div>
</div>