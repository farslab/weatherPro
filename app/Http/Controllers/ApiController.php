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
            "395" => "wi-thunderstorm",
            "392" => "wi-thunderstorm",
            "389" => "wi-thunderstorm",
            "386" => "wi-thunderstorm",
            "377" => "wi-sleet",
            "374" => "wi-sleet",
            "371" => "wi-snow",
            "368" => "wi-snow",
            "365" => "wi-sleet",
            "362" => "wi-sleet",
            "359" => "wi-showers",
            "356" => "wi-showers",
            "353" => "wi-showers",
            "350" => "wi-sleet",
            "338" => "wi-snow",
            "335" => "wi-snow",
            "332" => "wi-snow",
            "329" => "wi-snow",
            "326" => "wi-snow",
            "323" => "wi-snow",
            "320" => "wi-sleet",
            "317" => "wi-sleet",
            "314" => "wi-sleet",
            "311" => "wi-sleet",
            "308" => "wi-showers",
            "305" => "wi-showers",
            "302" => "wi-showers",
            "299" => "wi-showers",
            "296" => "wi-showers",
            "293" => "wi-showers",
            "284" => "wi-sleet",
            "281" => "wi-sleet",
            "266" => "wi-showers",
            "263" => "wi-showers",
            "260" => "wi-fog",
            "248" => "wi-fog",
            "230" => "wi-snow",
            "227" => "wi-snow",
            "200" => "wi-thunderstorm",
            "185" => "wi-sleet",
            "182" => "wi-sleet",
            "179" => "wi-snow",
            "176" => "wi-showers",
            "143" => "wi-fog",
            "122" => "wi-cloudy",
            "119" => "wi-cloudy",
            "116" => "wi-day-cloudy",
            "113" => "wi-day-sunny",
        ];

        $jsonFilePath = storage_path("app/responses/{$sehirAdi}.json");

        if (File::exists($jsonFilePath)) {
            $jsonData = json_decode(file_get_contents($jsonFilePath), true);

            $now = Carbon::now();
            $sehirAdi = ucfirst($sehirAdi);

            return view('welcome', compact('jsonData', 'sehirAdi', 'now','skipFirst','weatherIconClasses'));
        } else {
            // Belirtilen şehir adına ait JSON dosyası bulunamadı.
            abort(404);
        }
    }

}
