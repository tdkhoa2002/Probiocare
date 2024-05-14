<?php

view()->composer(['page::admin.pages.*'], \Modules\Page\Composers\PageTemplateViewComposer::class);
view()->composer(['page::admin.posts.*'], \Modules\Page\Composers\PostTemplateViewComposer::class);
