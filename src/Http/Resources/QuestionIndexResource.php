<?php

namespace Wepa\Surveys\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionIndexResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'tag' => $this->tag,
            'answers_count' => count($this->answers),
            'votes_count' => $this->votesCount(),
            'status' => $this->status === 1,
        ];
    }

    private function votesCount(): int
    {
        $votes = 0;
        foreach ($this->questionsAnswers as $qa) {
            if ($qa->votes) {
                $votes = $votes + count($qa->votes);
            }
        }

        return $votes;
    }
}
