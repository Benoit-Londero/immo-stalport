<?php
/* Template Name: page-attente */

get_header();?>

<div class="container">
     <div id="content">
          <?php $logo = get_field('logo');

          if($logo) : ?>
               <img id="logo" src="<?php echo $logo['url'] . '" alt="' . $logo['title'];?>"/>
          <?php endif;?>

          <?php $text = get_field('texte-principal'); ?>
          
          <?php echo $text;?>
          
          <div id="contact">
               <a class="cta blue" href="mailto:hello@noviad.be">Nous écrire <img src="dist/img/arrow.png"></a>

                    
               <a class="white" href="tel:0032<?php echo get_field('telephone');?>">
                    <div class="flex">
                         <img class="cta bg-white" src="dist/img/phone.png">
                         <?php echo get_field('telephone');?>
                    </div>
               </a>
          </div>
     </div>
</div>

<?php get_footer();?>