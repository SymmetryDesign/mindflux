<?php

namespace App\Notifications\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AssignedToTask extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The updated task instance.
     *
     * @var \App\Models\Task
     */
    protected $task;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Task $task
     */
    public function __construct($task)
    {
        $this->task = $task;
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
            ->line("A new task [{$this->task->content}] was assigned to you.")
            ->action('Open Project', route('app:projects.show', $this->task->project->uuid));
    }
}
