<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LocDistrict extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title_en' => $this->title_en,
            'title' => $this->title,
            'bbs_code' => $this->bbs_code
        ];
    }
}
