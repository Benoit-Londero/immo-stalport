<?php $bg_follow = get_field('arriere-plan_follow','options');?>

<section id="suiveznous" <?php if($bg_follow):?> style="background-image: url('<?php echo $bg_follow["url"];?>')" <?php endif;?>>
     <div class="container">
          <?php 
               $titre_follow = get_field('titre_follow','options');
               if($titre_follow): echo $titre_follow;endif;
          ?>

          <ul>
               <?php if(have_rows('rs_follow','options')):
                    while(have_rows('rs_follow','options')): the_row();
                         $cta_rs = get_sub_field('cta_rs','options') ;?>
                         <li><a href="<?php echo $cta_rs['url'];?>" class="cta cta-blue"><?php echo $cta_rs['title'];?></a></li>
               <?php endwhile;
               endif;?>
          </ul>
     </div>
</section>