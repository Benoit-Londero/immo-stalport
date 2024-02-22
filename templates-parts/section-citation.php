<?php 
$title = get_field('titre-vosp','options');
$baseline = get_field('baseline-vosp','options');
$quotes = get_field('image-quote','options');

?>

<div class="section_vosp from-bottom">
    <?php if($quotes): echo '<img class="quotes" src="'.$quotes['url'].'" alt="'.$quotes['title'].'"/>'; endif; ?>
    <?php 
    if($title && $baseline): 
        echo '<h3 class="from-bottom">'.$baseline.'</h3>';
        echo '<span class="from-bottom">'. $title . '</span>';
    endif;?>
</div>
