@extends('layout.app')

@section('title')
    Главная
@endsection

@section('main')
    <style>
        .searchTickets{
            background: linear-gradient(89.28deg, #2A27CB 3.49%, #265BE3 45.04%, #4BC4F9 93.82%);
            min-height: 70vh;
            color: white;
        }

        .searchTickets .btn{
            /* background: #F4C82C; */
            border-radius: 0.3125rem;
            height: 4.25rem;
            margin-top: auto;
            color: white;
            width: 100%;
        }

        .searchTickets .form-control{
            height: 4.25rem;
        }

        .searchTickets .form-label{
            font-size: 1.25rem;
        }

        .decorLine{
            display: block;
            height: 0.313rem;
            background-color: #265BE3;
            width: 50%;
        }

        @media(max-width:991px){

            form>div{
                width: 100% !important;
            }

            form>.p-0>button{
                width: 25% !important;
                height: 50px !important;
            }

            form>.p-0>label{
                display: none;
            }

            form>.p-0{
                display:  flex;
                justify-content: center;
                height: 50px !important;
            }

            form input{
                font-size: 1.5rem !important;
            }

            form .btn-warning{
                width: 50% !important;
                font-size: 1.5rem !important;
                margin-top: 1rem !important;
                margin: 1rem auto 0 auto !important;
            }

            .popularDirections  .col-3{
                width: 50% !important;
                margin-top: 1.5rem !important;
            }

            .allFlights{
                font-size: 0.7rem;
            }
        }

         @media(max-width:420px){

            .searchTickets h1{
                font-size: 3rem !important;
            }

            .popularDirections  .col-3{
                width: 100% !important;
                /* margin-top: 1.5rem !important;  */
            }

            .allFlights{
                font-size: 0.5rem;
            }
        }
    </style>

    <div class="searchTickets d-flex align-items-center pb-5">
        <div class="container">
            <h1 style="font-size: 4rem" class="mb-3 text-white">Поиск авиабилетов</h1>
            <form action="{{route('flightsSearchResultPage')}}" class="row" method="get">
                @csrf
                @method('get')
                <div class="mb-3 col-3">
                    <label for="from" class="form-label">откуда</label>
                    <input type="text" class="form-control" id="from" name="from" required v-model='fromInput'>
                </div>
                <div class="p-0" style="width: 2rem">
                    <label for="" class="form-label" style="opacity: 0">pad</label>
                    <button tabindex="-1" type="button" class="btn p-0" @click='swapInputsValues'>&rarr;<br>&larr;</button>
                </div>
                <div class="mb-3 col-3">
                    <label for="to" class="form-label">куда</label>
                    <input type="text" class="form-control" id="to" name="to" required v-model='toInput'>
                </div>
                <div class="mb-3 col-3">
                    <label for="date" class="form-label">когда</label>
                    <input type="date" class="form-control" id="date" name="date">
                </div>
                <div class="mb-3 col-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-warning">найти</button>
                </div>
            </form>
        </div>
    </div>
    <div class="popularDirections">
        <div class="container">
            <h2 class="d-flex align-items-center justify-content-between mt-5">Популярные направления <span class="decorLine"></span></h2>
            <div class="row">
                @foreach ($popular_directions as $popular_direction)
                  <div class="col-3 position-relative">
                    <div class="direction d-block" style="background: url({{asset('/public/'.$popular_direction->img)}}) no-repeat center; background-size:cover; height:21rem; border-radius:0.625rem; filter: brightness(0.7);"></div>
                    <h1 class="text-white position-absolute fw-bold" style="font-size: 2rem; bottom: 8%; left:10%">@php echo str_replace(' ', '<br>',$popular_direction->title) @endphp</h1>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <div class="allFlights">
        <div class="container">
            <h2 class="d-flex align-items-center justify-content-between mt-5">Все рейсы <span class="decorLine"></span></h2>
            <table class="w-100">
                <tr style="font-weight: normal; color: #265BE3; border-bottom: 2px #265BE3 solid; line-height: 3rem">
                    <td>откуда</td>
                    <td>куда</td>
                    <td>дата и время вылета</td>
                    <td>цена билета</td>
                </tr>
                <tr style="line-height: 3rem" v-for='flight in flights'>
                    <td>@{{flight.from_city.title}}</td>
                    <td>@{{flight.to_city.title}}</td>
                    <td>@{{flight.dateFrom}} года</td>
                    <td>@{{Math.round((flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price) * 100)/100}} руб.</td>
                </tr>
            </table>
        </div>
    </div>

    <script>
        const AllFlights = {
            data(){
                return {
                    flights:[],
                }
            },

            methods:{
                async getFlights(){
                    const response = await fetch('{{route('getFlights')}}');
                    const data = await response.json();
                    this.flights = data.flights_user;
                },
            },

            mounted(){
                this.getFlights();
            }
        }

        Vue.createApp(AllFlights).mount('.allFlights');

        const SearchTickets = {
            data(){
                return {
                    fromInput:'',
                    toInput:'',
                }
            },

            methods:{
                swapInputsValues(){
                    if (this.fromInput || this.toInput){
                        [this.fromInput,this.toInput] = [this.toInput, this.fromInput];
                    }
                }
            },
        }

        Vue.createApp(SearchTickets).mount('.searchTickets');

    </script>

@endsection
