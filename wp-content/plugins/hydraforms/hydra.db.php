<?php


class HydraModel {
    protected $manager;
    protected $tableName;

    public function __construct() {
        global $wpdb;
        $this->manager = $wpdb;
    }
}

class HydraFormCacheModel extends HydraModel {

    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_form_cache';
    }

    // delete records older than 1 hour
    public function clearOldRecords() {
        $this->manager->query($this->manager->prepare("DELETE FROM $this->tableName WHERE created < %d", time() - 60 * 60 * 2));
    }

    public function load($form_id) {

        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE form_id = %s',
            $form_id
        );

        $result = $this->manager->get_row($prepareSQL);


        // return only cache
        if ($result) {
            return unserialize($result->form);
        }

        return FALSE;
    }

    // delete on success or validation
    public function delete($form_id) {
        $this->manager->query($this->manager->prepare("DELETE FROM $this->tableName WHERE form_id = %s", $form_id));
    }

    public function save($form_id, $form) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE form_id = %s',
            $form_id
        );

        $result = $this->manager->get_row($prepareSQL);
        if ($result) {
            $this->delete($form_id);
        }

        $data = array(
            'form_id' => $form_id,
            'created' => time(),
            'form' => serialize($form),
        );
        $formats = array('%s', '%d', '%s');

        $this->manager->insert($this->tableName, $data, $formats);
    }
}

class HydraFormModel extends HydraModel {

    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_form';
    }

    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFormRecord($result);
        }

        return $record;
    }

    public function loadByName($name) {
        $prepareSQL = $this->manager->prepare('SELECT * FROM ' . $this->tableName . ' WHERE name = "%s"', $name);

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFormRecord($result);
        }

        return $record;
    }


    public function loadAll() {
        $results = $this->manager->get_results('SELECT * FROM ' . $this->tableName);
        $records = array();

        if (!count($results)) {
            return FALSE;
        }

        foreach ($results as $result) {
            $records[] = new HydraFormRecord($result);
        }

        return $records;
    }

    public function loadByType($type = 'form') {
        $prepareSQL = $this->manager->prepare('SELECT * FROM ' . $this->tableName . ' WHERE type = %s', array($type));

        $results = $this->manager->get_results($prepareSQL);
        $records = array();

        if (!count($results)) {
            return FALSE;
        }

        foreach ($results as $result) {
            $records[] = new HydraFormRecord($result);
        }

        return $records;
    }
}

class HydraFormHandlerModel extends HydraFormModel {

    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_form_handler';
    }

    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFormHandlerRecord($result);
        }

        return $record;
    }

    public function loadByName($name) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE name = %s',
            $name
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFormHandlerRecord($result);
        }

        return $record;
    }

    public function loadByFormId($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE form_id = %d',
            $id
        );


        $results = $this->manager->get_results($prepareSQL);
        $records = array();
        if ($results) {
            foreach ($results as $result) {
                $records[$result->id] = new HydraFormHandlerRecord($result);
            }
        }

        return $records;
    }

    public function loadByFormName($name) {
        $prepareSQL = $this->manager->prepare(
            'SELECT f2.* FROM ' . $this->tableName . ' as f2 LEFT JOIN ' . $this->manager->prefix . 'hydra_form' . ' as f1 on f2.form_id = f1.id WHERE f1.name = %s ORDER BY f2.weight ASC',
            $name
        );

        $results = $this->manager->get_results($prepareSQL);
        $records = array();
        if ($results) {
            foreach ($results as $result) {
                $records[$result->id] = new HydraFormHandlerRecord($result);
            }
        }

        return $records;
    }
}


