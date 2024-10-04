<!DOCTYPE html>
<html dir="{{App::isLocale('ar') ? "rtl" : "ltr" }}" lang="{{App::currentLocale()}}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    @stack('styles')
    <title>{{ $title }}</title>
</head>

<body>

    <header>
        <nav class="navbar navbar-expand-lg bg-body-tertiary mb-5">
            <div class="container ">
                <a class="navbar-brand" href="{{ route('classrooms.index') }}">{{ config("app.name", 'Laravel') }}</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <x-user-notification-menu />
                        {{-- <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('classrooms.create') }}">Create</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                                aria-expanded="false">
                                Dropdown
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" aria-disabled="true">Disabled</a>
                        </li> --}}
                    </ul>
                    {{-- <div class="d-flex align-items-center rounded">
                        <div class="image">
                            <img style="width: 50px; height: 50px; border-radius:100%" class="me-3"
                                src="{{ asset('images/user.jpg') }}" class="img-circle elevation-2" alt="User Image">
                </div>
            </div> --}}
            {{-- <a href="#" style="text-decoration: none; color: #000"
                                class="d-block">{{ Auth::user()->name }}</a> --}}


            <div class="me-3">
                <!-- Button trigger modal -->
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Join
                    <i class="fa-solid fa-arrow-right fa-bounce"></i>
                </button>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Enter The code to Join Classroom
                                </h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form action="{{ route('classrooms.join-by-code') }}" method="get">
                                    <div class="form-floating mb-3">
                                        <input type="text" name="code" class="form-control" id="code"
                                            placeholder="Enter code">
                                        <label for="code">Code</label>

                                    </div>
                                    <div>
                                        <button type="submit" class="btn btn-outline-success">join</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="dropdown">
                <div class="image">
                    <a class="" style="text-decoration: none;color:#000" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @if (Auth::user()->profile->user_img_path)
                        <img style="width: 50px; height: 50px; border-radius:100%" class="me-3"
                            src="{{ Storage::disk('public')->url(Auth::user()->profile->user_img_path) }}"
                            class="img-circle elevation-2" alt="User Image">
                        @else
                        {{Auth::user()->name}}
                        @endif
                    </a>
                    <ul class="dropdown-menu text-center">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                @if (Auth::user()->profile->user_img_path)
                                <img style="width: 30px; height: 30px; border-radius:100%" class="me-3"
                                    src="{{ Storage::disk('public')->url(Auth::user()->profile->user_img_path) }}"
                                    class="img-circle elevation-2" alt="User Image">
                                @endif
                                {{ Auth::user()->name }}</a>
                        </li>
                        <li>
                        <li>
                            <form action="{{route('logout')}}" method="post">
                                @csrf

                                <button type="submit" class="dropdown-item text-center">
                                    logout</button>
                            </form>
                        </li>
                        {{-- <li><a class="dropdown-item" href="#"></a></li> --}}
                    </ul>
                </div>


            </div>
            </div>
            {{-- <div class="me-5">
                        <span>{{ Auth::user()->name }}</span>
            </div> --}}
            {{-- <form class="d-flex" role="search">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form> --}}

            </div>
            </div>
        </nav>
    </header>


    <main>
        {{ $slot }}
    </main>

    <footer class="d-flex flex-wrap justify-content-between align-items-center py-3 my-4 border-top">
        <div class="col-md-4 d-flex align-items-center">
            <a href="/" class="mb-3 me-2 mb-md-0 text-body-secondary text-decoration-none lh-1">
                <svg class="bi" width="30" height="24">
                    <use xlink:href="#bootstrap"></use>
                </svg>
            </a>
            <span class="mb-3 mb-md-0 text-body-secondary">© 2023 {{ Config("app.name") }}, Inc</span>
        </div>

        <ul class="nav col-md-4 justify-content-end list-unstyled d-flex">
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#twitter"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#instagram"></use>
                    </svg></a></li>
            <li class="ms-3"><a class="text-body-secondary" href="#"><svg class="bi" width="24" height="24">
                        <use xlink:href="#facebook"></use>
                    </svg></a></li>
        </ul>
    </footer>
    <script src="{{ asset("js/bootstrap.min.js") }}"></script>
    <script src="{{ asset('js/axios.min.js') }}"></script>
    <script src="{{ asset("js/bootstrap.bundle.min.js") }}"></script>
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <script src="{{ asset('js/sweet_alert.js') }}"></script>
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
    <script>
        var classroomId;
        const userId = {{Auth::id()}}
    </script>
    @stack('scripts')
    @vite(['resources/js/app.js'])
</body>

</html>
