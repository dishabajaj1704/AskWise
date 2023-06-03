<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAnswerRequest;
use App\Http\Requests\MarkAsBestRequest;
use App\Http\Requests\UpdateAnswerRequest;
use App\Models\Answer;
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

    // public function destroy(Question $question, Answer $answer)
    // {

    //     $question->answer->delete();
    //     session()->flash('success', 'Answer has been deleted successfully!');
    //     return redirect($question->url);
    // }

    public function update(UpdateAnswerRequest $request, Question $question, Answer $answer)
    {
        $answer->update([
            'body' => $request->body
        ]);

        session()->flash('success', 'Answer has been updated succesfully successfully!');
        return redirect($question->url);
    }

    public function edit(Question $question, Answer $answer)
    {
        $this->authorize('update', $answer);
        return view('answers.edit', compact(['question', 'answer']));

    }

    public function markAsBest(MarkAsBestRequest $request, Question $question, Answer $answer)
    {
        $this->authorize('markAsBest', $question);
        if ($answer->question->id !== $question->id) {
            abort(403); //Inspect
        }
        $question->markAsBest(($answer));
        return redirect()->back();

    }

}
