{**
  Settings form for CustomField plugin (with dynamic fields map)
*}

<form class="pkp_form" id="customFieldSettingsForm" method="post" action="{$formActionUrl}">
  <input type="hidden" name="save" value="1">

  {foreach from=$fields key=fieldName item=fieldLabel}
    <div class="form-group" style="margin-bottom: 1.5em;">
      <label for="{$fieldName}" style="display: flex; justify-content: space-between; align-items: center;">
        <span>{$fieldLabel}</span><code>{$}{$fieldName}</code>
      </label>
      <input type="text"
             name="{$fieldName}"
             id="{$fieldName}"
             value="{$fieldValues[$fieldName]|escape}"
             class="form-control">
    </div>
  {/foreach}

  <div class="form-buttons">
    <button class="pkp_button pkp_button_primary" type="submit">
      {translate key="common.save"}
    </button>
  </div>
</form>

<script>
  $(function() {
    // Attach handler for Ajax submission
    $('#customFieldSettingsForm').pkpHandler('$.pkp.controllers.form.AjaxFormHandler');
  });
</script>