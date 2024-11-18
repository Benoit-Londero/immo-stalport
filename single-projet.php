<?php 
/* Template Name: Single Projet */

// Charger les fonctions nécessaires depuis whise.php
include 'templates-parts/whise/whise.php';

// Obtenir le token client
$tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTczMTk2MDk1Mn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTExNDl9.sgM94FmbE-v3X71GL7Y-zLSSkioQGV9XWq-sSrfVq54');

// Redirection si la référence n'est pas dans l'URL
if(!isset($_GET['reference']) || is_null($_GET['reference']) || $_GET['reference'] === ''){
    $front_page_id = get_option('page_on_front');
    wp_safe_redirect(get_permalink($front_page_id));
    exit;
}

// Récupération des données principales
$parentId = $_GET['reference'];
$estateId = $_GET['reference'];

$estate = getEstateById($estateId, $tokenClient, getWhiseLanguageCode());
if($estate == 'no-estate') {
    echo '<p>Propriété introuvable.</p>';
    exit;
}

$listDetails = getListCategory($tokenClient);
$categoryList = getAllTypeBien($listDetails->purposeAndCategory);
$subCategoryList = getSubCategory();

$purp = $estate->category->id;
$chambres = $estate->rooms;
$terrain = $estate->groundArea;
$surface = $estate->area;
$price = $estate->price;
$peb = $estate->energyClass;
$isNew = caclulateIsNew($estate->createDateTime);
$status = $estate->purposeStatus->id;
$pictures = $estate->pictures;

// Déterminer le statut
switch ($status) {
  case 1:
      $statusName = 'À vendre';
      break;
  case 2:
      $statusName = 'À louer';
      break;
  case 3:
      $statusName = 'Vendu';
      break;
  case 4:
      $statusName = 'Loué';
      break;
  case 5:
  case 6:
      $statusName = 'Option';
      break;
  default:
      $statusName = 'Indéterminé';
}

// Déterminer le type de bien
switch ($estate->category->id) {
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
      $type = 'Bâtiment industriel';
      break;
  case 7:
      $type = 'Garage / Parking';
      break;
  default:
      $type = 'Type inconnu';
}

get_header();

$bg_header = get_field('bg_header');
$bg_url = $bg_header ? $bg_header['url'] : get_template_directory_uri().'/assets/img/bg-default.jpg';

get_template_part( 'templates-parts/header-nav');?>

<header id="header" style="background:url('<?php echo $bg_url; ?>');">
    <div class="container">
        <?php if ($estate): ?>
            <h1><?php echo $type; ?> de <?php echo $surface; ?> m² <?php if ($chambres): echo $chambres . ' chambre(s)'; endif; ?><br/>
            <?php if ($status != 2 && $status != 4): ?>
                <strong><?php echo 'Àpd '; ?> <?php echo number_format($price, 0, ',', '.'); ?> €</strong></h1>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</header>

<section id="introduction">
  <div class="container">
    <?php 
      $title = get_field('titre');
      $subtitle = get_field('subtitle');
      $textExp = get_field('texte_explicatif');
      $cta = get_field('cta-contact');
    ?>

    <div class="colg">
      <div class="intro from-bottom"><h1>6 appartements</h1></div>
    </div>

    <div class="cold">
      <div class="intro from-bottom"><p><?php echo $estate->shortDescription[0]->content;?></p></div>
    </div>
  </div>
</section>

<section id="slider-bottom" class="from-bottom">
  <div class="container">
    <div class="swiper swiper-projet">
      <div class="swiper-wrapper">
        <?php foreach ($pictures as $pic): ?>
          <div class="swiper-slide">
            <a href="<?php echo $pic->urlXXL; ?>" data-fslightbox><img src="<?php echo $pic->urlLarge; ?>"/></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>

<section id="listing-biens-projet">
  <div class="container table-children">
    <h2><strong>Biens</strong> disponibles</h2>
    <?php 
      // Récupérer les biens enfants
      $childRequest = getChildEstate($tokenClient, $parentId, getWhiseLanguageCode());
      $child = $childRequest->estates ?? array();

      $status = $childEstate->purposeStatus->id;

      if(!empty($child)): ?>
        <table>
          <thead>
            <tr>
              <th><p>Appartements</p></th>
              <th><p>Caractéristiques</p></th>
              <th><p>Surfaces habitables</p></th>
              <th><p>Prix</p></th>
              <th><p>Disponibilités</p></th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($child as $childEstate):
              $childRooms = $childEstate->rooms ?? 'N/A';
              $childArea = $childEstate->area ?? 'N/A';
              $childPrice = $childEstate->price ?? 'N/A';

              // Déterminer le statut
              switch ($status) {
                case 1:
                  $statusName = 'À vendre';
                  break;
                case 2:
                  $statusName = 'À louer';
                  break;
                case 3:
                  $statusName = 'Vendu';
                  break;
                case 4:
                  $statusName = 'Loué';
                  break;
                case 5:
                case 6:
                  $statusName = 'Option';
                  break;
                default:
                  $statusName = 'Indéterminé';
              }

              // Déterminer le type de bien
              switch ($childEstate->category->id) {
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
                  $type = 'Bâtiment industriel';
                  break;
                case 7:
                  $type = 'Garage / Parking';
                  break;
                default:
                  $type = 'Type inconnu';
              }
            ?>
                
            <tr>
              <td><?php echo '<p><strong>' . $type . '</strong></p>'; ?></td>
              <td><?php echo '<p>' . $childRooms . ' chs</p>'; ?></td>
              <td><?php echo '<p><strong>' . $childArea . 'm2</strong></p>'; ?></td>
              <td><?php echo '<p><strong>' . $childPrice . '€</strong></p>'; ?></td>
              <td>
                <?php if(in_array($status, array(3,4))):
                  echo $status;
                else: ?>
                  <a href="<?php echo get_page_link( 274 ); ?>?reference=<?php echo $childEstate->id; ?>&prefill=<?php echo $childEstate->id; ?>&Whise=<?php echo $childEstate->referenceNumber; ?>"><strong>Disponible</strong></a>
                <?php endif;?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="section_contact">
        <?php
          $text = get_field('renseignement_projet');
          $cta  = get_field('cta_rens_contact');

          if($text): echo '<p>'.$text.'</p>'; endif;
          if($cta):
            echo '<a href="'.$cta['url'].'">'.$cta['title'].'</a>';
          endif;
        ?>
    </div>
  </div>
</section>

<?php 
  get_template_part('templates-parts/section-cta-contact');
  get_template_part('templates-parts/section-estimation');
  get_footer(); 
?>
