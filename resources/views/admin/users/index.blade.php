@extends('admin/index')

@section('title')
    Admin|Сотрудники
@endsection

@section('content')
    <div class="container mainUsersContainerBlock">
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('createError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('createError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('successCreate'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('successCreate') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('updateStatusError'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('updateStatusError') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('updateStatusSuccess'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('updateStatusSuccess') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
            Добавить сотрудника
        </button>

        <table class="table mainUsersTable">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">ФИО</th>
                <th scope="col">Почта</th>
                <th scope="col">Роль</th>
                <th scope="col">Должность</th>
                <th scope="col">Адрес</th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>
                <th scope="col"></th>

            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                @if($user->status != \App\Classes\UserStatusEnum::BLOCKED)
                    <tr>

                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->fio }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary updateStatus" id="updateStatus"
                                    data-id="{{ $user->id }}"
                                    data-toggle="modal" data-target="#some">
                                {{ $user->role }}
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary updatePost" id="updatePost"
                                    data-id="{{ $user->id }}"
                                    data-toggle="modal" data-target="#changePost">
                                {{ $user->post->name }}
                            </button>
                        </td>
                        <td>{{ $user->address }}</td>

                        <td>
                            <a href="{{ route('user.edit', [$user->id]) }}" type="button" class="btn btn-success">
                                Изменить
                            </a>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning blockUser" data-id="{{ $user->id }}"
                                    data-toggle="modal"
                                    data-target="#blockUser">
                                Заблокировать
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger deleteUser" data-id="{{ $user->id }}"
                                    data-toggle="modal"
                                    data-target="#deleteUser">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-basket" viewBox="0 0 16 16">
                                    <path d="M5.757 1.071a.5.5 0 0 1 .172.686L3.383 6h9.234L10.07 1.757a.5.5 0 1 1 .858-.514L13.783 6H15a1 1 0 0 1 1 1v1a1 1 0 0 1-1 1v4.5a2.5 2.5 0 0 1-2.5 2.5h-9A2.5 2.5 0 0 1 1 13.5V9a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h1.217L5.07 1.243a.5.5 0 0 1 .686-.172zM2 9v4.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V9H2zM1 7v1h14V7H1zm3 3a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 4 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 6 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3A.5.5 0 0 1 8 10zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5zm2 0a.5.5 0 0 1 .5.5v3a.5.5 0 0 1-1 0v-3a.5.5 0 0 1 .5-.5z"/>
                                </svg>
                            </button>
                        </td>

                        <td>
                            <form action="{{ route('users.history') }}" method="get">
                                <input type="hidden" name="user_id" value="{{ $user->id }}">
                                <button type="submit" class="btn btn-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clock-history" viewBox="0 0 16 16">
                                        <path d="M8.515 1.019A7 7 0 0 0 8 1V0a8 8 0 0 1 .589.022l-.074.997zm2.004.45a7.003 7.003 0 0 0-.985-.299l.219-.976c.383.086.76.2 1.126.342l-.36.933zm1.37.71a7.01 7.01 0 0 0-.439-.27l.493-.87a8.025 8.025 0 0 1 .979.654l-.615.789a6.996 6.996 0 0 0-.418-.302zm1.834 1.79a6.99 6.99 0 0 0-.653-.796l.724-.69c.27.285.52.59.747.91l-.818.576zm.744 1.352a7.08 7.08 0 0 0-.214-.468l.893-.45a7.976 7.976 0 0 1 .45 1.088l-.95.313a7.023 7.023 0 0 0-.179-.483zm.53 2.507a6.991 6.991 0 0 0-.1-1.025l.985-.17c.067.386.106.778.116 1.17l-1 .025zm-.131 1.538c.033-.17.06-.339.081-.51l.993.123a7.957 7.957 0 0 1-.23 1.155l-.964-.267c.046-.165.086-.332.12-.501zm-.952 2.379c.184-.29.346-.594.486-.908l.914.405c-.16.36-.345.706-.555 1.038l-.845-.535zm-.964 1.205c.122-.122.239-.248.35-.378l.758.653a8.073 8.073 0 0 1-.401.432l-.707-.707z"></path>
                                        <path d="M8 1a7 7 0 1 0 4.95 11.95l.707.707A8.001 8.001 0 1 1 8 0v1z"></path>
                                        <path d="M7.5 3a.5.5 0 0 1 .5.5v5.21l3.248 1.856a.5.5 0 0 1-.496.868l-3.5-2A.5.5 0 0 1 7 9V3.5a.5.5 0 0 1 .5-.5z"></path>
                                    </svg>
                                </button>
                            </form>
                        </td>
                    </tr>
                @elseif($user->status == \App\Classes\UserStatusEnum::BLOCKED)
                    <tr>

                        <th scope="row">{{ $user->id }}</th>
                        <td>{{ $user->fio }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <button type="button" class="btn btn-outline-primary updateStatus" id="updateStatus"
                                    data-id="{{ $user->id }}"
                                    data-toggle="modal" data-target="#some" disabled>
                                {{ $user->role }}
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-outline-primary updatePost" id="updatePost"
                                    data-id="{{ $user->id }}"
                                    data-toggle="modal" data-target="#changePost" disabled>
                                {{ $user->post->name }}
                            </button>
                        </td>
                        <td>{{ $user->address }}</td>

                        <td>
                            <button type="button" class="btn btn-success confirmUpdating" data-toggle="modal"
                                    data-target="#updateUser" disabled>
                                Изменить
                            </button>
                        </td>
                        <td>
                            <button type="button" class="btn btn-warning unblockUser" data-id="{{ $user->id }}"
                                    data-toggle="modal"
                                    data-target="#unBlockUser">
                                Разблокировать
                            </button>
                        </td>
                    </tr>
                @endif
            @endforeach

            </tbody>
        </table>
    </div>

    <div class="modal fade" id="deleteUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Удаление пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" class="row g-3 needs-validation" action="{{ route('delete_user') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="content modalDeleteCheck">
                            <input type="hidden" class="user_delete_id" name="user_id">
                            <p>Вы уверены, что хотите удалить пользователя?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-danger">Удалить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="blockUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Блокировка пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" class="row g-3 needs-validation" action="{{ route('block.user') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="content" style="margin-left: 25px;margin-right: 15px;">
                            <input type="hidden" class="user_block_id" name="user_id">
                            <p>Вы уверены, что хотите заблокировать пользователя?</p>
                            <label>Введите причину блокировки</label>
                            <textarea class="form-control" name="blocked_reason" required></textarea>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Введите причину
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-warning">Заблокировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="unBlockUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Разблокировка пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" class="row g-3 needs-validation" action="{{ route('unblock.user') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="content modalDeleteCheck">
                            <input type="hidden" class="user_unblock_id" name="user_id">
                            <p>Вы уверены, что хотите разблокировать пользователя?</p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-warning">Разблокировать</button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <div class="modal fade" id="some" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменение статуса</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" class="row g-3 needs-validation" action="{{ route('update_status') }}" novalidate>
                    @csrf
                    <div class="modal-body">
                        <input class="status_id" value="" name="id" type="hidden">
                        <select class="form-select modalChangeStatus" name="status"
                                aria-label="Default select example" required>
                            <option selected disabled value="">Выберите роль</option>
                            <option value="{{ \App\Classes\UserRolesEnum::EMPLOYEE }}">Сотрудник</option>
                            <option value="{{ \App\Classes\UserRolesEnum::ADMIN }}">Руководитель</option>
                        </select>
                        <div class="valid-feedback">
                            Отлично
                        </div>
                        <div class="invalid-feedback">
                            Выберите роль
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Изменить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Добавление пользователя</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" class="row g-3 needs-validation" action="{{ route('add.user') }}" novalidate>
                    @csrf
                    <div class="modal-body modalAddBlock">
                        <div>
                            <input name="email" placeholder="Введите почту" type="email"
                                   class=" emailInput form-control" required>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Введите почту
                            </div>
                        </div>
                        <div>
                            <select class="form-select chosePositionSelector" name="post_id"
                                    aria-label="Default select example" required>
                                <option selected disabled value="">Выберите должность</option>
                                @foreach($posts as $post)
                                    <option value="{{$post->id}}">{{ $post->name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Выберите должность
                            </div>
                        </div>
                        <div>
                            <select class="form-select chosePositionSelector" name="role"
                                    aria-label="Default select example" required>
                                <option selected disabled value="">Выберите роль</option>
                                <option value="{{ \App\Classes\UserRolesEnum::EMPLOYEE }}">Сотрудник</option>
                                <option value="{{ \App\Classes\UserRolesEnum::ADMIN }}">Руководитель</option>
                            </select>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Выберите роль
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <div class="modal fade" id="changePost" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Изменения должности</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form method="post" action="{{ route('update.user.post') }}" class="row g-3 "
                      novalidate>
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-4">
                            <input class="change_id" type="hidden" name="user_id">
                            <select class="form- emailInput" name="position_id"
                                    aria-label="Default select example" required>
                                <option selected disabled value="">Выберите должность</option>
                                @foreach($posts as $post)
                                    <option value="{{$post->id}}">{{ $post->name }}</option>
                                @endforeach
                            </select>
                            <div class="valid-feedback">
                                Отлично
                            </div>
                            <div class="invalid-feedback">
                                Выберите должность
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Закрыть</button>
                        <button type="submit" class="btn btn-primary">Добавить</button>
                    </div>
                </form>


            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.updatePost').click(function () {
                let id = $(this).data('id');

                document.querySelector('.change_id').value = id;
            });
        });

        $('.updateStatus').click(function () {
            let id = $(this).data('id');
            document.querySelector('.status_id').value = id;
        });

        $('.blockUser').click(function () {
            let id = $(this).data('id');
            document.querySelector('.user_block_id').value = id;
        });

        $('.deleteUser').click(function () {
            let id = $(this).data('id');
            document.querySelector('.user_delete_id').value = id;
        });

        $('.unblockUser').click(function () {
            let id = $(this).data('id');
            document.querySelector('.user_unblock_id').value = id;
        });

        $('.confirmUpdating').click(function () {
            let id = $(this).data('id');
            //document.querySelector('.post_id_udpate').value = id;
            $.ajax({
                url: 'http://localhost:8000/api/admin/users/' + id,
                type: "GET",
                success: function (data) {
                    document.querySelector('.post_id_update').value = data['id'];
                    document.querySelector('.name').value = data['name'];
                    document.querySelector('.name_parent_case').value = data['name_parent_case'];
                    console.log(data);
                }
            });
        });

    </script>
@endsection

