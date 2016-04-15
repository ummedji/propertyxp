<?php

use Hydra\Builder;


add_action('wp_enqueue_scripts', 'hydra_enqueue_scripts');
function hydra_enqueue_scripts() {
    /* Register our script. */
    wp_enqueue_script('chained', HYDRA_URL . '/assets/jquery.chained.min.js', array('jquery'), FALSE, TRUE);
    wp_enqueue_script('password', HYDRA_URL . '/assets/jquery.password.js', array('jquery'), FALSE, TRUE);
    wp_enqueue_script('fields', HYDRA_URL . '/assets/fields.js', array('jquery'), FALSE, TRUE);
}

function hydra_render_messages() {
    return \Hydra\MessageManager::renderAllMessages();
}

function hydra_get_messages() {
    return \Hydra\MessageManager::getAllMessages();
}

function hydra_get_frontend_submission($id = NULL, $post_type = NULL) {
    if ($id == NULL && $post_type == NULL) {
        print __('Specify id or post type', 'hydraforms');
    }

    if (!empty($id)) {
        $post = get_post($id);
    }
    else {
        $post = (object) array(
            'post_type' => $post_type,
            'ID' => $id,
        );
    }

    $renderer = new HydraPostRenderer();
    $form = $renderer->getForm($post);
    return $form;
}

function hydra_render_frontend_submission($id = NULL, $post_type = NULL) {

    if ($id == NULL && $post_type == NULL) {
        print __('Specify id or post type', 'hydraforms');
    }

    if (!empty($id)) {
        $post = get_post($id);
    }
    else {
        $post = (object) array(
            'post_type' => $post_type,
            'ID' => $id,
        );
    }

    $renderer = new HydraPostRenderer();
    $form = $renderer->render($post);

    return $form->render();
}

/**
 * @Todo refactor - ugly but working
 * Class HydraAdvancedRender
 */
class HydraAdvancedRender {
    private $form;
    private $renderedElements = array();

    public function __construct($form) {
        // we need just output
        $this->form = $form->customRender(true);
    }

    public function renderStart() {
        print $this->form['form_start'];
    }

    public function renderClose() {
        print $this->form['form_closure'];
    }

    public function renderField($field) {
        if (isset($this->renderedElements[$field]) || !isset($this->form['form_fields'][$field])) {
            return;
        }

        if (is_array($this->form['form_fields'][$field]) && isset($this->form['form_fields'][$field]['items'])) {
            // field
            foreach ($this->form['form_fields'][$field] as $items) {
                if(is_array($items)) {
                    foreach ($items as $values) {
                        foreach ($values as $value) {
                            print $value;
                        }
                    }
                } else {
                    print $items;
                }

            }
        }
        else {
            // group
            if (is_array($this->form['form_fields'][$field])) {
                foreach ($this->form['form_fields'][$field] as $group) {
                    foreach ($group as $items) {
                        foreach ($items as $values) {
                            foreach ($values as $value) {
                                print $value;
                            }
                        }
                    }
                }

            }
            else {
                //other
                print $this->form['form_fields'][$field];
            }
        }

        $this->setRendered($field);
    }

    public function setRendered($field) {
        if(is_array($field)) {
            foreach($field as $item) {
                $this->setRendered($item);
            }
        } else {
            $this->renderedElements[$field] = TRUE;
        }
    }

    // render all the remaining fields
    public function render() {
        foreach ($this->form['form_fields'] as $index => $field) {
            if (!isset($this->renderedElements[$index])) {
                // quite ugly
                $this->renderField($index);
            }
        }
    }
}

class HydraPostRenderer {
    // @todo - possible singleton - no need for multiple instances
    public function __construct() {

    }

    public function render($post) {
        return $this->getForm($post);
    }

