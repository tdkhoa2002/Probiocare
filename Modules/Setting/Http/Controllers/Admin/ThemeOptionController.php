<?php

namespace Modules\Setting\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Setting\Entities\ThemeOption;
use Modules\Setting\Http\Requests\CreateThemeOptionRequest;
use Modules\Setting\Http\Requests\UpdateThemeOptionRequest;
use Modules\Setting\Repositories\ThemeOptionRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class ThemeOptionController extends AdminBaseController
{
    /**
     * @var ThemeOptionRepository
     */
    private $themeoption;
    public function __construct(ThemeOptionRepository $themeoption)
    {
        parent::__construct();

        $this->themeoption = $themeoption;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $theme =  setting('core::template', null, 'Cryperr');
        $defaultThemeOptions = $this->themeoption->getAllConfigThemeOptions();
        $dbThemeOptions = $this->themeoption->savedThemeOptions($theme);
        return view('setting::admin.themeoptions.index', compact('defaultThemeOptions', 'theme', 'dbThemeOptions'));
    }


    public function store(CreateThemeOptionRequest $request)
    {
        $this->themeoption->createOrUpdate($request->all());

        return redirect()->route('admin.themeoption.themeoptions.index')
            ->withSuccess(trans('core::core.messages.resource created', ['name' => trans('setting::themeoptions.title.themeoptions')]));
    }
}
