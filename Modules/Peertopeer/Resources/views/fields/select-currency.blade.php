<div class="form-group">
    <label for="{{ $settingName }}">{{ trans($moduleInfo['description']) }}</label>
    <select multiple class="locales" name="{{ $settingName }}[]" id="{{ $settingName }}">
        @php
            $currencies = 
        @endphp
        @foreach ($locales as $id => $locale)
        <option value="{{ $id }}" {{ isset($dbSettings[$settingName]) && isset(array_flip(json_decode($dbSettings[$settingName]->plainValue))[$id]) ? 'selected' : '' }}>
            {{ Arr::get($locale, 'name') }}
        </option>
        @endforeach
    </select>
</div>
