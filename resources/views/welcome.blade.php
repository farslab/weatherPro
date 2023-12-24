<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hava Durumu</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="weathercard2.css">
    <link rel="stylesheet" href="/css/weather-icons.min.css">

</head>
<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-3">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse justify-content-between" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    Dropdown
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
        </ul>
        <div class="search-container">
            <form class=" form-inline my-2 my-lg-0 d-flex flex-row align-items-center" id="search-form">
                <input class="form-control mr-sm-2" type="search" placeholder="Şehir Ara" aria-label="Search"
                    id="search-input">
            </form>
            <div id="search-results" class="position-fixed rounded z-index-modal mt-2 bg-white"
            style="max-width: 200px; width:200px; max-height:350px; overflow-y:scroll"  
                >
            </div>
        </div>
    </div>
</nav>

<body>

    <div class="container-fluid row mt-5 overflow-hidden">
        <div class="col-sm-12 col-md-6 ps-4">
            {{-- <h1 class="ps-3">{{$sehirAdi}} Hava Durumu</h1> --}}
            <div class="col d-flex flex-row justify-content-center align-items-center">
                <div class="card shadow weather__card bg-light w-100">
                    <div class="d-flex flex-row justify-content-center align-items-center">
                        <div class="p-3 d-flex flex-column align-items-center">
                            <h2>{{$jsonData['data']['current_condition'][0]['temp_C']}}&deg</h2>


                        </div>
                        <div class="p-3">
                            <i style="font-size:6rem"
                                class="text-color wi {{$weatherIconClasses[$jsonData['data']['current_condition'][0]['weatherCode']]}} fa-6x "></i>
                        </div>
                        <div class="px-5">

                            <h5>{{ $now->isoFormat('D MMMM | dddd')}}<br>
                            </h5>
                            <h3>{{ucfirst($sehirAdi)}}</h3>
                            <span
                                class="weather__description">{{$jsonData['data']['current_condition'][0]['lang_tr'][0]['value']}}</span>
                        </div>
                    </div>
                    <div class="weather__status d-flex flex-row justify-content-center align-items-center ">
                        <div class="p-4 d-flex justify-content-center align-items-center">
                            <img src="https://svgur.com/i/oHw.svg">
                            <span><strong>Nem: </strong>
                                {{$jsonData['data']['current_condition'][0]['humidity']}}%</span>
                        </div>
                        <div class="p-4 d-flex justify-content-center align-items-center">
                            <img src="https://svgur.com/i/oH_.svg">
                            <span><strong>Basınç: </strong>{{$jsonData['data']['current_condition'][0]['pressure']}}
                                hPa</span>
                        </div>
                        <div class="p-4 d-flex justify-content-center align-items-center">
                            <img src="https://svgur.com/i/oKS.svg">
                            <span><strong>Rüzgar:
                                </strong>{{$jsonData['data']['current_condition'][0]['windspeedKmph']}} km/h</span>
                        </div>
                    </div>
                    <div class="weather__status d-flex flex-row justify-content-center align-items-center">
                        <div class="p-2 d-flex justify-content-center align-items-center">
                            <img src="https://svgur.com/i/oHw.svg">
                            <span><strong>Nem: </strong>
                                {{$jsonData['data']['current_condition'][0]['humidity']}}%</span>
                        </div>
                        <div class="p-2 d-flex justify-content-center align-items-center">
                            <img src="https://svgur.com/i/oH_.svg">
                            <span><strong>Basınç: </strong>{{$jsonData['data']['current_condition'][0]['pressure']}}
                                hPa</span>
                        </div>
                        
                    </div>
                </div>
            </div>
            <div class="hourly d-flex flex-row justify-content-between align-items-center mt-4">

                @foreach($jsonData['data']['weather'][0]['hourly'] as $hourly)
                <div class=" d-flex flex-column justify-content-center align-items-center">
                    <span>{{$hourly['time']}}</span>

                    <i class="py-2 fs-3 text-color wi {{$weatherIconClasses[$hourly['weatherCode']]?? "
                        wi-day-sunny"}}"></i>
                    <span>{{$hourly['tempC']}}&deg;</span>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-md-6 col-sm-12 ps-4">
            {{-- <h1>Yarınki Hava Durumu</h1> --}}
            <table class="table table-hover table-striped table-bordered ">
                <thead class="text-center">
                    <tr>
                        <th scope="col">Tarih</th>
                        <th scope="col">Durum</th>
                        <th scope="col">Min C&deg</th>
                        <th scope="col">Max C&deg</th>
                        <th scope="col">Yağış</th>
                    </tr>
                </thead>
                <tbody class="align-items-center text-center align-self-center">
                    @foreach($jsonData['data']['weather'] as $day)
                    @if($skipFirst)
                    @php
                    $skipFirst = false;
                    continue;
                    @endphp
                    @endif
                    <tr class="text-center">
                        <td scope="row">{{$day['date']}}</th>


                        <td><i class=" fs-3 text-color wi {{$weatherIconClasses[$day['hourly'][3]['weatherCode']]?? "
                                wi-day-sunny"}}"></i></td>
                        <td>{{$day['mintempC']}}&deg</td>
                        <td>{{$day['maxtempC']}}&deg</td>
                        <td>@mdo</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>
    </div>

</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
    $(document).ready(function () {

        $('#search-input').on('input', function () {
            // Input değeri her değiştiğinde bu fonksiyon çalışacak

            var searchQuery = $(this).val();
            if (searchQuery.trim() === '') {
            $('#search-results').hide();
            return;
            }

            $.ajax({
                type: 'GET',
                url: '/search',
                data: { query: searchQuery },
                success: function (data) {
                    
                    $('#search-results').empty(); 
                    $.each(data, function (index, result) {
                        $('#search-results').append('<a style="text-decoration:none;" class="text-capitalize ms-2 fs-5 text-dark" href="' + result + '-hava-durumu">' + result + '</a><br>');
                    });

                    $('#search-results').show();
                    
                }
            });
        });
    });
</script>



</html>