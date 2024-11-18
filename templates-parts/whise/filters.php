<?php

  $tokenClient = getClientToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiIsImlhdCI6MTcwODQ1MzMyMn0.eyJzZXJ2aWNlQ29uc3VtZXJJZCI6MTUzMCwidHlwZUlkIjo0LCJjbGllbnRJZCI6MTA2NjR9.P_SFcDZWfAzapAWmeL5qRynvA7qrPsujaWaHP5osP_Q');
  $estatesRequest = getListEstateHome($tokenClient, getWhiseLanguageCode());
  
  $filters = false;

  $listType = array();
  if(!empty($_GET['type'])){
    $listType = $_GET['type'];
    $filters = true;
  }
  $nbrChambre = 0;
  if(!empty($_GET['chambre'])){
    $nbrChambre = $_GET['chambre'];
    $filters = true;
  }
  $getRegion = array();
  if(!empty($_GET['region'])){
    $getRegion = $_GET['region'];
    $filters = true;
  }
  $getLocalite = array();
  if(!empty($_GET['localite'])){
    $getLocalite = $_GET['localite'];
    $filters = true;
  }
  $prixMinimum = 0;
  $prixMaximum = 99999999;
  if(!empty($_GET['prixMinimum'])){
    $prixMinimum = $_GET['prixMinimum'];
    $filters = true;
  }
  if(!empty($_GET['prixMaximum'])){
    $prixMaximum = $_GET['prixMaximum'];
    $filters = true;
  }
  if(!empty($_GET['investmentEstate'])){
    $investmentEstate = $_GET['investmentEstate'];
    $filters = true;
  }

  $fullType = $args['type'];

  $addRapHouse = array_push($fullType,array(
    'id' => '9999',
    'name' => 'maison de rapport'
  ));

  usort($fullType, function($a, $b) {
    return strcmp($a['name'], $b['name']);
  });

  $investmentEstate = $args['investmentEstate'];

  $listRegions = getRegionsIds($tokenClient);
  $listLocalite = getLocalite($tokenClient);
?>

<form class="whise-filter-container" action="" method="get">
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
        <?php foreach( $listLocalite as $localite){ ?>
          <option value="<?php echo $localite->zip;?>"><?php echo $localite->zip;?></option>
        <?php };?>
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

<?php if(!is_front_page() && !is_page(289)):?>
  <div class="container-result">
    <div class="container-result">
      <div class="result">
        <h2>Résultat pour :</h2>

        <div class="result-display">
          <?php if($filters):
            foreach($fullType as $felem): ?>
              <?php if(in_array($felem['id'],$listType)){
                $queryParamsType = $_GET; // Copies the current query parameters
                unset($queryParamsType['type']); // Change 'chambre' to the respective filter key

                $newQueryType = http_build_query($queryParamsType);

                echo "<a href='?{$newQueryType}'>".ucfirst($felem['name'])."</a>";
              }
            endforeach;
            
            if($_GET['chambre']):
              $queryParamsChambre = $_GET; // Copies the current query parameters
              unset($queryParamsChambre['chambre']); // Change 'chambre' to the respective filter key

              $newQueryChambre = http_build_query($queryParamsChambre);
              echo "<a href='?{$newQueryChambre}'>".$nbrChambre." Chambre(s)</a>";
            endif;

            if($_GET['region']):
              foreach( $listRegions as $region):
                if(in_array($region->id,$getRegion)):
                  $queryParamsRegions = $_GET; // Copies the current query parameters
                  unset($queryParamsRegions['region']); // Change 'chambre' to the respective filter key

                  $newQueryRegions = http_build_query($queryParamsRegions);

                  echo "<a href='?{$newQueryRegions}'>".substr($region->name,0,10)."...</a>";
                endif;
              endforeach;
            endif;

            if($_GET['invest']):
              $queryParamsInvest = $_GET; // Copies the current query parameters
              unset($queryParamsInvest['invest']); // Change 'chambre' to the respective filter key

              $newQueryInvest = http_build_query($queryParamsInvest);
              echo "<a href='?{$newQueryInvest}'>Immeuble d'apport</a>";
            endif;

            if($_GET['localite']):
              foreach($getLocalite as $rLocal):
                $queryParamsLocalite = $_GET; // Copies the current query parameters
                unset($queryParamsLocalite['localite']); // Change 'chambre' to the respective filter key

                $newQueryLocalite = http_build_query($queryParamsLocalite);
                echo "<a href='?{$newQueryLocalite}'>".$rLocal."</a>";
              endforeach;
            endif;

            if($_GET['prixMinimum']):
              $queryParamsPrixMin = $_GET; // Copies the current query parameters
              unset($queryParamsPrixMin['prixMinimum']); // Change 'chambre' to the respective filter key

              $newQueryPrixMin = http_build_query($queryParamsPrixMin);
              echo "<a href='?{$newQueryPrixMin}'> Min. ".$prixMinimum."</a>";
            endif;

            if($_GET['prixMaximum']):
              $queryParamsPrixMax = $_GET; // Copies the current query parameters
              unset($queryParamsPrixMax['prixMaximum']); // Change 'chambre' to the respective filter key

              $newQueryPrixMax = http_build_query($queryParamsPrixMax);
              echo "<a href='?{$newQueryPrixMax}'>Max. ".$prixMaximum."</a>";
            endif;  
          endif;?>
        </div>
      </div>
    </div>

    <form class="whise-filter-container" id="sort" action="" method="get">
      <label for="sortBy"> Trier :</label>
      <select name="order" id="sortBy" onchange="updateURL()">
        <option <?php echo empty($_GET['order']) ? 'selected' : ''; ?>> Pertinences </option>
        <option value="price_asc" <?php echo ($_GET['order'] === 'price_asc') ? 'selected' : ''; ?>>Prix croissant</option>
        <option value="price_dsc" <?php echo ($_GET['order'] === 'price_dsc') ? 'selected' : ''; ?>>Prix décroissant</option>
        <option value="communes" <?php echo ($_GET['order'] === 'communes') ? 'selected' : ''; ?>>Communes</option>
        <option value="recents" <?php echo ($_GET['order'] === 'recents') ? 'selected' : ''; ?>>Les plus récents</option>
      </select>
    </form>

    <script>
      function updateURL() {
        var form = document.getElementById('sort');
        var order = form.querySelector('#sortBy').value;

        // Récupérer l'URL actuelle
        var currentURL = new URL(window.location.href);

        // Mettre à jour ou ajouter le paramètre 'order' à la chaîne de requête
        currentURL.searchParams.set('order', order);

        // Rediriger vers la nouvelle URL
        window.location.href = currentURL.href;
      }
    </script>
<?php endif;?>
</div>