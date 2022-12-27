@extends('layout.app')

@section('title')
    Мои билеты
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

            #ticketsPage>.row>div{
                width: 100%;
            }

            .filters>.row{
                width: 75% !important;
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

            .flights .row{
                padding-right: var(--bs-gutter-x,.75rem) !important;
                padding-left: var(--bs-gutter-x,.75rem) !important;
            }
        }

    </style>
    <div class="container" id="ticketsPage">

        <h2 class="text-center m-5">Мои билеты</h2>

        <div class="row mt-5">
            <div class="flights col-9" style="margin: 0 auto">
                <div class="row mb-5" v-for='(ticket, index) in mixArrays'>
                    <div class="col-7 p-0 left-part" style="border-right: #265BE3 2px solid">
                        <a :href="`{{route('flightDetailsPage')}}/${ticket.flight.id}`" class="blue-top d-flex text-decoration-none align-items-center p-3 mb-4" style="background-color: #265BE3">
                            <b style="width: 5rem" class="text-white">@{{ticket.flight.airplane.title}}</b>
                            <p class="m-0 row w-100 text-white"><span class="col">@{{ticket.flight.from_city.title}}</span> <span class="col-3 arrow">&rarr;</span> <span class="col">@{{ticket.flight.to_city.title}}</span></p>
                        </a>
                        <div class="time row">
                            <div class="col">
                                <p>@{{ticket.flight.dateFrom.slice(8,10)}} @{{months[Number(ticket.flight.dateFrom.slice(5,7))-1]}} @{{ticket.flight.dateFrom.slice(0,4)}}</p>
                                <p style="font-size: 2rem">@{{ticket.flight.timeFrom.slice(0,-3)}}</p>
                                <p>@{{ticket.flight.from_city.title}}</p>
                            </div>
                            <div class="col d-flex align-items-center">
                                <p>@{{ticket.flight.timeWay.slice(0,2)}} ч @{{ticket.flight.timeWay.slice(3,5)}} мин</p>
                            </div>
                            <div class="col">
                                <p>@{{ticket.flight.dateTo.slice(8,10)}} @{{months[Number(ticket.flight.dateTo.slice(5,7))-1]}} @{{ticket.flight.dateTo.slice(0,4)}}</p>
                                <p style="font-size: 2rem">@{{ticket.flight.timeTo.slice(0,-3)}}</p>
                                <p>@{{ticket.flight.to_city.title}}</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-5 right-part">
                        <p class="row"><span class="col">Номер рейса:</span> <span class="col-5 text-end">@{{ticket.flight.id}}</span></p>
                        <p class="row"><span class="col">Место:</span> <span class="col-5 text-end">@{{ticket.seat}}</span></p>
                        <p class="row"><span class="col">ФИО:</span> <span class="col-8 text-end">@{{ticket.fio}}</span></p>
                        <p class="row" v-if="ticket.passport"><span class="col">Серия и номер паспорта:</span> <span class="col-5 text-end">@{{ticket.passport}}</span></p>
                        <p class="row" v-if="ticket.certificate"><span class="col">Номер свидетельства о рождении:</span> <span class="col-5 text-end">@{{ticket.certificate}}</span></p>
                        <p class="row"><span class="col">Статус рейса:</span> <span class="col-5 text-end">@{{ticket.flight.status}}</span></p>
                        <p class="row"><span class="col">Статус билета:</span> <span class="col-5 text-end">@{{ticket.status}}</span></p>                                                                 {{--                                                 расчёт цены билета                       ↓ для округления до двух знаков--}}
                        <p class="row align-items-end fw-bold price"><span class="col-4 fs-5">Стоимость</span> <span class="col-8 fs-2 text-end" style="transform: translateY(15%)">@{{Math.round((ticket.flight.airplane.price * (ticket.flight.percentPrice/100) + ticket.flight.airplane.price) * 100)/100}} руб.</span></p>
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" :data-bs-target="`#deleteModal_${ticket.id}`">Отказаться</button>

                        {{-- Модальное окно для подтверждения удаления --}}
                        <div class="modal fade" tabindex="-1" :id="`deleteModal_${ticket.id}`">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <h3 class="text-danger">Вы действительно хотите отказаться от билета?<br>В случае если он не был использован, уплаченная стоимость возвращена не будет.</h3>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                  <button type="button" class="btn btn-danger" @click='deleteTicket(ticket.id)'>Удалить</button>
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
        const Tickets = {
            data(){
                return{
                    errors:[],
                    flights:@json($flights),
                    tickets:@json($tickets),
                    message:'',
                    status:'',

                    months:['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'],
                }
            },

            methods:{
              async deleteTicket(id){
                    const response = await fetch(`{{route('deleteTicket')}}/${id}`, {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        }
                    });

                    if(response.status === 200){
                        window.location = response.url;
                    }
              },
            },

            computed:{

                filterTickets(){
                    if(this.status){
                        return this.mixArrays.filter(ticket => ticket.status == this.status);
                    }
                    return this.mixArrays;
                },

                mixArrays(){
                    this.tickets.forEach((ticket,key) => {
                        ticket['flight']=this.flights[key];
                    });
                    return this.tickets
                }

            },
        }

        Vue.createApp(Tickets).mount('#ticketsPage');
    </script>
@endsection
