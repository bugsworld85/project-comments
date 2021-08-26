<?php

namespace App\Http\Controllers;

use App\Http\Resources\DefaultResource;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $comments = Comment::whereNull('parent_id')
            ->orderBy('created_at', 'DESC')
            ->get();

        return DefaultResource::collection($comments)->additional([
            'meta' => [
                'total' => Comment::count(),
            ],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:191',
            'message' => 'required|max:6000',
            'parent_id' => 'nullable',
        ], [
            'name.required' => 'you must enter your name',
            'message.required' => 'we require your message'
        ]);

        if ($validator->fails()) {
            return abort(422, 'Oops! ' . str_replace('.', '', ucfirst(implode(' and ', $validator->errors()->all()))) . '.');
        }

        $comment = Comment::create($request->all());

        return response()->json([
            'comment' => $comment
        ]);
    }
}
