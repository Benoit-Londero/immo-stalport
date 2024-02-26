<?php
/* Template Name: page-attente */

get_header();?>

<div class="container">
     <div id="content">
          <?php $logo = get_field('logo');

          if($logo) : ?>
               <img id="logo" src="<?php echo $logo['url'] . '" alt="' . $logo['title'];?>"/>
          <?php endif;?>
          
          <div class="block_title">
               <?php $text = get_field('texte_principal'); ?>
               <?php echo $text;?>

          </div>
          
          <div id="contact">
               <a class="cta gray" href="mailto:<?php echo get_field('email');?>">Nous contacter</a>

               <a class="white" href="tel:0032<?php echo get_field('telephone');?>">
                    <div class="flex">
                         <img class="cta bg-white" src="<?php echo get_template_directory_uri();?>/assets/images/phone.png">
                          
                         <?php $tel = get_field('telephone');?>
                         <span><?php echo '+ 32 ('.substr($tel,0,1).') '.substr($tel,1,3).' '.substr($tel,4,2).' '.substr($tel,6,2).' '.substr($tel,8,2);?></span>
                    </div>
               </a>
          </div>
     </div>
</div>

<?php get_footer();?>