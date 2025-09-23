<?php
namespace APP\plugins\generic\customField;

use PKP\plugins\GenericPlugin;
use PKP\plugins\Hook;
use APP\plugins\generic\customField\CustomFieldSettingsForm;
use PKP\core\JSONMessage;

class CustomFieldPlugin extends GenericPlugin
{
   public function __construct()
    {
        parent::__construct();
    }

  public function register($category, $path, $mainContextId = null)
  {
    // Register the plugin
    $success = parent::register($category, $path);

    if ($success && $this->getEnabled()) {
      Hook::add('TemplateManager::display', [$this, 'addVariables']);
    }

    return $success;
  }

  /**
   * Plugin name for display in admin
   */
  public function getDisplayName()
  {
    return 'Custom Field';
  }

  /**
   * Plugin description
   */
  public function getDescription()
  {
    return 'Додає поле користувача, яке можна виводити в шаблонах.';
  }

  public function addVariables($hookName, $args)
  {
    $templateMgr = $args[0];
    $request = \Application::get()->getRequest();
    $context = $request->getContext();

    $customFields = [];
    foreach (CustomFieldMap::getFields() as $fieldName => $label) {
      $customFields[$fieldName] = $this->getSetting($context->getId(), $fieldName) ?? '';
    }

    $templateMgr->assign('customFields', $customFields);
    return false;
  }

  public function manage($args, $request)
{
    $context = $request->getContext();
    $contextId = $context ? $context->getId() : 0;

    require_once(__DIR__ . '/CustomFieldSettingsForm.php');

    if ($request->getUserVar('save')) {
        $form = new CustomFieldSettingsForm($this, $contextId);
        $form->readInputData();
        $form->execute();
        return new JSONMessage(true);
    } else {
        $form = new CustomFieldSettingsForm($this, $contextId);
        $form->initData();
        return new JSONMessage(true, $form->fetch($request));
    }
}

public function getActions($request, $verb)
{
    $actions = parent::getActions($request, $verb);

    require_once('lib/pkp/classes/linkAction/LinkAction.php');
    require_once('lib/pkp/classes/linkAction/request/AjaxModal.php');

    $router = $request->getRouter();

    $actions[] = new \PKP\linkAction\LinkAction(
        'settings',
        new \PKP\linkAction\request\AjaxModal(
            $router->url($request, null, null, 'manage', null, [
                'verb' => 'settings',
                'plugin' => $this->getName(),
                'category' => 'generic'
            ]),
            __('manager.plugins.settings'),
            'modal_manage'
        ),
        __('manager.plugins.settings')
    );

    return $actions;
}
}