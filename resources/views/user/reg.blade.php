@extends('layout.app')

@section('title')
    Регистрация
@endsection

@section('main')
    <style>
        .decorLine{
            display: block;
            height: 0.313rem;
            background-color: #265BE3;
            width: 50%;
        }

        .form-control{
            border-color: #265BE3;
        }

        .btn{
            background: #F4C82C;
            border: none;
        }
    </style>
    <div class="container d-flex justify-content-center align-items-center" style="min-height: 80vh" id="reg">
        <form class="col-4" @submit.prevent = "Registration" id="regForm" method="POST">
            <h1 class="d-flex align-items-center justify-content-between mb-4">Регистрация <span style="margin-left: 7%" class="decorLine"></span></h1>

            <div class="mb-4">
                <input type="text" class="form-control" id="fio" name="fio" placeholder="ФИО" :class="errors.fio ? 'is-invalid' : '' ">
                <div :class="errors.fio ? 'invalid-feedback' : '' " v-for="error in errors.fio">
                    @{{error}}
                </div>
            </div>
            <div class="mb-4">
                <label for="birthday" class="form-label">Дата рождения</label>
                <input type="date" class="form-control" id="birthday" name="birthday" :class="errors.birthday ? 'is-invalid' : '' ">
                <div :class="errors.birthday ? 'invalid-feedback' : '' " v-for="error in errors.birthday">
                    @{{error}}
                </div>
            </div>
            <div class="mb-4">
                <input type="number" class="form-control" id="passport" name="passport" placeholder="номер документа" :class="errors.passport ? 'is-invalid' : '' ">
                <div :class="errors.passport ? 'invalid-feedback' : '' " v-for="error in errors.passport">
                    @{{error}}
                </div>
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" id="login" name="login" placeholder="логин" :class="errors.login ? 'is-invalid' : '' ">
                <div :class="errors.login ? 'invalid-feedback' : '' " v-for="error in errors.login">
                    @{{error}}
                </div>
            </div>
            <div class="mb-4">
                <input type="text" class="form-control" id="phone" name="phone" placeholder="телефон" :class="errors.phone ? 'is-invalid' : '' ">
                <div :class="errors.phone ? 'invalid-feedback' : '' " v-for="error in errors.phone">
                    @{{error}}
                </div>
            </div>
            <div class="mb-4">
                <input type="email" class="form-control" id="email" name="email" placeholder="email" :class="errors.email ? 'is-invalid' : '' ">
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
            <div class="mb-4">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="подтвердите пароль">
            </div>
            <div class="mb-3 form-check">
                <label class="form-check-label" for="agreement">Я согласен на обработку данных</label>
                <input type="checkbox" class="form-check-input" id="agreement" name="agreement" :class="errors.agreement ? 'is-invalid' : '' ">
                <div :class="errors.agreement ? 'invalid-feedback' : '' " v-for="error in errors.agreement">
                    @{{error}}
                </div>
            </div>
            <button type="submit" class="btn col-6 btn-primary">регистрация</button>
        </form>
    </div>

    <script>
        const Reg = {
            data(){
                return {
                    errors:[],
                }
            },

            methods:{
                async Registration(){
                    const form = document.querySelector('#regForm');
                    const form_data = new FormData(form);
                    const response = await fetch('{{route('register')}}', {
                        method: 'post',
                        headers: {
                            'X-CSRF-TOKEN': '{{csrf_token()}}'
                        },
                        body:form_data,
                    });

                    if(response.status === 200){
                        window.location = response.url;
                    }

                    if(response.status === 400){
                        this.errors = await response.json();
                    }
                }
            }
        }

        Vue.createApp(Reg).mount('#reg');
    </script>
@endsection
