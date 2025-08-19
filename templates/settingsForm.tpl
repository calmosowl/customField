{**
  Settings form for CustomField plugin
*}

<form class="pkp_form" id="customFieldSettingsForm" method="post" action="{$formActionUrl}">
  <input type="hidden" name="save" value="1">

  <div class="form-group">
    <label for="customText">{translate key="plugins.generic.customField.settings.customText"}</label>
    <input type="text" name="customText" id="customText" value="{$customText|escape}" class="form-control">
  </div>

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