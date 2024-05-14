<?php

namespace Modules\Page\Composers;

use Illuminate\Contracts\View\View;
use Modules\Core\Foundation\Theme\ThemeManager;
use Modules\Page\Services\FinderService;

class PostTemplateViewComposer
{
    /**
     * @var ThemeManager
     */
    private $themeManager;

    /**
     * @var FinderService
     */
    private $finder;

    public function __construct(ThemeManager $themeManager, FinderService $finder)
    {
        $this->themeManager = $themeManager;
        $this->finder = $finder;
    }

    public function compose(View $view)
    {
        $view->with('post_templates', $this->getPostTemplates());
    }

    private function getPostTemplates()
    {
        $path = $this->getCurrentThemeBasePath();

        $templates = [];
        foreach ($this->finder->excluding(config('asgard.page.config.template-ignored-directories', []))->allFiles($path . '/views/post') as $template) {
            $relativePath = $template->getRelativePath();

            $templateName = $this->getTemplateName($template);
            $file = $this->removeExtensionsFromFilename($template);

            if ($this->hasSubdirectory($relativePath)) {
                $templates['post.' . str_replace('/', '.', $relativePath) . '.' . $file] = 'post.' . $templateName;
            } else {
                $templates['post.' . $file] = 'post.' . $templateName;
            }
        }

        return $templates;
    }

    /**
     * Get the base path of the current theme.
     *
     * @return string
     */
    private function getCurrentThemeBasePath()
    {
        return $this->themeManager->find(setting('core::template'))->getPath();
    }

    /**
     * Read template name defined in comments.
     *
     * @param $template
     *
     * @return string
     */
    private function getTemplateName($template)
    {
        preg_match("/{{-- Template: (.*) --}}/", $template->getContents(), $templateName);

        if (count($templateName) > 1) {
            return $templateName[1];
        }

        return $this->getDefaultTemplateName($template);
    }

    /**
     * If the template name is not defined in comments, build a default.
     *
     * @param $template
     *
     * @return mixed
     */
    private function getDefaultTemplateName($template)
    {
        $relativePath = $template->getRelativePath();
        $fileName = $this->removeExtensionsFromFilename($template);

        return $this->hasSubdirectory($relativePath) ? $relativePath . '/' . $fileName : $fileName;
    }

    /**
     * Remove the extension from the filename.
     *
     * @param $template
     *
     * @return mixed
     */
    private function removeExtensionsFromFilename($template)
    {
        return str_replace('.blade.php', '', $template->getFilename());
    }

    /**
     * Check if the relative path is not empty (meaning the template is in a directory).
     *
     * @param $relativePath
     *
     * @return bool
     */
    private function hasSubdirectory($relativePath)
    {
        return !empty($relativePath);
    }
}
