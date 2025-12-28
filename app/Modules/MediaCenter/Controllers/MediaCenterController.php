<?php

namespace App\Modules\MediaCenter\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\MediaCenter\Services\MediaCenterService;
use Illuminate\Http\Request;

class MediaCenterController extends Controller
{
    public function __construct(protected MediaCenterService $service) {}

    public function index()
    {
        return $this->service->list();
    }

    public function show($id)
    {
        return $this->service->show($id);
    }
}
