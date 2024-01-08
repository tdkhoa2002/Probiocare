<div class="checkbox">
    <?php foreach ($moduleInfo['options'] as $value => $optionName): ?>
        <?php $oldValue = (isset($dbThemeOptions[$settingName]) && $dbThemeOptions[$settingName]->hasTranslation($lang)) ? $dbThemeOptions[$settingName]->translate($lang)->value : ''; ?>
        <label for="{{ $optionName . "[$lang]" }}">
                <input id="{{ $optionName . "[$lang]" }}"
                        name="{{ $settingName . "[$lang]" }}"
                        type="radio"
                        class="flat-blue"
                        {{ isset($dbThemeOptions[$settingName]) && $oldValue == $value ? 'checked' : '' }}
                        value="{{ $value }}" />
                {{ trans($optionName) }}
        </label>
    <?php endforeach; ?>
</div>
