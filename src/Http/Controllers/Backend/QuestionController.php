<?php

namespace Wepa\Surveys\Http\Controllers\Backend;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Response;
use Wepa\Core\Http\Controllers\Backend\InertiaController;
use Wepa\Surveys\Http\Requests\QuestionRequest;
use Wepa\Surveys\Http\Resources\QuestionIndexResource;
use Wepa\Surveys\Http\Resources\QuestionResource;
use Wepa\Surveys\Models\Question;

class QuestionController extends InertiaController
{
    public string $packageName = 'surveys';

    public function index(Request $request): Response
    {
        $questions = QuestionIndexResource::collection(Question::when($request->search, function ($query, $search) {
            $query->where('question', 'like', '%'.$search.'%');
        })->paginate());

        return $this->render('Vendor/Surveys/Backend/Question/Index', ['survey', 'question'], compact(['questions']));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return $this->render('Vendor/Surveys/Backend/Question/Create', ['survey', 'question']);
    }

    public function store(QuestionRequest $request): RedirectResponse
    {
        $question = Question::create($request->all());

        return redirect()->route('admin.surveys.questions.edit', ['question' => $question->id]);
    }

    /**
     * @return Response
     */
    public function edit(Question $question)
    {
        $question = QuestionResource::make($question);

        return $this->render('Vendor/Surveys/Backend/Question/Edit', ['survey', 'question'], compact(['question']));
    }

    public function status(Request $request, Question $question)
    {
        $question->update($request->all());
    }

    public function update(Request $request, Question $question): RedirectResponse
    {
        $question->update($request->all());

        return redirect()->route('admin.surveys.questions.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question): void
    {
        $question->delete();
    }
}
