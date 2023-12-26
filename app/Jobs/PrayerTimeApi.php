<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PrayerTimeApi implements ShouldQueue
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
    public function handle(): void
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

        $baseUrl = 'https://api.aladhan.com/v1/calendarByCity';
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;
        foreach ($sehirler as $sehir) {
            $url = "$baseUrl/$currentYear/$currentMonth?city=$sehir&country=turkey&method=13";
            $response = Http::get($url);
            $directoryPath = storage_path("app/responses/prayerTime/$sehir");
            $jsonFilePath = "$directoryPath/$sehir-$currentYear-$currentMonth.json";

            if (!File::isDirectory($directoryPath)) {
                File::makeDirectory($directoryPath, 0755, true, true);
            }
            File::put($jsonFilePath, $response->body());

            if ($response->successful()) {
                Log::info("Namaz Vakitleri $sehir.json dosyasına kaydedildi. Url= $url");
            } else {
                Log::error("Hata: $sehir için API isteği başarısız oldu.Url= $url");
            }
        }
    }
    
}
