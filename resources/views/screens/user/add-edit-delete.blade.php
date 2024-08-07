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
        {{-- FORM INSERT --}}
        <form action="{{ route('admin.handleAdd') }}" method="post" name="formAddUser" id="formAddUser">
            @csrf
            <div class="row pt-2">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-5">
                    <div class="input-group" style="">
                        <label class=" col-6">
                            ID
                        </label>
                        <input type="hidden" name="id" value="">
                        <div class="col-sm-6 ">
                            <input type="text" name="" value="" class="form-control" id="" placeholder="" disabled>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-5">
                    <x-forms.text-group label="User Name" name="name" :isRequired="true" :isDisabled="$isDisable" :value="old('name')" />
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-1">
                </div>
                <div class="col-sm-5">
                    <x-forms.text-group label="Email" id="email" name="email" :isRequired="true" :value="old('email')"
                        :isDisabled="$isDisable" />
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
                            <select class="form-select text-truncate border rounded-1 " name="group_id"  {{ $isDisable ? 'disabled' : '' }}>
                                @php
                                    $oldSelected = old('group_id') ?? '';
                                @endphp
                                <option value="null">---</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}"@if ($oldSelected == $group->id) selected @endif>{{ $group->name }}</option>
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
                    <x-forms.text-group label="Started Date" id="started_date" name="started_date" :isRequired="true"
                        :isDisabled="$isDisable" :value="old('started_date')" />

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
                                $selected = old('position_id') ?? '';

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
                        :isRequired="true" :value="old('password')" />

                </div>
                <div class="col-sm-1">
                </div>
                <div class="col-sm-5">
                    <x-forms.text-group type="password" label="Password Confirmation" id="repassword" name="repassword"
                        :isRequired="true" :value="old('repassword')" />
                </div>
            </div>

            <div class="row ">
                <div class="col-sm-9  d-flex justify-content-between">
                    <x-button.userlist label="Register" class="btn btn-secondary  text-truncate" type="submit"
                        style="width: 100px;" id="registerButton" name="registerButton"></x-button.userlist>

                    <x-button.userlist label="Update" class="btn btn-secondary d-none text-truncate" type="button"
                        style="width: 100px;" id="updateButton" name="updateButton"></x-button.userlist>

                    <x-button.userlist label="Delete" class="btn btn-secondary d-none  text-truncate" type="button"
                        style="width: 100px;" id="deleteButton"></x-button.userlist>

                        <a class="btn btn-secondary  text-truncate" href="/admin/user/cancle"
                                style="width: 100px;" id="Cancel">Cancel</a>
                </div>
            </div>
            
        </form>

    </div>

    @push('scripts')
        @vite(['resources/js/screens/user/userAdd.js'], 'build')
    @endpush

</x-app-layout>
