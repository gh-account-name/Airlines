<style>
    .navbar{
        background: linear-gradient(89.28deg, #2A27CB 3.49%, #265BE3 45.04%, #4BC4F9 93.82%);
    }

    .navbar-toggler-custom{
        background: none;
        border: none;
        border-radius: 0.7rem;
        transition: .3s;
    }

    .navbar-toggler-custom:hover{
        transform: scale(.9);
        transition: .3s;
    }

    .offcanvas{
        background: rgba(42, 39, 203, 0.5);
        /* height: 70vh; */
    }

    .nav-link{
        color: white;
        font-size: 1.125rem;
    }

    .nav-link svg{
        margin-right: 1.875rem;
    }

    .nav-link:focus, .nav-link:hover {
        color: rgba(244, 200, 44, 1);
    }

    svg{
        stroke: white;
        transition: .3s;
    }
    .nav-link:hover svg, .nav-link:focus svg{
        stroke: rgba(244, 200, 44, 1) !important;
        transition: .3s;
    }


</style>
<nav class="navbar bg-light">
    <div class="container-fluid container">
        <a class="navbar-brand" href="{{route('mainPage')}}"><img src="{{asset('public/storage/logo.png')}}" alt="logo"></a>
        <button class="navbar-toggler-custom" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar">
            <img src="{{asset('public/storage/navbutton.svg')}}" alt="">
        </button>
        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
            @auth()
                <div class="userIcon p-5 pb-0" style="display: flex; align-items: center; justify-content:flex-start;">
                    <span class="d-flex justify-content-center align-items-center" style="background: white url('{{asset('public/storage/user-icon.png')}}') center no-repeat;background-size: cover; border-radius: 1000px; width: 60px; height: 60px;">
                        {{-- <img style="width: 100%;" src="{{asset('public\storage\user-icon.png')}}" alt="Avatar"> --}}
                    </span>
                    <p class="text-white h4" style="margin:0 0 0 1rem; font-weight: bold;">{{\Illuminate\Support\Facades\Auth::user()->login}}</p>
                </div>
            @endauth
            <div class="offcanvas-header p-5">
                <h5 class="offcanvas-title" style="cursor: pointer; color: white; font-weight: 700; font-size: 1.5rem" data-bs-dismiss="offcanvas" id="offcanvasNavbarLabel">Меню</h5>
            </div>
            <div class="offcanvas-body p-5 pt-0">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item d-flex align-items-center">
                        <a class="nav-link" aria-current="page" href="{{route('mainPage')}}">
                            <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M5.20832 5.20832L14.7917 14.7917M14.7917 5.20832L5.20832 14.7917M17.4583 12.125L12.1333 17.45C10.9667 18.6167 9.04999 18.6167 7.87499 17.45L2.54999 12.125C1.38332 10.9583 1.38332 9.04166 2.54999 7.86666L7.87499 2.54166C9.04165 1.37499 10.9583 1.37499 12.1333 2.54166L17.4583 7.86666C18.625 9.04166 18.625 10.9583 17.4583 12.125Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                            Главная</a>
                    </li>
                    @guest()
                        <li class="nav-item d-flex justify-content-between">
                            <a class="nav-link" aria-current="page" href="{{route('authPage')}}">
                                <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7.41669 6.30001C7.67502 3.30001 9.21669 2.07501 12.5917 2.07501H12.7C16.425 2.07501 17.9167 3.56668 17.9167 7.29168V12.725C17.9167 16.45 16.425 17.9417 12.7 17.9417H12.5917C9.24169 17.9417 7.70002 16.7333 7.42502 13.7833M1.66669 10H12.4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.5417 7.20834L13.3334 10L10.5417 12.7917" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Авторизация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{route('regPage')}}">
                                <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9.99998 9.99999C11.105 9.99999 12.1649 9.561 12.9463 8.7796C13.7277 7.9982 14.1666 6.93839 14.1666 5.83332C14.1666 4.72825 13.7277 3.66845 12.9463 2.88704C12.1649 2.10564 11.105 1.66666 9.99998 1.66666C8.89491 1.66666 7.8351 2.10564 7.0537 2.88704C6.2723 3.66845 5.83331 4.72825 5.83331 5.83332C5.83331 6.93839 6.2723 7.9982 7.0537 8.7796C7.8351 9.561 8.89491 9.99999 9.99998 9.99999V9.99999Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M16.0083 13.1167L13.0583 16.0667C12.9417 16.1833 12.8333 16.4 12.8083 16.5583L12.65 17.6833C12.5917 18.0917 12.875 18.375 13.2833 18.3167L14.4083 18.1583C14.5667 18.1333 14.7917 18.025 14.9 17.9083L17.85 14.9583C18.3583 14.45 18.6 13.8583 17.85 13.1083C17.1083 12.3667 16.5167 12.6083 16.0083 13.1167V13.1167Z" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M15.5833 13.5417C15.8333 14.4417 16.5333 15.1417 17.4333 15.3917" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M2.84167 18.3333C2.84167 15.1083 6.05001 12.5 10 12.5C10.8667 12.5 11.7 12.625 12.475 12.8583" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                                Регистрация</a>
                        </li>
                    @endguest
                   @auth()
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="{{route('myTicketsPage')}}">
                                <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M16.25 10.4167C16.25 9.86413 16.4695 9.33423 16.8602 8.94353C17.2509 8.55283 17.7808 8.33333 18.3334 8.33333V7.5C18.3334 4.16667 17.5 3.33333 14.1667 3.33333H5.83335C2.50002 3.33333 1.66669 4.16667 1.66669 7.5V7.91667C2.21922 7.91667 2.74913 8.13616 3.13983 8.52686C3.53053 8.91756 3.75002 9.44746 3.75002 10C3.75002 10.5525 3.53053 11.0824 3.13983 11.4731C2.74913 11.8638 2.21922 12.0833 1.66669 12.0833V12.5C1.66669 15.8333 2.50002 16.6667 5.83335 16.6667H14.1667C17.5 16.6667 18.3334 15.8333 18.3334 12.5C17.7808 12.5 17.2509 12.2805 16.8602 11.8898C16.4695 11.4991 16.25 10.9692 16.25 10.4167Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M8.33331 3.33333V16.6667" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="5 5"/>
                                </svg>                                                                 
                                Мои билеты</a>
                        </li>
                       @if(\Illuminate\Support\Facades\Auth::user()->role === 'admin')
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('citiesPage')}}">
                                    <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M10.8334 18.9583H4.16669C2.15002 18.9583 1.04169 17.85 1.04169 15.8333V9.16667C1.04169 7.15 2.15002 6.04167 4.16669 6.04167H8.33335C8.67502 6.04167 8.95835 6.325 8.95835 6.66667V15.8333C8.95835 17.15 9.51669 17.7083 10.8334 17.7083C11.175 17.7083 11.4584 17.9917 11.4584 18.3333C11.4584 18.675 11.175 18.9583 10.8334 18.9583ZM4.16669 7.29167C2.85002 7.29167 2.29169 7.85 2.29169 9.16667V15.8333C2.29169 17.15 2.85002 17.7083 4.16669 17.7083H8.16669C7.86669 17.2167 7.70835 16.5917 7.70835 15.8333V7.29167H4.16669Z" fill="white"/>
                                        <path d="M8.33335 7.29167H4.16669C3.82502 7.29167 3.54169 7.00833 3.54169 6.66667V5C3.54169 3.73333 4.56669 2.70833 5.83335 2.70833H8.42502C8.61669 2.70833 8.80002 2.8 8.91669 2.95C9.03335 3.10833 9.07502 3.30833 9.02502 3.49167C8.97502 3.675 8.95835 3.88333 8.95835 4.16667V6.66667C8.95835 7.00833 8.67502 7.29167 8.33335 7.29167ZM4.79169 6.04167H7.70835V3.95833H5.83335C5.25835 3.95833 4.79169 4.425 4.79169 5V6.04167ZM11.6667 11.4583C11.325 11.4583 11.0417 11.175 11.0417 10.8333V6.66667C11.0417 6.325 11.325 6.04167 11.6667 6.04167C12.0084 6.04167 12.2917 6.325 12.2917 6.66667V10.8333C12.2917 11.175 12.0084 11.4583 11.6667 11.4583ZM15 11.4583C14.6584 11.4583 14.375 11.175 14.375 10.8333V6.66667C14.375 6.325 14.6584 6.04167 15 6.04167C15.3417 6.04167 15.625 6.325 15.625 6.66667V10.8333C15.625 11.175 15.3417 11.4583 15 11.4583ZM15 18.9583H11.6667C11.325 18.9583 11.0417 18.675 11.0417 18.3333V15C11.0417 14.2 11.7 13.5417 12.5 13.5417H14.1667C14.9667 13.5417 15.625 14.2 15.625 15V18.3333C15.625 18.675 15.3417 18.9583 15 18.9583ZM12.2917 17.7083H14.375V15C14.375 14.8833 14.2834 14.7917 14.1667 14.7917H12.5C12.3834 14.7917 12.2917 14.8833 12.2917 15V17.7083ZM5.00002 14.7917C4.65835 14.7917 4.37502 14.5083 4.37502 14.1667V10.8333C4.37502 10.4917 4.65835 10.2083 5.00002 10.2083C5.34169 10.2083 5.62502 10.4917 5.62502 10.8333V14.1667C5.62502 14.5083 5.34169 14.7917 5.00002 14.7917Z" fill="white"/>
                                        <path d="M15.8333 18.9583H10.8333C8.81665 18.9583 7.70831 17.85 7.70831 15.8333V4.16667C7.70831 2.15 8.81665 1.04167 10.8333 1.04167H15.8333C17.85 1.04167 18.9583 2.15 18.9583 4.16667V15.8333C18.9583 17.85 17.85 18.9583 15.8333 18.9583ZM10.8333 2.29167C9.51665 2.29167 8.95831 2.85 8.95831 4.16667V15.8333C8.95831 17.15 9.51665 17.7083 10.8333 17.7083H15.8333C17.15 17.7083 17.7083 17.15 17.7083 15.8333V4.16667C17.7083 2.85 17.15 2.29167 15.8333 2.29167H10.8333Z" fill="white"/>
                                    </svg>
                                    Города</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('airportsPage')}}">
                                    <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <g clip-path="url(#clip0_11_16)">
                                        <path d="M4.2098 12.7825C4.11292 12.6856 4.02928 12.5667 3.97644 12.4346C3.8575 12.1396 3.87071 11.8093 4.01607 11.523L4.40359 10.748C4.57974 10.3957 4.98928 10.1447 5.3812 10.1403L7.38487 10.1359C7.41129 10.1359 7.47731 10.1051 7.49935 10.083L8.58703 8.99534L5.71148 7.85476C5.32835 7.70065 5.06853 7.41441 4.99806 7.07095C4.92763 6.72742 5.0509 6.35755 5.33715 6.0713L5.90522 5.50323C6.33679 5.07166 7.10743 4.91754 7.65348 5.15534L11.0663 6.50726L12.317 5.25662C12.8498 4.72378 13.8362 4.48598 14.5584 4.71497C14.7261 4.7697 14.8785 4.86324 15.0032 4.98796C15.1279 5.11269 15.2215 5.26508 15.2762 5.43277C15.5096 6.15938 15.2762 7.14138 14.7434 7.67422L13.4927 8.92486L14.8578 12.3509C15.0824 12.9102 14.9327 13.6588 14.4968 14.0948L13.9287 14.6628C13.6381 14.9535 13.277 15.0768 12.9291 15.0019C12.5812 14.9271 12.2993 14.6716 12.1408 14.2929L11.0003 11.4173L9.91256 12.505C9.89491 12.5227 9.86849 12.5843 9.86849 12.6107L9.86411 14.6232C9.86411 15.0107 9.60427 15.4291 9.2564 15.6008L8.48139 15.9883C8.1907 16.1293 7.86042 16.1425 7.5654 16.0148C7.27476 15.8914 7.05455 15.6537 6.95331 15.3586C6.94448 15.3233 6.93571 15.2881 6.93127 15.2485L6.76833 13.3594C6.76396 13.2933 6.68906 13.2273 6.63181 13.2229L4.74266 13.0599C4.70778 13.0594 4.67334 13.0519 4.64137 13.0379C4.47402 12.9939 4.3287 12.9014 4.2098 12.7825ZM9.44577 8.40964C9.54705 8.51092 9.61751 8.63423 9.64393 8.77514C9.69678 9.03056 9.6131 9.29037 9.41054 9.49294L8.15551 10.748C7.96612 10.9374 7.64905 11.0695 7.38483 11.0695L5.38117 11.0739C5.34157 11.0782 5.2579 11.1267 5.24029 11.1619L4.84833 11.9414C4.81752 11.9986 4.83075 12.047 4.83954 12.0735C4.84836 12.0911 4.86156 12.1219 4.89681 12.1395L6.71551 12.2936C7.23074 12.3333 7.6667 12.7692 7.70634 13.2845L7.86042 15.0944C7.8869 15.1296 7.91327 15.1472 7.93086 15.156C7.95734 15.1649 8.01013 15.1825 8.06741 15.1516L8.84247 14.7641C8.88808 14.7295 8.91942 14.6793 8.93051 14.6232L8.9349 12.6195C8.92613 12.3641 9.05824 12.0382 9.25202 11.8445L10.507 10.5894C10.7052 10.3913 10.9606 10.3032 11.2116 10.3517C11.4626 10.4001 11.6696 10.5807 11.7753 10.8449L13.0083 13.9451C13.048 14.0375 13.092 14.0816 13.114 14.0859C13.136 14.0903 13.1933 14.0683 13.2637 13.9979L13.8318 13.4298C13.9991 13.2624 14.074 12.9058 13.9859 12.6944L12.59 9.17585C12.4799 8.89846 12.5547 8.55053 12.7661 8.33916L14.0872 7.01806C14.3778 6.72742 14.5232 6.12414 14.3911 5.72781C14.3812 5.7005 14.3654 5.6757 14.3448 5.65516C14.3243 5.63462 14.2995 5.61883 14.2722 5.60891C13.8847 5.48561 13.2681 5.63533 12.9819 5.92157L11.6608 7.24267C11.4538 7.44964 11.1015 7.52891 10.8241 7.41881L7.30558 6.02286C7.08981 5.93038 6.73311 6.00524 6.57018 6.16818L6.00211 6.73625C5.93166 6.80669 5.90964 6.86394 5.91403 6.88597C5.91842 6.90801 5.96246 6.95205 6.05493 6.99168L9.15072 8.22028C9.26522 8.26432 9.3665 8.33038 9.44577 8.40964Z" fill="white"/>
                                        <rect x="1.5" y="1.5" width="17" height="17" rx="3.5" stroke-width="3"/>
                                        </g>
                                        <defs>
                                        <clipPath id="clip0_11_16">
                                        <rect width="20" height="20" fill="white"/>
                                        </clipPath>
                                        </defs>
                                    </svg>                                    
                                    Аэропорты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('flightsPage')}}">
                                    <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M13.65 18.9583H2.69999C1.90832 18.9583 1.17499 18.5917 0.699989 17.95C0.216656 17.3 0.0749892 16.4833 0.316656 15.7083L3.82499 4.43333C3.97947 3.92173 4.29477 3.47356 4.72409 3.15532C5.15342 2.83707 5.67391 2.66572 6.20832 2.66667H16.4583C17.4667 2.66667 18.375 3.26667 18.7583 4.2C18.9667 4.68333 19.0083 5.23333 18.8833 5.775L16.075 17.05C15.9458 17.5953 15.6358 18.0807 15.1954 18.4273C14.7551 18.7738 14.2103 18.961 13.65 18.9583V18.9583ZM6.21666 3.925C5.94974 3.92571 5.69006 4.01185 5.47563 4.1708C5.2612 4.32975 5.10328 4.55316 5.02499 4.80833L1.51666 16.0833C1.39999 16.475 1.46666 16.8833 1.71666 17.2167C1.94999 17.5333 2.31666 17.7167 2.70832 17.7167H13.6583C14.2333 17.7167 14.7333 17.325 14.8667 16.7667L17.675 5.48333C17.7417 5.20833 17.725 4.93333 17.6167 4.69167C17.4167 4.21667 16.975 3.91667 16.4667 3.91667H6.21666V3.925V3.925Z" fill="white"/>
                                        <path d="M17.3166 18.9583H13.3333C12.9916 18.9583 12.7083 18.675 12.7083 18.3333C12.7083 17.9917 12.9916 17.7083 13.3333 17.7083H17.3166C17.6583 17.7083 17.975 17.5675 18.2083 17.3175C18.4416 17.0675 18.5583 16.7342 18.5333 16.3925L17.7083 5.0425C17.6833 4.70083 17.9416 4.40083 18.2833 4.37583C18.625 4.35917 18.925 4.60917 18.95 4.95083L19.775 16.3008C19.825 16.9842 19.5833 17.6675 19.1166 18.1675C18.6583 18.6758 18 18.9592 17.3166 18.9592V18.9583ZM8.06665 5.94167C8.01665 5.94167 7.96665 5.93333 7.91665 5.925C7.83665 5.90549 7.76131 5.87036 7.69493 5.82164C7.62856 5.77292 7.57246 5.71156 7.52987 5.64109C7.48728 5.57062 7.45903 5.49244 7.44675 5.41102C7.43447 5.3296 7.4384 5.24656 7.45831 5.16667L8.32498 1.56667C8.36476 1.40533 8.46701 1.2664 8.60922 1.18044C8.67964 1.13788 8.75775 1.10961 8.8391 1.09724C8.92044 1.08486 9.00343 1.08864 9.08331 1.10833C9.1632 1.12803 9.23843 1.16327 9.30469 1.21204C9.37096 1.26081 9.42698 1.32216 9.46954 1.39258C9.5121 1.46299 9.54037 1.5411 9.55274 1.62245C9.56512 1.70379 9.56134 1.78678 9.54165 1.86667L8.67498 5.46667C8.60831 5.75 8.34998 5.94167 8.06665 5.94167V5.94167ZM13.65 5.95167C13.6083 5.95167 13.5583 5.95167 13.5166 5.935C13.3557 5.89804 13.2154 5.80008 13.1253 5.66174C13.0351 5.5234 13.0021 5.35548 13.0333 5.19333L13.8166 1.57667C13.8916 1.235 14.225 1.02667 14.5583 1.09333C14.8916 1.16 15.1083 1.50167 15.0416 1.835L14.2583 5.45167C14.2 5.75167 13.9416 5.95167 13.65 5.95167V5.95167ZM13.0833 10.625H6.41665C6.07498 10.625 5.79165 10.3417 5.79165 10C5.79165 9.65833 6.07498 9.375 6.41665 9.375H13.0833C13.425 9.375 13.7083 9.65833 13.7083 10C13.7083 10.3417 13.425 10.625 13.0833 10.625ZM12.25 13.9583H5.58331C5.24165 13.9583 4.95831 13.675 4.95831 13.3333C4.95831 12.9917 5.24165 12.7083 5.58331 12.7083H12.25C12.5916 12.7083 12.875 12.9917 12.875 13.3333C12.875 13.675 12.5916 13.9583 12.25 13.9583Z" fill="white"/>
                                    </svg>
                                    Рейсы</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="#">
                                    <svg style="width: 30px" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M16.25 10.4167C16.25 9.86413 16.4695 9.33423 16.8602 8.94353C17.2509 8.55283 17.7808 8.33333 18.3334 8.33333V7.5C18.3334 4.16667 17.5 3.33333 14.1667 3.33333H5.83335C2.50002 3.33333 1.66669 4.16667 1.66669 7.5V7.91667C2.21922 7.91667 2.74913 8.13616 3.13983 8.52686C3.53053 8.91756 3.75002 9.44746 3.75002 10C3.75002 10.5525 3.53053 11.0824 3.13983 11.4731C2.74913 11.8638 2.21922 12.0833 1.66669 12.0833V12.5C1.66669 15.8333 2.50002 16.6667 5.83335 16.6667H14.1667C17.5 16.6667 18.3334 15.8333 18.3334 12.5C17.7808 12.5 17.2509 12.2805 16.8602 11.8898C16.4695 11.4991 16.25 10.9692 16.25 10.4167Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M8.33331 3.33333V16.6667" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" stroke-dasharray="5 5"/>
                                    </svg>
                                    Билеты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('airplanesPage')}}">
                                    <svg style="width: 30px" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6.15168 17.7917C5.96835 17.7917 5.77668 17.7583 5.60168 17.6833C5.21001 17.5167 4.91001 17.1917 4.77668 16.7833L4.41001 15.6833C4.24335 15.1833 4.39335 14.5583 4.76001 14.1833L6.65168 12.2833C6.67668 12.2583 6.71001 12.1667 6.71001 12.125V10.0667L2.91001 11.7083C2.40168 11.925 1.88501 11.9 1.49335 11.6417C1.10168 11.3833 0.868347 10.9167 0.868347 10.375V9.3C0.868347 8.48333 1.45168 7.60833 2.19335 7.31667L6.70168 5.36667V3C6.70168 1.99167 7.41001 0.833333 8.31001 0.366666C8.52046 0.259799 8.75316 0.204102 8.98918 0.204102C9.22521 0.204102 9.4579 0.259799 9.66835 0.366666C10.5767 0.833333 11.285 1.98333 11.285 2.99167V5.35833L15.8183 7.30833C16.56 7.625 17.1267 8.475 17.1267 9.3V10.375C17.1267 10.925 16.9017 11.3833 16.5017 11.6417C16.1017 11.9 15.5933 11.925 15.085 11.7167L11.285 10.075V12.1333C11.285 12.1667 11.3183 12.25 11.3433 12.275L13.2433 14.1833C13.61 14.55 13.76 15.1917 13.5933 15.6833L13.2267 16.7833C13.085 17.1917 12.785 17.5167 12.385 17.675C11.9933 17.8333 11.56 17.8167 11.185 17.6333C11.1433 17.6083 11.1017 17.5833 11.06 17.55L9.11835 15.9167C9.05168 15.8583 8.91835 15.8667 8.86001 15.9167L6.91835 17.55C6.88485 17.5825 6.84518 17.608 6.80168 17.625C6.60168 17.7417 6.37668 17.7917 6.15168 17.7917ZM6.96835 8.7C7.16001 8.7 7.34335 8.75 7.50168 8.85833C7.79335 9.05 7.96001 9.375 7.96001 9.75833V12.1333C7.96001 12.4917 7.78501 12.9167 7.53501 13.1667L5.64335 15.0667C5.61001 15.1083 5.57668 15.2333 5.59335 15.2833L5.96001 16.3917C5.98501 16.475 6.04335 16.5083 6.07668 16.525C6.10168 16.5333 6.14335 16.55 6.19335 16.5333L8.06001 14.9583C8.58501 14.5083 9.41001 14.5083 9.93501 14.9583L11.7933 16.525C11.8517 16.5333 11.8933 16.525 11.9183 16.5167C11.9517 16.5 12.0183 16.4667 12.0433 16.3833L12.41 15.2833C12.4204 15.2074 12.4026 15.1303 12.36 15.0667L10.4683 13.1667C10.2183 12.9333 10.035 12.5 10.035 12.1333V9.75833C10.035 9.38333 10.1933 9.05833 10.4767 8.86667C10.76 8.675 11.1267 8.65 11.4767 8.8L15.5767 10.5667C15.7017 10.6167 15.785 10.6167 15.81 10.6C15.835 10.5833 15.8683 10.5083 15.8683 10.375V9.3C15.8683 8.98333 15.6017 8.575 15.3183 8.45833L10.6683 6.45C10.3017 6.29167 10.0433 5.89167 10.0433 5.49167V2.99167C10.0433 2.44167 9.61001 1.73333 9.11001 1.48333C9.07479 1.46688 9.03639 1.45835 8.99751 1.45835C8.95864 1.45835 8.92024 1.46688 8.88501 1.48333C8.40168 1.73333 7.96001 2.45833 7.96001 3V5.5C7.96001 5.89167 7.70168 6.3 7.33501 6.45833L2.68501 8.46667C2.39335 8.58333 2.12668 8.99167 2.12668 9.3V10.375C2.12668 10.5083 2.16001 10.5833 2.18501 10.6C2.21001 10.6167 2.29335 10.6167 2.41835 10.5667L6.51001 8.8C6.66001 8.73333 6.81835 8.7 6.96835 8.7Z" fill="white"/>
                                    </svg>
                                    Самолёты</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link active" aria-current="page" href="{{route('usersPage')}}">
                                    <svg style="width: 30px" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M12.675 3.33333C14.2917 3.33333 15.5917 4.64166 15.5917 6.25C15.5917 7.825 14.3417 9.10833 12.7833 9.16666C12.7113 9.15833 12.6386 9.15833 12.5667 9.16666M14.2833 16.6667C14.8833 16.5417 15.45 16.3 15.9167 15.9417C17.2167 14.9667 17.2167 13.3583 15.9167 12.3833C15.4583 12.0333 14.9 11.8 14.3083 11.6667M6.63333 9.05833C6.55 9.05 6.45 9.05 6.35833 9.05833C5.40183 9.02585 4.49553 8.62236 3.83135 7.9333C3.16718 7.24423 2.79728 6.32371 2.8 5.36666C2.8 3.325 4.45 1.66666 6.5 1.66666C7.48019 1.64898 8.42726 2.02141 9.13287 2.70201C9.83848 3.38261 10.2448 4.31563 10.2625 5.29583C10.2802 6.27603 9.90775 7.2231 9.22715 7.9287C8.54655 8.63431 7.61353 9.04065 6.63333 9.05833ZM2.46666 12.1333C0.449996 13.4833 0.449996 15.6833 2.46666 17.025C4.75833 18.5583 8.51666 18.5583 10.8083 17.025C12.825 15.675 12.825 13.475 10.8083 12.1333C8.525 10.6083 4.76666 10.6083 2.46666 12.1333V12.1333Z" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                    Пользователи</a>
                            </li>
                       @endif

                       <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="{{route('logout')}}">
                            <svg style="width: 30px" viewBox="0 0 20 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7.41667 6.5639C7.675 3.5639 9.21667 2.3389 12.5917 2.3389H12.7C16.425 2.3389 17.9167 3.83056 17.9167 7.55556V12.9889C17.9167 16.7139 16.425 18.2056 12.7 18.2056H12.5917C9.24167 18.2056 7.7 16.9972 7.425 14.0472M1.66667 10.2639H12.4" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4.45834 7.48057L1.66667 10.2722L4.45834 13.0639" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>                                                                                                  
                            Выйти</a>
                        </li>
                   @endauth
                </ul>
            </div>
        </div>
    </div>
</nav>
