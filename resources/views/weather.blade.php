<!DOCTYPE html>
<html>

<head>
    <title>Weather Information</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="weathercard2.css">

</head>
<!-- Weather -->
<div class="container mt-5">
    <div class="d-flex flex-row justify-content-center align-items-center">
        <div class="weather__card">
            <div class="d-flex flex-row justify-content-center align-items-center">
                <div class="p-3">
                    <h2>15&deg;</h2>
                </div>
                <div class="p-3">
                    <img src="https://svgur.com/i/oKG.svg">
                </div>
                <div class="p-3">
                    <h5>Tuesday, 10 AM</h5>
                    <h3>San Francisco</h3>
                    <span class="weather__description">Mostly Cloudy</span>
                </div>
            </div>
            <div class="weather__status d-flex flex-row justify-content-center align-items-center mt-3">
                <div class="p-4 d-flex justify-content-center align-items-center">
                    <img src="https://svgur.com/i/oHw.svg">
                    <span>10%</span>
                </div>
                <div class="p-4 d-flex justify-content-center align-items-center">
                    <img src="https://svgur.com/i/oH_.svg">
                    <span>0.53 mB</span>
                </div>
                <div class="p-4 d-flex justify-content-center align-items-center">
                    <img src="https://svgur.com/i/oKS.svg">
                    <span>10 km/h</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Weather Forecast -->
<div class="weather__forecast d-flex flex-row justify-content-center align-items-center mt-3">
    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Wed</span>
        <img src="https://svgur.com/i/oJe.svg">
        <span>13&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Thu</span>
        <img src="https://svgur.com/i/oKG.svg">
        <span>15&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Wed</span>
        <img src="https://svgur.com/i/oKG.svg">
        <span>15&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Fri</span>
        <img src="https://svgur.com/i/oJe.svg">
        <span>13&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Sat</span>
        <img src="https://svgur.com/i/oJx.svg">
        <span>13&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Sun</span>
        <img src="https://svgur.com/i/oJU.svg">
        <span>11&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Mon</span>
        <img src="https://svgur.com/i/oJU.svg">
        <span>11&deg;</span>
    </div>

    <div class="p-4 d-flex flex-column justify-content-center align-items-center">
        <span>Tue</span>
        <img src="https://svgur.com/i/oJy.svg">
        <span>6&deg;</span>
    </div>
</div>


<body>
    <h1>Current Weather in {{ $sehirAdi }}</h1>

    @if(isset($jsonData['data']['current_condition']))
    <h2>Current Conditions:</h2>
    <ul>
        @foreach($jsonData['data']['current_condition'] as $condition)
        <li>
            {{$jsonData['data']['time_zone'][0]['localtime']}}<br>
            <strong>Temperature:</strong> {{ $condition['temp_C'] }}°C<br>
            <strong>Weather:</strong> {{ $condition['weatherDesc'][0]['value'] }}<br>
            <img src="{{ $condition['weatherIconUrl'][0]['value'] }}" alt="Weather Icon"><br>
        </li>
        @endforeach
    </ul>
    @else
    <p>No current weather information available.</p>
    @endif

    @if(isset($jsonData['data']['weather']))
    <h2>Weather Forecast:</h2>
    <ul>
        @foreach($jsonData['data']['weather'] as $day)
        <li>
            <strong>Date:</strong> {{ $day['date'] }}<br>
            <strong>Weather Desc:</strong> {{ $day['date'] }}<br>
            <strong>Sunrise:</strong> {{ $day['astronomy'][0]['sunrise'] }}<br>
            <strong>Sunset:</strong> {{ $day['astronomy'][0]['sunset'] }}<br>
            <strong>Max Temperature:</strong> {{ $day['maxtempC'] }}°C<br>
            <strong>Min Temperature:</strong> {{ $day['mintempC'] }}°C<br>
            <strong>Average Temperature:</strong> {{ $day['avgtempC'] }}°C<br>
        <li>

            @foreach($day['hourly'] as $hour)
            <strong>Hour:</strong> {{ $hour['time'] }}<br>
            <strong>Temp:</strong> {{ $hour['tempC'] }}<br>
            <strong>Desc:</strong> {{ $hour['weatherDesc'][0]['value'] }}<br>
            <img src="{{ $hour['weatherIconUrl'][0]['value'] }}" alt="Weather Icon"><br>

            @endforeach


        </li>
        </li>
        @endforeach
    </ul>
    @else
    <p>No weather forecast available.</p>
    @endif
</body>

</html>