@extends('layout.app')

@section('title')
    Рейсы
@endsection

@section('main')
    <style>

        .form-control{
            border-color: #265BE3;
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

        <h2 class="text-center m-5 col-12">Рейсы <button type="button" class="btn text-primary fw-bold fs-5" data-bs-toggle="modal" data-bs-target="#addModal">+</button></h2>

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

        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Название</th>
                <th scope="col">Город</th>
                <th scope="col">Действие</th>
              </tr>
            </thead>
            <tbody>
               <tr v-for="(flight, key) in flights">
                <th scope="row">@{{key+1}}</th>
                <td></td>
                <td></td>
                <td>
                    <div class="d-flex">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" :data-bs-target="`#deleteModal_${flight.id}`">Удалить</button>

                        {{-- Модальное окно для подтверждения удаления --}}
                        <div class="modal fade" tabindex="-1" :id="`deleteModal_${flight.id}`">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <h3 class="text-danger">Подтвердите удаление рейса "@{{flight.title}}"</h3>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                  <button type="button" class="btn btn-danger" @click='deleteFlight(flight.id)'>Удалить</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        <button data-bs-toggle="modal" :data-bs-target="`#editModal_${flight.id}`" class="btn btn-warning text-white" style="margin-left: 1rem">Редактировать</button>
                        
                        {{-- Модальное окно для редактирования --}}
                        <div class="modal fade" :id="`editModal_${flight.id}`" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h3 class="modal-title" id="addModalLabel">Редактировать рейс "@{{flight.title}}"</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="col-12" method="post" enctype="multipart/form-data" :id="`editForm_${flight.id}`" @submit.prevent = 'editFlight(flight.id)'>
            
                                        <div class="mb-4">
                                            <input type="text" :class="errors.title ? 'is-invalid' : '' " class="form-control" id="title" name="title" :value="flight.title" placeholder="название">
                                            <div :class="errors.title ? 'invalid-feedback' : '' " v-for="error in errors.title">
                                             @{{error}}
                                            </div>
                                        </div>
            
                                        <div class="mb-4">
                                            <select name="city" id="city" :class="errors.city ? 'is-invalid' : '' " class="form-select">
                                                <option value="" selected>Город</option>
                                                <option v-for="city in cities" :value="city.id" :selected="city.id == flight.city_id">@{{city.title}}</option>
                                            </select>
                                            <div :class="errors.city ? 'invalid-feedback' : '' " v-for="error in errors.city">
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
                </td>
              </tr>   
            </tbody>
          </table>
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
                    this.flights = data.flights;
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
                        this.dateFrom='';
                        this.dateTo='';
                        this.timeFrom='';
                        this.timeTo='';
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
                        form.reset();
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
