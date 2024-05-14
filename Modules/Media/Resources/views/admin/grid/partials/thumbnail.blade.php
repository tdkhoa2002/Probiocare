<?php if ($file->isImage()): ?>
<img src="{{ Imagy::getThumbnail($file->path, 'smallThumb') }}" alt=""/>
<?php else: ?>
<i class="fa {{ FileHelper::getFaIcon($file->media_type) }}" style="font-size: 20px;"></i>
<?php endif; ?>