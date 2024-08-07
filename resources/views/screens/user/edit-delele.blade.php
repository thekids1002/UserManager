<x-app-layout :title="$pageTitle">
    @php
        $isDisable = false;
        if (in_array(Auth::user()->position_id, [1, 2, 3])) {
            $isDisable = true;
        }
    @endphp
    <div class="mb-sm-5 mx-sm-2 pt-5 col-sm-11">
        @if (session('error'))
            <div class="alert alert-danger text-white p-1">
                <span>{{ session('error') }}</span>
            </div>
        @endif
            <div class="error-delete">
                
            </div>
            {{-- FORM UPDATE --}}

            @php
            $route = 'admin.handleEdit';
                if(isset($user)) {
                    if(Auth::id() == $user->id && Auth::user()->position_id != 0) {
                        $route = 'admin.updatePassword';
                    }
                }
            @endphp
            <form action="{{ route($route,$user->id) }}" method="POST" name="formEditUser"
                id="formEditUser">
                @method('put')
                @csrf
                <div class="row pt-2">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group" style="">
                            <label class=" col-6">
                                ID
                            </label>
                            <div class="col-sm-6">
                                {{-- select2 --}}
                                <input type="hidden" value="{{ $user->id}}" name="id" id="id">
                                <input type="text" name="" value="{{ $user->id}}" class="form-control" id="" placeholder="" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <x-forms.text-group label="User Name" name="name" :isRequired="true" :value="old('name') ?? $user->name"  :isDisabled="$isDisable" />
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <x-forms.text-group label="Email" id="email" name="email" :isRequired="true"  :isDisabled="$isDisable"
                            :value="old('email') ?? $user->email"/>
                        <input type="hidden" value="" data-add-route="{{route('admin.checkEmail')}}" name="check_mail_url" id="check_mail_url">
                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Group
                            </label>   
                        <div class="col-sm-6">
                            {{-- select2 --}}
                            <select class="form-select text-truncate border rounded-1 " name="group_id" {{ $isDisable ? 'disabled' : '' }}>
                                @php
                                    $selected = old('group_id') ?? $user->group_id;
                                @endphp
                                <option value="null">---</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}"@if ($selected == $group->id) selected @endif>{{ $group->name }}</option>
                                @endforeach
                            </select>
                            <x-error-message field="group_id" />
                        </div>

                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <x-forms.text-group label="Started Date" id="started_date" name="started_date"  :isDisabled="$isDisable"
                            :isRequired="true" :value="old('started_date') ?? $user->started_date->format('d/m/Y')" />

                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <div class="input-group" style="">
                            <label class="input-required col-6">
                                Position
                            </label>

                            @php

                                $positions = [
                                    '0' => 'Director',
                                    '1' => 'Group Leader',
                                    '2' => 'Leader',
                                    '3' => 'Member',
                                ];
                                $selected = old('position_id') ?? $user->position_id;

                            @endphp
                            <div class="col-sm-6">
                                <select class="form-select text-truncate border rounded-1" name="position_id" {{ $isDisable ? 'disabled' : '' }}>
                                    <option value="null">---</option>
                                    @foreach ($positions as $positionValue => $positionLabel)
                                        <option value="{{ $positionValue }}"{{ $positionValue == $selected ? 'selected' : '' }}>{{ $positionLabel }}</option>
                                    @endforeach
                                </select>
                                <x-error-message field="position_id" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row pt-2">
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <x-forms.text-group type="password" label="Password" id="password" name="password"
                            :value="old('password')" />

                    </div>
                    <div class="col-sm-1">
                    </div>
                    <div class="col-sm-5">
                        <x-forms.text-group type="password" label="Password Confirmation" id="repassword"
                            name="repassword" : :value="old('repassword')" />
                    </div>
                </div>

                <div class="row ">
                    <div class="col-sm-9  d-flex justify-content-between">
                        <div class="" style="width: 100px;"></div>
                       
                        <x-button.userlist label="Update" class="btn btn-secondary  text-truncate" type="button"
                            type="submit" style="width: 100px;" id="updateButton"
                            name="updateButton"></x-button.userlist>
                            <x-button.userlist label="Delete" class="btn btn-secondary  text-truncate" type="button"
                            style="width: 100px;"  id="deleteButton" name="deleteButton"></x-button.userlist>
                        {{-- <a class="btn btn-secondary  text-truncate" href="/admin/user/delete/{{$user->id}}"
                            style="width: 100px;" id="deleteButton">Delete</a> --}}

                            <a class="btn btn-secondary  text-truncate" href="/admin/user/cancle"
                                style="width: 100px;" id="Cancel">Cancel</a> 
                    </div>
                </div>

            </form>
            <input type="hidden" value="{{Auth::user()->id}}" name="current-userId" id="current-userId">
       
    </div>
<!-- Modal -->
<div class="modal fade" id="deleteUserModal" tabindex="-1" aria-labelledby="deleteUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="/admin/user/delete/{{$user->id}}" method="get" 
                name="" id="deleteUserForm">
                <div class="row">
                    <div class="d-flex align-items-center justify-content-center"> このユーザーを削除してもいいですか？</div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary"  id="okButton">OK</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
    @push('scripts')
        @vite(['resources/js/screens/user/userEdit.js'], 'build')
    @endpush

</x-app-layout>
