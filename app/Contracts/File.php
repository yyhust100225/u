<?php

namespace App\Contracts;

use http\Client\Response;


/**
 * 程序文件操作接口契约
 * Interface File
 * @package App\Contracts
 */
interface File
{
    /**
     * 文件上传
     * @param $file
     * @param $disk
     * @return integer|boolean 返回存储文件ID
     */
    public function upload($file, $disk = '');

    /**
     * 文件下载
     * @param $file
     * @param $disk
     */
    public function download($file, $disk);
}
