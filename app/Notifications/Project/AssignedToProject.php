<?php

namespace App\Notifications\Project;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignedToProject extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The assigned project instance.
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
        return (new MailMessage)
            ->line("You have been assigned to a new project [{$this->project->name}]")
            ->action('Open Project', route('app:projects.show', $this->project->uuid));
    }
}
