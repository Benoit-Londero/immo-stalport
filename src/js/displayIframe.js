$(document).ready(function () {
    $('#displayIframe').click(function () {
        $('#contentToHide').hide();
        $('#iframeToDisplay').show();

        // Ajoute un écouteur pour s'assurer que l'iframe est bien chargé
        $('#iframeToDisplay').on('load', function () {
            console.log('Iframe bien chargée');
            
            // Sélectionne le bouton et simule un clic
            let iframeButton = $(this).contents().find('.sc-bdvvtL');
            if (iframeButton.length > 0) {
                iframeButton.click();
                console.log("Bouton cliqué dans l'iframe :", iframeButton);
            } else {
                console.log("Le bouton .sc-bdvvtL n'a pas été trouvé dans l'iframe.");
            }
        });
    });
});
