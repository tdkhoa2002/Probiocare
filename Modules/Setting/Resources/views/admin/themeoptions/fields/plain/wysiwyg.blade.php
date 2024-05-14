<div class='form-group'>
    {!! Form::label($settingName, trans($moduleInfo['description'])) !!}
    <?php if (isset($dbThemeOptions[$settingName]) && $dbThemeOptions[$settingName]->plainValue !== null): ?>
        {!! Form::textarea($settingName, old($settingName, $dbThemeOptions[$settingName]->plainValue), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php else: ?>
        {!! Form::textarea($settingName, old($settingName), ['class' => 'form-control ckeditor', 'placeholder' => trans($moduleInfo['description'])]) !!}
    <?php endif; ?>
</div>
