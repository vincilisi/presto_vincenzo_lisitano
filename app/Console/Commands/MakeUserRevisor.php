<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserRevisor extends Command
{
    /**
     * La signature del comando Artisan (con lo spazio corretto!)
     *
     * @var string
     */
    protected $signature = 'app:make-user-revisor {email}';

    /**
     * La descrizione del comando.
     *
     * @var string
     */
    protected $description = 'Rende un utente revisore';

    /**
     * Esegui il comando.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("Utente con email {$email} non trovato.");
            return;
        }

        $user->is_revisor = true;
        $user->save();

        $this->info("✅ L'utente {$user->name} è ora un revisore!");
    }
}
