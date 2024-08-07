<x-app-layout :title="$pageTitle">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        @if (session('error'))
            <div class="alert alert-danger text-white p-1">
                <span>{{ session('error') }}</span>
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success text-white p-1">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        <form action="{{ route('admin.userList') }}" method="get" name="formSearch" id="formSearch">
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="User Name" name="name" :value="$searchParams['name'] ?? old('name')" />
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-6 ">
                    <x-forms.text-group label="Started Date From" id="started_date_from" name="started_date_from"
                        :value="$searchParams['started_date_from'] ?? old('started_date_from')" />

                </div>
                <div class="col-sm-6">
                    <x-forms.text-group label="Started Date To" id="started_date_to" name="started_date_to"
                        :value="$searchParams['started_date_to'] ?? old('started_date_to')" />
                </div>
            </div>
            <div class="row d-flex">
                <div class="col-sm-5 gap-5 mr-md-4 d-sm-none d-md-block">
                </div>
                <div class="col-sm-6 gap-5 ml-md-3 ml-sm-0">
                    <x-button.userlist label="Clear" class="btn btn-secondary m-1 text-truncate" type="button"
                        style="width: 100px;" id="btnClear" name="btnClear"></x-button.userlist>
                    <x-button.userlist label="Search" class="btn btn-secondary m-1 text-truncate" style="width: 100px;"
                        id="btnSearch"></x-button.userlist>
                </div>
            </div>

        </form>
    </div>
    <div class="mx-sm-1 col-sm-12">
        @if (isset($users))
            @if (count($users) > 0)
                
                <div class="row mt-5">
                    <div class="col-sm-12 table-container m-0 p-0">
                        <div class="d-flex justify-content-end my-4">
                            {{ $users->links('common.pagination') }}
                        </div>
                        <table class="table table-bordered table-responsive-md list-user-table" style="table-layout: fixed; width: 100%;">
                            <thead>
                                <tr>
                                    <th class="fw-normal text-center" style="width: 25%;">User Name</th>
                                    <th class="fw-normal text-center" style="width: 25%;">Email</th>
                                    <th class="fw-normal text-center" style="width: 20%;">Group Name</th>
                                    <th class="fw-normal text-center" style="width: 15%;">Started Date</th>
                                    <th class="fw-normal text-center" style="width: 15%;">Position</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                    <tr>
                                        <td>
                                            @if (Auth::user()->position_id == 0)
                                                <a href="{{ route('admin.edit', ['id' => $user->id]) }}" class="">
                                                    {{ nl2br($user->name) }}
                                                </a>
                                            @else
                                                {{ nl2br($user->name) }}
                                            @endif
                                        </td>
                                        <td>
                                            {{ nl2br($user->email) }}
                                        </td>
                                        <td>
                                            {{ nl2br($user->group->name ?? '') }}
                                        </td>
                                        <td>
                                            {{ nl2br($user->started_date != null ? $user->started_date->format('d/m/Y') : '') }}
                                        </td>
                                        <td>
                                            {{ nl2br($user->getPosition()) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @elseif ($messageNotFound != '')
                <div class="row mt-5 mx-1">
                    <div class="col-sm-12 h-25 w-100 py-3 d-flex justify-content-center align-items-center">
                        <span class="mx-1 text-gray">
                            <h4> {{ $messageNotFound }}</h4>
                        </span>
                    </div>
                </div>
            @endif

        @endif
    </div>
    <div class="mx-sm-5 col-sm-8">
        @if (Auth::user()->position_id == 0)
            <div class="row d-block">
                <div class="col">
                    <x-button.userlist label="Add New" class="btn btn-secondary m-1 text-truncate" type="button"
                        style="width: 100px;" id="btnNew" name="btnNew"></x-button.userlist>
                    @if (isset($users) && count($users) > 0)
                        <form action="{{ route('admin.userExport') }}" method="post" style="display: inline;">
                            @csrf
                            <x-button.userlist label="Export CSV" class="btn btn-secondary m-1 text-truncate"
                                style="width: 100px;" id="btnExport" name="btnExport"></x-button.userlist>
                        </form>
                    @endif
                </div>
            </div>
        @endif
    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userList.js'], 'build')
    @endpush
</x-app-layout>
