<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use EscolaLms\Courses\Facades\Topic;
use App\Models\TopicContent\GameTopic;
use App\Http\Resources\TopicType\Client\GameResource as ClientGameResource;
use App\Http\Resources\TopicType\Admin\GameResource as AdminGameResource;
use App\Http\Resources\TopicType\Export\GameResource as ExportGameResource;


class GameTopicRegisterProvider extends ServiceProvider
{
    public function register()
    {
        Topic::registerContentClass(GameTopic::class);

        Topic::registerResourceClasses(GameTopic::class, [
            'client' => ClientGameResource::class,
            'admin' => AdminGameResource::class,
            'export' => ExportGameResource::class,
        ]);
    }
}