class HydraFieldModel extends HydraModel {

    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_field';
    }

    /**
     * @param $id
     * @return bool|HydraFieldRecord
     */
    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFieldRecord($result);
        }

        return $record;
    }

    /**
     * @param $id
     */
    public function delete($id) {
        $this->manager->delete($this->tableName, array('id' => $id), array('%d'));
    }

    public function save() {

    }

    /**
     * @param $name
     * @return bool|HydraFieldRecord
     */
    public function loadByName($name) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE field_name = %s',
            $name
        );

        $result = $this->manager->get_row($prepareSQL);

        $record = FALSE;
        if ($result) {
            $record = new HydraFieldRecord($result);
        }

        return $record;
    }

    /**
     * @param $postType
     * @return HydraRecordsContainer
     */
    public function loadByPostType($postType) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE post_type = %s ORDER BY weight ASC',
            $postType
        );

        $results = $this->manager->get_results($prepareSQL);
        $container = new HydraRecordsContainer($results);

        return $container;
    }

    /**
     * Return only specific fields
     * Usable for filter and sorting functionality
     * @param $fieldType
     * @param $postType
     * @return array
     */
    public function loadOptionsByFieldType($fieldType, $postType) {
        $prepareSQL = $this->manager->prepare(
            'SELECT id, field_label FROM ' . $this->tableName . ' WHERE post_type = %s  AND field_type = %s ORDER BY weight ASC',
            $postType, $fieldType
        );

        $results = $this->manager->get_results($prepareSQL);
        $options = array();

        foreach ($results as $result) {
            $options[$result->id] = $result->field_label;
        }

        return $options;
    }

    /**
     * @param $postType
     * @return HydraRecordsContainer
     */
    public function loadByPostTypeOptions($postType, $key = 'id') {

        $prepareSQL = $this->manager->prepare(
            'SELECT ' . $key . ', field_label FROM ' . $this->tableName . ' WHERE post_type = %s  AND wrapper = %d ORDER BY weight ASC',
            $postType, 0
        );


        $results = $this->manager->get_results($prepareSQL);

        $options = array();

        foreach ($results as $result) {
            $options[$result->{$key}] = $result->field_label;
        }
        return $options;
    }

    /**
     * @param $groupName
     * @return array
     */
    public function loadGroupRecordsByName($groupName) {
        $prepareSQL = $this->manager->prepare(
            'SELECT f2.* FROM ' . $this->tableName . ' as f1 LEFT JOIN ' . $this->tableName . ' as f2 on f2.parent_id = f1.id WHERE f1.field_name = %s ORDER BY f1.weight ASC',
            $groupName
        );

        $results = $this->manager->get_results($prepareSQL);
        $container = new HydraRecordsContainer($results);

        return $container;
    }

    /**
     * Load list post types which are using fields
     * @return mixed
     */
    public function loadUsedPostTypes() {
        $results = $this->manager->get_results('SELECT post_type FROM ' . $this->tableName . ' GROUP BY post_type;');

        return $results;
    }

    public function loadUsedPostTypesAsArray() {
        $postTypes = array();
        $results = $this->manager->get_results('SELECT post_type FROM ' . $this->tableName . ' GROUP BY post_type;');

        foreach ($results as $result) {
            if (array_key_exists($result->post_type, get_post_types())) {
                $postTypes[$result->post_type] = $result->post_type;
            }
        }

        return $postTypes;
    }
}

class HydraFieldViewModel extends HydraModel {
    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_field_view';
    }

    /**
     * @param $id
     * @return bool|HydraFieldViewRecord
     */
    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFieldViewRecord($result);
        }

        return $record;
    }


    /**
     * @param $id
     * @return HydraRecordsContainer
     */
    public function loadByField($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE field_id = %d',
            $id
        );

        $results = $this->manager->get_results($prepareSQL);
        $container = new HydraRecordsContainer($results, 'view');

        return $container;
    }

    /**
     * @param $name
     * @param $view
     * @return bool|HydraViewRecord
     */
    public function loadByFieldName($name, $view) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' as t WHERE t.field_name = %s AND t.view = %s',
            $name,
            $view
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFieldViewRecord($result);
        }

        return $record;
    }

    public function loadGroupsByPostType($post_type) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' as t WHERE t.wrapper = %d AND t.post_type = %s',
            1, $post_type);

        $results = $this->manager->get_results($prepareSQL);
        $records = array();
        foreach ($results as $result) {
            $records[] = new HydraFieldViewRecord($result);
        }
        return $records;
    }

    /**
     * @param $id
     * @return array
     */
    public function loadGroupRecords($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE parent_id = %d',
            $id
        );

        $results = $this->manager->get_results($prepareSQL);
        $container = new HydraRecordsContainer($results, 'view');

        return $container;
    }

    /**
     * @param $viewName
     * @param $postType
     * @return HydraRecordsContainer
     */
    public function loadByViewName($viewName, $postType) {

        $prepareSQL = $this->manager->prepare(
            'SELECT t1.* FROM ' . $this->tableName . ' as t1 LEFT JOIN ' . $this->manager->prefix . 'hydra_field as t2 on t1.field_id = t2.id WHERE t1.view = %s AND t2.post_type = %s',
            $viewName, $postType
        );

        $fields = $this->manager->get_results($prepareSQL);

        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' as t1 WHERE t1.view = %s AND t1.post_type = %s AND t1.field_id = %d',
            $viewName, $postType, 0
        );


        $groups = $this->manager->get_results($prepareSQL);
        $results = array_merge($fields, $groups);
        $container = new HydraRecordsContainer($results, 'view');

        return $container;
    }


    /**
     * @param $postType
     * @param string $viewName
     * @return HydraRecordsContainer
     */
    public function loadByViewNamePostType($postType, $viewName = 'default') {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE view = %s AND post_type = %s',
            $viewName,
            $postType
        );


        $results = $this->manager->get_results($prepareSQL);
        $container = new HydraRecordsContainer($results, 'view');

        return $container;
    }
}


