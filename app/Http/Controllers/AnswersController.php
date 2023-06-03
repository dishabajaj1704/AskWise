<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnswerRequest;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswersController extends Controller
{
    //

    public function store(CreateAnswerRequest $request, Question $question)
    {
        $question->answers()->create([
            'body' => $request->body,
            'user_id' => auth()->id()
        ]);
        session()->flash('success', 'Answer has been added successfully!');
        return redirect($question->url);
    }

}
