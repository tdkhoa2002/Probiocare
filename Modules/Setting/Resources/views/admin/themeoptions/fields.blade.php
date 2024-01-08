<?php foreach ($settings as $settingName => $moduleInfo): ?>

<?php $fieldView = Str::contains($moduleInfo['view'], '::') ? $moduleInfo['view'] : "setting::admin.themeoptions.fields.$type.{$moduleInfo['view']}" ?>
<?php $locale = isset($locale) ? $locale : '' ?>
@include($fieldView, [
'lang' => $locale,
'settings' => $settings,
'setting' => $settingName,
'moduleInfo' => $moduleInfo,
'settingName' => strtolower($theme) . '::' . $settingName
])
<?php endforeach;