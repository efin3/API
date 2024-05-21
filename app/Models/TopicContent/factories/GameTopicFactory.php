<?php

namespace App\Models\TopicContent\factories;

use DavidBadura\FakerMarkdownGenerator\FakerProvider;
use App\Models\TopicContent\Enums\TextHelperEnum;
use App\Models\TopicContent\GameTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

if (!function_exists('getMDSink')) {
    function getMDSink()
    {
        return TextHelperEnum::MD_SINK_PHRASE;
    }
}

class GameTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = GameTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerProvider($this->faker));
        return [
            //'topic_id' => $this->faker->word,
            'value' => $this->faker->markdown,
        ];
    }
}