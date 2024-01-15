<?php

namespace Wepa\Surveys\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Wepa\Surveys\Models\QuestionAnswer;

class QuestionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'question' => $this->question,
            'tag' => $this->tag,
            'answers' => $this->formatAnswers(),
            'votes_count' => $this->votesCount(),
            'status' => $this->status === 1,
            'voted' => $this->voted(),
        ];
    }

    private function formatAnswers()
    {
        $answers = [];
        foreach ($this->answers as $answer) {
            $answers[] = [
                'id' => $answer->id,
                'answer' => $answer->answer,
                'percent' => $answer->questionAnswer->votes
                    ? round(((100 * count($answer->questionAnswer->votes)) / $this->votesCount()) * 100) / 100 .'%'
                    : 0,
            ];
        }

        return $answers;
    }

    public function voted()
    {
        $voted = false;
        $questionsAnswers = QuestionAnswer::where('question_id', $this->id)->get();

        foreach ($questionsAnswers as $questionAnswer) {
            $votes = collect($questionAnswer->votes);
            if ($votes->contains('ip', request()->ip())) {
                $voted = true;
                break;
            }
        }

        return $voted;
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
