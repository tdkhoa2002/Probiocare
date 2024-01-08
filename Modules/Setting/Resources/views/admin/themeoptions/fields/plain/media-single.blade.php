@php
    $setting = isset($dbThemeOptions[$settingName]) ? $dbThemeOptions[$settingName] : null;
@endphp

@mediaSingle($settingName, $setting, null, trans($moduleInfo['description']))
