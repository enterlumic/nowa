<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Horario;

class CreateDefaultHorarios
{
    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handle(Registered $event)
    {
        $userId = $event->user->id;

        $horarios = [
            ['user_id' => $userId, 'dia' => 'Lunes', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Martes', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Miércoles', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Jueves', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Viernes', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Sábado', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 0],
            ['user_id' => $userId, 'dia' => 'Domingo', 'abre_a' => '09:00:00', 'cierra_a' => '18:00:00', 'cerrada' => 1],
        ];

        foreach ($horarios as $horario) {
            Horario::create($horario);
        }
    }
}
