@extends('layout.app')

@section('title')
    Пользователи
@endsection

@section('main')
    <style>

        .form-control{
            border-color: #265BE3;
        }

    </style>
    <div class="container" id="usersPage">

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

        <h2 class="text-center m-5">Пользователи</h2>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Логин</th>
                <th scope="col">Дата рождения</th>
                <th scope="col">Номер документа</th>
                <th scope="col">Email</th>
                <th scope="col">Телефон</th>
                <th scope="col">Действие</th>
              </tr>
            </thead>
            <tbody>
               <tr v-for="(user, key) in users">
                <th scope="row">@{{key+1}}</th>
                <td>@{{user.fio}}</td>
                <td>@{{user.login}}</td>
                <td>@{{user.birthday}}</td>
                <td>@{{user.passport}}</td>
                <td>@{{user.email}}</td>
                <td>@{{user.phone}}</td>
                <td>
                    <div class="d-flex">
                        <button class="btn btn-danger" type="button" data-bs-toggle="modal" :data-bs-target="`#deleteModal_${user.id}`">Удалить</button>

                        {{-- Модальное окно для подтверждения удаления --}}
                        <div class="modal fade" tabindex="-1" :id="`deleteModal_${user.id}`">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <div class="modal-body">
                                  <h3 class="text-danger">Подтвердите удаление пользователя "@{{user.fio}}"</h3>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Отмена</button>
                                  <button type="button" class="btn btn-danger" @click='deleteUser(user.id)'>Удалить</button>
                                </div>
                              </div>
                            </div>
                          </div>

                        <button data-bs-toggle="modal" :data-bs-target="`#editModal_${user.id}`" class="btn btn-warning text-white" style="margin-left: 1rem">Редактировать</button>
                        
                        {{-- Модальное окно для редактирования --}}
                        <div class="modal fade" :id="`editModal_${user.id}`" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h3 class="modal-title" id="addModalLabel">Редактировать пользователя "@{{user.fio}}"</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="col-12" method="post" enctype="multipart/form-data" :id="`editForm_${user.id}`" @submit.prevent = 'editUser(user.id)'>
            
                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО" :class="errors.fio ? 'is-invalid' : '' " :value="user.fio">
                                            <div :class="errors.fio ? 'invalid-feedback' : '' " v-for="error in errors.fio">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="birthday" class="form-label">Дата рождения</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday ? 'is-invalid' : '' " :value="user.birthday">
                                            <div :class="errors.birthday ? 'invalid-feedback' : '' " v-for="error in errors.birthday">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <input type="number" class="form-control" id="passport" name="passport" placeholder="номер документа" :class="errors.passport ? 'is-invalid' : '' " :value="user.passport">
                                            <div :class="errors.passport ? 'invalid-feedback' : '' " v-for="error in errors.passport">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="login" name="login" placeholder="логин" :class="errors.login ? 'is-invalid' : '' " :value="user.login">
                                            <div :class="errors.login ? 'invalid-feedback' : '' " v-for="error in errors.login">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="телефон" :class="errors.phone ? 'is-invalid' : '' " :value="user.phone">
                                            <div :class="errors.phone ? 'invalid-feedback' : '' " v-for="error in errors.phone">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email" :class="errors.email ? 'is-invalid' : '' " :value="user.email">
                                            <div :class="errors.email ? 'invalid-feedback' : '' " v-for="error in errors.email">
                                                @{{error}}
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="пароль" :class="errors.password ? 'is-invalid' : '' ">
                                            <div :class="errors.password ? 'invalid-feedback' : '' " v-for="error in errors.password">
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
        const Users = {
            data(){
                return{
                    errors:[],
                    users:[],
                    message:'',
                }
            },

            methods:{
                async getUsers(){
                    const response = await fetch('{{route('getUsers')}}');
                    const data = await response.json();
                    this.users = data.users;
                }, 

                async editUser(id){
                    const form = $(`#editForm_${id}`)[0];
                    const form_data = new FormData(form);
                    const response = await fetch(`{{route('editUser')}}/${id}`, {
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
                        this.getUsers();
                    }
                },
                
                async deleteUser(id){
                    const response = await fetch(`{{route('deleteUser')}}/${id}`, {
                        method:'post',
                        headers:{
                            'X-CSRF-TOKEN':'{{csrf_token()}}'
                        }
                    });

                    if(response.status === 200){
                        $(`#deleteModal_${id}`).modal('hide');
                        this.message = await response.json();
                        $('#messageModal').modal('show');
                        this.getUsers();
                    }
                },
                
            },

            mounted(){
                this.getUsers();
                $('#messageModal').on('shown.bs.modal', function (e) {
                    $(".modal-backdrop").css({ opacity: 0 });
                });
            },

        }

        Vue.createApp(Users).mount('#usersPage');
    </script>
@endsection
