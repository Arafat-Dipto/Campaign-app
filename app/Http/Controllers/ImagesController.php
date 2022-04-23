<?php

namespace App\Http\Controllers;

use League\Glide\Server;
use App\Http\Controllers\Backend\Controller;

class ImagesController extends Controller
{
    public function show(Server $glide)
    {
        return $glide->fromRequest()->response();
    }
}
