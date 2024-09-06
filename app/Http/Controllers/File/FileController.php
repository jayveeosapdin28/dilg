<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\TemporaryFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $folder = uniqid() . '-' . now()->timestamp;
            $path = 'files/tmp/'.$user_id.'/' . $folder.'/'.$filename;
            Storage::put($path,  file_get_contents($file));

            TemporaryFile::create([
                'user_id' => $user_id,
                'filename' => $filename,
                'folder' => $folder,
            ]);

            return $folder;

        }
        return '';
    }
}
