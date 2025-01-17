<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DB;
use Mail;
use App\Mail\MailNotify;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function(){

            $curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "https://api.ipify.org/?format=json");
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                $response = curl_exec($curl);
                curl_close($curl);
                $response = json_decode($response);
                var_dump($response->ip);
                //error_log(print_r($response->ip, true));
                $data = array(
                    'ip' => $response->ip,
                    'fecha' => date('Y-m-d H:i:s')
                );

            //DB::table('a')->insert(['codigo_a' => "ip", "categoria_a" => $response->ip]);
            Mail::send('emails.ipsender', $data, function ($message) use($response) {
                $message->from('bluemix.informatica@gmail.com', 'Bluemix SPA.');
                $message->to('informatica@bluemix.cl')->subject('IP Púbica');
            });

        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
