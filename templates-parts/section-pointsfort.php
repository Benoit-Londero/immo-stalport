<?php 
    $title_ptsfort = get_field('titre_point_fort');?>


<div class="content_service">
    <?php echo $title_ptsfort;

    if(have_rows('liste_points_forts')):
        while(have_rows('liste_points_forts')) : the_row();?>

    <div class="card_pf from-bottom">
        <h4><?php echo get_sub_field('titres_pf');?></h4>
        <?php echo get_sub_field('description_pf');?>
    </div>
    <?php 

        endwhile;
    endif;


    if(have_rows('liste_documents')):
        while(have_rows('liste_documents')) : the_row();
        
        $document = get_sub_field('document');
        $libelle = get_sub_field('libelle');?>

    <a href="<?php echo $document['url'];?>" target="_blank" class="from-left">
        <div class="document_ddl">
            <img src="<?php echo get_template_directory_uri(  );?>/assets/img/icone_pdf.svg" alt="icone_ddl" />
            <p><?php echo $libelle;?></p>
        </div>
    </a><?php 
endwhile;
endif;?>
</div>