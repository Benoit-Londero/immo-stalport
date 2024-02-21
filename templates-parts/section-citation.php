<?php 
$title = get_field('titre-vosp','options');
$baseline = get_field('baseline-vosp','options');

?>

<div class="section_vosp from-bottom">
    <?php 
    if($title && $baseline): 
        echo '<h3 class="from-bottom">'.$baseline.'</h3>';
        echo '<span class="from-bottom">'. $title . '</span>';
    endif;?>
</div>