class HydraFieldFilterModel extends HydraModel {
    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_field_filter';
    }

    /**
     * @param $id
     * @return bool|HydraFieldViewRecord
     */
    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFieldFilterRecord($result);
        }

        return $record;
    }

    public function loadByPostType($type) {
        $prepareSQL = $this->manager->prepare(
            'SELECT f2.* FROM ' . $this->tableName . ' as f2 LEFT JOIN ' . $this->manager->prefix . 'hydra_field' . ' as f1 on f1.id = f2.field_id WHERE f1.post_type = %s',
            $type
        );

        $results = $this->manager->get_results($prepareSQL);
        $records = array();

        if (!$results) {
            return FALSE;
        }

        foreach ($results as $result) {
            $records[] = new HydraFieldFilterRecord($result);
        }

        return $records;
    }


    /**
     * @param $id
     * @param $column
     * @return bool|HydraFieldFilterRecord
     */
    public function loadByFieldAll($id) {

        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE field_id = %d', $id
        );


        $results = $this->manager->get_results($prepareSQL);

        $records = array();
        if (!count($results)) {
            return $records;
        }

        foreach ($results as $result) {
            $records[] = new HydraFieldFilterRecord($result);
        }

        return $records;
    }

    /**
     * @param $id
     * @param $column
     * @return bool|HydraFieldFilterRecord
     */
    public function loadByReferrerId($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE referrer_id = %d', $id
        );

        $results = $this->manager->get_results($prepareSQL);

        $records = array();
        if (!count($results)) {
            return $records;
        }

        foreach ($results as $result) {
            $records[] = new HydraFieldFilterRecord($result);
        }

        return $records;
    }

    /**
     * @param $id
     * @param $column
     * @return bool|HydraFieldFilterRecord
     */
    public function loadByField($id, $column) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE field_id = %d AND col = %s', $id, $column
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraFieldFilterRecord($result);
        }

        return $record;
    }

    public function deleteByFieldId($field_id) {
        $this->manager->delete($this->tableName, array('field_id' => $field_id), array('%d'));
    }
}


class HydraViewModel extends HydraModel {
    public function __construct() {
        parent::__construct();
        $this->tableName = $this->manager->prefix . 'hydra_view';
    }

    /**
     * @param $id
     * @return bool|HydraFieldViewRecord
     */
    public function load($id) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE id = %d',
            $id
        );

        $result = $this->manager->get_row($prepareSQL);
        $record = FALSE;
        if ($result) {
            $record = new HydraViewRecord($result);
        }

        return $record;
    }


    /**
     * @param $postType
     * @return array
     */
    public function loadByPostType($postType, $default = TRUE) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE post_type = %s',
            $postType
        );

        $results = $this->manager->get_results($prepareSQL);
        $items = array();

        if ($default) {
            $items = array(
                new HydraViewRecord(array(
                    'name' => 'default',
                    'label' => 'Default',
                    'post_type' => $postType,
                ))
            );
        }

        foreach ($results as $result) {
            $items[] = new HydraViewRecord($result);
        }

        return $items;
    }

    public function loadByNamePostType($postType, $name) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE post_type = %s AND name = %s',
            $postType,
            $name
        );

        $item = $this->manager->get_row($prepareSQL);

        if ($item) {
            return new HydraViewRecord($item);
        }

        return FALSE;
    }


    public function loadOptionsByPostType($postType) {
        $prepareSQL = $this->manager->prepare(
            'SELECT * FROM ' . $this->tableName . ' WHERE post_type = %s',
            $postType
        );

        $results = array(
            (object) array(
                'name' => 'default',
                'label' => 'Default'
            ),
        );
        $results = array_merge($results, $this->manager->get_results($prepareSQL));

        return $results;
    }

}

/**
 * Class FieldRecordsContainer
 */
class HydraRecordsContainer {
    private $records;

    public function __construct($records, $type = 'field') {

        foreach ($records as $record) {
            if ($type == 'field') {
                $this->records[$record->id] = new HydraFieldRecord($record);
            }
            else {
                $this->records[$record->id] = new HydraFieldViewRecord($record);
            }
        }
    }

    /**
     * Get records in flat array
     * @return mixed
     */
    public function getRecords() {
        $records = $this->records;
        if (is_array($records) && count($records)) {
            uasort($records, array($this, 'sort'));

            return $records;
        }

        return array();
    }

    /**
     * Get hierarchical structure of Records
     * @return mixed
     */
    public function getHierarchy() {
        $records = $this->getRecordsHierarchy();

        uasort($records, array($this, 'sort'));

        return $records;
    }

