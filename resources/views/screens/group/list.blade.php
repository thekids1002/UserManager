<x-app-layout title="Group List">
    <div class="mb-sm-5 mx-sm-5 pt-5 col-sm-8">
        {{-- @if (session('error'))
            <div class="alert alert-danger text-white p-1">
                <span>{{ session('error') }}</span>
            </div>
        @endif --}}
        @if (session('success'))
            <div class="alert alert-success text-white p-1">
                <span>{{ session('success') }}</span>
            </div>
        @endif
        {{-- @if ($errors && $errors->any())
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <p class="m-0 p-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif --}}
    </div>
    <div class="col-sm-12">


        <div class="row mt-5">
            <div class="col table-container m-0 p-0">
                @if (count($groups) > 0)
                    <div class="d-flex justify-content-end my-4">
                        {{ $groups->links('common.pagination') }}
                    </div>
                @endif
                <table class="table table-bordered table-responsive-sm group-list-table" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th class="fw-normal" style="width: 12.5%;">ID</th>
                            <th class="fw-normal" style="width: 12.5%;">Group Name</th>
                            <th class="fw-normal" style="width: 12.5%;">Group Note</th>
                            <th class="fw-normal" style="width: 12.5%;">Group Leader</th>
                            <th class="fw-normal" style="width: 12.5%;">Floor Number</th>
                            <th class="fw-normal" style="width: 12.5%;">Created Date</th>
                            <th class="fw-normal" style="width: 12.5%;">Updated Date</th>
                            <th class="fw-normal" style="width: 12.5%;">Deleted Date</th>
                        </tr>
                    </thead>
                    @if (count($groups) > 0)
                        <tbody>
                            @foreach ($groups as $group)
                                <tr>
                                    <td>{{ $group->id }}</td>
                                    <td>{{ $group->name }}</td>
                                    <td>{{ $group->note }}</td>
                                    <td>
                                        {{ $group->leader->deleted_date == null ? $group->leader->name : '' }}
                                    </td>
                                    <td>{{ $group->group_floor_number }}</td>
                                    <td class="text-center">
                                        {{ $group->created_date->format('d/m/Y') ?? '' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $group->updated_date->format('d/m/Y') ?? '' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $group->deleted_date ? $group->deleted_date->format('d/m/Y') : '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    @endif
                </table>
                @if ($messageNotFound != '')
                    <div class="row mt-5 mx-1">
                        <div class="col-sm-12 h-25 w-100 py-3 d-flex justify-content-center align-items-center">
                            <span class="mx-1 text-gray">
                                <h4>{{ $messageNotFound }}</h4>
                            </span>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="col-sm-8">
            <div class="row d-block">
                <div class="col">
                    <x-button.base type="button" label="Import" class="btn btn-secondary m-1" data-bs-toggle="modal"
                        data-bs-target="#importCSVModal"></x-button.base>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="importCSVModal" tabindex="-1" aria-labelledby="importCSVModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="importCSVModalLabel">Import CSV</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.import') }}" method="post" enctype="multipart/form-data"
                    name="formImportCSV" id="formImportCSV">
                    @csrf
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="csvFile" class="form-label">Choose your CSV File</label>
                            <input class="form-control" type="file" id="csvFile" name="csvFile">
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnCloseModalImport" name="btnCloseModalImport" >Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="errorModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul id="errorList" class="list-unstyled">
                        @if ($errors && $errors->any())
                            <li>
                                @foreach ($errors->all() as $error)
                                    <p class="m-0 p-0 text-red">{{ $error }}</p>
                                @endforeach
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @push('scripts')
        @vite(['resources/js/screens/group/groupList.js'], 'build')
    @endpush

</x-app-layout>
