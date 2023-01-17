<?php

namespace App\Http\Controllers;

use App\Helpers\NumberSanitizer;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected NumberSanitizer $numberSanitizer;

    public function __construct(NumberSanitizer $numberSanitizer)
    {
        $this->numberSanitizer = $numberSanitizer;
    }
}