    /**
     * Build hierarchy
     * @param null $record
     * @return mixed
     */
    private function getRecordsHierarchy($record = NULL) {
        if ($record) {
            $children = $this->getRecordsByParent($record->id);

            // no children, we are done with this leaf
            if (!count($children)) {
                return;
            }
            foreach ($children as $child) {
                $record->addChild($child);
                if ($child->isWrapper()) {
                    $this->getRecordsHierarchy($child);
                }
            }
        }
        else {
            $hierarchy = array();
            if (!count($this->records)) {
                return $hierarchy;
            }
            foreach ($this->records as $record) {
                if ($record->parent_id == 0 || $record->isWrapper()) {
                    $hierarchy[$record->id] = $record;
                }

                if ($record->isWrapper()) {
                    $this->getRecordsHierarchy($record);
                }
            }

            return $hierarchy;
        }
    }

    /**
     * Weigh based sorting
     * @param $itemA
     * @param $itemB
     * @return bool
     */
    public function sort($itemA, $itemB) {
        if ($itemA->weight > $itemB->weight) {
            return TRUE;
        }

        return FALSE;
    }

    /**
     * Find all records belonging to parent
     * @param $parent_id
     * @return array
     */
    private function getRecordsByParent($parent_id) {
        $results = array();
        foreach ($this->records as $record) {
            if ($record->parent_id == $parent_id) {
                $results[$record->id] = $record;
            }
        }

        return $results;
    }
}


function hydra_get_post_meta($post_id, $field_name) {
    static $postMeta;
    $meta = NULL;
    if (isset($postMeta[$post_id])) {
        $meta = $postMeta[$post_id];
    }

    if (!$meta) {
        $meta = get_post_meta($post_id);
        $postMeta[$post_id] = $meta;
    }


    if (isset($postMeta[$post_id][$field_name][0])) {
        return unserialize($postMeta[$post_id][$field_name][0]);

    }

    return false;
}

function hydra_get_post_meta_single($post_id, $field_name) {
    $items = hydra_get_post_meta($post_id, $field_name);

    if ($items) {
        return reset($items['items']);
    }

    return false;
}

/**
 * Class HydraViewRecord
 */
class HydraViewRecord extends HydraRecord {

    public $id;
    public $name;
    public $label;
    public $post_type;

    private $tableName;
    private $dbManager;

    public function __construct($record = NULL) {
        global $wpdb;
        $record = (object) $record;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_view';

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        $this->name = isset($record->name) ? $record->name : '';
        $this->label = isset($record->label) ? $record->label : '';
        $this->post_type = isset($record->post_type) ? $record->post_type : '';
    }

    public function save() {
        $data = array(
            'name' => $this->name,
            'label' => $this->label,
            'post_type' => $this->post_type,
        );

        $formats = array('%s', '%s', '%s');

        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;
            $viewConsistency = new HydraViewConsistency();
            $viewConsistency->viewAdded($this);
        }
    }


    public function delete() {
        if ($this->id) {
            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
        }
    }
}


abstract class HydraRecord {

    public function updateWithData($data) {
        $data = (array) $data;
        foreach ($data as $property => $value) {
            // save only properties on this object
            if (isset($this->{$property})) {
                $this->{$property} = $value;
            }
        }
    }

    abstract function save();

    abstract function delete();
}

class HydraFormRecord extends HydraRecord {
    public $id;
    public $name;
    public $label;
    public $settings;
    public $type;
    public $translations;

    public $handlers;
    public $fields;

    public function __construct($record) {
        global $wpdb;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_form';

        $record = (object) $record;

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        $this->name = $record->name;
        $this->label = $record->label;
        $this->type = isset($record->type) ? $record->type : 'form';

        if (isset($record->settings) && is_string($record->settings)) {
            $this->settings = unserialize($record->settings);
        }
        else {
            if (is_array($record->settings)) {
                $this->settings = $record->settings;
            }
            else {
                $this->settings = array();
            }
        }

        if (isset($record->translations) && is_string($record->translations)) {
            $this->translations = unserialize($record->translations);
        }
        else {
            if (!empty($record->translations) && is_array($record->translations)) {
                $this->translations = $record->translations;
            }
            else {
                $this->translations = array();
            }
        }
    }

    /**
     * Load all handlers associated with this form
     * @return array
     */
    public function loadHandlers() {
        $dbModel = new HydraFormHandlerModel();
        $handlers = $dbModel->loadByFormId($this->id);
        if (count($handlers)) {
            $this->handlers = $handlers;

            return $this->handlers;
        }

        return FALSE;
    }

    /**
     * Load all fields associated with this form
     */
    public function loadFields() {
        $dbModel = new HydraFieldModel();

        $fieldContainer = $dbModel->loadByPostType($this->name);
        $fields = $fieldContainer->getRecords();
        if (count($fields)) {
            $this->fields = $fields;
            return $this->fields;
        }

        return FALSE;
    }

