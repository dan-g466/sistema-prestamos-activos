<?php

namespace App\Models;
;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Notifications\Messages\MailMessage;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Enviar la notificación de restablecimiento de contraseña.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new class($token) extends ResetPassword {
            public function toMail($notifiable)
            {
                return (new MailMessage)
                    ->subject('Recuperación de Contraseña - Sistema de Préstamos SENA')
                    ->greeting('¡Hola!')
                    ->line('Estás recibiendo este correo porque recibimos una solicitud de restablecimiento de contraseña para tu cuenta.')
                    ->action('Restablecer Contraseña', route('password.reset', ['token' => $this->token, 'email' => $notifiable->getEmailForPasswordReset()], true))
                    ->line('Este enlace de restablecimiento de contraseña expirará en 60 minutos.')
                    ->line('Si no realizaste esta solicitud, no es necesario realizar ninguna otra acción.')
                    ->salutation('Saludos, el equipo del Sistema de Préstamos SENA');
            }
        });
    }

    protected $guard_name = 'web';

    protected $fillable = [
        'name',
        'documento',
        'email',
        'password',
        'telefono',
        'sancionado',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
            'sancionado'        => 'boolean',
        ];
    }

    // Relación: Un usuario puede tener muchos préstamos
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    // Relación: Un usuario puede tener muchas sanciones
    public function sanciones()
    {
        return $this->hasMany(Sancion::class);
    }

    /**
     * Verifica dinámicamente si el usuario tiene una sanción activa por fecha.
     */
    public function estaSancionado(): bool
    {
        return $this->sancionado || $this->sanciones()
            ->where('estado', 'Activa')
            ->where('fecha_fin', '>=', now()->startOfDay())
            ->exists();
    }

    /**
     * Obtiene la sanción activa actual del usuario para mostrar información.
     */
    public function obtenerSancionActiva()
    {
        return $this->sanciones()
            ->where('estado', 'Activa')
            ->where('fecha_fin', '>=', now()->startOfDay())
            ->orderBy('fecha_fin', 'desc')
            ->first();
    }
}