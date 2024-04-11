<?php 
/* Template Name: Single estate */

include 'templates-parts/whise/whise.php';

$tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODg5MTE2Nn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.HV20SItaD7PrgcIvWXg4uRpv_Yfo77O_lDDht5BxL3Q');

if(!isset($_GET['reference']) || is_null($_GET['reference']) || $_GET['reference'] === ''){
    $front_page_id = get_option('page_on_front');
    wp_safe_redirect( get_permalink( $front_page_id ) );
} 

  $estateId = $_GET['reference'];
  $estate = getEstateById($estateId, $tokenClient, getWhiseLanguageCode());
  if($estate != 'no-estate'){
    $listDetails = getListCategory($tokenClient);

    $subCategoryList = getSubCategory();
    $organizedDetails = array();
    foreach($estate->details as $detail){
      $organizedDetails[$detail->group][] = $detail;
    }
  }

  $purp = $estate->category->id;
  $chambres = $estate->rooms;
  $terrain = $estate->groundArea;
  $surface = $estate->area;
  $price = $estate->price;
  $peb = $estate->energyClass;
  $isNew = caclulateIsNew($estate->createDateTime);
  $iconArea = get_field('icone_area','options');
  $iconGround = get_field('icone_ground','options');
  $iconRooms = get_field('icone_rooms','options');

  $pictures = $estate->pictures;

  switch($status){
    case 1 : 
      $statusName = 'A vendre';
      break;
    case 2 : 
      $statusName = 'À louer';
      break;
    case 3:
      $statusName = 'Vendu';
      break;
  }

  switch($estate->category->id){
    case 1:
      $purpose = 'Maison';
      break;
    case 2:
      $purpose = 'Appartement';
      break;
    case 3:
      $purpose = 'Terrain';
      break;
    case 4:
      $purpose = 'Bureau';
      break;
    case 5:
      $purpose = 'Commerce';
      break;
    case 7:
      $purpose = 'Batiment industriel';
      break;
    case 7:
      $purpose = 'Garage / Parking';
      break;
  } 


get_header();

$bg_header = get_field('bg_header');

if(!$bg_header):
    $bg_url = get_template_directory_uri(  ).'/assets/img/bg-default.jpg';
else :
    $bg_header = get_field('bg_header');
    $bg_url = $bg_header['url'];
endif;

$idBien = $_GET['prefill'];
$refBien = $_GET['idbien'];

if($idBien == NULL) :
  $idBien = 0;
endif;

get_template_part( 'templates-parts/header-nav' );
get_template_part( 'templates-parts/whise/log' );?>

<header id="header" style="background:url('<?php echo $bg_url;?>');">
  <div class="container">
    <?php if($estate): ?>
      <h1><?php echo $purpose;?> de <?php echo $surface;?> m2 <?php if($chambres): echo $chambres.' chambre(s)';endif;?><br/>
      <strong>Àpd <?php echo number_format($price, 0, ',', '.');?> €</strong></h1>
    <?php endif;?>
  </div>
</header>

<section id="slider-home">
  <div class="container">
    <?php 
      $img_1 = $pictures[0]->urlXXL;
      $img_2 = $pictures[1]->urlXXL;
      $img_3 = $pictures[2]->urlXXL;
    ?>

    <div class="col-g">
      <?php if($img_1):?><a href="<?php echo $img_1;?>" data-fslightbox><img src="<?php echo $img_1;?>" /></a><?php endif;?>
    </div>
    <div class="col-d">
      <?php if($img_2):?><a href="<?php echo $img_2;?>" data-fslightbox><img src="<?php echo $img_2;?>" /></a><?php endif;?>
      <?php if($img_3):?><a href="<?php echo $img_3;?>" data-fslightbox><img src="<?php echo $img_3;?>" /></a><?php endif;?>
    </div>
  </div>
</section>

<section id="detailsEstate">
  <div class="container descr_bien">
    <h2>Details</h2>
    <p><?php echo $estate->shortDescription[0]->content;?></p>
  </div>
  <div class="container">
      <h2>Caractéristiques du bien</h2>

  <div class="accordeon-content">
    <div class="list-table">
        <?php
      foreach($organizedDetails as $title => $group){
      echo '<div class="group">';

      $remove = array('x de coordonnées xy', 'y de coordonnées xy');

      if($title !== 'Titre de l\'annonce') {
        echo '<div class="accordion"><h3>' . $title . '</h3><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
        <path fill="#BCE035" d="M233.4 105.4c12.5-12.5 32.8-12.5 45.3 0l192 192c12.5 12.5 12.5 32.8 0 45.3s-32.8 12.5-45.3 0L256 173.3 86.6 342.6c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3l192-192z" />
    </svg></div>';
        echo '<div class="panel">';

        foreach($group as $detail){
          if(!in_array($detail->label, $remove)){
            if(isset($detail->value)){
              if($detail->type == 'yes/no'){
                $value = $detail->value == 1 ? 'Oui' : 'Non';
              }else if( isset($detail->label) && ($detail->label == "Label PEB" || $detail->label == "EPC-klasse")){
                $value = "<img src='" . get_bloginfo('stylesheet_directory')  . "/assets/img/peb/peb_" .strtolower($estate->energyClass) . ".png' alt='PEB'>";
              }else if($detail->type == 'surface'){
                $value = ucfirst($detail->value).' '. 'm²';
              } else {
                $value = ucfirst($detail->value);
              }

              $check = array('Date du PEB','PEB valide jusqu\'au');

              if(!in_array($detail->label, $check)){
                echo '<p class="item">' . (isset($detail->label) ? '<span class="label">' . ucfirst($detail->label) . '</span>' : '');
                echo '<span class="value">' . $value . '</span></p>';
              }
            }

          }
        }
        echo '</div>';
      }
      echo '</div>';
      }?>
    </div>
  </div>
</section>

<section id="slider-bottom" class="from-bottom">
  <div class="container">
    <div class="swiper swiper-estate">
      <div class="swiper-wrapper">
        <?php foreach($pictures as $pic):?>
          <div class="swiper-slide">
            <a href="<?php echo $pic->urlXXL;?>" data-fslightbox><img src="<?php echo $pic->urlLarge;?>"/></a>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
  </div>
</section>


<?php $bg_ct = get_field('background_banner_contact','options');?>

<section id="contact-banner" class="img_nl" style="background:url('<?php if($bg_ct):echo $bg_ct['url'];endif; ?>')">
     <?php 
          $surtitre_nl = get_field('surtitre_contact','options');
          $titre_nl = get_field('question','options');
          $cta_ct = get_field('cta_contact','options');
     ?>
     <div class="container">
          <div class="colg">
               <h3><?php if($surtitre_nl): echo $surtitre_nl;endif;?></h3>
               <?php if($titre_nl): echo $titre_nl;endif;?>
          </div>
          <div class="cold">
          <?php if($cta_ct):?><a class="cta cta-border" href="<?php echo $cta_ct['url'];?>"><?php echo $cta_ct['title'];?></a><?php endif;?>
          </div>
     </div>
</section>

<?php get_template_part( 'templates-parts/section-estimation' );?>
<?php get_template_part( 'templates-parts/section-assurance' );?>

<?php $img_banner_foot = get_field('img_banner_parallax','options');?>
<section id="image" class="parallax" style="background:url(<?php echo $img_banner_foot['url'];?>);">

</section>

<?php get_template_part( 'templates-parts/section-newsletter' );?>

<?php get_footer();