    public function getFields() {
        return $this->fields;
    }

    public function getHandlers() {
        return $this->handlers;
    }

    private function deleteHandlers() {
        $handlers = $this->loadHandlers();
        if ($handlers) {
            foreach ($handlers as $handler) {
                $handler->delete();
            }
        }
    }

    private function deleteFields() {
        $fields = $this->loadFields();
        if ($fields) {
            foreach ($fields as $fields) {
                $fields->delete();
            }
        }
    }


    public function delete() {
        if ($this->id) {
            $this->deleteHandlers();
            $this->deleteFields();
            $this->deleteConditions();
            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
        }
    }

    public function save() {

        $data = array(
            'name' => $this->name,
            'label' => $this->label,
            'type' => $this->type,
            'settings' => serialize($this->settings),
            'translations' => serialize($this->translations),
        );

        $formats = array('%s', '%s', '%s', '%s', '%s');

        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;
        }
    }

    public function getLabel() {

        if (defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;
            $translations = $this->translations;

            if (isset($translations['label'][$language])) {
                return $translations['label'][$language];
            }
        }

        return $this->label;

    }

    public function getSettings($name, $language = NULL) {

        if (defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;
            if (isset($this->translations['settings'])) {
                $translations = $this->translations['settings'];

                if (isset($translations[$name][$language])) {
                    return $translations[$name][$language];
                }
            }
        }

        return $this->settings[$name];
    }
}

class HydraFormHandlerRecord extends HydraRecord {

    public $id;
    public $label;
    public $name;
    public $type;
    public $weight;
    public $settings;
    public $translations;

    public function __construct($record) {
        global $wpdb;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_form_handler';

        $record = (object) $record;

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        $this->form_id = $record->form_id;
        $this->label = $record->label;
        $this->name = $record->name;
        $this->type = $record->type;

        if (isset($record->weight)) {
            $this->weight = $record->weight;
        }
        else {
            $this->weight = 0;
        }

        if (isset($record->settings)) {
            if (is_string($record->settings)) {
                $this->settings = unserialize($record->settings);
            }
            else {
                $this->settings = $record->settings;
            }
        }
        else {
            $this->settings = array();
        }

        if (isset($record->translations)) {
            if (is_string($record->translations)) {
                $this->translations = unserialize($record->translations);
            }
            else {
                $this->translations = $record->translations;
            }
        }
        else {
            $this->translations = array();
        }
    }

    public function delete() {
        if ($this->id) {
            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
        }
    }

    public function save() {

        $data = array(
            'label' => $this->label,
            'type' => $this->type,
            'settings' => serialize($this->settings),
            'translations' => serialize($this->translations),
            'name' => $this->name,
            'form_id' => $this->form_id,
            'weight' => $this->weight,
        );

        $formats = array('%s', '%s', '%s', '%s', '%s', '%d', '%d');

        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;
        }
    }

    public function getSettings($name, $language = NULL) {
        if (defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;
            $translations = $this->translations['settings'];

            if (isset($translations[$name][$language])) {
                return $translations[$name][$language];
            }
        }

        return $this->settings[$name];
    }
}

class HydraRecordNestable extends HydraRecord {

    public $weight;
    public $parent_id;
    public $wrapper;
    public $children;

    public function save() {
        // : \
    }

    public function delete() {
        // : \
    }

    public function addChild($child) {
        $this->children[$child->id] = $child;
    }

    public function isWrapper() {
        return (bool) ($this->wrapper);
    }

    public function hasChildren() {
        return (bool) count($this->children);
    }

    public function getChildren() {
        usort($this->children, array($this, 'sort'));

        return $this->children;
    }

    // from lowest to highest
    public function sort($itemA, $itemB) {
        if ($itemA->weight > $itemB->weight) {
            return TRUE;
        }

        return FALSE;
    }
}

/**
 * Class HydraFieldViewRecord
 */
class HydraFieldViewRecord extends HydraRecordNestable {

    public $id;
    public $field_id;
    public $formatter;
    public $hidden;
    public $attributes;
    public $settings;
    public $view;
    public $field;
    public $wrapper;
    public $field_name;
    public $field_label;

    public function __construct($record = NULL) {

        global $wpdb;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_field_view';

        $record = (object) $record;

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        $this->view = $record->view;
        $this->wrapper = $record->wrapper;
        if (isset($record->hidden)) {
            $this->hidden = $record->hidden;
        }
        else {
            $this->hidden = 0;
        }

        if (isset($record->weight)) {
            $this->weight = $record->weight;
        }
        else {
            $this->weight = 120;
        }

        $this->parent_id = $record->parent_id;
        $this->field_id = $record->field_id;
        $this->formatter = $record->formatter;
        $this->post_type = $record->post_type;
        $this->field_name = $record->field_name;
        $this->field_label = $record->field_label;

        if (isset($record->settings) && is_string($record->settings)) {
            $this->settings = unserialize($record->settings);
        }
        else {
            $this->settings = array();
        }
    }

