<?php get_header() ?>

<?php the_post(); ?>



<div id="main-content" class="col-md-12 col-sm-12<?php /*if (is_active_sidebar('sidebar-1')) : ?>col-md-9 col-sm-9<?php else : ?>col-md-12 col-sm-12<?php endif;*/ ?>">

    <?php if (dynamic_sidebar('content-top')) : ?><?php endif; ?>

    <?php 
    	$person_field = strip_tags(hydra_render_field(get_the_ID(), 'person', 'grid')); 
        
    	//if($person_field == 'Developer')
          $selected_template_value = get_field("select_template");
       
        /*
         * NEW TEMPLATE APPROACH CODE ADDED
         * if statement change on the basics of selected templated value earlier it dependes on person field.
         */
        if($selected_template_value == 'developer'){
    		//aviators_get_content_template('property', 'developer');
                aviators_get_content_template('property', 'template-V1');
        }
		elseif($selected_template_value == 'TemplateV2'){
			 aviators_get_content_template('property', 'template-V2');
		}
		else 
    		aviators_get_content_template('property', 'detail'); ?>



    <?php /*if (comments_open(get_the_ID())) : ?>

        <?php comments_template() ?>

    <?php endif; */?>



    <?php if (dynamic_sidebar('content-bottom')) : ?><?php endif; ?>

</div><!-- /#main-content -->



<?php /*if (is_active_sidebar('sidebar-1')) : ?>

    <div class="sidebar col-md-3 col-sm-3">

        <?php dynamic_sidebar('sidebar-1'); ?>

    </div><!-- /#sidebar -->

<?php endif;*/ ?>



<?php get_footer(); ?>
