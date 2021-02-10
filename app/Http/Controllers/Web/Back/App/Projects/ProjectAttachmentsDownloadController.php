<?php

namespace App\Http\Controllers\Web\Back\App\Projects;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Plank\Mediable\Media;

class ProjectAttachmentsDownloadController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('tenant.user');
    }

    /**
     * Download attachment file.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function get(Request $request)
    {
        $project = Project::where('uuid', $request->project)->firstOrFail();

        $this->authorize('view', $project);

        $attachment = Media::where('uuid', $request->attachment)->firstOrFail();

        return response()->download(
            $attachment->getAbsolutePath(),
            $attachment->original_filename
        );
    }
}