    public function getCleanMachineName() {
        if (!isset($this->field_name)) {
            return '';
        }
        $parts = explode('_', $this->field_name);

        // @todo remove later - Ehm, currently there is db inconsistency which needs to be resolved
        if (count($parts) < 2) {
            return $this->field_name;
        }
        unset($parts[0]);
        unset($parts[1]);

        $machineName = implode('_', $parts);

        return $machineName;
    }

    public function getLabel() {
        return $this->field_label;
    }

    public function loadField() {
        $db = new HydraFieldModel();
        $this->field = $db->load($this->field_id);
        return $this->field;
    }

    public function setParentId($parent_id) {
        $this->parent_id = $parent_id;
    }

    public function save() {
        $data = array(
            'view' => $this->view,
            'formatter' => $this->formatter,
            'settings' => serialize($this->settings),
            'post_type' => $this->post_type,
            'hidden' => $this->hidden,
            'weight' => $this->weight,
            'parent_id' => $this->parent_id,
            'field_id' => $this->field_id,
            'wrapper' => $this->wrapper,
            'field_name' => $this->field_name,
            'field_label' => $this->field_label,
        );

        $formats = array('%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d');

        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;
        }
    }

    public function delete() {
        if ($this->id) {
            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
        }
    }
}


/**
 * Class HydraFieldFilterRecord
 */
class HydraFieldFilterRecord extends HydraRecordNestable {

    public $id;
    public $field_id;
    public $col;
    public $condition;
    public $referrer_id;

    public function __construct($record = NULL) {

        global $wpdb;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_field_filter';

        $record = (object) $record;

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        if (isset($record->field_id)) {
            $this->field_id = $record->field_id;
        }

        if (isset($record->referrer_id)) {
            $this->referrer_id = $record->referrer_id;
        }
        else {
            $this->referrer_id = 0;
        }

        $this->condition = $record->condition;
        $this->col = $record->col;
    }

    public function loadReferrer() {
        $db = new HydraFieldModel();
        return $db->load($this->referrer_id);
    }

    public function loadField() {
        $db = new HydraFieldModel();
        $this->field = $db->load($this->field_id);
    }

    public function save() {

        $data = array(
            'field_id' => $this->field_id,
            'referrer_id' => $this->referrer_id,
            'condition' => $this->condition,
            'col' => $this->col,
        );

        $formats = array('%d', '%d', '%s', '%s');

        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;
        }
    }

    public function delete() {
        if ($this->id) {
            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
        }
    }
}

/**
 * Class FieldRecord
 * Dummy field class for manipulating the data
 */
class HydraFieldRecord extends HydraRecordNestable {

    public $id;
    public $post_type;
    public $attributes;
    public $validators;

    public $widget_settings;
    public $default_values;

    public $field_type;
    public $field_name;
    public $field_label;
    public $widget;
    public $cardinality;

    public $hidden;
    public $views;
    public $translations;

    private $dbManager;
    private $tableName;

    // initialize from database/array
    public function __construct($record = NULL) {
        global $wpdb;
        $this->dbManager = $wpdb;
        $this->tableName = $wpdb->prefix . 'hydra_field';

        $record = (object) $record;

        if (isset($record->id)) {
            $this->id = $record->id;
        }

        $this->weight = isset($record->weight) ? $record->weight : 0;
        $this->children = isset($record->children) ? $record->children : array();
        $this->post_type = isset($record->post_type) ? $record->post_type : '';
        $this->wrapper = isset($record->wrapper) ? $record->wrapper : 0;
        $this->parent_id = isset($record->parent_id) ? $record->parent_id : 0;
        $this->field_name = isset($record->field_name) ? $record->field_name : '';
        $this->field_type = isset($record->field_type) ? $record->field_type : '';
        $this->field_label = isset($record->field_label) ? $record->field_label : '';
        $this->widget = isset($record->widget) ? $record->widget : '';
        $this->cardinality = isset($record->cardinality) ? $record->cardinality : 1;

        if (isset($record->attributes)) {
            $this->attributes = is_array($record->attributes) ? $record->attributes : unserialize($record->attributes);
        }
        else {
            $this->attributes = array();
        }

        if (isset($record->default_values)) {
            $this->default_values = is_array($record->default_values) ? $record->default_values : unserialize($record->default_values);
        }
        else {
            $this->default_values = array();
        }

        if (isset($record->validators)) {
            $this->validators = is_array($record->validators) ? $record->validators : unserialize($record->validators);
        }
        else {
            $this->validators = array();
        }

        if (isset($record->widget_settings)) {
            $this->widget_settings = is_array($record->widget_settings) ? $record->widget_settings : unserialize(
                $record->widget_settings
            );
        }
        else {
            $this->widget_settings = array();
        }

        if (isset($record->translations)) {
            $this->translations = is_array($record->translations) ? $record->translations : unserialize(
                $record->translations
            );
        }
        else {
            $this->translations = array();
        }
    }

