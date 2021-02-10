<?php

namespace App\Http\Controllers\Web\Back\App\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Inertia\Inertia;

class EmailNotificationsController extends Controller
{
    /**
     * Show edit email notifications page.
     *
     * @return \Inertia\Response
     */
    public function edit()
    {
        $preferences = auth()->user()->preferences()->all();

        return Inertia::render('back/app/account/email-notifications/edit', [
            'assigned_to_project'          => Arr::get($preferences, 'email_notifications.assigned_to_project', false),
            'project_status_changed'       => Arr::get($preferences, 'email_notifications.project_status_changed', false),
            'team_member_joined_project'   => Arr::get($preferences, 'email_notifications.team_member_joined_project', false),
            'project_timeline_changed'     => Arr::get($preferences, 'email_notifications.project_timeline_changed', false),
            'task_assigned_to_you'         => Arr::get($preferences, 'email_notifications.task_assigned_to_you', false),
            'task_assigned_to_team_member' => Arr::get($preferences, 'email_notifications.task_assigned_to_team_member', false),
            'task_phase_changed'           => Arr::get($preferences, 'email_notifications.task_phase_changed', false),
            'task_status_changed'          => Arr::get($preferences, 'email_notifications.task_status_changed', false),
            'task_deadline_changed'        => Arr::get($preferences, 'email_notifications.task_deadline_changed', false),
        ]);
    }

    /**
     * Update email notifications settings.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        auth()->user()->preferences()->set([
            'email_notifications.assigned_to_project'          => $request->input('assigned_to_project'),
            'email_notifications.project_status_changed'       => $request->input('project_status_changed'),
            'email_notifications.team_member_joined_project'   => $request->input('team_member_joined_project'),
            'email_notifications.project_timeline_changed'     => $request->input('project_timeline_changed'),
            'email_notifications.task_assigned_to_you'         => $request->input('task_assigned_to_you'),
            'email_notifications.task_assigned_to_team_member' => $request->input('task_assigned_to_team_member'),
            'email_notifications.task_phase_changed'           => $request->input('task_phase_changed'),
            'email_notifications.task_status_changed'          => $request->input('task_status_changed'),
            'email_notifications.task_deadline_changed'        => $request->input('task_deadline_changed'),
        ]);

        session()->flash('message', __('app.messages.email-notifications-updated'));

        return back();
    }
}
