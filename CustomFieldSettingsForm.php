<?php
namespace APP\plugins\generic\customField;

use PKP\form\Form;
use PKP\core\JSONMessage;

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

    // Validation rule
    $this->addCheck(new \PKP\form\validation\FormValidator($this, 'customText', 'required', 'plugins.generic.customField.settings.customTextRequired'));
  }

  public function initData()
  {
    $this->_data = [
      'customText' => $this->plugin->getSetting($this->contextId, 'customText')
    ];
  }

  public function readInputData()
  {
    $this->readUserVars(['customText']);
  }

  public function fetch($request, $template = null, $display = false)
  {
    $templateMgr = \TemplateManager::getManager($request);
    $router = $request->getRouter();

    // Generate action URL for Ajax form
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
    $this->plugin->updateSetting(
      $this->contextId,
      'customText',
      $this->getData('customText'),
      'string'
    );
    parent::execute(...$functionArgs);
  }
}