<?php

namespace App\Http\Controllers\Upload;

use App\Http\Controllers\Controller;
use App\Models\Upload;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class UploadController extends Controller
{
    public function view()
    {
        session()->put('referring_route', request()->route()->getName());
        if (auth()->user()->instance() == "admin" && auth()->user()->dflt == 1) {
            $uploads = Upload::paginate(20);
        } else {
            $uploads = Upload::where('user_id', auth()->user()->id)->where('user_instance', auth()->user()->instance())->paginate(20);
        }
        return view('uploader.upload', compact('uploads'));
    }
    public function action(Request $request)
    {
        $request->validate([
            "action" => 'required|in:upload,fetch,delete'
        ]);
        $action = $request->action;
        switch ($action) {
            case 'upload':
                if (check() && user()->hasPermission('write')) {
                    return $this->create($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Write");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            case 'fetch':
                if (check() && user()->hasPermission('update')) {
                    return $this->fetch($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Update");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            case 'delete':
                if (check() && user()->hasPermission('delete')) {
                    return $this->delete($request);
                } else {
                    ce("Unautorize Permission Access Not Allowed For Delete");
                    return back()->withErrors(["error"], "Unautorize Permission Access Not Allowed");
                }
            default:
                ce("Invalid action");
                return back()->withErrors(['error' => 'Invalid action']);
        }
    }
    protected function create(Request $request)
    {
        $uploadedFiles = "";
        try {
            if (!$request->ajax && !check()) {
                return response()->json(['error' => true, 'message' => 'Unauthorize access'], 403);
            }
            $request->validate([
                'files' => 'required|array|min:1',
                'files.*' => 'file|max:' . setting("max_file_size")
            ], [
                'files.required' => 'At least one file is required.',
                'files.min' => 'At least one file must be uploaded.',
            ]);
            $errors = [];
            // Loop through each file
            foreach ($request->file('files') as $file) {
                // Generate a unique file name
                $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
                // Note: Ensure to sanitize the original name if using it directly
                $existingFile = Upload::where('original_name', $file->getClientOriginalName())->first();
                if ($existingFile) {
                    $errors[] = 'File already exists: ' . $existingFile->original_name;
                    continue;
                }
                $filePath = $file->storeAs('uploads', $fileName, 'public');
                $fileSizeByte = $file->getSize();
                $fileSize = $this->formatFileSize($fileSizeByte);
                $fileExtension = $file->getClientOriginalExtension();
                $originalName = $file->getClientOriginalName();
                $fileType = $this->getFileType($file->getMimeType());
                // Create a new Upload record
                $upload = Upload::create([
                    'original_name' => $originalName,
                    'file_name' => $fileName,
                    'file_size' => $fileSize,
                    'extension' => $fileExtension,
                    'type' => $fileType,
                    'user_id' => $request->user()->id,
                    'user_instance' => user()->instance(),
                    'external_link' => Storage::url($filePath),
                ]);
            }
            if (auth()->user()->instance() == "admin" && auth()->user()->dflt == 1) {
                $uploadedFiles= Upload::all();
            } else {
                $uploadedFiles = Upload::where('user_id', $request->user()->id)
                    ->where('user_instance', auth()->user()->instance())
                    ->get();
            }
            return response()->json([
                'error' => false, // Indicate if there were any errors
                'message' => empty($errors) ? 'Files uploaded successfully' : $errors,
                'data' => $uploadedFiles,
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => true,
                'message' => 'File upload failed: ' . $th->getMessage() ?? $errors,
            ], 200);
        }
    }

    public function fetch(Request $request)
    {
        try {
            // Check if the request is AJAX and user is authorized
            if (!$request->ajax() && !check()) {
                return response()->json(['error' => true, 'message' => 'Unauthorized access'], 403);
            }

            // Retrieve search query and type from the request
            $search = $request->input('query');
            $type = $request->input('type');

            // Start building the query
            $query = Upload::query();
            if ($type) {
                $query->where('type', $type);
            }
            if ($search) {
                switch ($type) {
                    case 'image':
                        $query->where('original_name', 'like', "%$search%");
                        break;
                    case 'video':
                        $query->where('description', 'like', "%$search%"); // Example field for videos
                        break;
                    case 'document':
                        $query->where('document_title', 'like', "%$search%"); // Example field for documents
                        break;
                    // Add more cases as needed
                    default:
                        // If type is not specified or does not match, search in default fields
                        $query->where('original_name', 'like', "%$search%")
                            ->orWhere('type', 'like', "%$search%")
                            ->orWhere('extension', 'like', "%$search%");
                        break;
                }
            }
            if (auth()->user()->instance() == "admin" && auth()->user()->dflt == 1) {
                $uploads = $query->get();
            } else {
                $uploads = $query->where('user_id', auth()->user()->id)->where('user_instance', auth()->user()->instance())
                    ->get();
            }
            return response()->json([
                'files' => $uploads->map(function ($upload) {
                    $upload->external_link = asset($upload->external_link); // Replace with asset URL
                    return $upload;
                })
            ]);


        } catch (\Throwable $th) {
            // Return an error response if something goes wrong
            return response()->json(['error' => true, 'message' => $th->getMessage()]);
        }
    }
    public function delete(Request $request)
    {
        try {
            $fileIds = json_decode($request->input('file'));
            foreach ($fileIds as $id) {
                $file = Upload::find($id);
                if ($file) {
                    $filePath = $file->external_link;
                    if (File::exists(public_path($filePath))) {
                        File::delete(public_path($filePath));
                    }
                    $file->forceDelete();
                }
            }
            return withSuccess('delete');
        } catch (\Throwable $th) {
            ce($th->getMessage());
            return back()->withErrors(['error' => $th->getMessage()]);
        }
    }

    private function getFileType($mimeType)
    {
        if (strpos($mimeType, 'image/') === 0) {
            return 'image';
        } elseif (strpos($mimeType, 'video/') === 0) {
            return 'video';
        } elseif (strpos($mimeType, 'audio/') === 0) {
            return 'audio';
        } elseif (strpos($mimeType, 'application/pdf') === 0) {
            return 'pdf';
        } elseif (strpos($mimeType, 'application/vnd.openxmlformats-officedocument.') === 0) {
            return 'document'; // Handles DOCX and other office formats
        } else {
            return 'other';
        }
    }

    private function formatFileSize($bytes)
    {
        if ($bytes >= 1048576) { // 1 MB = 1048576 bytes
            $size = $bytes / 1048576; // Convert to MB
            $unit = 'MB';
        } elseif ($bytes >= 1024) { // 1 KB = 1024 bytes
            $size = $bytes / 1024; // Convert to KB
            $unit = 'KB';
        } else {
            $size = $bytes; // Bytes
            $unit = 'Bytes';
        }

        // Format the size to 2 decimal places
        $formattedSize = number_format($size, 2);

        return $formattedSize . ' ' . $unit;
    }

}
