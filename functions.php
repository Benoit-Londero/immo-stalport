<?php

remove_action( 'shutdown', 'wp_ob_end_flush_all', 1 );

// Menu 
register_nav_menus( array(
    'megamenu' => 'Mega Menu',
	  'main' => 'Menu Principal',
	  'footer' => 'Bas de page',
    'topheader' => 'Top menu'
) );

add_theme_support( 'post-thumbnails' ); 

//SVG Files
add_filter( 'wp_check_filetype_and_ext', function($data, $file, $filename, $mimes) {
    global $wp_version;
    if ( $wp_version !== '4.7.1' ) {
       return $data;
    }
  
    $filetype = wp_check_filetype( $filename, $mimes );
  
    return [
        'ext'             => $filetype['ext'],
        'type'            => $filetype['type'],
        'proper_filename' => $data['proper_filename']
    ];
}, 10, 4 );
  
function cc_mime_types( $mimes ){
  $mimes['svg'] = 'image/svg+xml';
  return $mimes;
}
  
function fix_svg() {
    echo '<style type="text/css">
          .attachment-266x266, .thumbnail img {
               width: 100% !important;
               height: auto !important;
          }
          </style>';
}
  add_filter( 'upload_mimes', 'cc_mime_types' );
  add_action( 'admin_head', 'fix_svg' );

// WHISE

function getWhiseLanguageCode(){
    //fr-BE ou nl-BE
    if ( function_exists( 'pll' ) ) {
      if(pll_current_language() == 'fr'){
        return 'fr-BE';
      }else if(pll_current_language() == 'nl'){
        return 'nl-BE';
      }else{
        return 'fr-BE';
      }
    }else{
      return 'fr-BE';
    }
}

function getUrlFromFr($id){
  if ( function_exists( 'pll' ) ) {
    $urls = pll_the_languages( array( 'show_flags' => 0,'show_names' => 0, 'display_names_as' => 'slug', 'echo' => 0, 'raw' => 1, 'post_id' => $id ) );
    if(pll_current_language() == 'nl'){
      return $urls['nl']['url'];
    }else if(pll_current_language() == 'fr'){
      return $urls['fr']['url'];
    }else{
      return $urls['fr']['url'];
    }
  }
}

////////////////////////////////////////////////////////////////////////

/***********************
       * WPCF 7 *
************************/


function getClientTokenFunction($token){

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

add_action('wpcf7_mail_sent', 'your_wpcf7_function');

function your_wpcf7_function($contact_form)
{
    $titleArray = array('Contact','S\'inscrire');
    $tokenClient = getClientTokenFunction('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODQ1MzMyMn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.P_SFcDZWfAzapAWmeL5qRynvA7qrPsujaWaHP5osP_Q');

    $title = $contact_form->title;
    $lang = get_bloginfo('language');
    $submission = WPCF7_Submission::get_instance();

    if ($submission) {
        $posted_data = $submission->get_posted_data();
    }

    if (in_array($title, $titleArray)) {
        $nom = $posted_data['your-name'];
        $prenom = $posted_data['your-surname'];
        $email = $posted_data['your-email'];
        $telephone = $posted_data['your-phone'];
        $message = 'Message provenant du site internet : ' . $posted_data['your-message'];

        $bienId = $posted_data['prefill'];

        if ($bienId == 0 || $bienId == NULL) {
            $arrId = null;
        } else {
            $arrId = array($bienId);
        }

        //Url Token Client
        $url = 'https://api.whise.eu/v1/contacts/create';

        //The data you want to send via POST
        $fieldsArray = array(
            "AgreementEmail" => true,
            "AgreementSms" => true,
            "AgreementMailingCampaign" => true,
            "Comments" => $message,
            "CountryId" => 1,
            "EstateIds" => $arrId,
            "FirstName" => $prenom,
            "LanguageId" => 'fr-BE',
            "Message" => $message,
            "Name" => $nom,
            "OfficeIds" => array(3167),
            "PrivateEmail" => $email,
            "PrivateTel" => $telephone,
        );

        $fields = json_encode($fieldsArray);

        $authorization = "Authorization: Bearer " . $token;

        //Créer requête curl
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $authorization));
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $result = curl_exec($ch);
        $result = json_decode($result);

        if ($result->isValidRequest) {
            // Set session variable to indicate success
            $_SESSION['wpcf7_whise_success'] = true;
        } else {
            // Set session variable to indicate error
            $_SESSION['wpcf7_whise_success'] = false;
        }
    }
}
?>