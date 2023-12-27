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
    protected $sehirler = ['adana', 'adiyaman', 'afyonkarahisar', 'agri', 'amasya', 'ankara', 'antalya', 'artvin',
        'aydin', 'balikesir', 'bilecik', 'bingol', 'bitlis', 'bolu', 'burdur', 'bursa', 'canakkale', 'cankiri',
        'corum', 'denizli', 'diyarbakir', 'edirne', 'elazig', 'erzincan', 'erzurum', 'eskisehir', 'gaziantep',
        'giresun', 'gumushane', 'hakkari', 'hatay', 'isparta', 'mersin', 'istanbul', 'izmir', 'kars', 'kastamonu',
        'kayseri', 'kirklareli', 'kirsehir', 'kocaeli', 'konya', 'kutahya', 'malatya', 'manisa', 'kahramanmaras',
        'mardin', 'mugla', 'mus', 'nevsehir', 'nigde', 'ordu', 'rize', 'sakarya', 'samsun', 'siirt', 'sinop',
        'sivas', 'tekirdag', 'tokat', 'trabzon', 'tunceli', 'sanliurfa', 'usak', 'van', 'yozgat', 'zonguldak',
        'aksaray', 'bayburt', 'karaman', 'kirikkale', 'batman', 'sirnak', 'bartin', 'ardahan', 'igdir', 'yalova',
        'karabuk', 'kilis', 'osmaniye', 'duzce'];
    protected $sehirlerTr = [
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
    protected $sehirlerMap = ["adana" => "Adana", "adiyaman" => "Adıyaman", "afyonkarahisar" => "Afyonkarahisar", "agri" => "Ağrı", "amasya" => "Amasya", "ankara" => "Ankara", "antalya" => "Antalya", "artvin" => "Artvin", "aydin" => "Aydın", "balikesir" => "Balıkesir", "bilecik" => "Bilecik", "bingol" => "Bingöl", "bitlis" => "Bitlis", "bolu" => "Bolu", "burdur" => "Burdur", "bursa" => "Bursa", "canakkale" => "Çanakkale", "cankiri" => "Çankırı", "corum" => "Çorum", "denizli" => "Denizli", "diyarbakir" => "Diyarbakır", "edirne" => "Edirne", "elazig" => "Elazığ", "erzincan" => "Erzincan", "erzurum" => "Erzurum", "eskisehir" => "Eskişehir", "gaziantep" => "Gaziantep", "giresun" => "Giresun", "gumushane" => "Gümüşhane", "hakkari" => "Hakkâri", "hatay" => "Hatay", "isparta" => "Isparta", "mersin" => "Mersin", "istanbul" => "İstanbul", "izmir" => "İzmir", "kars" => "Kars", "kastamonu" => "Kastamonu", "kayseri" => "Kayseri", "kirklareli" => "Kırklareli", "kirsehir" => "Kırşehir", "kocaeli" => "Kocaeli", "konya" => "Konya", "kutahya" => "Kütahya", "malatya" => "Malatya", "manisa" => "Manisa", "kahramanmaras" => "Kahramanmaraş", "mardin" => "Mardin", "mugla" => "Muğla", "mus" => "Muş", "nevsehir" => "Nevşehir", "nigde" => "Niğde", "ordu" => "Ordu", "rize" => "Rize", "sakarya" => "Sakarya", "samsun" => "Samsun", "siirt" => "Siirt", "sinop" => "Sinop", "sivas" => "Sivas", "tekirdag" => "Tekirdağ", "tokat" => "Tokat", "trabzon" => "Trabzon", "tunceli" => "Tunceli", "sanliurfa" => "Şanlıurfa", "usak" => "Uşak", "van" => "Van", "yozgat" => "Yozgat", "zonguldak" => "Zonguldak", "aksaray" => "Aksaray", "bayburt" => "Bayburt", "karaman" => "Karaman", "kirikkale" => "Kırıkkale", "batman" => "Batman", "sirnak" => "Şırnak", "bartin" => "Bartın", "ardahan" => "Ardahan", "igdir" => "Iğdır", "yalova" => "Yalova", "karabuk" => "Karabük", "kilis" => "Kilis", "osmaniye" => "Osmaniye", "duzce" => "Düzce",];

    public function search(Request $request)
    {
        $query = $request->input('query');
        $filteredCities = array_filter($this->sehirler, function ($sehir) use ($query) {
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
        $prayerJsonFilePath = storage_path("app/responses/prayerTime/{$this->sehirlerMap[$sehirAdi]}/{$this->sehirlerMap[$sehirAdi]}.json");


        if (File::exists($weatherJsonFilePath)) {
            $jsonData = json_decode(file_get_contents($weatherJsonFilePath), true);
            $prayerJsonData = json_decode(file_get_contents($prayerJsonFilePath), true);
            $now = Carbon::now();
            $namazVakti=collect($prayerJsonData['times'][$now->format('Y-m-d')]);
            $sehirAdi = $this->sehirlerMap[$sehirAdi];
            return view('welcome', compact('namazVakti','jsonData', 'prayerJsonData', 'sehirAdi', 'now', 'skipFirst', 'weatherIconClasses'));
        } else {
            // Belirtilen şehir adına ait veri yok.
            abort(404);
        }
    }

}
