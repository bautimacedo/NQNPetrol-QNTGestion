<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class FetchWeatherData extends Command
{
    protected $signature = 'app:fetch-weather-data';
    protected $description = 'Obtiene el clima de Neuquén desde OpenWeatherMap';

    public function handle()
    {
        // Usamos los datos de tu imagen de n8n
        $lat = -39.01;
        $lon = -67.88;
        $apiKey = env('OPENWEATHER_API_KEY');

        $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
            'lat' => $lat,
            'lon' => $lon,
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'es'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            
            // Guardamos en Cache por 35 min (un poco más que la frecuencia del scheduler)
            Cache::put('weather_data', [
                'temp' => $data['main']['temp'],
                'wind' => $data['wind']['speed'],
                'gust' => $data['wind']['gust'] ?? 0,
                'condition' => $data['weather'][0]['description'],
                'icon' => $data['weather'][0]['icon'],
                'last_update' => now()->format('H:i')
            ], 2100);

            $this->info('Clima actualizado: ' . $data['main']['temp'] . '°C');
        } else {
            $this->error('Error al conectar con la API de Clima');
        }
    }
}