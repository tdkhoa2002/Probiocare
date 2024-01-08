<div class="btn-group">
    <?php if ($isWysiwyg == 1): ?>
    <button type="button" class="btn btn-primary btn-flat dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
        {{ trans('media::media.insert') }} <span class="caret"></span>
    </button>
    <ul class="dropdown-menu" role="menu">
        <?php foreach ($thumbnails as $thumbnail): ?>
        <li data-file-path="{{ Imagy::getThumbnail($file->path, $thumbnail->name()) }}"
            data-id="{{ $file->id }}" data-media-type="{{ $file->media_type }}"
            data-mimetype="{{ $file->mimetype }}" class="jsInsertImage">
            <a href="">{{ $thumbnail->name() }} ({{ $thumbnail->size() }})</a>
        </li>
        <?php endforeach; ?>
        <li class="divider"></li>
        <li data-file-path="{{ $file->path }}" data-id="{{ $file->id }}"
            data-media-type="{{ $file->media_type }}" data-mimetype="{{ $file->mimetype }}" class="jsInsertImage">
            <a href="">Original</a>
        </li>
    </ul>
    <?php else: ?>
    <a href="" class="btn btn-primary jsInsertImage btn-flat" data-id="{{ $file->id }}"
       data-file-path="{{ Imagy::getThumbnail($file->path, 'mediumThumb') }}"
       data-media-type="{{ $file->media_type }}" data-mimetype="{{ $file->mimetype }}">
        {{ trans('media::media.insert') }}
    </a>
    <?php endif; ?>
</div>