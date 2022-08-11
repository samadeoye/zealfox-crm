<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Companies') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <h3 class="text-center">Add New Company</h3>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                @if(Session::has('suc_msg'))
                                <div class="alert alert-success">{{ Session::get('suc_msg') }}</div>
                                @endif
                                @if(Session::has('err_msg'))
                                <div class="alert alert-danger">{{ Session::get('err_msg') }}</div>
                                @endif

                                <form method="post" action="{{ route('companies.save') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-3">
                                      <label class="form-label">Name</label>
                                      <input type="text" class="form-control" name="name" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Logo</label>
                                        <input type="file" class="form-control" name="logo">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Website</label>
                                        <input type="text" class="form-control" name="website">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Country</label>
                                        <input type="text" class="form-control" name="country">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Company</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12">
                                <h3 class="text-center fw-bold">All Companies</h3>

                                <table id="thecrmTable" class="table table-bordered table-hover nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Logo</th>
                                            <th class="text-center">Website</th>
                                            <th class="text-center">Country</th>
                                            <th class="text-center">Date Added</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sn = 1; @endphp
                                        @foreach($companies as $comp)
                                            <tr>
                                                <td>{{ $sn }}</td>
                                                <td>{{ $comp->name }}</td>
                                                <td>{{ $comp->email }}</td>
                                                <td>
                                                    @if($comp->logo != '')
                                                    <a href="/storage/{{ $comp->logo }}" target="_blank">
                                                        <img src="/storage/{{ $comp->logo }}" alt="{{ $comp->name }} logo">
                                                    </a>
                                                    @endif
                                                </td>
                                                <td>{{ $comp->website }}</td>
                                                <td>{{ $comp->country }}</td>
                                                <td>{{ $comp->created_at }}</td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#editModal{{$comp->id}}" class="btn btn-primary">Edit</a>
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal{{$comp->id}}" class="btn btn-danger">Delete</a>
                                                </td>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal{{$comp->id}}" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Company</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('companies.update') }}" enctype="multipart/form-data">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label class="form-label">Name</label>
                                                                    <input type="text" class="form-control" name="name" value="{{ $comp->name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" class="form-control" name="email" value="{{ $comp->email }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Logo</label>
                                                                    @if($comp->logo != '')
                                                                    <img src="/storage/{{ $comp->logo }}" alt="{{ $comp->name }} logo" class="modalLogoImg">
                                                                    @endif
                                                                    <input type="file" class="form-control" name="logo">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Website</label>
                                                                    <input type="text" class="form-control" name="website" value="{{ $comp->website }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Country</label>
                                                                    <input type="text" class="form-control" name="country" value="{{ $comp->country }}">
                                                                </div>
                                                                <input type="hidden" value="{{ $comp->id }}" name="company_id">
                                                            
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>


                                                <!-- Delete Modal -->
                                                <div class="modal fade" id="deleteModal{{$comp->id}}" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Company</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('companies.delete') }}">
                                                                @csrf
                                                                <p>Are you sure you want to delete this company?</p>
                                                                <input type="hidden" value="{{ $comp->id }}" name="company_id">
                                                            
                                                            </div>
                                                            <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                            <button type="submit" class="btn btn-primary">Authorize</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    </div>
                                                </div>
  
                                            </tr>
                                            @php $sn++; @endphp
                                        @endforeach

                                        
                                    </tbody>
                                </table>

                                <div class="pt-3">
                                    {{ $companies->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
