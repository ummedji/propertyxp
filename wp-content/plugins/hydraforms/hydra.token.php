<?php

/**
 * Class HydraFormToken
 */
class HydraFormToken {
    private $dbModel;
    private $form;

    public function __construct($formName) {
        $this->formName = $formName;
        $this->dbModel = new HydraFormModel();
        $this->form = $this->dbModel->loadByName($formName);
    }

    public function listTokens($postTypeContext = array()) {
        $data = $this->collectTokens();

        $currentContexts = array($this->formName, 'post');
        $context = array_merge($postTypeContext, $currentContexts);
        $output = '';

        foreach ($data['type'] as $type => $definition) {
            // there is requirement which was not filled for this form
            if (isset($definition['requirement']) && !in_array($definition['requirement'], $context)) {
                continue;
            }
        }

        $data = array();
        $this->collectFormData($data);
        $output .= $this->createTokenList($this->formName, $data);

        // contextual post type tokens
        foreach ($postTypeContext as $postType) {
            $this->collectPostTypeData($postType, $data);
            $output .= $this->createTokenList($postType, $data);
        }

        return '<div class="tokens">' . $output . "</div>";
    }

    public function replaceTokens($text, $values) {
        // nothing to replace
        if (empty($text)) {
            return '';
        }
        // custom tokens, not related to fields, but to posts, users.. global variables
        $tokens = $this->collectTokens();
        $text = apply_filters('hydra_token_process_data', $text, $values, $tokens);

        $definitionManager = new \Hydra\Definitions\DefinitionManager();
        if (isset($values['token_posts'])) {
            $posts = $values['token_posts'];
            $data = array();

            foreach ($posts as $post) {
                $this->collectFieldTokens($post->post_type, $data);

                $fields = $data['tokens'][$post->post_type];
                foreach ($fields as $field) {
                    $meta = hydra_get_post_meta($post->ID, $field['field']->field_name);
                    $definition = $definitionManager->createDefinition($field['field']->field_type);


                    foreach ($field['tokens'] as $token) {
                        $token_id = $this->createTokenId($post->post_type, $token['name']);
                        if ($meta) {
                            list($field_name, $column) = explode(':', $token['name']);
                            if (strstr($text, $token_id)) {
                                $text = $definition->replaceToken($field['field'], $token_id, $column, $meta, $text);
                            }

                        }
                        else {
                            // empty - but we dont want to keep token ? so empty value instead
                            $text = str_replace($token_id, '', $text);
                        }
                    }
                }
            }
        }

        $this->collectFieldTokens($this->formName, $data);
        $fields = $data['tokens'][$this->formName];
        foreach ($fields as $field_name => $field) {

            $definition = $definitionManager->createDefinition($field['field']->field_type);

            if (isset($values[$field_name])) {
                $meta = $values[$field_name];

                foreach ($field['tokens'] as $token) {
                    $token_id = $this->createTokenId($this->formName, $token['name']);
                    list($field_name, $column) = explode(':', $token['name']);
                    if (strstr($text, $token_id)) {
                        $text = $definition->replaceToken($field['field'], $token_id, $column, $meta, $text);
                    }
                }
            }
        }

        return $text;
    }


    private
    function createTokenList($type, $data) {
        $output = '';
        // perform check if we have values and if they are not empty
        if (isset($data['tokens'][$type]) && !empty($data['tokens'][$type])) {
            $list = '';
            $fields = $data['tokens'][$type];
            $context = $data['type'][$type];
            ob_start();

            include 'template/tokens/table.php';
            $output = ob_get_clean();
        }

        return $output;
    }

    /**
     * @param $type
     * @param $name
     * @return string
     */
    private
    function createTokenId($type, $name) {
        return "[$type:$name]";
    }

    /**
     * @param $type
     * @param $name
     * @param $title
     * @return string
     */
    private
    function createTokenLink($type, $name, $title) {
        $token_id = $this->createTokenId($type, $name);
        return "<a href=\"#\" class=\"replacement-token\" data-input=\"$token_id\">$title</a>";
    }

    private
    function collectTokens() {
        $data = array();
        $data = apply_filters('hydra_token_data', $data);
        return $data;
    }

