@extends('layout.app')

@section('title')
    Города
@endsection

@section('main')
    <style>

        .form-control{
            border-color: #265BE3;
        }

    </style>
    <div class="container" id="citiesPage">

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

        <h2 class="text-center m-5 col-12">Города <button type="button" class="btn text-primary fw-bold fs-5" data-bs-toggle="modal" data-bs-target="#addModal">+</button></h2>

        {{-- Модальное окно для добавления --}}
        <div class="modal fade" id="addModal" tabindex="-1">
            <div class="modal-dialog modal-dialog-centered">
              <div class="modal-content">
                <div class="modal-header">
                  <h1 class="modal-title" id="addModalLabel">Добавить город</h1>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="col-12" method="post" enctype="multipart/form-data" id="addForm" @submit.prevent = 'addCity'>
            
                        <div class="mb-4">
                            <input type="text" :class="errors.title ? 'is-invalid' : '' " class="form-control" id="title" name="title" placeholder="название">
                            <div :class="errors.title ? 'invalid-feedback' : '' " v-for="error in errors.title">
                                @{{error}}
                            </div>
                        </div>
            
                        <div class="mb-4">
                            <label for="img" class="form-label">Картинка</label>
                            <input type="file" :class="errors.img ? 'is-invalid' : '' " class="form-control" id="img" name="img">
                            <div :class="errors.img ? 'invalid-feedback' : '' " v-for="error in errors.img">
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
                <th scope="col">Картинка</th>
                <th scope="col">Действие</th>
              </tr>
            </thead>
            <tbody>
               <tr v-for="(city, key) in cities">
                <th scope="row">@{{key+1}}</th>
                <td>@{{city.title}}</td>
                <td><img height="150" :src="city.img" alt="city"></td>
                <td>
                    <div class="d-flex">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" :data-bs-target="`#deleteModal_${city.id}`">Удалить</button>

                        {{-- Модальное окно для подтверждения удаления --}}
                        <div class="modal fade" tabindex="-1" :id="`deleteModal_${city.id}`">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <h3 class="text-danger">Подтвердите удаление города "@{{city.title}}"</h3>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                  <button type="button" class="btn btn-danger" @click='deleteCity(city.id)'>Удалить</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        <button data-bs-toggle="modal" :data-bs-target="`#editModal_${city.id}`" class="btn btn-warning text-white" style="margin-left: 1rem">Редактировать</button>
                        
                        {{-- Модальное окно для редактирования --}}
                        <div class="modal fade" :id="`editModal_${city.id}`" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h3 class="modal-title" id="addModalLabel">Редактировать город "@{{city.title}}"</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="col-12" method="post" enctype="multipart/form-data" :id="`editForm_${city.id}`" @submit.prevent = 'editCity(city.id)'>
            
                                        <div class="mb-4">
                                            <input type="text" :class="errors.title ? 'is-invalid' : '' " class="form-control" id="title" name="title" :value="city.title" placeholder="название">
                                            <div :class="errors.title ? 'invalid-feedback' : '' " v-for="error in errors.title">
                                             @{{error}}
                                            </div>
                                        </div>
            
                                        <div class="mb-4">
                                            <label for="img" class="form-label">Картинка</label>
                                            <input type="file" :class="errors.img ? 'is-invalid' : '' " class="form-control" id="img" name="img">
                                            <div :class="errors.img ? 'invalid-feedback' : '' " v-for="error in errors.img">
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
        const Cities = {
            data(){
                return{
                    errors:[],
                    cities:[],
                    message:'',
                    isModalOpen: false,
                }
            },

            methods:{
                async getCities(){
                    const response = await fetch('{{route('getCities')}}');
                    const data = await response.json();
                    this.cities = data.cities;
                }, 

                async addCity(){
                    const form = $('#addForm')[0];
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('addCity')}}', {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        },
                        body: form_data,
                    });

                    if(response.status === 403){
                        this.errors = await response.json();
                    }

                    if(response.status === 200){
                        form.reset();
                        $('#addModal').modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getCities();
                    }
                },

                async editCity(id){
                    const form = $(`#editForm_${id}`)[0];
                    const form_data = new FormData(form);
                    const response = await fetch(`{{route('editCity')}}/${id}`, {
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
                        this.getCities();
                    }
                },
                
                async deleteCity(id){
                    const response = await fetch(`{{route('deleteCity')}}/${id}`, {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        }
                    });

                    if(response.status === 200){
                        $(`#deleteModal_${id}`).modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getCities();
                    }
                },
                
            },

            mounted(){
                this.getCities();
                $('#messageModal').on('shown.bs.modal', function (e) {
                    $(".modal-backdrop").css({ opacity: 0 });
                });
            },

        }

        Vue.createApp(Cities).mount('#citiesPage');
    </script>
@endsection
