<?php

// -----------
// ETAPE 1
// -----------
function getToken(){

  //Url Token Client
  $urlToken = 'https://api.whise.eu/token';
  
  //The data you want to send via POST
  $fields = [
    "username" => "benoit@noviad.be",
    "password" => "mcpQCHTe9A5kK36^",
  ];

  //Encode les paramètre poste en JSON
  $fields_string = json_encode($fields);

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array("content-type: application/json"));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $urlToken);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  $result = json_decode($result);

  return $result->token;

}

// -----------
// ETAPE 2
// -----------
function getClientToken($token){

  //Url Token Client
  $urlClientToken = 'https://api.whise.eu/v1/admin/clients/token';

  //The data you want to send via POST

  $fields = [
    'ClientId' => '10664',
    'OfficeId' => '13244'
  ];

  $authorization = "Authorization: Bearer " . $token;

  //Encode les paramètre poste en JSON
  $fields_string = json_encode($fields);

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $urlClientToken);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  $result = json_decode($result);

  return $result->token;
}

function getListEstateHome($token,$lang = 'fr-BE'){
  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 6,
    )
    );
  $fields = json_encode( $fieldsArray );
  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);
  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

function getListEstate($token, $lang = 'fr-BE'){
  $purpose = array();
  $listType = array();
  $langCode = 'fr';

  //Tri
  $field = 'city';
  $asc = false;

  //Langue
  if($lang == 'nl-NL'){
    $langCode = 'nl';
  }
  if(is_page(215)){
    $purpose[] = 1;
    $purpose[] = 3;
    $listType = array(1);
  }else if(is_page(213)){
    $purpose[] = 2;
  }

  if(!empty($_GET['reference'])){
    $toRedirect = get_bloginfo('url') . '/?reference=' . $_GET['reference'];
    wp_safe_redirect( $toRedirect );
  }

  $localiteIds = array();
  if(!empty($_GET['localite'])){
    $localiteIds = $_GET['localite'];
  }

  $investmentEstate = false;

  if(!empty($_GET['invest'])){
      $investmentEstate = true;
  } 

  if(!empty($_GET['type'])){
    foreach( $_GET['type'] as $typ):
      if($typ == "9999"){
        $listType = array_map('intval', [1]);
        $investmentEstate = true;

      } else {
        $listType = array_map('intval', $_GET['type']);
      }
  endforeach;
  }

  $page = 0;
  if(!empty($_GET['listPage'])){
    $page = $_GET['listPage'] * 15;
  }
  $nbrChambre = null;
  if(!empty($_GET['chambre'])){
    $nbrChambre = $_GET['chambre'];
  }
  $prixMinimum = 0;
  $prixMaximum = 99999999;

  if(!empty($_GET['prixMaximum'])){
    $prixMaximum = intval($_GET['prixMaximum']);
  }

  $regionIds = array();
  if(!empty($_GET['region'])){
    $regionIds = $_GET['region'];
  }

  if(!empty($_GET['order'])){
    switch($_GET['order']){
      case 'communes' :
        $field = 'city';
        $asc = true;
        break;

      case 'price_asc' : 
        $field = 'price';
        $asc = true;
        break;

      case 'price_dsc':
        $field = 'price';
        $asc = false;
        break;

      case 'recents':
        $field = 'createDateTime';
        $asc = false;
        break;
    }
  }

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 9,
      'Offset' => $page
    ),
    'Filter' => array(
      'PurposeIds' => $purpose,
      'RegionIds' => $regionIds,
      'ZipCodes' => $localiteIds,
      'CategoryIds' => $listType,
      'LanguageId' => $lang,
      'Rooms' => $nbrChambre,
      'PriceRange' => array(
        'Max' => $prixMaximum,
        'Min' => 0  ,
      ),
      'investmentEstate' => $investmentEstate
    ),
    'Sort' => array(
      array(
        'Ascending' => $asc,
        'Field' => $field
      ),
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;

  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

function getListEstateOfTheMonth($token, $lang = 'fr-BE'){

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 9
    ),
    'Filter' => array(
      'DisplayStatusIds' => array(3),
      'LanguageId' => $lang,
    ),
    'Sort' => array(
      array(
        'Ascending' => false,
        'Field' => 'createDateTime'
      ),
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;

  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

function getListAllEstate($token, $lang = 'fr-BE'){

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 9999
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;

  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

function getListRefEstate($token){

  $page = 0;
  if(!empty($_GET['listPage'])){
    $page = $_GET['listPage'] * 9;
  }

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 9,
      'Offset' => $page
    ),
    'Filter' => array(
      'DisplayStatusIds' => array(4),
      'LanguageId' => getWhiseLanguageCode(),
    ),
    'Sort' => array(
      array(
        'Ascending' => true,
        'Field' => 'city'
      ),
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;
  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

function getEstateById($id, $token, $lang = 'fr-BE'){

  $reference = $id;
  $url = 'https://api.whise.eu/v1/estates/list';


  $refLength = strlen($reference);

  if($refLength <= 5){
    $filter = array(
      'Filter' => array(
        'referenceNumber' => $reference,
        'LanguageId' => $lang,
      )
    );
  } else {
    $filter = array(
      'Filter' => array(
        // Dans l'API de Whise, la valeur id correspond à EstateIds (si on utilise `id` -> Il renvoit un bien au hasard)
        'EstateIds' => [$reference],
        'LanguageId' => $lang,
      )
    );
  }


  //The data you want to send via POST
  $fieldsArray = $filter;
  $fields = json_encode( $fieldsArray );

  //echo $fields;

  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result->estates[0];
  }else{
    return 'no-estate';
  }
}

function getSimilarEstate($token, $purpose, $category, $minRoom, $region, $ref){

  $categoryId = array();

  foreach($category as $id){
    $categoryId[] = $id;
  }

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    'Page' => array(
      'Limit' => 4,
    ),
    'Filter' => array(
      'PurposeStatusIds' => array($purpose->id),
      'RegionIds' => array($region[0]->id),
      'MinRooms' => $minRoom,
      'LanguageId' => getWhiseLanguageCode(),
      'SubCategoryIds' => $categoryId
    ),
    'Sort' => array(
      array(
        'Ascending' => false,
        'Field' => 'createDateTime'
      ),
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;
  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    $i = 0;
    $z = 3;
    while ($i < count($result->estates)) {
      if($result->estates[$i]->referenceNumber == $ref){ $z = $i; }
      $i++;
    }
    unset($result->estates[$z]);
    return $result;
  }else{
    return 'no-estate';
  }
}

function getListCategory($token){

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/details/list';

  $authorization = "Authorization: Bearer " . $token;

  $fieldsArray = array(
    'IncludeInactive' => false,
    'LanguageId' => getWhiseLanguageCode(),
    'WithRefDescriptions' => true
  );
  $fields = json_encode( $fieldsArray );

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);

  return $result;

}

function findTypeBienById($id, $array){
  foreach ( $array as $element ) {
      if ( $id == $element->category->id ) {
          return $element->category->name;
      }
  }

  return false;
}

function findDetailsById($something, $array){
  //type / group / label
  $toReturn = array();
  foreach ( $array as $element ) {
      if ( $something == $element->type ) {
        $toReturn[] = $element;
      }
  }

  return $toReturn;
}

function getAllTypeBien($array){
  $toReturn = array();
  foreach ( $array as $element ) {
    $toPush = array('id' => $element->category->id, 'name' => $element->category->name);
    if(!in_array($toPush, $toReturn)){
      $toReturn[] = $toPush;
    }
  }
  return $toReturn;
}

function findStatusBienById($id, $array){
  foreach ( $array as $element ) {
      if ( $id == $element->purpose->id ) {
          return $element->purpose->name;
      }
  }

  return false;
}

function findDetails($label, $array){
  foreach ( $array as $element ) {
      if ( $label == $element->label ) {
          return $element->value;
      }
  }

  return false;
}

function change_url_parameter($url,$parameterName,$parameterValue) {
    $url = parse_url($url);
    $editParam = get_query_var( $parameterName, $parameterValue );
    parse_str($url["query"],$parameters);
    unset($parameters[$parameterName]);
    $parameters[$parameterName]=$editParam;
    return '?' . http_build_query($parameters);
}

function getRegionsIds($token){
  $url = 'https://api.whise.eu/v1/estates/regions/list';

  $authorization = "Authorization: Bearer " . $token;

  $fieldsArray = array(
    'LanguageId' => 'fr-BE'
  );
  $fields = json_encode( $fieldsArray );

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);

  return $result->regions;

}

function getLocalite($token){
  $url = 'https://api.whise.eu/v1/estates/usedcities/list';

  $authorization = "Authorization: Bearer " . $token;

  $fieldsArray = array(
    'LanguageId' => getWhiseLanguageCode()
  );
  $fields = json_encode( $fieldsArray );

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);

  return $result->cities;
}

