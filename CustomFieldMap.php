<?php
namespace APP\plugins\generic\customField;

/**
 * Defines available custom fields for the plugin
 */
class CustomFieldMap
{
  public static function getFields(): array
  {
    return [
      'email' => 'Email',
      'phone' => 'Phone',
    ];
  }
}