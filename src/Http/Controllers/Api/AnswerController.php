<?php

namespace Wepa\Surveys\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Wepa\Surveys\Http\Resources\QuestionResource;
use Wepa\Surveys\Models\Answer;
use Wepa\Surveys\Models\QuestionAnswer;

class AnswerController extends Controller
{
    public function vote(Request $request, Answer $answer)
    {
        $voted = false;
        $questionsAnswers = QuestionAnswer::where('question_id', $answer->question->id)->get();
        $clientIp = request()->server('HTTP_DO_CONNECTING_IP', request()->ip());

        foreach ($questionsAnswers as $questionAnswer) {
            $votes = collect($questionAnswer->votes);
            if ($votes->contains('ip', $clientIp)) {
                $voted = true;
                break;
            }
        }

        if (! $voted) {
            $answer->questionAnswer->votes = $votes->merge([['ip' => $clientIp]])->toArray();
            $answer->questionAnswer->save();
        }

        return QuestionResource::make($answer->question);
    }
}
