<?php /* Template Name: homepage */

include 'templates-parts/whise/whise.php';
get_template_part( 'templates-parts/whise/log.php' );

$tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODg5MTE2Nn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.HV20SItaD7PrgcIvWXg4uRpv_Yfo77O_lDDht5BxL3Q');
$estatesRequest = getListEstateHome($tokenClient, getWhiseLanguageCode());

$estates = 0;
if(isset($estatesRequest->estates)){
  $estates = $estatesRequest->estates;
  $estateCount = $estatesRequest->totalCount;
}

$listDetails = getListCategory($tokenClient);

$categoryList = getAllTypeBien($listDetails->purposeAndCategory);
$subCategoryList = getSubCategory();

$baseurl = basename($_SERVER['REQUEST_URI']);
 
get_header();?>

<?php get_template_part( 'templates-parts/header-nav');?>

<section id="hero-container">
    <div class="swiper">
        <div class="swiper-wrapper">
            <?php if(have_rows('slides')):
                while(have_rows('slides')) : the_row();?>
            <?php $bg = get_sub_field('background_image');?>

            <?php if($bg):?>
            <div class="swiper-slide">
                <img src="<?php echo $bg['url'];?>" alt="bg_slider" />
                <div class="content">
                    <p class="baseline"><?php echo get_sub_field('sous-titre');?></p>
                    <?php echo get_sub_field('titre');?>
                    <a href="#" class="cta">NOS SOLUTIONS</a>
                </div>
            </div>
            <?php endif;?>
            <?php endwhile;
            endif;?>
        </div>

        <div class="swiper-pagination"></div>

    </div>
</section>

<?php get_template_part( 'templates-parts/section-assurance' );?>

<section id="section_nosbiens">
    <div class="container">
        <?php
        
        $titleBiens = get_field('titre_listing');

        if($titleBiens): echo $titleBiens; endif;?>

        <?php /* Liste bien */ ?>
        <div class="whise-list-biens">

        <?php
            if(!$args['data']['no-filter']){
                get_template_part('./templates-parts/whise/filters', 'filter', array('type' => $categoryList, 'investmentEstate' => $investmentEstate ));
            }
            
            if($estates && $estates != 0):
                $i = 0;?>
                <ul id="estates" class="list-container <?php if(count($estates) <= 3){ echo "one-line"; }else if(count($estates) <= 6 && count($estates) > 3){ echo 'two-line'; } ?>">
                    <?php foreach($estates as $estate): 
                        $status = $estate->status->id;
                        $statusName = '';

                        $chambres = $estate->rooms;
                        $terrain = $estate->groundArea;
                        $surface = $estate->area;
                        $price = $estate->price;
                        $peb = $estate->energyClass;
                        $isNew = caclulateIsNew($estate->createDateTime);
                        $iconArea = get_field('icone_area','options');
                        $iconGround = get_field('icone_ground','options');
                        $iconRooms = get_field('icone_rooms','options');

                        switch($status){
                            case 1 : 
                                $statusName = 'A vendre';
                                break;
                            case 2 : 
                                $statusName = 'À louer';
                                break;
                            case 3:
                                $statusName = 'Vendu';
                        }?>
                    <li class="item-estate <?php echo $i != 1 && $i != 4 ? '' : '-center';?>">
                        <a href="<?php echo get_page_link( 274 ). '?reference='.$estate->id.'&prefill='.$estate->id.'&Whise='.$estate->referenceNumber; ?>" >
                            <div class="item-thumbnail">
                                <?php if($isNew){
                                    echo '<span class="available">'. "Nouveau" .'</span>';
                                };?>
                                <img src="<?php echo $estate->pictures[0]->urlLarge;?>" alt=""/>
                            </div>
                            
                            <div class="item-content">
                                <div class="item-title">
                                    <?php echo '<p><strong>'.$estate->name.'</strong> - '. $statusName . ' - <strong>'.$estate->city.'</strong></p>';?>
                                </div>
                                <div class="item-detail">
                                    <ul>
                                        <?php if($chambres): echo '<li><img src="'.$iconRooms['url'].'" alt=""/><p>'.$chambres.'</p></li>'; endif;?>
                                        <?php if($terrain): echo '<li><img src="'.$iconGround['url'].'" alt=""/><p>'.$terrain.'</p></li>'; endif;?>
                                        <?php if($surface): echo '<li><img src="'.$iconArea['url'].'" alt=""/><p>'.$surface.'</p></li>'; endif;?>
                                    </ul>
                                </div>
                                <div class="item-peb">
                                    <?php if($peb): ?><img src="<?php bloginfo('stylesheet_directory'); ?>/assets/img/peb/peb_<?php echo strtolower($peb);?>.png" alt="PEB"><?php endif;?>
                                </div>
                                <div class="item-price">
                                    <a href="#" class="cta-estate"><?php if($price): echo number_format($estate->price, 0, ',', '.') . ' €';endif;?></a> 
                                </div>
                            </div>
                        </a>
                    </li><?php
                    $i++;
                    endforeach;
                ?></ul><?php
            endif;?>
        </div>
    <?php
        get_template_part( 'templates-parts/line-separator' );
        get_template_part( 'templates-parts/section-citation' );
        get_template_part( 'templates-parts/line-separator' );?>
    </div>
</section>

<?php 
get_template_part( 'templates-parts/section-cta-contact' );
get_template_part( 'templates-parts/section-confiance');

get_template_part( 'templates-parts/section-estimation' );
get_template_part( 'templates-parts/contact' );

get_footer();?>