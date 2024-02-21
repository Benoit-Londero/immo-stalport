<section id="newsletter">
     <?php 
          $bg_nl = get_field('bg_newsletter','options');
          $surtitre_nl = get_field('surtitre_newsletter','options');
          $titre_nl = get_field('titre_newsletter','options');
          $form_nl = get_field('form_newsletter','options');
     ?>

     <div class="img_nl" style="background:url('<?php if($bg_nl):echo $bg_nl['url'];endif; ?>')"></div>
     <div class="container">
          <div class="colg">
               <?php if($surtitre_nl): echo $surtitre_nl;endif;?>
               <?php if($titre_nl): echo $titre_nl;endif;?>
          </div>
          <div class="cold">
               <?php if($form_nl): echo $form_nl;endif;?>
          </div>
     </div>
</section>