function getSubCategory(){
  $lang = getWhiseLanguageCode();
  $subCat = file_get_contents('https://api.whise.eu/reference?item=subcategory&lang=' . $lang);

  return json_decode($subCat);
}

function caclulateIsNewPrice($dateCreation='0000-00-00', $dateModifPrice='0000-00-00'){
  $isNewPrice = false;
  $today      = new DateTime();
  $modifPrice = new DateTime($dateModifPrice);
  $creation   = new DateTime($dateCreation);

  $nbrDays = (int) $creation->diff($modifPrice)->format('%a');

  $nbrDaysToday = (int) $modifPrice->diff($today)->format('%a');

  if ($nbrDays > 0) $isNewPrice = true;

  if ($nbrDaysToday > 15) $isNewPrice = false;

  return (bool) $isNewPrice;
}

function caclulateIsNew($date='0000-00-00') {
    $isNew = false;
    $today = new DateTime();
    $start = new DateTime($date);

    $nbrDays = $start->diff($today)->format('%a');

    if ($nbrDays <= 15) $isNew = true;

    return $isNew;
}

function getListReference($token, $lang = 'fr-BE'){
  $listType = array();
  $langCode = 'fr';

  $included = array('pictures');

  //Langue
  if($lang == 'nl-NL'){
    $langCode = 'nl';
  } 

  //Url Token Client
  $url = 'https://api.whise.eu/v1/estates/list';

  //The data you want to send via POST
  $fieldsArray = array(
    "Page" => array(
      "Limit" => 20,
      "Offset" => 0
    ),
    'Filter' => array(
      'DisplayStatusIds' => array(2,3,4),
      'PurposeStatusIds' => array(3,4,14,17),
    ), 
    'Sort' => array(
      'Field' => 'soldRentDateTime',
      'Ascending' => false
    ),
    'Field' => array(
      'Included' => $included
    )
    );
  $fields = json_encode( $fieldsArray );

  //echo $fields;

  $authorization = "Authorization: Bearer " . $token;

  //Créer requête curl
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json' , $authorization ));
  curl_setopt($ch,CURLOPT_POST, true);
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch,CURLOPT_POSTFIELDS, $fields);
  curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);

  $result = curl_exec($ch);

  $result = json_decode($result);
  if(isset($result->estates)){
    return $result;
  }else{
    return 'no-estate';
  }
}

?>