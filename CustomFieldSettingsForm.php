<?php
namespace APP\plugins\generic\customField;

use PKP\form\Form;
use PKP\template\PKPTemplateManager;

class CustomFieldSettingsForm extends Form
{
  /** @var CustomFieldPlugin */
  public $plugin;

  /** @var int */
  public $contextId;

  public function __construct($plugin, $contextId)
  {
    $this->plugin = $plugin;
    $this->contextId = $contextId;

    parent::__construct($plugin->getTemplateResource('settingsForm.tpl'));
  }

  public function initData()
  {
    $data = [];
    foreach (CustomFieldMap::getFields() as $fieldName => $label) {
      $data[$fieldName] = $this->plugin->getSetting($this->contextId, $fieldName);
    }
    $this->_data = $data;
  }

  public function readInputData()
  {
    $this->readUserVars(array_keys(CustomFieldMap::getFields()));
  }

  public function fetch($request, $template = null, $display = false)
  {
    $templateMgr = PKPTemplateManager::getManager($request);
    $router = $request->getRouter();

    $templateMgr->assign('fields', CustomFieldMap::getFields());
    $templateMgr->assign('fieldValues', $this->_data); // <--- додати оце
    $templateMgr->assign('formActionUrl', $router->url(
      $request, null, null, 'manage', null, [
        'verb' => 'settings',
        'plugin' => $this->plugin->getName(),
        'category' => 'generic',
      ]
    ));

    return parent::fetch($request, $template, $display);
  }

  public function execute(...$functionArgs)
  {
    foreach (CustomFieldMap::getFields() as $fieldName => $label) {
      $this->plugin->updateSetting(
        $this->contextId,
        $fieldName,
        $this->getData($fieldName),
        'string'
      );
    }
    parent::execute(...$functionArgs);
  }
}