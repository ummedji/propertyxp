<script type="text/javascript">
    jQuery(document).ready(function ($) {
        $('.trigger-submit').change(function () {
            $('#sort').submit();
        });
    });
</script>


<?php
    if(is_archive()) {
        $form = aviators_properties_sort_get_form('archive');
    } else {
        $form = aviators_properties_sort_get_form(get_the_ID());
    }
?>

<div class="sorting">
    <?php print $form->render(); ?>
</div>