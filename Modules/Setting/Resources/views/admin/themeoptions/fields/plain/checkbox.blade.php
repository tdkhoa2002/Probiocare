<div class="checkbox">
    <label for="{{ $settingName }}">
        <input id="{{ $settingName }}"
                name="{{ $settingName }}"
                type="checkbox"
                class="flat-blue"
                {{ isset($dbThemeOptions[$settingName]) && (bool)$dbThemeOptions[$settingName]->plainValue == true ? 'checked' : '' }}
                value="1" />
        {{ trans($moduleInfo['description']) }}
    </label>
</div>
