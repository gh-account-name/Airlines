@extends('layout.app')

@section('title')
    Подходящие рейсы
@endsection

@section('main')
    <style>

    .form-control, .form-select{
        border-color: #265BE3;
    }

    .flights p, .flights b{
        color: #265BE3;
    }

    .decorLine{
            display: block;
            height: 0.313rem;
            background-color: #265BE3;
            width: 70%;
    }

    .flights{
        padding-left: calc(var(--bs-gutter-x)/ 2);
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

        #flightsSearchResultPage>.row>div{
            width: 100%;
        }

        .filters>.row{
            width: 75% !important;
        }

        .flights{
            padding-right: calc(var(--bs-gutter-x)/ 2);
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

    <div class="container" id="flightsSearchResultPage">
        <div class="row mt-5">
            <div class="filters col-3 mt-5">
                <h4>Фильтры</h4>
                <h5 class="mt-5 mb-3">Стоимость</h5>
                <div class="row" style="padding:0 calc(var(--bs-gutter-x)/ 2) 0 calc(var(--bs-gutter-x)/ 2);">
                    <input v-model="minPrice" class="form-control col" type="number" placeholder="от" id='minPrice' name="minPrice" style="margin-right: 1rem">
                    <input v-model="maxPrice" class="form-control col" type="number" placeholder="до" id='maxPrice' name="maxPrice">
                </div>
            </div>  
            <div class="col-9">
                <h2 class="d-flex align-items-center justify-content-between mt-5">Рейсы <span class="decorLine"></span></h2>
                <p class="mt-5" v-if="filterByPrice.length != 0">По вашему запросу найдены следующие рейсы</p>
                <p class="mt-5" v-else>По вашему запросу ничего не найдено</p>
                <div class="flights">
                    <div class="row mb-5" v-for='flight in filterByPrice'>
                        <div class="col-7 p-0 left-part" style="border-right: #265BE3 2px solid">
                            <div class="blue-top d-flex align-items-center p-3 mb-4" style="background-color: #265BE3">
                                <b style="width: 5rem" class="text-white">@{{flight.airplane.title}}</b>
                                <p class="m-0 row w-100 text-white"><span class="col">@{{flight.from_city.title}}</span> <span class="col-3 arrow">&rarr;</span> <span class="col">@{{flight.to_city.title}}</span></p>
                            </div>
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
                            <p class="row"><span class="col">Взимаемый процент:</span> <span class="col-5 text-end">@{{flight.percentPrice}}</span></p>                          {{--                                                 расчёт цены билета                       ↓ для округления до двух знаков--}}
                            <p class="row align-items-end fw-bold price"><span class="col-4 fs-5">Стоимость</span> <span class="col-8 fs-2 text-end" style="transform: translateY(15%)">@{{Math.round((flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price) * 100)/100}} руб.</span></p>
                            <a :href="`{{route('flightDetailsPage')}}/${flight.id}`" class="btn btn-warning text-white" style="padding-left: 2rem; padding-right: 2rem">выбрать место</a>
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
                    flights: @json($flights),
                    months:['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
                    minPrice:'',
                    maxPrice:'',
                }
            },

            computed:{
                filterByPrice(){
                    if (this.minPrice || this.maxPrice){
                        if(this.minPrice && this.maxPrice==''){
                            return [...this.flights].filter(flight => {
                                let flight_price = flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price;
                                return flight_price >= this.minPrice;
                            });
                        }
                        if(this.minPrice=='' && this.maxPrice){
                            return [...this.flights].filter(flight => {
                                let flight_price = flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price;
                                return flight_price <= this.maxPrice;
                            });
                        }
                        if(this.minPrice && this.maxPrice){
                            return [...this.flights].filter(flight => {
                                let flight_price = flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price;
                                return (flight_price >= this.minPrice && flight_price <= this.maxPrice);
                            });
                        }
                    }
                    return [...this.flights]
                }
            }
        }
        
        Vue.createApp(Flights).mount('#flightsSearchResultPage')
    </script>
@endsection