    private
    function collectPostTypeData($postType, &$data) {
        $definition = get_post_type_object($postType);

        if (!$definition) {
            return;
        }

        $data['type'][$postType] = array(
            'title' => $definition->labels->name,
            'requirement' => NULL,
        );

        // collect standard post type data first
        $allTokens = $this->collectTokens();
        $data['type'][$postType]['tokens'] = $allTokens['tokens']['post'];

        $this->collectFieldTokens($postType, $data);
    }

    private
    function collectFormData(&$data) {

        $data['type'][$this->formName] = array(
            'title' => $this->formName,
            'requirement' => NULL,
        );

        $this->collectFieldTokens($this->formName, $data);
    }

    /**
     * @param $postType
     * @param $data
     * @return mixed
     */
    private
    function collectFieldTokens($postType, &$data) {
        $fieldModel = new HydraFieldModel();
        $fieldsContainer = $fieldModel->loadByPostType($postType);
        $fields = $fieldsContainer->getRecords();
        $definitionManager = new \Hydra\Definitions\DefinitionManager();

        foreach ($fields as $field) {
            $definition = $definitionManager->createDefinition($field->field_type);
            $tokens = $definition->getTokenDefinition();

            if ($tokens && (is_array($tokens) && !empty($tokens))) {
                $data['tokens'][$postType][$field->field_name] = array(
                    'title' => $field->field_label,
                    'field' => $field,
                );

                foreach ($tokens as $index => $token) {
                    $data['tokens'][$postType][$field->field_name]['tokens'][$index] = array(
                        'title' => $token['title'],
                        'name' => $field->field_name . ':' . $index,
                        'description' => isset($token['description']) ? $token['description'] : '',
                    );

                }
            }
        }
    }
}


/**
 * @param $data
 * @return mixed
 */
function hydra_token_post_data($data) {
    $data['type']['post'] = array(
        'title' => __('Post Data'),
        'requirement' => 'post',
    );

    $data['tokens']['post'] = array(
        'id' => array(
            'name' => 'id',
            'title' => __('Post ID'),
            'description' => __('Unique Identifier of Wordpress post'),
        ),
        'title' => array(
            'name' => 'title',
            'title' => __('Post Title'),
        ),
        'title_link' => array(
            'name' => 'title_link',
            'title' => __('Title Link'),
            'description' => __('Post title formatted as link to the post'),
        ),
        'author' => array(
            'name' => 'author',
            'title' => __('Author'),
            'description' => __('Post author name'),
        ),
        'author_id' => array(
            'name' => 'author',
            'title' => __('Author ID'),
            'description' => __('Post author ID'),
        ),
        'author_id' => array(
            'name' => 'author_id',
            'title' => __('Author ID'),
            'description' => __('Post author ID'),
        ),
        'author_mail' => array(
            'name' => 'author_mail',
            'title' => __('Author email'),
            'description' => __('Post author email'),
        ),
    );

    return $data;
}

add_filter('hydra_token_data', 'hydra_token_post_data');

function hydra_token_process_post_data($text, $data, $tokens) {
    if (!isset($data['token_posts'])) {
        return $text;
    }

    $posts = $data['token_posts'];
    if (!count($posts)) {
        return $text;
    }

    if (!isset($tokens['tokens']['post'])) {
        return $text;
    }

    $tokens = $tokens['tokens']['post'];

    foreach ($posts as $post) {
        foreach ($tokens as $index => $token) {
            $token_id = "[" . $post->post_type . ":" . $token['name'] . "]";
            switch ($index) {
                case 'id':
                    $text = str_replace($token_id, $post->ID, $text);
                    break;
                case 'title':
                    $text = str_replace($token_id, $post->post_title, $text);
                    break;
                case 'title_link':
                    $permalink = "<a href=" . get_permalink($post->ID) . ">" . $post->post_title . "</a>";
                    $text = str_replace($token_id, $permalink, $text);
                    break;
                case 'author':
                    $nice_name = get_the_author_meta('user_nicename', $post->post_author);
                    $text = str_replace($token_id, $nice_name, $text);
                    break;
                case 'author_id':
                    $text = str_replace($token_id, $post->post_author, $text);
                    break;
                case 'author_mail':
                    $mail = get_the_author_meta('user_email', $post->post_author);
                    $text = str_replace($token_id, $mail, $text);
                    break;
            }
        }
    }

    return $text;
}

add_filter('hydra_token_process_data', 'hydra_token_process_post_data', 10, 3);