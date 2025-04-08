<x-app-layout>
    <x-slot name="header">
        <!-- Optional header -->
    </x-slot>

    <div class="max-w-5xl mx-auto mt-10">
        <h2 class="text-2xl font-bold mb-4">Upload a File</h2>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('files.store') }}" method="POST" enctype="multipart/form-data" class="mb-6">
            @csrf
            <input type="file" name="file" class="border p-2 w-full mb-2">
            @error('file')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Upload
            </button>
        </form>

        <h3 class="text-xl font-semibold mb-4">Your Uploaded Files</h3>

        @if($files->count())
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
                @foreach ($files as $file)
                    <div class="border rounded p-3 shadow-sm bg-white">
                        @if(Str::startsWith($file->mime_type, 'image'))
                            <img 
                                src="{{ Storage::disk('s3')->temporaryUrl($file->s3_path, now()->addMinutes(10)) }}" 
                                alt="{{ $file->original_name }}" 
                                class="w-full h-32 object-cover rounded mb-2"
                            >
                        @else
                            <div class="h-32 flex items-center justify-center bg-gray-100 rounded mb-2">
                                <p class="text-sm text-gray-600">[{{ $file->mime_type }}]</p>
                            </div>
                        @endif

                        <div class="text-sm">
                            <strong class="block truncate">{{ $file->original_name }}</strong>
                            <span class="text-gray-600">{{ number_format($file->size / 1024, 2) }} KB</span>
                        </div>

                        <div class="flex items-center gap-4 mt-2">
                            <!-- View button -->
                            <a href="{{ route('files.view', $file) }}" 
                               class="text-gray-700 hover:text-black flex items-center text-sm"
                               title="View" target="_blank">
                                <!-- Eye icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0zm-9.354 0a9.003 9.003 0 0116.708 0 9.003 9.003 0 01-16.708 0z"/>
                                </svg>
                                View
                            </a>

                            <!-- Download button -->
                            <a href="{{ route('files.download', $file) }}" 
                               class="text-blue-600 hover:text-blue-800 flex items-center text-sm"
                               title="Download" target="_blank">
                                <!-- Download icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-1" fill="none"
                                     viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3m0-9h-6a2 2 0 00-2 2v4h10V6a2 2 0 00-2-2z"/>
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mb-4">
                {{ $files->links() }}
            </div>
        @else
            <p class="text-gray-600">No files uploaded yet.</p>
        @endif
    </div>
</x-app-layout>