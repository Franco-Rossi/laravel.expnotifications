<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail;
use App\Provider;
use Illuminate\Support\Carbon;

class CheckExpiration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:checkexpiration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Revisa los certificados prontos a vencer y envia mail de notificacion si cumple con las condiciones.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $NOTIFICATION_DAY = 20;
        $NOTIFICATION_MARGIN = 5;
        $day = $NOTIFICATION_DAY;

        while ($day >= 0) {
            $days[] = $day;
            $day -= $NOTIFICATION_MARGIN;
        }

        foreach($days as $notificationDays){
            $expiratedProviders[] = Provider::whereDate('fecha_hasta', '=', Carbon::now()->addDays($notificationDays))->get();
        }


        foreach ($expiratedProviders as $providers){
                foreach($providers as $provider){
                // Mail::to($provider->email->send(new ExpirationNotification($provider));
                echo "Mail enviado a " . $provider->id_proveedor . "\n";
            }
        };

    }
}
