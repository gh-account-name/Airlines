@extends('layout.app')

@section('title')
    Главная
@endsection

@section('main')
    <style>
        .searchTickets{
            background: linear-gradient(89.28deg, #2A27CB 3.49%, #265BE3 45.04%, #4BC4F9 93.82%);
            height: 70vh;
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
    </style>

    <div class="searchTickets d-flex align-items-center">
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
                <div class="col">
                    <a href="#" class="direction d-block" style="background: url('https://realrussia.co.uk/portals/0/images/Moscow%20St%20Basils%20Cathedral.jpg') no-repeat center; background-size:cover; height:21rem; border-radius:0.625rem; filter: brightness(0.7);"></a>
                </div>
                <div class="col">
                    <a href="#" class="direction d-block" style="background: url('https://tripplanet.ru/wp-content/uploads/europe/russia/st-petersburg/saint-isaacs-cathedral.jpg') no-repeat center; background-size:cover; height:21rem; border-radius:0.625rem;"></a>
                </div>
                <div class="col">
                    <a href="#" class="direction d-block" style="background: url('https://planetofhotels.com/guide/sites/default/files/styles/node__blog_post__bp_banner/public/2021-06/Central-District-of-Sochi.jpeg') no-repeat center; background-size:cover; height:21rem; border-radius:0.625rem;"></a>
                </div>
                <div class="col">
                    <a href="#" class="direction d-block" style="background: url('https://upload.wikimedia.org/wikipedia/commons/8/85/Saint_Basil%27s_Cathedral_and_the_Red_Square.jpg') no-repeat center; background-size:cover; height:21rem; border-radius:0.625rem;"></a>
                </div>
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
