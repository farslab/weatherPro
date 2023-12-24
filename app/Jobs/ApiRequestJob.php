<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Log;

class ApiRequestJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle() : void
    {
        $this->apiRequest();
    }
    public function apiRequest()
    {
        $sehirler = ['adana', 'adiyaman', 'afyonkarahisar', 'agri', 'amasya', 'ankara', 'antalya', 'artvin', 
        'aydin', 'balikesir', 'bilecik', 'bingol', 'bitlis', 'bolu', 'burdur', 'bursa', 'canakkale', 'cankiri', 
        'corum', 'denizli', 'diyarbakir', 'edirne', 'elazig', 'erzincan', 'erzurum', 'eskisehir', 'gaziantep', 
        'giresun', 'gumushane', 'hakkari', 'hatay', 'isparta', 'mersin', 'istanbul', 'izmir', 'kars', 'kastamonu',
        'kayseri', 'kirklareli', 'kirsehir', 'kocaeli', 'konya', 'kutahya', 'malatya', 'manisa', 'kahramanmaras', 
        'mardin', 'mugla', 'mus', 'nevsehir', 'nigde', 'ordu', 'rize', 'sakarya', 'samsun', 'siirt', 'sinop', 
        'sivas', 'tekirdag', 'tokat', 'trabzon', 'tunceli', 'sanliurfa', 'usak', 'van', 'yozgat', 'zonguldak', 
        'aksaray', 'bayburt', 'karaman', 'kirikkale', 'batman', 'sirnak', 'bartin', 'ardahan', 'igdir', 'yalova',
        'karabuk', 'kilis', 'osmaniye', 'duzce'];

        $apiKey = '42b55a2e45d54585be7202904232012';
        $baseUrl = 'http://api.worldweatheronline.com/premium/v1/weather.ashx';

        foreach ($sehirler as $sehir) {
            $url = "$baseUrl?key=$apiKey&q=$sehir,turkey&format=json&num_of_days=11&showlocaltime=yes&lang=tr";
            $response = Http::get($url);

            if ($response->successful()) {
                $jsonFilePath = storage_path("app/responses/$sehir.json");
                File::put($jsonFilePath, $response->body());
                Log::info("Cevap $sehir.json dosyasına kaydedildi.");
            } else {
                Log::error("Hata: $sehir için API isteği başarısız oldu.");
            }
        }
    }
}
