# CustomField Plugin for OMP

## Overview
This plugin allows developers to define and use custom fields in **Open Monograph Press (OMP)**.  
It is intended **for developers**, not administrators — after installation, you will need to edit the plugin code (map and templates) to define which fields exist and how they are rendered.

## Features
- Add arbitrary custom fields to OMP.
- Manage their values through the plugin settings form in the OMP dashboard.
- Access these values in your theme templates using Smarty variables.

## Installation
1. Clone or copy this plugin into the `plugins/generic/customField` directory of your OMP installation.
2. Enable the plugin from **Settings → Website → Plugins** in the OMP dashboard.

## Usage

### 1. Define your fields
Open `CustomFieldMap.php` and edit the `getFields()` method.  

Example:
```php
class CustomFieldMap {
  public static function getFields(): array {
    return [
      'customText' => 'Custom text field',
      'footerNote' => 'Footer note',
      'extraInfo'  => 'Extra information',
    ];
  }
}
```

Each entry is defined as:
```php
'fieldName' => 'Label shown in settings form'
```

### 2. Enter field values
-	Go to Settings → Website → Plugins.
-	Find CustomField in the list and click Settings.
-	Fill in your custom values and save.

### 3. Use fields in templates
In your OMP Smarty templates (e.g. header.tpl, footer.tpl), you can access the values with:
```smarty
{$customText}
{$footerNote}
{$extraInfo}
```

## Notes
-	Field definitions are static: you must update CustomFieldMap.php if you want to add/remove fields.
-	This plugin is a developer tool: site administrators cannot add new fields via UI.
-	You can freely customize the templates to display the values wherever needed.