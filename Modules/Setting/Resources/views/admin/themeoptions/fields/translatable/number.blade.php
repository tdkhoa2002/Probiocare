<?php
    $defaultValue = isset($moduleInfo['default']) ? $moduleInfo['default']: '';
    $defaultOptions = [
        'class' => 'form-control',
        'placeholder' => trans($moduleInfo['description']),
    ];
    $options = array_merge($defaultOptions, isset($moduleInfo['options']) ? $moduleInfo['options'] : []);
?>
<div class='form-group'>
    {!! Form::label($settingName . "[$lang]", trans($moduleInfo['description'])) !!}
    <?php if (isset($dbThemeOptions[$settingName])): ?>
        <?php $value = $dbThemeOptions[$settingName]->hasTranslation($lang) ? $dbThemeOptions[$settingName]->translate($lang)->value : $defaultValue; ?>
        {!! Form::number($settingName . "[$lang]", old($settingName . "[$lang]", $value), $options) !!}
    <?php else: ?>
        {!! Form::number($settingName . "[$lang]", old($settingName . "[$lang]", $defaultValue), $options) !!}
    <?php endif; ?>
</div>
