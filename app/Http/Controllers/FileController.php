<?php

namespace App\Http\Controllers;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class FileController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        // $files = Auth::user()->files()->latest()->get();
        $files = Auth::user()
        ->files()
        ->latest()
        ->paginate(12); // paginate 12 per page
        return view('files.index', compact('files'));
    }

    public function view(File $file)
    {
        // Only the file owner can view it
        abort_unless(Auth::id() === $file->user_id, 403);

        $url = Storage::disk('s3')->temporaryUrl($file->s3_path, now()->addMinutes(5));
        return redirect($url);
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'max:10240'], // 10MB
        ]);

        $user = Auth::user();
        $uploaded = $request->file('file');
        $path = $uploaded->store("uploads/{$user->id}", 's3');

        $file = File::create([
            'user_id' => $user->id,
            'original_name' => $uploaded->getClientOriginalName(),
            's3_path' => $path,
            'mime_type' => $uploaded->getMimeType(),
            'size' => $uploaded->getSize(),
        ]);

        return redirect()->back()->with('success', 'File uploaded successfully!');
    }

    public function download(File $file)
    {
        $this->authorize('view', $file); // Optional if using policies

        $url = Storage::disk('s3')->temporaryUrl($file->s3_path, now()->addMinutes(10));
        return redirect($url);
    }
}
