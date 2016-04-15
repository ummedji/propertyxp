<?php

aviators_profile_tabs();
$action = isset($_GET['action']) ? $_GET['action'] : 'view';

?>

<?php
    switch($action) {
        case 'view':
            aviators_get_content_template('profile', 'view');
            break;
        case 'edit':
            aviators_get_content_template('profile', 'edit');
            break;
    }
?>
