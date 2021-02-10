<?php

namespace App\Notifications\Task;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssignedToTeamMember extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The updated task instance.
     *
     * @var \App\Models\Task
     */
    protected $task;

    /**
     * The assigned task user.
     *
     * @var \App\Models\User
     */
    protected $user;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\Task $task
     * @param \App\Models\User $user
     */
    public function __construct($task, $user)
    {
        $this->task = $task;
        $this->user = $user;
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
            ->line("Task [{$this->task->content}] was assigned to your team member [{$this->user->name}]")
            ->action('Open Project', route('app:projects.show', $this->task->project->uuid));
    }
}
