<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $teachers = $this->teachers;
        $teacher_infos = [];
        foreach($teachers as $teacher) {
            $teacher_infos[] = trans('message.table.teacher_course_fee', [
                'teacher' => $teacher->name,
                'level' => $teacher->course_fee->name,
                'fee' => $teacher->course_fee->fee,
            ]);
        }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'teachers' => implode(',', $teacher_infos),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
