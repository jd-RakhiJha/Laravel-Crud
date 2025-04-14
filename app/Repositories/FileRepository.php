<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FileRepository
{
    public function upload(UploadedFile $file, string $path = 'uploads', string $disk = 'public'): array
    {
        $fileName = $this->generateUniqueFileName($file);
        $filePath = $file->storeAs($path, $fileName, $disk);

        return $this->buildFileMetadata($file, $filePath, $disk);
    }

    public function delete(string $path, string $disk = 'public'): bool
    {
        return Storage::disk($disk)->exists($path)
            ? Storage::disk($disk)->delete($path)
            : false;
    }

    private function generateUniqueFileName(UploadedFile $file): string
    {
        return time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
    }

    private function buildFileMetadata(UploadedFile $file, string $filePath, string $disk): array
    {
        return [
            'name' => basename($filePath),
            'path' => $filePath,
            'url' => asset("storage/{$filePath}"),
            'size' => $file->getSize(),
            'mime_type' => $file->getMimeType(),
        ];
    }
}
