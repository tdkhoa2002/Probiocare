<div class="checkbox">
    <?php $oldValue = (isset($dbThemeOptions[$settingName]) && $dbThemeOptions[$settingName]->hasTranslation($lang)) ? $dbThemeOptions[$settingName]->translate($lang)->value : ''; ?>
    <label for="{{ $settingName . "[$lang]" }}">
        <input id="{{ $settingName . "[$lang]" }}"
                name="{{ $settingName . "[$lang]" }}"
                type="checkbox"
                class="flat-blue"
                {{ isset($dbThemeOptions[$settingName]) && (bool)$oldValue == true ? 'checked' : '' }}
                value="1" />
        {{ trans($moduleInfo['description']) }}
    </label>
</div>
