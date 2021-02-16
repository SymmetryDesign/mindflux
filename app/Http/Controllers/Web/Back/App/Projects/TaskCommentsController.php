<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\Comment;
use Illuminate\Http\Request;
use Plank\Mediable\Media;

class TaskCommentsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
        $this->middleware('plan.limit')->only('store');
    }

    /**
     * Get a listing of all task comments.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $task = Task::where('uuid', $request->task)->firstOrFail();

        $this->authorize('view', $task->column->project);

        return $task->comments->sortByDesc('created_at')->transform(function ($comment) {
            return [
                'uuid'        => $comment->uuid,
                'content'     => $comment->content,
                'pinned_comment'     => $comment->is_pinned,
                'task_id'     => $comment->task_id,
                'created_at'  => $comment->created_at->diffForHumans(),
                'attachments' => $comment->getMedia('attachments')->transform(function ($attachment) {
                    return [
                        'uuid'     => $attachment->uuid,
                        'filename' => $attachment->original_filename,
                        'size'     => $attachment->size,
                    ];
                }),
                'user'        => [
                    'uuid'       => $comment->user->uuid,
                    'name'       => $comment->user->name,
                    'avatar_url' => $comment->user->avatar_url,
                ],
            ];
        })->values();
    }

    /**
     * Store a newly created task comment.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request)
    {
       
        if($request->has('pinned_comment') AND $request->input('comment_uuid') AND $request->input('task_id'))
        {
            Comment::where('task_id',$request->input('task_id'))->update(['is_pinned' => 0]);

            $comment = Comment::where('uuid', $request->comment_uuid)->firstOrFail();

            $comment->is_pinned = $request->input('pinned_comment');
            $comment->save();

            session()->flash('message','Comment Updated');

            return back();

        }
        elseif($request->input('comment_uuid') AND $request->input('content'))
        {
            $comment = Comment::where('uuid', $request->comment_uuid)->firstOrFail();

            $comment->content = $request->input('content');
            $comment->save();

            session()->flash('message','Comment Updated');

            return back();
        }
        else
        {

            $task = Task::where('uuid', $request->task)->firstOrFail();

            $this->authorize('view', $task->column->project);

            $this->validate($request, [
                'content' => 'required',
            ]);

            $comment = $task->comments()->create([
                'content' => $request->input('content'),
                'user_id' => auth()->user()->id,
            ]);

            if (count($request->input('attachments'))) {
                Media::whereIn('uuid', $request->input('attachments'))->each(function ($attachment) use ($comment) {
                    $comment->attachMedia($attachment, 'attachments');
                });
            }

            return back();
        }
    }
    /**
     * Delete the specified task.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Request $request)
    {
        $comment = Comment::where('uuid', $request->comment_uuid)->firstOrFail();

        // $this->authorize('delete', $comment);

        $comment->delete();

        return back();
    }
    // called from projectscontroller
    public function getTaskPinnedComment($task_id)
    {
        return Comment::where('is_pinned',true)->where('task_id',$task_id)->pluck('content')->first();
    }
}
