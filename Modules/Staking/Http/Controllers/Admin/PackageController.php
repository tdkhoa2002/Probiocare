<?php

namespace Modules\Staking\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Staking\Entities\Package;
use Modules\Staking\Http\Requests\CreatePackageRequest;
use Modules\Staking\Http\Requests\UpdatePackageRequest;
use Modules\Staking\Repositories\PackageRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class PackageController extends AdminBaseController
{
    /**
     * @var PackageRepository
     */
    private $package;

    public function __construct(PackageRepository $package)
    {
        parent::__construct();

        $this->package = $package;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('staking::admin.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('staking::admin.packages.create');
    }

    
    public function edit(Package $package)
    {
        return view('staking::admin.packages.edit', compact('package'));
    }
}