    public function getForm($post) {
        $postForm = new Builder('post-form', '/submit/post-form');

        // post title
        if (post_type_supports($post->post_type, 'title')) {
            $title = $postForm->addField('text', array('post_title', __('Title', 'hydraforms')))
                ->addValidator('required');
            if (isset($post->post_title)) {
                $title->setDefaultValue($post->post_title);
            }
        }

        // post content
        if (post_type_supports($post->post_type, 'editor')) {
            $body = $postForm->addField('textarea', array('post_content', __('Content', 'hydraforms')))
                ->setRows(10);

            if (isset($post->post_content)) {
                $body->setDefaultValue($post->post_content);
            }
        }

        $postForm->addField('hidden', array('id', $post->ID));
        $postForm->addField('hidden', array('frontend_save', 1));
        $postForm->addField('hidden', array('post_type', $post->post_type));

        $postFormExtender = new HydraPostForm($post);
        $postFormExtender->getForm($postForm);

        // post featured image
        if (post_type_supports($post->post_type, 'thumbnail')) {
            $postForm->addField('markup', array(
                'thumbnail_title',
                "<h3>" . __('Featured image', 'hydraforms') . "</h3>"
            ));


            if (has_post_thumbnail($post->ID)) {
                $postForm->addAttribute('enctype', 'multipart/form-data');

                $html = "<div id=\"delete-image\">" . get_the_post_thumbnail($post->ID) . "</div>";
                $postForm->addField('markup', array('thumbnail_markup', $html));

                $postForm->addField('submit', array('delete_thumbnail', __('Delete Image', 'hydraforms')))
                    ->addAjaxAction('#delete-image')
                    ->addAjaxCallback('ajaxCallback', $this);
            }
            else {
                $postForm->addField('file', array('thumbnail', __('Featured image', 'hydraforms')))
                    ->disableLabel();
            }
        }

        $postForm->addField('submit', array('save', __('Save', 'hydraforms')));

        $postForm->addOnValidation('postFormValidate', $this);
        $postForm->addOnSuccess('postFormSubmit', $this);

        apply_filters('hydra_frontend_submission_form', array(
                'form' => $postForm,
                'type' => $post->post_type
            )
        );

        $postForm->build();
        return $postForm;
    }


    public function ajaxCallback($form, $values) {
        print $form->addField('file', array('thumbnail', __('Featured image', 'hydraforms')))
            ->disableLabel()
            ->render();
    }

    public function postFormValidate($form, $values) {
        if (!isset($_FILES['thumbnail'])) {
            return array();
        }

        // error uploading image
        if ($_FILES['thumbnail']['error'] !== UPLOAD_ERR_OK && !empty($_FILES['thumbnail']['name'])) {
            if (!empty($_FILES['thumbnail'])) {
                return array(
                    array(__('Error uploading featured image', 'hydraforms'), 'thumbnail')
                );
            }
        }
    }

    public function postFormSubmit($form, $values) {
        $post = (object) array();

        if ($values['id']) {
            $post = get_post($values['id']);
        }

        $post->post_type = $values['post_type'];

        if (isset($values['post_title'])) {
            $post->post_title = $values['post_title'];
        }

        if (isset($values['post_content'])) {
            $post->post_content = $values['post_content'];
        }

        if(!isset($post->post_status)) {
            $post->post_status = 'draft';
        }

        if (isset($post->ID)) {
            $post_id = wp_update_post((array) $post);
        }
        else {
            $post_id = wp_insert_post((array) $post);
        }
        $post->ID = $post_id;
        require_once(ABSPATH . 'wp-admin/includes/image.php');
        require_once(ABSPATH . 'wp-admin/includes/file.php');
        require_once(ABSPATH . 'wp-admin/includes/media.php');

        // if the thumbnail is not set, we dont want to delete the previous one
        if ($post->ID && isset($values['thumbnail'])) {
            get_the_post_thumbnail($post->ID);
        }

        if(isset($_FILES['thumbnail'])) {
            if ($_FILES['thumbnail']['name'] && !$_FILES['thumbnail']['error']) {
                $attach_id = media_handle_upload('thumbnail', $post->ID);
                update_post_meta($post->ID, '_thumbnail_id', $attach_id);
            }
        }


        $postForm = new HydraPostForm($post);
        $postForm->submitForm($values, $post);

        $form->setValue('post_id', $post->ID);
        $form->build();
        $form->setRedirect(get_permalink($post_id));
    }
}

