<?php
    $defaultValue = isset($moduleInfo['default']) ? $moduleInfo['default']: '';
    $defaultOptions = [
        'class' => 'form-control',
        'placeholder' => trans($moduleInfo['description']),
    ];
    $options = array_merge($defaultOptions, isset($moduleInfo['options']) ? $moduleInfo['options'] : []);
?>
<div class='form-group'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
    <?php if (isset($dbThemeOptions[$settingName]) && $dbThemeOptions[$settingName]->plainValue !== null): ?>
        {!! Form::number($settingName, old($settingName, $dbThemeOptions[$settingName]->plainValue) ?: $defaultValue, $options) !!}
    <?php else: ?>
        {!! Form::number($settingName, old($settingName, $defaultValue), $options) !!}
    <?php endif; ?>
</div>
