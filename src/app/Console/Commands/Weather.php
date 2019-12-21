<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class Weather extends Command
{
    protected $signature = 'command:Weather {city}';

    protected $description = 'Get weather for exist City';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $city = $this->argument('city');
        $url = config('api.weather.url');
        $key = config ('api.weather.key');
        $format = sprintf($url, $city, $key);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$format);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        $result = curl_exec($ch);
        curl_close($ch);
        $decoded = json_decode($result);
        $tempK = $decoded->main->temp;
        $tempC = $tempK-272.15;
        echo 'Текущая температура в '.$city. ' равна: '. $tempC . ' градусов' . PHP_EOL;
    }
}
