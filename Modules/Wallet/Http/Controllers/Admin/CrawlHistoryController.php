<?php

namespace Modules\Wallet\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Wallet\Entities\CrawlHistory;
use Modules\Wallet\Http\Requests\CreateCrawlHistoryRequest;
use Modules\Wallet\Http\Requests\UpdateCrawlHistoryRequest;
use Modules\Wallet\Repositories\CrawlHistoryRepository;
use Modules\Core\Http\Controllers\Admin\AdminBaseController;

class CrawlHistoryController extends AdminBaseController
{
    /**
     * @var CrawlHistoryRepository
     */
    private $crawlhistory;

    public function __construct(CrawlHistoryRepository $crawlhistory)
    {
        parent::__construct();

        $this->crawlhistory = $crawlhistory;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('wallet::admin.crawlhistories.index');
    }

   }