    public function getCleanMachineName() {
        if (!isset($this->field_name)) {
            return '';
        }

        $parts = explode('_', $this->field_name);

        unset($parts[0]);
        unset($parts[1]);

        $machineName = implode('_', $parts);
        return $machineName;
    }

    public function loadConditions() {
        $db = new HydraFieldFilterModel();
        $conditions = $db->loadByFieldAll($this->id);
        return $conditions;
    }

    public function loadReferredConditions() {
        $db = new HydraFieldFilterModel();
        $conditions = $db->loadByReferrerId($this->id);
        return $conditions;
    }

    public function loadCondition($column = 'value') {
        $db = new HydraFieldFilterModel();
        $condition = $db->loadByField($this->id, $column);
        return $condition;
    }

    public function loadViews() {
        $db = new HydraFieldViewModel();

        $container = $db->loadByField($this->id);
        $fieldViews = $container->getRecords();

        foreach ($fieldViews as $fieldView) {
            $this->views[$fieldView->view] = $fieldView;
        }
    }

    public function getView($view_name) {
        if (isset($this->views[$view_name])) {
            return $this->views[$view_name];
        }

        return $this->views['default'];
    }

    public function getViews() {
        return $this->views;
    }

    public function save() {
        $data = array(
            'field_type' => $this->field_type,
            'field_name' => $this->field_name,
            'field_label' => $this->field_label,
            'post_type' => $this->post_type,
            'attributes' => serialize($this->attributes),
            'validators' => serialize($this->validators),
            'default_values' => serialize($this->default_values),
            'widget_settings' => serialize($this->widget_settings),
            'translations' => serialize($this->translations),
            'widget' => $this->widget,
            'parent_id' => $this->parent_id,
            'wrapper' => $this->wrapper,
            'weight' => $this->weight,
            'cardinality' => $this->cardinality,
        );

        $formats = array('%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%d', '%d', '%d');
        if ($this->id) {
            $this->dbManager->update($this->tableName, $data, array('id' => $this->id), $formats);
        }
        else {
            $this->dbManager->insert($this->tableName, $data, $formats);
            $this->id = $this->dbManager->insert_id;

            $hydraConsistency = new HydraViewConsistency();
            $hydraConsistency->fieldAdded($this);

        }
    }

    public function delete() {
        if ($this->id) {
            $referredConditions = $this->loadReferredConditions();
            // cleanup filter fields referencing to this field content
            if(count($referredConditions)) {
                foreach($referredConditions as $condition) {
                    $dbModel = new HydraFieldModel();
                    $field = $dbModel->load($condition->field_id);
                    if($field) {
                        $field->delete();
                    }
                }
            }

            // delete associated conditions if there are any, dont leave dead conditions haning
            $conditions = $this->loadConditions();
            if (count($conditions)) {
                foreach ($conditions as $condition) {
                    $condition->delete();
                }
            }

            $this->dbManager->delete($this->tableName, array('id' => $this->id), array('%d'));
            $hydraConsistency = new HydraViewConsistency();
            $hydraConsistency->fieldDeleted($this);
        }
    }

    /**
     * Load meta-values for one field
     * @param $postId
     * @return array
     */
    public function loadMeta($postId) {

        $meta = (object) array(
            'prefix' => isset($this->attributes['prefix']) ? $this->attributes['prefix'] : '',
            'suffix' => isset($this->attributes['suffix']) ? $this->attributes['suffix'] : '',
            'label' => $this->field_label,
        );

        // no point of loading value for wrapper
        if (!$this->isWrapper()) {
            $value = hydra_get_post_meta($postId, $this->field_name);
            $meta->value = $value;
        }


        return $this->meta = $meta;
    }

    public function getLabel() {
        return $this->getTranslation('field_label');
    }

    public function getAttribute($name) {
        if (defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;
            if (isset($this->translations['attributes'])) {
                $translations = $this->translations['attributes'];
                if (isset($translations[$name][$language])) {
                    return $translations[$name][$language];
                }
            }
        }

        return $this->attributes[$name];
    }


    public function getTranslation($name, $language = NULL) {

        if (defined('ICL_LANGUAGE_CODE')) {
            $language = ICL_LANGUAGE_CODE;

            $translations = $this->translations;
            if (isset($translations[$name][$language])) {
                return $translations[$name][$language];
            }
        }

        return $this->{$name};
    }
}

