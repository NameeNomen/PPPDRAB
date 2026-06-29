<?php

namespace App\Http\Controllers;

use App\Models\RProject;
use Illuminate\Http\Request;

class ProjectPreviewController extends Controller
{
    public function show($id)
    {
        $proyek = RProject::with(['category', 'user', 'attachments'])->findOrFail($id);

        return view('detail', compact('proyek'));
    }
}