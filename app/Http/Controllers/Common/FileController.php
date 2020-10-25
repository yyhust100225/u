<?php

namespace App\Http\Controllers\Common;

use App\Contracts\File as FileContract;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\File as FileModel;
use Illuminate\Support\Facades\DB;

class FileController extends CommonController
{
    /**
     * 上传文件
     * @param Request $request
     * @param FileContract $file_tool 上传工具类
     * @return JsonResponse
     */
    public function upload(Request $request, FileContract $file_tool)
    {
        $resource = $request->file('file');

        $file_id = $file_tool->upload($resource);
        if($file_id)
            return $this->returnSuccessJsonResponse([
                'file_id' => $file_id,
                'file_name' => $resource->getClientOriginalName(),
            ]);
        else
            return $this->returnFailedJsonResponse($resource->getError() == 0 ? trans('request.upload failed') : $resource->getErrorMessage());
    }

    /**
     * wangEditor 富文本编辑器上传图片接口
     * @param Request $request
     * @param FileContract $file_tool 上传工具类
     * @param FileModel $file
     * @return JsonResponse
     */
    public function uploadEditorImage(Request $request, FileContract $file_tool, FileModel $file)
    {
        $resources = $request->allFiles();

        $image_urls = [];
        try {
            DB::transaction(function() use($resources, $file_tool, $file, &$image_urls){
                // 多图片上传
                foreach($resources as $resource) {
                    // 上传成功后返回资源ID
                    $file_id = $file_tool->upload($resource);
                    // 获取资源访问url
                    $image_urls[] = $file->newQuery()->find($file_id)->resourceUrl();
                }
            });
        } catch (\Throwable $e) {
            return $this->returnFailedJsonResponse($e->getMessage());
        }

        return response()->json([
            'errno' => 0,
            'data' => $image_urls,
        ], 200);
    }
}
