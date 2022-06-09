<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageCropperController extends Controller
{
    public function index()
    {
        return view('backend.image_cropper.index');
    }
}
