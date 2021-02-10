<?php

namespace App\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TeamMemberJoined extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The updated project instance.
     *
     * @var \App\Models\Project
     */
    protected $project;

    /**
     * Collection the new assigned users.
     *
     * @var \Illuminate\Support\Collection
     */
    protected $users;

    /**
     * Create a new notification instance.
     *
     * @param \Illuminate\Support\Collection $users
     * @param \App\Models\Project $project
     */
    public function __construct($users, $project)
    {
        $this->users = $users;
        $this->project = $project;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        if ($this->users->count() > 1) {
            $message = "New team members [{$this->users->implode('name', ', ')}] joined your project [{$this->project->name}]";
        } else {
            $message = "New team member [{$this->users->first()->name}] joined your project [{$this->project->name}]";
        }

        return (new MailMessage)
            ->line($message)
            ->action('Open Project', route('app:projects.show', $this->project->uuid));
    }
}
