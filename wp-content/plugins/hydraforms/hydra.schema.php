<?php

add_action( 'init', 'hydraforms_init_db');

function hydraforms_init_db() {
    if (!get_option('hydra_installation', FALSE)) {
        hydra_create_tables();
        update_option('hydra_installation', TRUE);
    }

    if (!get_option('hydra_update', FALSE)) {
        if (get_option('hydra_update', 1) < 7) {
            hydra_update_007();
            update_option('hydra_update', 7);
        }
    }
}

function hydra_create_tables() {
    global $wpdb;

    if ( get_option('hydra_installation', false) ) {
        return;
    }

    // Fields table
    $table = $wpdb->prefix . "hydra_field";
    $sql = 'CREATE TABLE ' . $table . ' (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    parent_id int(11) DEFAULT NULL,
    field_type varchar(255) DEFAULT NULL,
    field_label varchar(255) DEFAULT NULL,
    post_type varchar(255) DEFAULT NULL,
    field_name varchar(255) DEFAULT NULL,
    validators blob,
    attributes blob,
    weight smallint(11) DEFAULT NULL,
    wrapper int(11) DEFAULT NULL,
    widget varchar(255) DEFAULT NULL,
    widget_settings blob,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;';
    hydra_create_table($sql, $table);

    // Views table for fields
    $table = $wpdb->prefix . "hydra_field_view";
    $sql = 'CREATE TABLE ' . $table . ' (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    field_id int(11) DEFAULT NULL,
    field_name varchar(255) DEFAULT NULL,
    field_label varchar(255) DEFAULT NULL,
    parent_id int(11) DEFAULT NULL,
    formatter varchar(100) DEFAULT NULL,
    weight int(2) DEFAULT NULL,
    hidden int(1) DEFAULT NULL,
    settings blob,
    attributes blob,
    wrapper int(1) DEFAULT NULL,
    view varchar(255) DEFAULT NULL,
    post_type varchar(255) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
    hydra_create_table($sql, $table);

    // View table
    $table = $wpdb->prefix . "hydra_view";
    $sql = 'CREATE TABLE ' . $table . '(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    post_type varchar(255) DEFAULT NULL,
    name varchar(255) DEFAULT NULL,
    label varchar(255) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
    hydra_create_table($sql, $table);

    $table = $wpdb->prefix . "hydra_form";
    $sql = "CREATE TABLE " . $table . " (
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    name varchar(255) DEFAULT NULL,
    label varchar(255) DEFAULT NULL,
    settings blob,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8";
    hydra_create_table($sql, $table);

    $table = $wpdb->prefix . "hydra_form_handler";
    $sql = 'CREATE TABLE ' . $table . '(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    form_id int(11) DEFAULT NULL,
    label varchar(255) DEFAULT NULL,
    type varchar(100) DEFAULT NULL,
    settings blob,
    weight smallint(11) DEFAULT NULL,
    PRIMARY KEY (id)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
    hydra_create_table($sql, $table);

    $table = $wpdb->prefix . "hydra_field_filter";
    $sql = 'CREATE TABLE ' . $table . '(
    id int(11) unsigned NOT NULL AUTO_INCREMENT,
    `field_id` int(11) DEFAULT NULL,
    `referrer_id` int(11) DEFAULT NULL,
    `col` varchar(50) DEFAULT NULL,
    `condition` varchar(20) DEFAULT NULL,
    PRIMARY KEY (id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8';
    hydra_create_table($sql, $table);

    $table = $wpdb->prefix . "hydra_form_cache";
    $sql = 'CREATE TABLE ' . $table . '(
    `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `form_id` varchar(255) DEFAULT NULL,
    `created` int(11) DEFAULT NULL,
    `form` longblob,
    PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;';
    hydra_create_table($sql, $table);

    hydra_update_001();
    hydra_update_002();
    hydra_update_003();
    hydra_update_004();
    hydra_update_005();
    hydra_update_006();

    update_option('hydra_installation', TRUE);
}

function hydra_update_001() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_form_handler";
    $sql = "ALTER TABLE " . $table . " ADD name VARCHAR(250)";
    $wpdb->query($sql);
}

/**
 * Cardinality support
 */
function hydra_update_002() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_field";
    $sql = "ALTER TABLE " . $table . " ADD cardinality int(2)";
    $wpdb->query($sql);
}

/**
 * Adding type support for forms - recognizing between filters || other forms
 */
function hydra_update_003() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_form";
    $sql = "ALTER TABLE " . $table . " ADD type varchar(20)";
    $wpdb->query($sql);
}

/**
 * Adding translations support for fields
 */
function hydra_update_004() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_field";
    $sql = "ALTER TABLE " . $table . " ADD translations blob";
    $wpdb->query($sql);
}


/**
 * Adding translations support for forms
 */
function hydra_update_005() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_form";
    $sql = "ALTER TABLE " . $table . " ADD translations blob";
    $wpdb->query($sql);
}

/**
 * Adding translations support for form handlers
 */
function hydra_update_006() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_form_handler";
    $sql = "ALTER TABLE " . $table . " ADD translations blob";
    $wpdb->query($sql);
}

/**
 * Adding default values support for widgets
 */
function hydra_update_007() {
    global $wpdb;

    $table = $wpdb->prefix . "hydra_field";
    $sql = "ALTER TABLE " . $table . " ADD default_values blob";
    $wpdb->query($sql);
}

/**
 * @param $sql
 * @param $table
 */
function hydra_create_table($sql, $table) {
    global $wpdb;

    // sanitize
    $sql = trim(preg_replace('/\s\s+/', ' ', $sql));

    require_once ABSPATH . 'wp-admin/upgrade.php';
    dbDelta($sql);

    if (!isset($wpdb->{$table})) {
        $wpdb->{$table} = $table;
        $wpdb->tables[] = str_replace($wpdb->prefix, '', $table);
    }
}
