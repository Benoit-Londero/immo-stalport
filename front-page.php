<?php /* Template Name: homepage */

include 'templates-parts/whise/whise.php';

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

if(isset($args)):
  $investmentEstate = $args['investmentEstate'];
endif;

$listLocalite = getLocalite($tokenClient);

$listType = array();
$fullType = $categoryList;

$addRapHouse = array_push($fullType,array(
  'id' => '9999',
  'name' => 'maison de rapport'
));
 
get_header();?>

<?php get_template_part( 'templates-parts/header-nav');?>

<section id="hero-container">
  <div class="swiper">
    <div class="swiper-wrapper">
      <?php if(have_rows('slides')):
        while(have_rows('slides')) : the_row();
          $bg = get_sub_field('background_image');
            if($bg):?>
              <div class="swiper-slide" data-swiper-autoplay="5000">
                <img src="<?php echo $bg['url'];?>" alt="bg_slider" />
                <div class="content">
                  <p class="baseline" data-swiper-parallax="-100"><?php echo get_sub_field('sous-titre');?></p>
                  <span  data-swiper-parallax="-200">
                    <?php echo get_sub_field('titre');?>
                    <?php $cta = get_sub_field('liens');?> 
                  </span>
                  <?php if(!empty($cta)):?><a href="<?php echo $scta['url'];?>" class="cta"><?php echo $cta['title'];?></a><?php endif;?>
                </div>
              </div>
            <?php endif;
        endwhile;
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
      
      <div class="whise-list-biens">
        <form class="whise-filter-container" action="https://immobiliere-stalport.be/nos-biens/" method="get">
          <div class="input-text">
            <input type="text" name="reference" placeholder="Référence">
          </div>

          <div class="input-select">
            <div class="select-custom">
              <p class="select-custom-lib"><span data-lib="Type de bien">Type de bien</span><i class="fa-solid fa-chevron-down"></i></p>
                <div class="select-custom-container">
                  <label>
                    <input class="auto-focus" type="text" placeholder="Recherche...">
                  </label>
                  
                  <?php foreach( $fullType as $elem){ ?>
                    <label>
                      <input type="checkbox" name="type[]" value="<?php echo $elem['id']; ?>"
                        <?php if(in_array($elem['id'], $listType)){ echo 'checked'; } ?>>
                          <span class="input-controller"><i class="fa-solid fa-check"></i></span>
                          <span class="title"><?php echo ucfirst($elem['name']); ?></span>
                    </label>
                  <?php } ?>
                </div>
            </div>
          </div>

          <div class="input-select">
            <div class="select-custom">
              <select class="select_localite select_2_localites" name="localite[]" multiple="multiple" style="text-transform:uppercase;">
                <?php foreach( $listLocalite as $localite){ ?>
                  <option value="<?php echo $localite->zip;?>"><?php echo $localite->name;?></option>
                <?php };?>
              </select>
            </div>
          </div>

          <div class="input-select">
            <div class="select-custom">
              <select class="select_cp select_3_localites" name="cp[]" multiple="multiple" style="text-transform:uppercase;">
                <?php foreach( $listLocalite as $localite): ?>
                  <option value="<?php echo $localite->zip;?>"><?php echo $localite->zip;?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>

          <div class="input-select one-only">
            <div class="select-custom">
              <p class="select-custom-lib"><span data-lib="Chambres">Chambres</span><i class="fa-solid fa-chevron-down"></i></p>
                
              <div class="select-custom-container">
                <label>
                  <input class="auto-focus" type="text" placeholder="Recherche...">
                </label>
                <label>
                  <input type="radio" name="chambre" value="">
                  <span class="input-controller"><i class="fa-solid fa-check"></i></span>
                  <span class="title">Pas d'importance</span></label>
                    
                  <?php for($i = 1; $i < 7; $i++){ ?>
                    <label>
                      <input type="radio" name="chambre" value="<?php echo $i; ?>" <?php if($i == $nbrChambre) { echo 'checked'; } ?>>
                      <span class="input-controller"><i class="fa-solid fa-check"></i></span>
                      <span class="title">Min. <?php echo $i; ?> chambre<?php echo $i > 1 ? 's' : ''; ?></span>
                    </label>
                  <?php } ?>
                </div>
            </div>
          </div>

          <div class="input-text">
            <input type="number" name="prixMaximum" placeholder="Prix max."  <?php if(!empty($_GET['prixMaximum'])) { ?>value="<?php $_GET['prixMaximum']; ?>" <?php } ?>>
          </div>
          

          <div class="buttons-container">
            <input type="hidden" name="listPage" <?php if(!empty($_GET['listPage'])) { ?>value="<?php $_GET['listPage']; ?>"<?php } ?>>
            <button type="submit" class="cta">Rechercher</button>
          </div>
        </form>
        <?php if($estates && $estates != 0): $i = 0;?>
          <ul id="estates" class="list-container <?php if(count($estates) <= 3){ echo "one-line"; }else if(count($estates) <= 6 && count($estates) > 3){ echo 'two-line'; } ?>">
            <?php foreach($estates as $estate): 
              $status = $estate->status->id;
              $availableType = '';

              $chambres = $estate->rooms;
              $terrain = $estate->groundArea;
              $surface = $estate->area;
              $price = $estate->price;
              $peb = $estate->energyClass;
              $isNew = caclulateIsNew($estate->createDateTime);
              $iconArea = get_field('icone_area','options');
              $iconGround = get_field('icone_ground','options');
              $iconRooms = get_field('icone_rooms','options');

              switch($estate->purposeStatus->id){
                case 1:
                  $availableType = 'À vendre';
                  break;
                case 2:
                  $availableType = 'À Louer';
                  break;
                case 3:
                  $isAvailable = false;
                  $availableType = 'Vendu';
                  break;
                case 4:
                  $isAvailable = false;
                  $availableType = 'Loué';
                  break;
                case 5:
                  $availableType = 'Option';
                  break;
                case 6:
                  $availableType = 'Option';
                  break;
              }
            
              $type = '';
                  
              switch($estate->category->id){
                case 1:
                  $type = 'Maison';
                  break;
                case 2:
                  $type = 'Appartement';
                  break;
                case 3:
                  $type = 'Terrain';
                  break;
                case 4:
                  $type = 'Bureau';
                  break;
                case 5:
                  $type = 'Commerce';
                  break;
                case 6:
                  $type = 'Batiment industriel';
                  break;
                case 7:
                  $type = 'Garage / Parking';
                  break;
              } ?>

              <li class="item-estate <?php echo $i != 1 && $i != 4 ? '' : '-center';?>">
                <a href="<?php echo get_page_link( 274 ). '?reference='.$estate->id.'&prefill='.$estate->id.'&Whise='.$estate->referenceNumber; ?>" >
                  <div class="item-thumbnail">
                    <?php if($isNew): echo '<span class="available">'. "Nouveau" .'</span>'; endif;?>
                    <img src="<?php echo $estate->pictures[0]->urlLarge;?>" alt=""/>
                  </div>
                            
                  <div class="item-content">
                    <div class="item-title">
                      <?php echo '<p><strong>'.$type.'</strong> - '. $availableType . ' - <strong>'.$estate->city.'</strong></p>';?>
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
              </li><?php $i++;
            endforeach;?>
          </ul>
        <?php endif;?>
      </div>

      <div class="seeMore">
        <a href="<?php echo get_bloginfo('url').'/nos-biens/';?>" class="cta">Voir plus</a>
      </div>
        
    <?php get_template_part( 'templates-parts/line-separator' );?>
    <?php get_template_part( 'templates-parts/section-citation' );?>
    <?php get_template_part( 'templates-parts/line-separator' );?>
  </div>
</section>

<?php 
get_template_part( 'templates-parts/section-cta-contact' );
get_template_part( 'templates-parts/section-confiance' );
get_template_part( 'templates-parts/section-estimation' );

get_footer();?>