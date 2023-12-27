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
        $sehirler = [
            'Adana', 'Adıyaman', 'Afyonkarahisar', 'Ağrı', 'Amasya', 'Ankara', 'Antalya', 'Artvin',
            'Aydın', 'Balıkesir', 'Bilecik', 'Bingöl', 'Bitlis', 'Bolu', 'Burdur', 'Bursa', 'Çanakkale', 'Çankırı',
            'Çorum', 'Denizli', 'Diyarbakır', 'Edirne', 'Elazığ', 'Erzincan', 'Erzurum', 'Eskişehir', 'Gaziantep',
            'Giresun', 'Gümüşhane', 'Hakkâri', 'Hatay', 'Isparta', 'Mersin', 'İstanbul', 'İzmir', 'Kars', 'Kastamonu',
            'Kayseri', 'Kırklareli', 'Kırşehir', 'Kocaeli', 'Konya', 'Kütahya', 'Malatya', 'Manisa', 'Kahramanmaraş',
            'Mardin', 'Muğla', 'Muş', 'Nevşehir', 'Niğde', 'Ordu', 'Rize', 'Sakarya', 'Samsun', 'Siirt', 'Sinop',
            'Sivas', 'Tekirdağ', 'Tokat', 'Trabzon', 'Tunceli', 'Şanlıurfa', 'Uşak', 'Van', 'Yozgat', 'Zonguldak',
            'Aksaray', 'Bayburt', 'Karaman', 'Kırıkkale', 'Batman', 'Şırnak', 'Bartın', 'Ardahan', 'Iğdır', 'Yalova',
            'Karabük', 'Kilis', 'Osmaniye', 'Düzce'
        ];
        
        $baseUrl = 'https://namaz-vakti.vercel.app/api/timesFromPlace?country=Turkey&region=';

        $currentDate=Carbon::now()->format('Y-m-d');
        foreach ($sehirler as $sehir) {
            $url = "$baseUrl$sehir&city=$sehir&date=$currentDate&days=30&timezoneOffset=180&calculationMethod=Turkey";
            $response = Http::get($url);
            $directoryPath = storage_path("app/responses/prayerTime/$sehir");
            $jsonFilePath = "$directoryPath/$sehir.json";

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
