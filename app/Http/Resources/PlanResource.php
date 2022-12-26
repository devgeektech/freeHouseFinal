<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PlanResource extends JsonResource
{
     /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userID= auth('sanctum')->user(); 
         if(isset($userID->id)){
            $user_id= $userID->id;
          }else{
            $user_id= 0;
          }

        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'download_count' => $this->download_plans->count(),
            'plan_specifications' => plan_specifications($this->id),
            'drawing_list' => explode(",",$this->drawing_list),
            'featured_image' => env('APP_URL').'/public'.Storage::url($this->image),
            'pdf' => env('APP_URL').'/public'.Storage::url($this->pdf),
            'gallery_images' => plan_gallery_images($this->id),
            "status" => get_like_unlike($this->id,$user_id),
            'created_at' => $this->created_at->format('Y-m-d H:i:s')
        ];
    }
}
