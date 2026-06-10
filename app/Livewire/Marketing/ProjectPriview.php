<?php

namespace App\Http\Controllers;

use App\Models\RProject;
use Illuminate\Http\Request;

class ProjectPreviewController extends Controller
{
    public function show($id)
    {
        // Pakai 'with' buat narik relasi sekalian. Ini yang bikin gambarmu nanti muncul.
        $proyek = RProject::with(['category', 'user', 'attachments'])->findOrFail($id);

        return view('detail', compact('proyek'));
    }
}