<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Question;

class QuestionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'])->only(['create', 'store']);
    }
    public function index()
    {
        $questions = Question::with('owner')->latest()->paginate(10);
        return view('questions.index', compact(['questions']));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(CreateQuestionRequest $request)
    {
        auth()->user()->questions()->create([
            'title' => $request->title,
            'body' => $request->body
        ]);

        session()->flash('success', 'Question has been added successfully!');
        return redirect(route('questions.index'));
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact([
            'question'
        ]));
    }

    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        session()->flash('success', 'Question has been updated successfully!');
        return redirect(route('questions.index'));
    }
}
