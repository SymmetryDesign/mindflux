<?php

namespace App\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ProjectTimelineChanged extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The updated project instance.
     *
     * @var \App\Models\Project
     */
    protected $project;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Project $project
     */
    public function __construct($project)
    {
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
        if ($this->project->timeline === null) {
            $message = "The timeline of the project [{$this->project->name}] was set to be open.";
        } else {
            $message = "The timeline of the project [{$this->project->name}] is changed to start from {$this->project->timeline}.";
        }

        return (new MailMessage)
            ->line($message)
            ->action('Open Project', route('app:projects.show', $this->project->uuid));
    }
}
