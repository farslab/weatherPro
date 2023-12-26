<?php

namespace App\Http\Controllers;

use App;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\File;
use Log;

class ApiController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $sehirler = ['adana', 'adiyaman', 'afyonkarahisar', 'agri', 'amasya', 'ankara', 'antalya', 'artvin',
            'aydin', 'balikesir', 'bilecik', 'bingol', 'bitlis', 'bolu', 'burdur', 'bursa', 'canakkale', 'cankiri',
            'corum', 'denizli', 'diyarbakir', 'edirne', 'elazig', 'erzincan', 'erzurum', 'eskisehir', 'gaziantep',
            'giresun', 'gumushane', 'hakkari', 'hatay', 'isparta', 'mersin', 'istanbul', 'izmir', 'kars', 'kastamonu',
            'kayseri', 'kirklareli', 'kirsehir', 'kocaeli', 'konya', 'kutahya', 'malatya', 'manisa', 'kahramanmaras',
            'mardin', 'mugla', 'mus', 'nevsehir', 'nigde', 'ordu', 'rize', 'sakarya', 'samsun', 'siirt', 'sinop',
            'sivas', 'tekirdag', 'tokat', 'trabzon', 'tunceli', 'sanliurfa', 'usak', 'van', 'yozgat', 'zonguldak',
            'aksaray', 'bayburt', 'karaman', 'kirikkale', 'batman', 'sirnak', 'bartin', 'ardahan', 'igdir', 'yalova',
            'karabuk', 'kilis', 'osmaniye', 'duzce'];


        $filteredCities = array_filter($sehirler, function ($sehir) use ($query) {
            return stristr($sehir, $query);
        });

        return response()->json($filteredCities);
    }
    public function index()
    {
        return view('welcome');
    }

    public function showWeather($sehirAdi)
    {

        $skipFirst = true;
        $weatherIconClasses = [
            "395" => "thunder",
            "392" => "snowy-4",
            "389" => "rainy-5",
            "386" => "rainy-4",
            "377" => "snowy-4",
            "374" => "rainy-6",
            "371" => "snowy-5",
            "368" => "snowy-3",
            "365" => "snowy-4",
            "362" => "snowy-3",
            "359" => "rainy-7",
            "356" => "rainy-6",
            "353" => "rainy-5",
            "350" => "snowy-6",
            "338" => "snowy-6",
            "335" => "snowy-6",
            "332" => "snowy-5",
            "329" => "snowy-5",
            "326" => "snowy-4",
            "323" => "snowy-4",
            "320" => "snowy-3",
            "317" => "snowy-3",
            "314" => "rainy-5",
            "311" => "rainy-5",
            "308" => "rainy-7",
            "305" => "rainy-7",
            "302" => "rainy-5",
            "299" => "rainy-5",
            "296" => "rainy-3",
            "293" => "rainy-2",
            "284" => "rainy-4",
            "281" => "rainy-5",
            "266" => "rainy-1",
            "263" => "rainy-1",
            "260" => "snowy-6",
            "248" => "cloudy",
            "230" => "snowy-6",
            "227" => "snowy-6",
            "200" => "thunder",
            "185" => "rainy-1",
            "182" => "rainy-2",
            "179" => "snowy-1",
            "176" => "rainy-2",
            "143" => "cloudy",
            "122" => "cloudy",
            "119" => "cloudy-day-1",
            "116" => "cloudy-day-2",
            "113" => "cloudy-day-3"
        ];
        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $weatherJsonFilePath = storage_path("app/responses/{$sehirAdi}.json");
        $prayerJsonFilePath = storage_path("app/responses/prayerTime/{$sehirAdi}/{$sehirAdi}-{$currentYear}-{$currentMonth}.json");


        if (File::exists($weatherJsonFilePath)) {
            $jsonData = json_decode(file_get_contents($weatherJsonFilePath), true);
            $prayerJsonData = json_decode(file_get_contents($prayerJsonFilePath), true);


            $now = Carbon::now();
            $sehirAdi = ucfirst($sehirAdi);
            return view('welcome', compact('jsonData', 'prayerJsonData', 'sehirAdi', 'now', 'skipFirst', 'weatherIconClasses'));
        } else {
            // Belirtilen şehir adına ait veri yok.
            abort(404);
        }
    }

}
