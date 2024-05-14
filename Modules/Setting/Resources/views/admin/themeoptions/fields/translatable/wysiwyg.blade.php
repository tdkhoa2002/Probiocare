<div class='form-group'>
    {!! Form::label($settingName . "[$lang]", trans($moduleInfo['description'])) !!}
    <?php if (isset($dbThemeOptions[$settingName])): ?>
        <?php $value = $dbThemeOptions[$settingName]->hasTranslation($lang) ? $dbThemeOptions[$settingName]->translate($lang)->value : ''; ?>
        {!! Form::textarea($settingName . "[$lang]", old($settingName . "[$lang]", $value), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::textarea($settingName . "[$lang]", old($settingName . "[$lang]"), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
