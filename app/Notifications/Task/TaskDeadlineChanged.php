<?php

namespace App\Notifications\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskDeadlineChanged extends Notification implements ShouldQueue
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
        if ($this->task->due_date) {
            $message = "The deadline of task [{$this->task->content}] was changed to [{$this->task->due_date->format('Y-m-d')}].";
        } else {
            $message = "The deadline of task [{$this->task->content}] was set to be open.";
        }

        return (new MailMessage)
            ->line($message)
            ->action('Open Project', route('app:projects.show', $this->task->project->uuid));
    }
}
