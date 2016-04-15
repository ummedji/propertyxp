<?php
use \Hydra\Builder;

add_action('admin_menu', 'hydra_plugins_admin_menu');

function hydra_plugins_admin_menu() {
    $hydraOptions = new HydraPluginsAdmin();
    $icon = '/wp-content/plugins/hydraforms/assets/img/icon-small.png';

    add_submenu_page(
        'hydrapost',
        __('Plugins', 'hydraforms'),
        __('Plugins', 'hydraforms'),
        'edit_pages',
        'hydraplugins',
        array($hydraOptions, 'router')
    );

}

class HydraPluginsAdmin extends HydraAdmin {

    public function router() {
        $params = $_GET;
        $this->viewPage();
    }

    public function viewPage() {

        $plugins = $this->collectPlugins();
        if(!count($plugins)) {
            echo __('There are no plugins defined', 'hydraforms');
        } else {
            $form = $this->getForm();
            $formRender = $form->customRender();
            $form->renderMessages();
            include_once 'templates/form.tpl.php';

            $form->build();
        }

    }

    public function getForm() {
        $builder = new Builder('hydra-plugins');
        $plugins = $this->collectPlugins();

        foreach ($plugins as $name => $plugin) {
            $fieldset = $builder->addField('fieldset', array($name));

            $export = $fieldset->addField('submit', array('update', __('Update', 'hydraforms')));
            $export->addOnSuccess('update', $this);

            $synchronize = $fieldset->addField('submit', array('revert', __('Revert', 'hydraforms')));
            $synchronize->addOnSuccess('revert', $this);
        }

        $builder->addField('submit', array('update_all', __('Update All', 'hydraforms')))
            ->addOnSuccess('updateAll', $this);

        $builder->addField('submit', array('revert_all', __('Revert All', 'hydraforms')))
            ->addOnSuccess('revertAll', $this);

        return $builder;
    }

    public function updateAll($form, $values) {
        $plugins = $this->collectPlugins();
        foreach ($plugins as $plugin) {
            $this->exportSource($plugin, $form);
        }
    }

    public function revertAll($form, $values) {
        $plugins = $this->collectPlugins();
        foreach ($plugins as $plugin) {
            $this->revertSource($plugin, $form);
        }
    }

    public function update($form, $values) {
        $submitField = $form->getSubmittedField();
        $plugin = $this->getPluginBySubmitField($submitField);

        if (!$plugin) {
            return;
        }

        $this->exportSource($plugin, $form);
    }

    public function exportSource($plugin, $form) {
        $exportValues = array();

        if(isset($plugin['post_types']) && count($plugin['post_types'])) {
            $exportValues['post_types'] = $plugin['post_types'];
        }
        if(isset($plugin['forms']) && count($plugin['forms'])) {
            $exportValues['forms'] = $plugin['forms'];
        }

        if(!count($exportValues)) {
            return;
        }

        $hydraExport = new HydraExportAdmin();

        ob_start();
        $hydraExport->exportFormSubmit($form, $exportValues);
        $data = ob_get_clean();

        if (file_put_contents($plugin['source'], $data)) {
            $form->addSuccessMessage(sprintf(__('%s plugin was updated', 'hydraforms'), $plugin['title']));
        }
    }


    public function revert($form, $values) {
        $submitField = $form->getSubmittedField();
        $plugin = $this->getPluginBySubmitField($submitField);

        $this->revertSource($plugin, $form);
    }

    public function revertSource($plugin, $form) {
        $hydraImport = new HydraImportAdmin();

        $xmlString = file_get_contents($plugin['source']);
        $hydraImport->import($xmlString, $form);
    }

    /**
     * @param $field
     * @return bool
     */
    private function getPluginBySubmitField($field) {
        $parts = explode('[', $field->getName());
        $plugin = $this->getPlugin(reset($parts));

        return $plugin;
    }

    public function getPlugin($name) {
        $plugins = $this->collectPlugins();
        if (isset($plugins[$name])) {
            return $plugins[$name];
        }

        return FALSE;
    }

    public function collectPlugins() {
        $plugins = array();
        $plugins = apply_filters('hydra_plugin_feature', $plugins);

        return $plugins;
    }
}