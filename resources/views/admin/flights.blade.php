@extends('layout.app')

@section('title')
    Рейсы
@endsection

@section('main')
    <style>

        .form-control, .form-select{
            border-color: #265BE3;
        }

        .flights p, .flights b{
            color: #265BE3;
        }

        @media(max-width:991px){
            .right-part, .left-part{
                width: 100% !important;
            }

            .left-part{
                border-right: none !important;
            }

            .right-part{
                padding-left: 0 !important;
                padding-top: 1rem !important;
                border-top: #265BE3 2px solid !important;
            }

            body{
                font-size: 0.75rem;
            }
        }

        @media(max-width: 420px){
            .time> .col p:nth-child(2){
                font-size: 1.5rem !important;
            }

            .blue-top b{
                width: 3rem !important;
            }

            .arrow{
                width: auto !important;
            }

            .price span{
                font-size: 1.2rem !important;
                transform: none !important;
            }
        }

    </style>
    <div class="container" id="flightsPage">

        {{-- Модальное оповещение --}}
        <div class="modal fade" id="messageModal" tabindex="-1">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-body alert alert-success m-0 text-center">
                    @{{message}}
                </div>
              </div>
            </div>
          </div>

        <h2 class="text-center m-5">Рейсы <button type="button" class="btn text-primary fw-bold fs-5" data-bs-toggle="modal" data-bs-target="#addModal" @click='clearFlightData'>+</button></h2>

        {{-- Модальное окно для добавления --}}
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title" id="addModalLabel">Добавить рейс</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-12" method="post" id="addForm" @submit.prevent = 'addFlight'>

                        <div class="mb-4">
                            <select name="from_city" id="from_city" :class="errors.from_city ? 'is-invalid' : '' " class="form-select" v-model='from_city'>
                                <option value="" selected>Город отправления</option>
                                <option v-for="city in filterFromCities" :value="city.id">@{{city.title}}</option>
                            </select>
                            <div :class="errors.from_city ? 'invalid-feedback' : '' " v-for="error in errors.from_city">
                                @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <select name="to_city" id="to_city" :class="errors.to_city ? 'is-invalid' : '' " class="form-select" v-model='to_city'>
                                <option value="" selected>Город назначения</option>
                                <option v-for="city in filterToCities" :value="city.id">@{{city.title}}</option>
                            </select>
                            <div :class="errors.to_city ? 'invalid-feedback' : '' " v-for="error in errors.to_city">
                                @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="dateFrom" class="form-label">Дата отправления</label>
                            <input type="date" :class="errors.dateFrom ? 'is-invalid' : '' " class="form-control" id="dateFrom" name="dateFrom" v-model='dateFrom'>
                            <div :class="errors.dateFrom ? 'invalid-feedback' : '' " v-for="error in errors.dateFrom">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="dateTo" class="form-label">Дата прибытия</label>
                            <input type="date" :class="errors.dateTo ? 'is-invalid' : '' " class="form-control" id="dateTo" name="dateTo" v-model='dateTo'>
                            <div :class="errors.dateTo ? 'invalid-feedback' : '' " v-for="error in errors.dateTo">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="timeFrom" class="form-label">Время отправления</label>
                            <input type="time" :class="errors.timeFrom ? 'is-invalid' : '' " class="form-control" id="timeFrom" name="timeFrom" v-model='timeFrom'>
                            <div :class="errors.timeFrom ? 'invalid-feedback' : '' " v-for="error in errors.timeFrom">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="timeTo" class="form-label">Время прибытия</label>
                            <input type="time" :class="errors.timeTo ? 'is-invalid' : '' " class="form-control" id="timeTo" name="timeTo" v-model='timeTo'>
                            <div :class="errors.timeTo ? 'invalid-feedback' : '' " v-for="error in errors.timeTo">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="timeWay" class="form-label">Время в пути</label>
                            <input type="time" :class="errors.timeWay ? 'is-invalid' : '' " class="form-control" id="timeWay" name="timeWay" :value="countTimeWay">
                            <div :class="errors.timeWay ? 'invalid-feedback' : '' " v-for="error in errors.timeWay">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <input type="text" :class="errors.percentPrice ? 'is-invalid' : '' " class="form-control" id="percentPrice" name="percentPrice" placeholder="Взимаемый процент">
                            <div :class="errors.percentPrice ? 'invalid-feedback' : '' " v-for="error in errors.percentPrice">
                             @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <select name="airplane" id="airplane" :class="errors.airplane ? 'is-invalid' : '' " class="form-select">
                                <option value="" selected>Самолёт</option>
                                <option v-for="airplane in airplanes" :value="airplane.id">№@{{airplane.id}} @{{airplane.title}} (@{{airplane.count_seats}} мест)</option>
                            </select>
                            <div :class="errors.airplane ? 'invalid-feedback' : '' " v-for="error in errors.airplane">
                                @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <select name="from_airport" id="from_airport" :class="errors.from_airport ? 'is-invalid' : '' " class="form-select" v-model='from_airport'>
                                <option value="" selected>Аэропорт отправления</option>
                                <option v-for="airport in filterFromAirports" :value="airport.id">@{{airport.title}} (@{{airport.city.title}})</option>
                            </select>
                            <div :class="errors.from_airport ? 'invalid-feedback' : '' " v-for="error in errors.from_airport">
                                @{{error}}
                            </div>
                        </div>

                        <div class="mb-4">
                            <select name="to_airport" id="to_airport" :class="errors.to_airport ? 'is-invalid' : '' " class="form-select" v-model='to_airport'>
                                <option value="" selected>Аэропорт прибытия</option>
                                <option v-for="airport in filterToAirports" :value="airport.id">@{{airport.title}} (@{{airport.city.title}})</option>
                            </select>
                            <div :class="errors.to_airport ? 'invalid-feedback' : '' " v-for="error in errors.to_airport">
                                @{{error}}
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">добавить</button>
                          </div>
                    </form>
                </div>
              </div>
            </div>
        </div>

        <div class="flights col-9" style="margin: 0 auto">
            <div class="row mb-5" v-for='flight in flights'>
                <div class="col-7 p-0 left-part" style="border-right: #265BE3 2px solid">
                    <a :href="`{{route('flightDetailsPage')}}/${flight.id}`" class="blue-top text-decoration-none d-flex align-items-center p-3 mb-4" style="background-color: #265BE3">
                        <b style="width: 5rem" class="text-white">@{{flight.airplane.title}}</b>
                        <p class="m-0 row w-100 text-white"><span class="col">@{{flight.from_city.title}}</span> <span class="col-3 arrow">&rarr;</span> <span class="col">@{{flight.to_city.title}}</span></p>
                    </a>
                    <div class="time row">
                        <div class="col">
                            <p>@{{flight.dateFrom.slice(8,10)}} @{{months[Number(flight.dateFrom.slice(5,7))-1]}} @{{flight.dateFrom.slice(0,4)}}</p>
                            <p style="font-size: 2rem">@{{flight.timeFrom.slice(0,-3)}}</p>
                            <p>@{{flight.from_city.title}}</p>
                        </div>
                        <div class="col d-flex align-items-center">
                            <p>@{{flight.timeWay.slice(0,2)}} ч @{{flight.timeWay.slice(3,5)}} мин</p>
                        </div>
                        <div class="col">
                            <p>@{{flight.dateTo.slice(8,10)}} @{{months[Number(flight.dateTo.slice(5,7))-1]}} @{{flight.dateTo.slice(0,4)}}</p>
                            <p style="font-size: 2rem">@{{flight.timeTo.slice(0,-3)}}</p>
                            <p>@{{flight.to_city.title}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-5 right-part">
                    <p class="row"><span class="col">Цена места:</span> <span class="col-5 text-end">@{{flight.airplane.price}} руб.</span></p>
                    <p class="row"><span class="col">Количество свободных мест:</span> <span class="col-2 text-end">@{{flight.airplane.count_seats - flight.tickets_count}}</span></p>
                    <p class="row"><span class="col">Взимаемый процент:</span> <span class="col-5 text-end">@{{flight.percentPrice}}</span></p>
                    <p class="row"><span class="col">Статус:</span> <span class="col-5 text-end">@{{flight.status}}</span></p>                                                                                                                                                                                 {{--                                                 расчёт цены билета                       ↓ для округления до двух знаков--}}
                    <p class="row align-items-end fw-bold price"><span class="col-4 fs-5">Стоимость</span> <span class="col-8 fs-2 text-end" style="transform: translateY(15%)">@{{Math.round((flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price) * 100)/100}} руб.</span></p>
                    {{-- <a href="" class="btn btn-warning text-white" style="padding-left: 2rem; padding-right: 2rem">выбрать место</a> --}}
                    <div class="row">
                        <div class="col">
                            <button class="btn btn-danger" type="button" data-bs-toggle="modal" :data-bs-target="`#deleteModal_${flight.id}`">Удалить</button>
                            {{-- Модальное окно для подтверждения удаления --}}
                            <div class="modal fade" tabindex="-1" :id="`deleteModal_${flight.id}`">
                                <div class="modal-dialog modal-dialog-centered">
                                  <div class="modal-content">
                                    <div class="modal-body">
                                      <h3 class="text-danger">Подтвердите удаление рейса "№@{{flight.id}} @{{flight.from_city.title}} -> @{{flight.to_city.title}}"</h3>
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                      <button type="button" class="btn btn-danger" @click='deleteFlight(flight.id)'>Удалить</button>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <button data-bs-toggle="modal" :data-bs-target="`#editModal_${flight.id}`" class="btn btn-warning text-white" @click='pushFlightData(flight)'>Редактировать</button>

                            {{-- Модальное окно для редактирования --}}
                            <div class="modal fade" :id="`editModal_${flight.id}`" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                    <h3 class="modal-title" id="addModalLabel">Редактировать рейс "№@{{flight.id}} @{{flight.from_city.title}} -> @{{flight.to_city.title}}"</h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="col-12" method="post" enctype="multipart/form-data" :id="`editForm_${flight.id}`" @submit.prevent = 'editFlight(flight.id)'>

                                            <div class="mb-4">
                                                <select name="from_city" id="from_city" :class="errors.from_city ? 'is-invalid' : '' " class="form-select" v-model='from_city'>
                                                    <option value="" selected>Город отправления</option>
                                                    <option v-for="city in filterFromCities" :value="city.id">@{{city.title}}</option>
                                                </select>
                                                <div :class="errors.from_city ? 'invalid-feedback' : '' " v-for="error in errors.from_city">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="to_city" id="to_city" :class="errors.to_city ? 'is-invalid' : '' " class="form-select" v-model='to_city'>
                                                    <option value="" selected>Город назначения</option>
                                                    <option v-for="city in filterToCities" :value="city.id">@{{city.title}}</option>
                                                </select>
                                                <div :class="errors.to_city ? 'invalid-feedback' : '' " v-for="error in errors.to_city">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="dateFrom" class="form-label">Дата отправления</label>
                                                <input type="date" :class="errors.dateFrom ? 'is-invalid' : '' " class="form-control" id="dateFrom" name="dateFrom" v-model='dateFrom'>
                                                <div :class="errors.dateFrom ? 'invalid-feedback' : '' " v-for="error in errors.dateFrom">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="dateTo" class="form-label">Дата прибытия</label>
                                                <input type="date" :class="errors.dateTo ? 'is-invalid' : '' " class="form-control" id="dateTo" name="dateTo" v-model='dateTo'>
                                                <div :class="errors.dateTo ? 'invalid-feedback' : '' " v-for="error in errors.dateTo">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="timeFrom" class="form-label">Время отправления</label>
                                                <input type="time" :class="errors.timeFrom ? 'is-invalid' : '' " class="form-control" id="timeFrom" name="timeFrom" v-model='timeFrom'>
                                                <div :class="errors.timeFrom ? 'invalid-feedback' : '' " v-for="error in errors.timeFrom">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="timeTo" class="form-label">Время прибытия</label>
                                                <input type="time" :class="errors.timeTo ? 'is-invalid' : '' " class="form-control" id="timeTo" name="timeTo" v-model='timeTo'>
                                                <div :class="errors.timeTo ? 'invalid-feedback' : '' " v-for="error in errors.timeTo">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <label for="timeWay" class="form-label">Время в пути</label>
                                                <input type="time" :class="errors.timeWay ? 'is-invalid' : '' " class="form-control" id="timeWay" name="timeWay" :value="countTimeWay">
                                                <div :class="errors.timeWay ? 'invalid-feedback' : '' " v-for="error in errors.timeWay">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <input type="text" :class="errors.percentPrice ? 'is-invalid' : '' " class="form-control" id="percentPrice" name="percentPrice" placeholder="Взимаемый процент" :value="flight.percentPrice">
                                                <div :class="errors.percentPrice ? 'invalid-feedback' : '' " v-for="error in errors.percentPrice">
                                                 @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="airplane" id="airplane" :class="errors.airplane ? 'is-invalid' : '' " class="form-select">
                                                    <option value="" selected>Самолёт</option>
                                                    <option v-for="airplane in airplanes" :selected="airplane.id == flight.airplane_id" :value="airplane.id">№@{{airplane.id}} @{{airplane.title}} (@{{airplane.count_seats}} мест)</option>
                                                </select>
                                                <div :class="errors.airplane ? 'invalid-feedback' : '' " v-for="error in errors.airplane">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="from_airport" id="from_airport" :class="errors.from_airport ? 'is-invalid' : '' " class="form-select" v-model='from_airport'>
                                                    <option value="" selected>Аэропорт отправления</option>
                                                    <option v-for="airport in filterFromAirports" :value="airport.id">@{{airport.title}} (@{{airport.city.title}})</option>
                                                </select>
                                                <div :class="errors.from_airport ? 'invalid-feedback' : '' " v-for="error in errors.from_airport">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="to_airport" id="to_airport" :class="errors.to_airport ? 'is-invalid' : '' " class="form-select" v-model='to_airport'>
                                                    <option value="" selected>Аэропорт прибытия</option>
                                                    <option v-for="airport in filterToAirports" :value="airport.id">@{{airport.title}} (@{{airport.city.title}})</option>
                                                </select>
                                                <div :class="errors.to_airport ? 'invalid-feedback' : '' " v-for="error in errors.to_airport">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="mb-4">
                                                <select name="status" id="status" :class="errors.status ? 'is-invalid' : '' " class="form-select">
                                                    <option value="готов" :selected="flight.status == 'готов'">Готов</option>
                                                    <option value="в полете" :selected="flight.status == 'в полете'">В полете</option>
                                                    <option value="прибыл" :selected="flight.status == 'прибыл'">Прибыл</option>
                                                    <option value="ТО" :selected="flight.status == 'ТО'">ТО</option>
                                                </select>
                                                <div :class="errors.status ? 'invalid-feedback' : '' " v-for="error in errors.status">
                                                    @{{error}}
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                                <button type="submit" class="btn btn-primary">Редактировать</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const Flights = {
            data(){
                return{
                    errors:[],
                    flights:[],
                    message:'',
                    cities:[],
                    airplanes:[],
                    airports:[],

                    dateFrom:'',
                    dateTo:'',
                    timeFrom:'',
                    timeTo:'',

                    from_city:'',
                    to_city:'',
                    from_airport:'',
                    to_airport:'',

                    months:['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
                }
            },

            methods:{
                async getAirplanes(){
                    const response = await fetch('{{route('getAirplanes')}}');
                    const data = await response.json();
                    this.airplanes = data.airplanes;
                },

                async getCities(){
                    const response = await fetch('{{route('getCities')}}');
                    const data = await response.json();
                    this.cities = data.cities;
                },

                async getAirports(){
                    const response = await fetch('{{route('getAirports')}}');
                    const data = await response.json();
                    this.airports = data.airports;
                },

                async getFlights(){
                    const response = await fetch('{{route('getFlights')}}');
                    const data = await response.json();
                    this.flights = data.flights_admin;
                },

                async addFlight(){
                    const form = $('#addForm')[0];
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('addFlight')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data,
                    });

                    if(response.status === 403){
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 3000);
                    }

                    if(response.status === 200){
                        form.reset();
                        $('#addModal').modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getFlights();
                    }
                },

                async editFlight(id){
                    const form = $(`#editForm_${id}`)[0];
                    const form_data = new FormData(form);
                    const response = await fetch(`{{route('editFlight')}}/${id}`, {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data,
                    });

                    if(response.status === 403){
                        this.errors = await response.json();
                        setTimeout(() => {
                            this.errors = [];
                        }, 3000);
                    }

                    if(response.status === 200){
                        $(`#editModal_${id}`).modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getFlights();
                    }
                },

                async deleteFlight(id){
                    const response = await fetch(`{{route('deleteFlight')}}/${id}`, {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        }
                    });

                    if(response.status === 200){
                        $(`#deleteModal_${id}`).modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getFlights();
                    }
                },

                pushFlightData(flight){
                    this.dateFrom=flight.dateFrom;
                    this.dateTo=flight.dateTo;
                    this.timeFrom=flight.timeFrom;
                    this.timeTo=flight.timeTo;
                    this.from_city=flight.from_city_id;
                    this.to_city=flight.to_city_id;
                    this.from_airport=flight.from_airport_id;
                    this.to_airport=flight.to_airport_id;
                },

                clearFlightData(){
                    this.dateFrom='';
                    this.dateTo='';
                    this.timeFrom='';
                    this.timeTo='';
                    this.from_city='';
                    this.to_city='';
                    this.from_airport='';
                    this.to_airport='';
                },

            },

            mounted(){
                this.getAirplanes();
                this.getCities();
                this.getAirports();
                this.getFlights();
                $('#messageModal').on('shown.bs.modal', function (e) {
                    $(".modal-backdrop").css({ opacity: 0 });
                });
            },

            computed:{
                countTimeWay(){
                    if(this.dateFrom && this.dateTo && this.timeFrom && this.timeTo){
                       let from = new Date(this.dateFrom + "T" + this.timeFrom);
                        let to = new Date(this.dateTo + "T" + this.timeTo);
                        let minsAmount = Math.abs(from - to) / 60000;
                        let hours = Math.floor(minsAmount/60);
                        let minutes = Math.round((minsAmount/60 - hours)*60);
                        return new Date(0,0,0,hours,minutes).toLocaleTimeString().slice(0,-3);
                    }
                },

                filterFromAirports(){
                    if(this.from_city){
                        return [...this.airports].filter(airport=>airport.city_id == this.from_city);
                    }
                    return [...this.airports];
                },

                filterToAirports(){
                    if(this.to_city){
                        return [...this.airports].filter(airport=>airport.city_id == this.to_city);
                    }
                    return [...this.airports];
                },

                filterFromCities(){
                    if(this.from_airport){
                        return [...this.cities].filter(city=>{
                            for(airport of [...this.airports]){
                                if (airport.id == this.from_airport && airport.city_id == city.id){
                                    return true;
                                }
                            }
                            return false;
                        });
                    }
                    return [...this.cities];
                },

                filterToCities(){
                    if(this.to_airport){
                        return [...this.cities].filter(city=>{
                            for(airport of [...this.airports]){
                                if (airport.id == this.to_airport && airport.city_id == city.id){
                                    return true;
                                }
                            }
                            return false;
                        });
                    }
                    return [...this.cities];
                },
            }

        }

        Vue.createApp(Flights).mount('#flightsPage');
    </script>
@endsection
