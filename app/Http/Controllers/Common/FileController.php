<?php

namespace App\Http\Controllers\Common;

use App\Contracts\File;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FileController extends CommonController
{
    /**
     * 上传文件
     * @param Request $request
     * @param File $upload 上传工具类
     * @return JsonResponse
     */
    public function upload(Request $request, File $upload)
    {
        $file = $request->file('file');

        $file_id = $upload->upload($file);
        if($file_id)
            return $this->returnSuccessJsonResponse([
                'file_id' => $file_id,
            ]);
        else
            return $this->returnFailedJsonResponse($file->getError() == 0 ? trans('request.upload failed') : $file->getErrorMessage());
    }
}
