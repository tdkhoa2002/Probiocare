<?php

use Modules\Page\Repositories\CategoryRepository;
use Modules\Page\Repositories\PageRepository;

if (!function_exists('random_strings')) {
    function random_strings($length_of_string)
    {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }
}
if (!function_exists('random_number')) {
    function random_number($length_of_number)
    {
        $str_result = '123456789';
        return substr(str_shuffle($str_result), 0, $length_of_number);
    }
}

if (!function_exists('getParentPageCategoriesShowHome')) {
    function getParentPageCategoriesShowHome()
    {
        $categories = app(CategoryRepository::class)->getByAttributes(['show_homepage' => true, 'status' => true]);
        return $categories;
    }
}

if (!function_exists('getCategoryById')) {
    function getCategoryById($categoryId)
    {
        $category = app(CategoryRepository::class)->find($categoryId);
        return $category;
    }
}

if (!function_exists('getChildCategories')) {
    function getChildCategories($elements)
    {
        foreach ($elements as $key => $value) {
            if (count($value->children()->get()) > 0) {
                $elements[$key]['children'] = getChildCategories($value->children()->get());
            }
        }

        return $elements;
    }
}

if (!function_exists('renderLabel')) {
    function renderLabel($array)
    {
        $arrayNew = [];

        foreach ($array as $key => $value) {
            $arrayNew[$key]['id'] = $value->id;
            $arrayNew[$key]['label'] = $value->title;
        }

        return $arrayNew;
    }
}

if (!function_exists('renderArrayId')) {
    function renderArrayId($array)
    {
        foreach ($array as $value) {
            $arrayNew[] = $value->id;
        }

        return $arrayNew;
    }
}

if (!function_exists('getPageByCategory')) {
    function getPageByCategory($categoryId)
    {
        $posts = app(PageRepository::class)->findPageByCategory($categoryId);
        $category = app(CategoryRepository::class)->find($categoryId);
        if (count($category->children)) {
            foreach ($category->children as $key => $value) {
                if (json_encode($posts) == json_encode(app(PageRepository::class)->findPageByCategory($value->id))) {
                    return [];
                }
            }
        }

        return $posts;
    }
}


if (!function_exists('getAllParent')) {
    function getAllParent($post)
    {
        if ($post->categories) {
            foreach ($post->categories as $key => $value) {
                $categories[] = getParentRootPageCategories($value->id);
            }
        }
    }
}

if (!function_exists('getParentRootPageCategories')) {
    function getParentRootPageCategories($categoryId)
    {
        $category = app(CategoryRepository::class)->find($categoryId);

        if ($category->parent_id) {
            getParentRootPageCategories($category->parent_id);
        } else {
            return $category->id;
        }
    }
}


if (!function_exists('getTopParentCategory')) {
    function getTopParentCategory($post)
    {
        $listCategoryTop = [];
        foreach ($post->categories()->get() as $key => $value) {
            if ($value->parent_id) {
                $listCategoryTop[] = getTopParentCategoryItem($value->parent_id);
            };
        }

        return array_unique($listCategoryTop);
    }
}
if (!function_exists('getTopParentCategoryItem')) {
    function getTopParentCategoryItem($categoryId)
    {
        $category = app(CategoryRepository::class)->find($categoryId);
        if ($category->parent_id) {
            $category = getTopParentCategoryItem($category->parent_id);
        }

        return $category;
    }
}

if (!function_exists('getRecursiveCategory')) {
    function getRecursiveCategory($categories)
    {
        $data = [];
        foreach ($categories as $category) {
            if ($category['parent_id'] == 0) {
                $char = "";
                $dt = [
                    'id' => $category['id'],
                    'title' => $category['title'],
                    'char' => $char,
                    'parent_id' => $category['parent_id']
                ];
                array_push($data, $dt);
                recursiveCategory($categories, $category, $char, $data);
            }
        }
        return $data;
    }
}

if (!function_exists('recursiveCategory')) {
    function recursiveCategory($categories, $category, $char, &$data)
    {
        $dataCategories = array_filter($categories, function ($cate) use ($category) {
            return $cate['parent_id'] == $category['id'];
        });
        if (count($dataCategories) > 0) {
            foreach ($dataCategories as $cate) {
                $ch = $char . '&nbsp;&nbsp;&nbsp;&nbsp;';
                $dt = [
                    'id' => $cate['id'],
                    'title' => $cate['title'],
                    'char' => $ch,
                    'parent_id' => $cate['parent_id']
                ];
                array_push($data, $dt);
                recursiveCategory($categories, $cate, $ch, $data);
            }
        }
    }
}


if (!function_exists('getAllBlogs')) {
    function getAllBlogs()
    {
        return app(PageRepository::class)->getAllBlogs();
    }
}


if (!function_exists('getRelatePost')) {
    function getRelatePost($postId, $limit = 5)
    {
        return app(PageRepository::class)->getRelatePost($postId, $limit);
    }
}
