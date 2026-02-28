<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PrestamoStatusUpdated extends Notification
{
    use Queueable;

    public $prestamo;
    public $mensaje;

    /**
     * Create a new notification instance.
     */
    public function __construct($prestamo, $mensaje)
    {
        $this->prestamo = $prestamo;
        $this->mensaje = $mensaje;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'prestamo_id' => $this->prestamo->id,
            'elemento_nombre' => $this->prestamo->elemento->nombre,
            'estado' => $this->prestamo->estado,
            'mensaje' => $this->mensaje,
            'url' => route('user.historial'),
        ];
    }
}
