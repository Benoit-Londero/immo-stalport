<?php

include 'whise.php';

$tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODQ1MzMyMn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.P_SFcDZWfAzapAWmeL5qRynvA7qrPsujaWaHP5osP_Q');
$estatesRequest = getListEstateHome($tokenClient, getWhiseLanguageCode());

$estates = 0;
if(isset($estatesRequest->estates)){
  $estates = $estatesRequest->estates;
  $estateCount = $estatesRequest->totalCount;
}

$investmentEstate = false;

foreach ($estates as $estate):
  if($estate->investmentEstate):
    $investmentEstate = true;
  endif;
endforeach;

$listDetails = getListCategory($tokenClient);

$status = array('À vendre', 'À louer', 'Vendu', 'Loué');

$categoryList = getAllTypeBien($listDetails->purposeAndCategory);
$subCategoryList = getSubCategory();

$baseurl = basename($_SERVER['REQUEST_URI']);

$chambres = $estate->rooms;
$terrain = $estate->groundArea;
$surface = $estate->area;
$price = $estate->price;
$peb = $estate->energyClass;

$iconArea = get_field('icone_area','options');
$iconGround = get_field('icone_ground','options');
$iconRooms = get_field('icone_rooms','options');

?>

<div class="whise-list-biens">
    <?php
    if(!$args['data']['no-filter']){
      get_template_part('./templates-parts/whise/filters', 'filter', array('type' => $categoryList, 'investmentEstate' => $investmentEstate ));
    }
  ?>

    <?php
     if(!empty($_GET['order'])):
      $value='';
      
      switch($_GET['order']){
        case 'price_asc':
          $value = 'Prix ascendant';
          break;

        case 'price_dsc':
          $value = 'Prix descendant';
          break;

        case 'recents':
          $value = 'Les plus récents';
          break;

        case 'communes':
          $value = 'Communes';
          break;
      };
    ?>

    <div id="resume_filter_order">
        <h2>Trier par : <span><?php echo $value;?></span></h2>
    </div>

    <?php endif;
    
    if(isset($estatesRequest->estates)){ ?>
    <ul id="estates" class="list-container <?php if(count($estates) <= 3){ echo "one-line"; }else if(count($estates) <= 6 && count($estates) > 3){ echo 'two-line'; } ?>">
        <?php foreach($estates as $estate){
        $isAvailable = true;
        $availableType = '';
        
        $isNewPrice = caclulateIsNewPrice($estate->createDateTime, $estate->priceChangeDateTime);
        $isNew = caclulateIsNew($estate->createDateTime);
      ?>
        <li class="from-bottom whise-list-item item-estate <?php echo $i != 1 && $i != 4 ? '' : '-center';?>">
            <?php
          /*
            3 : Vendu
            4 : Loué
            5 : Option (vendu)
            6 : Option (Loué)
          */
          switch($estate->purposeStatus->id){
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
           
          if($isAvailable): ?>
               <a  href="<?php echo get_page_link( 274 ); ?>?reference=<?php echo $estate->id; ?>&prefill=<?php echo $estate->id; ?>&Whise=<?php echo $estate->referenceNumber; ?>">
          <?php else: 
                echo '<div>';
          endif; ?>
               
          <div class="container-image <?php echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $availableType))); ?>">
               <?php if($availableType): ?>
                        <span class="available <?php echo strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $availableType))); ?>"><?php echo $availableType; ?></span>
                    <?php  else :
                      if($isNew){
                        echo '<span class="available">'. "Nouveau" .'</span>';
                      }else if($isNewPrice){
                        echo '<span class="available">'. "Nouveau prix" .'</span>';
                      }
                    endif; ?>

                    <img src="<?php echo $estate->pictures[0]->urlLarge; ?>" alt="<?php echo $estate->name; ?>" class="object-fit">
          </div>
          
          <?php
               $subCategory = findTypeBienById($estate->category->id, $listDetails->purposeAndCategory);
               
               if($estate->subCategory):
                    $found_key = array_search($estate->subCategory->id, array_column($subCategoryList, 'id'));
                    $subCategory = $subCategoryList[$found_key]->name;
               endif;
          ?>

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
                    <?php if($isAvailable){ ?>
                         <a href="#" class="cta-estate"><?php if(isset($estate->makeOffer) && $estate->makeOffer){ echo 'Àpd'; }; ?><?php if($price): echo number_format($estate->price, 0, ',', '.') . ' €';endif;?></a>
                    <?php };?>
               </div>
               
          </div>
     <?php if($isAvailable){ ?>
          </a>
            <?php } else{ ?>
</div>
<?php } ?>
</li>
<?php } ?>
</ul>
<div class="btn-container text-align-center">

    <?php
        $listPage = isset($_GET['listPage']) ? max(0, (int)$_GET['listPage']) : 0;  // Assurez-vous que listPage est un nombre entier non négatif.
        $type = $_GET['type'][0];

        $query = $_GET;

        // Construire l'URL de base
        $baseurl = strtok($_SERVER["REQUEST_URI"], '?');

        // Construire l'URL avec les paramètres existants (en excluant "listPage")
        $queryString = http_build_query(array_filter($query, function ($key) {
            return $key !== 'listPage';
        }, ARRAY_FILTER_USE_KEY));

        // Générer les liens "précédent" et "suivant"
        $prevLink = $baseurl . '?' . $queryString . ($listPage > 0 ? '&listPage=' . ($listPage - 1) : '');
        $nextLink = $baseurl . '?' . $queryString . '&listPage=' . ($listPage + 1);

        $maxPage = (int)($estateCount / 9);
        ?>

    <?php if(!$args['data']['no-button']){ ?>
    <?php if($prevLink){ ?><a href="<?php echo $prevLink ;?>"
        class="btn fill secondaryColor"><?php echo "Page Précédente"; ?></a><?php } ?>
    <?php if($maxPage != $listPage) { ?><a href="<?php echo $nextLink; ?>"
        class="btn fill secondaryColor"><?php echo "Page suivante"; ?></a><?php } ?>
    <?php } ?>
    <?php if($args['data']['see-more']){ ?>
    <a href="<?php echo getUrlFromFr(18); ?>"
        class="btn fill secondaryColor"><?php echo "Voir plus"; ?></a>
    <?php } ?>

</div>
<?php } else { ?>
<div class="no-estate">
    <?php the_field('no-estate','option'); ?>
</div>
<?php } ?>

</div>