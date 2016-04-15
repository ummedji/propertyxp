<?php
/**
 * Codes related to the frontend submission of properties
 */

/**
 * Applying filter for processing frontend submission
 * @param $arguments
 */
function aviators_frontend_submission_process($arguments) {
    if ($arguments['type'] == 'property') {
        $form = $arguments['form'];
        $form->addOnValidation('aviators_property_validate', NULL);
        $form->addOnSuccess('aviators_property_submit', NULL);

        if(aviators_submission_tos_enabled('property')) {
            if(!isset($_GET['action']) || $_GET['action'] != 'edit') {
                $link = '<a class="btn btn-primary" data-toggle="modal" data-target="#legal-agreement">' .__('Read here', 'aviators'). '</a>';
                $form->addField('checkbox', array('agreement', __('I agree with terms and conditions: ' . $link, 'aviators')));
            }
        }
    }

    return $arguments;
}

add_filter('hydra_frontend_submission_form', 'aviators_frontend_submission_process', 10, 1);



/**
 * Validation callback - use this as example how to add specific validations
 * @param $form
 * @param $values
 */
function aviators_property_validate($form, $values) {
    // custom validation - you can put your validation here
    // return array of messages in case of error

    // ** Example **
    // return array(array('Invalid price', 'field_property_price[Properties][0][value]'));
    // $arg[0] = Error Message displayed
    // $arg[1] = Element which caused the error

    // agreement is available but not checked! Oh my , lets display some error then!
    $messages = array();
    if(!isset($values['post_id']) ||(isset($values['post_id']) && !empty($values['post_id']))) {
        if(isset($values['agreement']) && !$values['agreement']) {
            $messages[] = array(__('You need to confirm you agree with terms and conditions', 'aviators'), 'agreement');
            return $messages;
        }
    }
}



/**
 * Submission callback - use this as example how to add specific submission behavior
 * @param $form
 * @param $values
 */
function aviators_property_submit($form, $values) {
    // custom submit - you can put your redirect here in form
    // $form->setRedirect($permalink)
}