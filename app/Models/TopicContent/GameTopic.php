<?php

namespace App\Models\TopicContent;

use EscolaLms\TopicTypes\Events\TopicTypeChanged;
use EscolaLms\TopicTypes\Facades\Markdown;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use EscolaLms\TopicTypes\Models\TopicContent\AbstractTopicContent;

/**
 * @OA\Schema(
 *      schema="TopicGameTopic",
 *      required={"value"},
 *      @OA\Property(
 *          property="id",
 *          description="id",
 *          @OA\Schema(
 *             type="integer",
 *         )
 *      ),
 *      @OA\Property(
 *          property="value",
 *          description="value",
 *          type="string"
 *      ),
 *      @OA\Property(
 *          property="length",
 *          description="length",
 *          type="integer"
 *      ),
 * )
 */
class GameTopic extends AbstractTopicContent
{
    use HasFactory;

    public $table = 'topic_game';

    public static function rules(): array
    {
        return [
            'value' => ['required', 'string'],
        ];
    }

    protected static function newFactory()
    {
        return App\Models\TopicContent\factories\GameTopicFactory::new();
    }

    public function fixAssetPaths(): array
    {
        $topic = $this->topic;
        $course = $topic->lesson->course;
        $destinationPrefix = sprintf('course/%d/topic/%d/', $course->id, $topic->id);

        $result = Markdown::convertAssetPaths($this->value, $destinationPrefix);

        if ($result['value'] !== $this->value) {
            $this->value = $result['value'];
            $this->save();
        }

        return $result['results'];
    }

    public function processMetadataInfo(): void
    {
        $this->length = strlen($this->value);
    }

    protected static function booted(): void
    {
        parent::booted();
        static::saving(function (GameTopic $topic) {
            $topic->length = strlen($topic->value);
        });
    }

    public function getMorphClass()
    {
        return self::class;
    }
}
