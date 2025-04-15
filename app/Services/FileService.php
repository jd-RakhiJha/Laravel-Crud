<?php

namespace App\Services;

use App\Repositories\FileRepository;

class FileService
{
    protected $fileRepository;

    public function __construct(FileRepository $fileRepository)
    {
        $this->fileRepository = $fileRepository;
    }

    public function uploadFile($file, $path = 'uploads', $disk = 'public')
    {
        return $this->fileRepository->upload($file, $path, $disk);
    }
    public function uploadMultipleFiles($files, $path)
    {
        $uploadedFiles = [];
        foreach ($files as $file) {
            $uploadedFiles[] = $this->uploadFile($file);
        }
        return $uploadedFiles;
    }

    public function deleteFile($path, $disk = 'public')
    {
        return $this->fileRepository->delete($path, $disk);
    }
}
