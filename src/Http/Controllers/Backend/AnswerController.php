<?php

namespace Wepa\Surveys\Http\Controllers\Backend;

use Illuminate\Http\Request;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Surveys\Models\Answer;
use Wepa\Surveys\Models\QuestionAnswer;

class AnswerController extends InertiaController
{
    public function store(Request $request): void
    {
        $answer = Answer::create($request->all());
        $data = ['answer_id' => $answer->id, 'question_id' => $request->questionId, 'votes' => []];
        QuestionAnswer::create($data);
    }

    public function update(Request $request, Answer $answer): void
    {
        $answer->update($request->all());
    }

    public function destroy(Answer $answer): void
    {
        $answer->delete();
    }
}
