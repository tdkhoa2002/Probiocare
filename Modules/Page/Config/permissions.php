<?php

return [
    'page.pages' => [
        'index' => 'page::pages.list resource',
        'create' => 'page::pages.create resource',
        'edit' => 'page::pages.edit resource',
        'destroy' => 'page::pages.destroy resource',
    ],
    'post.posts' => [
        'index' => 'page::posts.list resource',
        'create' => 'page::posts.create resource',
        'edit' => 'page::posts.edit resource',
        'destroy' => 'page::posts.destroy resource',
    ],
    'category.categories' => [
        'index' => 'page::categories.list resource',
        'create' => 'page::categories.create resource',
        'edit' => 'page::categories.edit resource',
        'destroy' => 'page::categories.destroy resource',
    ],
];
