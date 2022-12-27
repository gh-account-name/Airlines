@extends('layout.app')

@section('title')
    Личный кабинет
@endsection

@section('main')
    <style>
        .invalid-feedback{
            font-size: 1rem;
        }

        @media(max-width:991px){
            .user-data>div{
                width: 100%;
                padding-bottom: 2rem;
            }
        }
    </style>

    <div class="container" id="cabinetPage">
        <h1 class="text-center m-5">Личный кабинет</h1>
        <div class="user-data row">
            <div class="user-avatar-login d-flex flex-wrap justify-content-center col-5">
                {{-- <img style="width: 50%;" class="p-3" src="{{asset('public/storage/public/user-icon.png')}}" alt="Avatar"> --}}
                <span class="d-flex justify-content-center align-items-center m-3" style="background: url('{{asset('public/storage/user-icon.png')}}') center no-repeat;background-size: cover; border-radius: 1000px; width: 300px; height: 300px;">
                    {{-- <img style="width: 100%;" src="https://wallpapers.com/images/hd/cool-picture-wolf-art-o0ixt449edz5dgpa.jpg" alt="Avatar"> --}}
                </span>
                <div class="user-login col-12 d-flex justify-content-center">
                    <p class="h2 fw-bold">{{Auth::user()->login}}</p>
                </div>
            </div>
            <div class="col-7 h3 d-flex flex-wrap align-items-center">
                <div class="row ">
                    <b class="w-auto p-0">ФИО:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->fio}}</p>
                </div>
                <div class="row col-12">
                    <b class="w-auto p-0">Дата рождения:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->birthday}}</p>
                </div>
                @if(Auth::user()->passport)
                <div class="row col-12">
                    <b class="w-auto p-0">Серия и номер паспорта:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->passport}}</p>
                </div>
                @endif
                @if(Auth::user()->certificate)
                <div class="row col-12">
                    <b class="w-auto p-0">Свидетельство о рождении:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->certificate}}</p>
                </div>
                @endif
                <div class="row col-12">
                    <b class="w-auto p-0">Email:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->email}}</p>
                </div>
                <div class="row col-12">
                    <b class="w-auto p-0">Телефон:&nbsp;</b><p class="w-auto p-0">{{Auth::user()->phone}}</p>
                </div>
                <div class="row">
                    <button data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-warning text-white">Изменить данные</button>

                        {{-- Модальное окно для редактирования --}}
                        <div class="modal fade" id="editModal" tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                <h3 class="modal-title" id="addModalLabel">Редактировать данные</h3>
                                </div>
                                <div class="modal-body">
                                    <form class="col-12" method="post" id="editForm" @submit.prevent = 'editUser({{Auth::id()}})'>

                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО" :class="errors.fio ? 'is-invalid' : '' " value="{{Auth::user()->fio}}">
                                            <div :class="errors.fio ? 'invalid-feedback' : '' " v-for="error in errors.fio">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <label for="birthday" class="form-label" style="font-size: 1rem">Дата рождения</label>
                                            <input type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday ? 'is-invalid' : '' " value="{{Auth::user()->birthday}}">
                                            <div :class="errors.birthday ? 'invalid-feedback' : '' " v-for="error in errors.birthday">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="number" class="form-control" id="passport" name="passport" placeholder="номер документа" :class="errors.passport ? 'is-invalid' : '' " value="{{Auth::user()->passport}}">
                                            <div :class="errors.passport ? 'invalid-feedback' : '' " v-for="error in errors.passport">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="login" name="login" placeholder="логин" :class="errors.login ? 'is-invalid' : '' " value="{{Auth::user()->login}}">
                                            <div :class="errors.login ? 'invalid-feedback' : '' " v-for="error in errors.login">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="text" class="form-control" id="phone" name="phone" placeholder="телефон" :class="errors.phone ? 'is-invalid' : '' " value="{{Auth::user()->phone}}">
                                            <div :class="errors.phone ? 'invalid-feedback' : '' " v-for="error in errors.phone">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="email" :class="errors.email ? 'is-invalid' : '' " value="{{Auth::user()->email}}">
                                            <div :class="errors.email ? 'invalid-feedback' : '' " v-for="error in errors.email">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="password" class="form-control" id="old_password" name="old_password" placeholder="старый пароль" :class="errors.old_password ? 'is-invalid' : '' ">
                                            <div :class="errors.old_password ? 'invalid-feedback' : '' " v-for="error in errors.old_password">
                                                @{{error}}
                                            </div>
                                        </div>
                                        <div class="mb-4">
                                            <input type="password" class="form-control" id="new_password" name="new_password" placeholder="новый пароль" :class="errors.new_password ? 'is-invalid' : '' ">
                                            <div :class="errors.new_password ? 'invalid-feedback' : '' " v-for="error in errors.new_password">
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

    <script>
        const Cabinet = {
            data(){
                return{
                    errors:[],
                }
            },

            methods:{

                async editUser(id){
                    const form = $('#editForm')[0];
                    const form_data = new FormData(form);
                    const response = await fetch(`{{route('editUserData')}}/${id}`, {
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
                },

            },

        }

        Vue.createApp(Cabinet).mount('#cabinetPage');
    </script>
@endsection
