<?php

namespace App\Logic;

class FileUploadLogic
{
    private $queryData;

    public function __construct($queryData)
    {
        $this->queryData = $queryData;
    }

    // 上传
    public function upload($files, $path = null, $filename = null)
    {
        foreach ($files as $fields => $file) {
            $upFile = $this->move($file, $path, $filename);
            $this->queryData[$fields] = [
                'filename' => $upFile->getFilename(),
                'pathname' => $upFile->getPathname()
            ];
        }
        return $this->queryData;
    }

    // 移动
    private function move($file, $path, $filename = null)
    {
        if (!$file->isValid()) {
            return $file->getError();
        }
        $extension = $file->getClientOriginalExtension();
        // 文件名
        if (!$filename) {
            $filename = uniqid() . '.' . $extension;
        }
        // 保存路径
        if ($path) {
            $newFilePath = $path;
        } else {
            $newFilePath = config('filesystems.disks.upload.root') . DIRECTORY_SEPARATOR;
        }
        // 访问权限
        if (!is_dir($newFilePath)) {
            mkdir($path, 0755);
        } else {
            chmod($newFilePath, 0755);
        }
        $filePath = $file->move($newFilePath, $filename);
        return $filePath;
    }
}