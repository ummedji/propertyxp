<?php
/**
 * Codes related to the frontend submission of agencys
 */

/**
 * Applying filter for processing frontend submission
 * @param $arguments
 */
function aviators_agency_frontend_submission($arguments) {
    if ($arguments['type'] == 'agency') {
        $form = $arguments['form'];
        $form->addOnValidation('aviators_agency_validate', NULL);
        $form->addOnSuccess('aviators_agency_submit', NULL);

        if(aviators_submission_tos_enabled('agency')) {
            if(!isset($_GET['action']) || $_GET['action'] != 'edit') {
                $link = '<a class="btn btn-primary" data-toggle="modal" data-target="#legal-agreement">' .__('Read here', 'aviators'). '</a>';
                $form->addField('checkbox', array('agreement', __('I agree with terms and conditions: ' . $link, 'aviators')));
            }
        }
    }
    
    return $arguments;
}
add_filter('hydra_frontend_submission_form', 'aviators_agency_frontend_submission', 10, 1);


/**
 * Validation callback - use this as example how to add specific validations
 * @param $form
 * @param $values
 */
function aviators_agency_validate($form, $values) {
    // custom validation - you can put your validation here
    // return array of messages in case of error

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
function aviators_agency_submit($form, $values) {
    // custom submit - you can put your redirect here in form
    // $form->setRedirect($permalink)
}