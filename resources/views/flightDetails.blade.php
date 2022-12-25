@extends('layout.app')

@section('title')
    Регистрация на рейс
@endsection

@section('main')

<style>

    .form-control, .form-select{
        border-color: #265BE3;
    }

    .left-part p, .left-part b{
        color: #265BE3;
    }

    .decorLine{
            display: block;
            height: 0.313rem;
            background-color: #265BE3;
            width: 50%;
    }

    .flights>.row{
        padding-left: calc(var(--bs-gutter-x)/ 2);
    }

    .form-check{
        padding-left: calc(var(--bs-gutter-x)/ 2);
    }

    .form-check-input{
        margin-right: 1rem;
        margin-left: 0 !important;
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

        .flights>.row{
            padding-right: calc(var(--bs-gutter-x)/ 2);
        }

        form .col-4{
            width: 50%;
        }

        form .col-2{
            width: 25%;
        }
    }

    @media(max-width: 767px){
        .seats .col-1{
            width: 12.5%;
        }

        .square{
            margin-right: 0.5rem !important;
        }

        form .col-4{
            width: 100%;
        }

        form .col-2{
            width: 50%;
        }

        .form-check-input{
            width: 20px;
            height: 20px;
        }

        .form-check label{
            font-size: 0.6rem;
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

        .seats .col-1{
            width: 16.6666%;
        }

        .right-part .row:last-child{
            padding-left: calc(var(--bs-gutter-x)/ 2);
        }

        .right-part .row:last-child .col{
            padding: 0;
        }

        .form-check-input{
            width: 30px;
            height: 22px;
        }

    }

    </style>

    <div class="container" id="flightDetailsPage">
        <div class="row mt-5">
            <h2 class="d-flex align-items-center justify-content-between mt-5">Выбор места <span class="decorLine"></span></h2>
            <div class="flights mt-5">
                <div class="row">
                    <div class="col-5 p-0 left-part" style="border-right: #265BE3 2px solid">
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
                        </div>                                                                                                                                                                                                          {{--                                                     расчёт цены билета                       ↓ для округления до двух знаков--}}
                        <p class="row align-items-end fw-bold price" style="padding-right: calc(var(--bs-gutter-x)/ 2);"><span class="col-4 fs-5">Стоимость</span> <span class="col-8 fs-2 text-end" style="transform: translateY(15%);">@{{Math.round((flight.airplane.price * (flight.percentPrice/100) + flight.airplane.price) * 100)/100}} руб.</span></p>
                    </div>
                    <div class="col-7 right-part">
                        <p>Выберите одно из предлагаемых мест.</p>
                        <i>Выход из самолёта находится в левой части расположения мест:</i>
                        <div class="row seats mt-4 flex-wrap">
                            <div class="col-1 mb-4" style="height:40px;" v-for="seat in flight.airplane.count_seats">
    {{-- для занятого места--}} <button v-if="occupiedSeats.includes(seat)" class="btn p-0 h-100 text-white" :id="`seat_${seat}`" style="width:40px; background-color: black;">@{{seat}}</button>   
  {{-- для незанятого места--}} <button v-else class="btn btn-primary p-0 h-100 text-white" :id="`seat_${seat}`" style="width:40px" @click="selectSeat(seat)">@{{seat}}</button>  
                            </div>
                        </div>
                        <div class="row mt-5">
                            <div class="col d-flex align-items-center">
                                <div class="square" style="width: 20px; height: 20px; background-color: #265BE3; border-radius: 5px; margin-right: 2rem;"></div>
                                <p class="m-0">свободно</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="square" style="width: 20px; height: 20px; background-color: black; border-radius: 5px; margin-right: 2rem;"></div>
                                <p class="m-0">занято</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <div class="square" style="width: 20px; height: 20px; background-color: #F4C82C; border-radius: 5px; margin-right: 2rem;"></div>
                                <p class="m-0">выбрано вами</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 mb-5">
            <h2 class="d-flex align-items-center justify-content-between mt-5">Регистрация на рейс <span class="decorLine"></span></h2>
            <p class="mt-5">Заполните личные данные для покупки и оформления билета<br>
                <b>ВНИМАНИЕ!</b> Если вы покупаете билет не для себя, введите данные человека, на которого оформляете билет</p>
            <form method="post" id="buyTicketForm" @submit.prevent = 'buyTicket'>

                <div class="row">
                    <div class="col-4 mb-4">
                        <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО" :class="errors.fio ? 'is-invalid' : '' ">
                        <div :class="errors.fio ? 'invalid-feedback' : '' " v-for="error in errors.fio">
                            @{{error}}
                        </div>
                    </div>
                    
                    <div class="col-4 mb-4">
                        {{-- <label for="birthday" class="form-label text-black-50 m-0" style="padding-left: 1rem; position: absolute;">дата рождения</label> --}}
                        <input type="text" class="form-control" id="birthday" name="birthday" :class="errors.birthday ? 'is-invalid' : '' " placeholder="дата рождения" onfocus="(this.type='date')">
                        <div :class="errors.birthday ? 'invalid-feedback' : '' " v-for="error in errors.birthday">
                            @{{error}}
                        </div>
                    </div>

                    <div class="col-4 mb-4">
                        <input type="number" class="form-control" id="passport" name="passport" placeholder="серия и номер паспорта" :class="errors.passport ? 'is-invalid' : '' " v-model="passport" :disabled="certificate!=''">
                        <div :class="errors.passport ? 'invalid-feedback' : '' " v-for="error in errors.passport">
                            @{{error}}
                        </div>
                    </div>

                    <div class="col-4 mb-3">
                        <input type="number" class="form-control" id="birthCertificate" name="birthCertificate" placeholder="номер свидетельства о рождении" :class="errors.birthCertificate ? 'is-invalid' : '' " v-model="certificate" :disabled="passport!=''">
                        <i>*eсли билет оформляется для ребёнка</i>
                        <div :class="errors.birthCertificate ? 'invalid-feedback' : '' " v-for="error in errors.birthCertificate">
                            @{{error}}
                        </div>
                    </div>

                    {{-- <div class="col-2 mb-3">
                        <input type="number" class="form-control" id="seatNumber" name="seatNumber" placeholder="номер места" :class="errors.seatNumber ? 'is-invalid' : '' ">
                        <div :class="errors.seatNumber ? 'invalid-feedback' : '' " v-for="error in errors.seatNumber">
                            @{{error}}
                        </div>
                    </div>

                    <div class="col-2 mb-3">
                        <input type="number" class="form-control" id="flightNumber" name="flightNumber" placeholder="номер рейса" :class="errors.flightNumber ? 'is-invalid' : '' ">
                        <div :class="errors.flightNumber ? 'invalid-feedback' : '' " v-for="error in errors.flightNumber">
                            @{{error}}
                        </div>
                    </div> --}}

                    <div class="col-4 mb-3">
                        <input type="password" class="form-control" id="password" name="password" placeholder="пароль" :class="errors.password ? 'is-invalid' : '' ">
                        <div :class="errors.password ? 'invalid-feedback' : '' " v-for="error in errors.password">
                            @{{error}}
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="mb-3 form-check d-flex position-relative">
                        <label class="form-check-label" style="order: 2" for="agreement"><i>Я знаком с политикой конфиденциальности и даю свое согласие на обработку персональных данных.</i></label>
                        <input type="checkbox" class="form-check-input" id="agreement" name="agreement" :class="errors.agreement ? 'is-invalid' : '' ">
                        <div :class="errors.agreement ? 'invalid-feedback' : '' " v-for="error in errors.agreement" class="position-absolute" style="bottom:-1rem">
                            @{{error}}
                        </div>
                    </div>
                </div>

                @auth()
                    <div class="d-flex align-items-center">
                        <button type="submit" class="btn btn-warning text-white mt-3" style="padding-left: 2rem; padding-right: 2rem">оформить</button>
                        <div :class="errors.seat ? 'text-danger' : '' " v-for="error in errors.seat" class="mt-3" style="margin-left: 1rem">
                            @{{error}}
                        </div>
                    </div>
                @endauth
                 
                @guest
                <a href='{{route('authPage')}}' class="btn btn-warning text-white mt-3" style="padding-left: 2rem; padding-right: 2rem">оформить</a>
                @endguest
            </form>    
        </div>
    </div>

    <script>
        const FlightDetails = {
            data(){
                return {
                    flight: @json($flight),
                    occupiedSeats: @json($occupiedSeats),
                    months:['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
                    errors:[],
                    selectedSeat:'',
                    passport:'',
                    certificate:'',
                }
            },

            methods:{
                selectSeat(seat){
                    if (this.selectedSeat) {
                        $(`#seat_${this.selectedSeat}`).removeClass('btn-warning');
                    }
                    this.selectedSeat = seat;
                    $(`#seat_${seat}`).addClass('btn-warning');
                },

                async buyTicket(){
                    const form = $('#buyTicketForm')[0];
                    const form_data = new FormData(form);
                    form_data.append('flight', this.flight.id);
                    form_data.append('seat', this.selectedSeat);
                    form_data.append('price', Math.round((this.flight.airplane.price * (this.flight.percentPrice/100) + this.flight.airplane.price) * 100)/100);
                    const response = await fetch('{{route('buyTicket')}}', {
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
                        window.location = response.url;
                    }
                }
            },
        }

        Vue.createApp(FlightDetails).mount('#flightDetailsPage');
    </script>
@endsection