<?php

namespace Wepa\Surveys\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Wepa\Surveys\Http\Resources\QuestionResource;
use Wepa\Surveys\Models\Question;

class QuestionController extends Controller
{
    /**
     * @return QuestionResource
     */
    public function withTag(string $tag)
    {
        if ($question = Question::where('tag', $tag)->first()) {
            return QuestionResource::make($question);
        }

        return null;
    }
}
