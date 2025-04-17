<?php

namespace App\Http\Controllers;

use App\Services\FileService;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\DeleteFileRequest;
use App\Http\Requests\UploadMultipleFilesRequest;

class FileController extends Controller
{
    protected $fileService;

    public function __construct(FileService $fileService)
    {
        $this->fileService = $fileService;
    }

    /**
     * Upload a file
     */
    public function upload(UploadFileRequest $request)
    {
        $file = $request->file('file');
        $path = $request->input('path', 'uploads');

        $uploadedFile = $this->fileService->uploadFile($file, $path);

        return response()->json([
            'success' => true,
            'message' => 'File uploaded successfully',
            'data' => $uploadedFile
        ], 201);
    }

    public function uploadMultiple(UploadMultipleFilesRequest $request)
    {
        $files = $request->file('files');
        $path = $request->input('path', 'uploads');

        $uploadedFiles = $this->fileService->uploadMultipleFiles($files, $path);

        return response()->json([
            'success' => true,
            'message' => count($uploadedFiles) . ' files uploaded successfully',
            'data' => $uploadedFiles
        ], 201);
    }

    /**
     * Delete a file
     */
    public function delete(DeleteFileRequest $request)
    {
        $deleted = $this->fileService->deleteFile($request->path);

        return response()->json([
            'success' => $deleted,
            'message' => $deleted ? 'File deleted successfully' : 'File not found or already deleted'
        ]);
    }
}
