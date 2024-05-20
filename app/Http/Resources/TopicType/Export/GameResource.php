<?php

namespace App\Http\Resources\TopicType\Export;

use EscolaLms\TopicTypes\Facades\Markdown;
use EscolaLms\TopicTypes\Facades\Path;
use EscolaLms\TopicTypes\Http\Resources\TopicType\Contacts\TopicTypeResourceContract;
use Illuminate\Http\Resources\Json\JsonResource;

class GameResource extends JsonResource implements TopicTypeResourceContract
{
    public function toArray($request)
    {
        return [
            'value' => Path::sanitizePathForExport(Markdown::getImagesPathsWithoutImageApi($this->value)),
            'asset_folder' => $this->topic->getKey(),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}