<?php

namespace App\Tools;

use App\Contracts\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\File as FileModel;

class Upload implements File
{
    protected $disk;
    protected $file;

    public function __construct(FileModel $file)
    {
        $this->file = $file;
        $this->disk = config('filesystems.default');
    }

    /**
     * 文件上传
     * @param $handle
     * @param $disk
     */
    public function upload($handle, $disk = '')
    {
        // 选择存储磁盘
        if($disk) {
            $this->disk = $disk;
        }

        // 按年月/日分隔文件夹
        $dir = date('Ym') . DIRECTORY_SEPARATOR . date('d');

        // 上传成功
        if($path = Storage::disk($this->disk)->putFile($dir, $handle)) {
            $this->file->name = $handle->getClientOriginalName();
            $this->file->path = $path;
            $this->file->disk = $this->disk;
            $this->file->user_id = Auth::user()->getAuthIdentifier();
            if($this->file->save())
                return $this->file->id;
            else {
                @Storage::disk($this->disk)->delete($path);
                return false;
            }
        } else
            return false;
    }

    /**
     * 文件下载
     * @param $file
     * @param $disk
     */
    public function download($file, $disk)
    {
        return '123';
    }
}