/**
 * Synchronization for Fields <-> Views
 * Class HydraViewConsistency
 */
class HydraViewConsistency {


    public function __construct() {
    }

    /**
     * Check all the existing displays and add view outputs
     * @param $field
     */
    public function fieldAdded($field) {
        if ($field->isWrapper()) {
            return;
        }

        if ($field->field_type == 'fieldset') {
            // no synchronization for fieldset
            return;
        }

        $db = new HydraViewModel();
        $views = $db->loadByPostType($field->post_type);

        // create field record for each available view, for this particular post
        foreach ($views as $view) {
            $postTypes = get_post_types();

            if (!in_array($field->post_type, $postTypes)) {
                return;
            }

            $formatters = hydra_formatter_get_formatters_for_type($field->field_type);
            $keys = array_keys($formatters);
            $definition = hydra_field_get_definition($field->field_type);

            if (isset($definition['default_formatter']) && !empty($definition['default_formatter'])) {
                $formatter = $definition['default_formatter'];
            }
            else {
                $formatter = reset($keys);
            }
            if ($formatter) {
                // retrieve default settings also
                $formatterInstance = Hydra\Formatter\Formatter::getFormatter($formatter);
                $defaultSettings = $formatterInstance->getDefaultSettings();
            }
            else {
                $formatter = '';
                $defaultSettings = array();
            }

            $wrapper = 0;
            if ($field->field_type == 'fieldset') {
                $wrapper = 1;
            }

            $fieldView = new HydraFieldViewRecord(array(
                'view' => $view->name,
                'hidden' => 0,
                'weight' => 99,
                'parent_id' => 0,
                'field_id' => $field->id,
                'wrapper' => $wrapper,
                'post_type' => $field->post_type,
                'formatter' => $formatter,
                'settings' => serialize($defaultSettings),
                'field_name' => $field->field_name,
                'field_label' => $field->field_label,
            ));

            $fieldView->save();
        }
    }

    /**
     * Check all the existing displays and remove view outputs
     * @param $field
     */
    public function fieldDeleted($field) {
        if ($field->isWrapper()) {
            return;
        }
        $db = new HydraFieldViewModel();
        $viewsContainer = $db->loadByField($field->id);
        $fieldViews = $viewsContainer->getRecords();

        foreach ($fieldViews as $fieldView) {
            $fieldView->delete();
        }
    }

    /**
     * Check all the existing fields and add field outputs
     * @param $view
     */
    public function viewAdded($view) {
        $db = new HydraFieldModel();
        $dbFieldView = new HydraFieldViewModel();

        $recordContainer = $db->loadByPostType($view->post_type);
        $fields = $recordContainer->getRecords();

        // create record for each field listed for post type

        $fieldViewContainer = $dbFieldView->loadByViewNamePostType($view->post_type);
        $defaultFieldViews = $fieldViewContainer->getRecords();

        $idMapping = array();
        $newFieldViews = array();
        foreach ($defaultFieldViews as $defaultFieldView) {
            $fieldView = new HydraFieldViewRecord(array(
                'view' => $view->name,
                'hidden' => $defaultFieldView->hidden,
                'weight' => $defaultFieldView->weight,
                'parent_id' => $defaultFieldView->parent_id,
                'field_id' => $defaultFieldView->field_id,
                'wrapper' => $defaultFieldView->wrapper,
                'post_type' => $view->post_type,
                'formatter' => $defaultFieldView->formatter,
                'settings' => $defaultFieldView->settings,
                'field_name' => $defaultFieldView->field_name,
                'field_label' => $defaultFieldView->field_label,
            ));

            $fieldView->save();
            $newFieldViews[$fieldView->id] = $fieldView;

            $idMapping[$defaultFieldView->id] = array(
                'id' => $fieldView->id,
                'parent_id' => $defaultFieldView->parent_id,
            );
        }

        foreach ($idMapping as $old_id => $ids) {
            $new_id = $ids['id'];

            $old_parent_id = (int) $newFieldViews[$new_id]->parent_id;
            if (!empty($old_parent_id)) {
                $new_parent_id = $idMapping[$defaultFieldViews[$old_parent_id]->id]['id'];

                $newFieldViews[$new_id]->parent_id = $new_parent_id;
                $newFieldViews[$new_id]->save();
            }
        }

    }

    /**
     * Check all the existing fields and remove field outputs
     * @param $view
     */
    public function viewDeleted($view) {
        $db = new HydraFieldViewModel();

        $viewsContainer = $db->loadByViewName($view->name, $view->post_type);
        $fieldViews = $viewsContainer->getRecords();

        foreach ($fieldViews as $fieldView) {
            $fieldView->delete();
        }
    }
}