<?php

namespace Modules\Page\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Modules\Core\Http\Controllers\BasePublicController;
use Modules\Menu\Repositories\MenuItemRepository;
use Modules\Page\Entities\Page;
use Modules\Page\Repositories\PageRepository;
use Modules\Page\Repositories\CategoryRepository;

class PublicController extends BasePublicController
{
    /**
     * @var PageRepository
     */
    private $page;
    /**
     * @var Application
     */
    private $app;

    private $postCategory;

    private $disabledPage = false;

    public function __construct(PageRepository $page, CategoryRepository $postCategory, Application $app)
    {
        parent::__construct();
        $this->page = $page;
        $this->postCategory = $postCategory;
        $this->app = $app;
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function uri($slug)
    {
        $page = $this->findPageForSlug($slug);

        $this->throw404IfNotFound($page);

        $currentTranslatedPage = $page->getTranslation(locale());
        if ($slug !== $currentTranslatedPage->slug) {
            return redirect()->to($currentTranslatedPage->locale . '/' . $currentTranslatedPage->slug, 301);
        }

        $template = $page->type == "post" ? $this->getTemplateForPost($page) : $this->getTemplateForPage($page);

        $this->addAlternateUrls($this->getAlternateMetaData($page));

        return view($template, compact('page'));
    }

    /**
     * @return \Illuminate\View\View
     */
    public function homepage()
    {
        
        $page = $this->page->findHomepage();
    
        $this->throw404IfNotFound($page);
        $template = $this->getTemplateForPage($page);
        $this->addAlternateUrls($this->getAlternateMetaData($page));

        return view($template, compact('page'));
    }

    /**
     * Find a page for the given slug.
     * The slug can be a 'composed' slug via the Menu
     * @param string $slug
     * @return Page
     */
    private function findPageForSlug($slug)
    {
        $menuItem = app(MenuItemRepository::class)->findByUriInLanguage($slug, locale());

        if ($menuItem) {
            return $this->page->find($menuItem->page_id);
        }

        return $this->page->findBySlug($slug);
    }

    /**
     * Return the template for the given page
     * or the default template if none found
     * @param $page
     * @return string
     */
    private function getTemplateForPage($page)
    {
        return (view()->exists($page->template)) ? $page->template : 'page.default';
    }
    
    private function getTemplateForPost($post)
    {
        return (view()->exists($post->template)) ? $post->template : 'post.default';
    }

    /**
     * Throw a 404 error page if the given page is not found or draft
     * @param $page
     */
    private function throw404IfNotFound($page)
    {
        if (null === $page || $page->status === $this->disabledPage) {
            $this->app->abort('404');
        }
    }

    /**
     * Create a key=>value array for alternate links
     *
     * @param $page
     *
     * @return array
     */
    private function getAlternateMetaData($page)
    {
        $translations = $page->getTranslationsArray();

        $alternate = [];
        foreach ($translations as $locale => $data) {
            $alternate[$locale] = $data['slug'];
        }

        return $alternate;
    }

    /**
     * @param $slug
     * @return \Illuminate\View\View
     */
    public function getCategory($categorySlug, $pageSlug = null)
    {
        $postCategory = $this->findPageCategoryForSlug($categorySlug);

        if ($pageSlug) {
            $page = $this->findPageForSlug($pageSlug);
            $this->throw404IfNotFound($page);
        } else {
            $page = $postCategory;
        }

        $this->throw404IfNotFound($postCategory);

        $currentTranslatedPage = $postCategory->getTranslation(locale());
        if ($categorySlug !== $currentTranslatedPage->slug) {
            return redirect()->to($currentTranslatedPage->locale . '/' . $currentTranslatedPage->slug, 301);
        }

        $template = 'post.default';

        $this->addAlternateUrls($this->getAlternateMetaData($postCategory));

        return view($template, compact('page', 'postCategory'));
    }

    /**
     * Find a post for the given slug.
     * The slug can be a 'composed' slug via the Menu
     * @param string $slug
     * @return Blog
     */
    private function findPageCategoryForSlug($slug)
    {
        return $this->postCategory->findBySlug($slug);
    }
}
