<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Employees') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-6">
                                <h3 class="text-center">Add New Employee</h3>

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

                                <form method="post" action="{{ route('employees.save') }}">
                                    @csrf
                                    <div class="mb-3">
                                      <label class="form-label">First Name</label>
                                      <input type="text" class="form-control" name="fname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Last Name</label>
                                        <input type="text" class="form-control" name="lname" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Company</label>
                                        <select name="company_id" class="form-control" required>
                                            <option value="" selected disabled>Select a company</option>
                                            @foreach($data['companies'] as $comp)
                                            <option value="{{ $comp->id }}">{{ $comp->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Phone</label>
                                        <input type="tel" class="form-control" name="phone">
                                    </div>
                                    <button type="submit" class="btn btn-primary">Add Employee</button>
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
                                <h3 class="text-center fw-bold">All Employees</h3>

                                <table id="thecrmTable" class="table table-bordered table-hover nowrap" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">First Name</th>
                                            <th class="text-center">Last Name</th>
                                            <th class="text-center">Company</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Date Added</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $sn = 1; @endphp
                                        @foreach($data['employees'] as $emp)
                                            <tr>
                                                <td>{{ $sn }}</td>
                                                <td>{{ $emp->first_name }}</td>
                                                <td>{{ $emp->last_name }}</td>
                                                <td>{{ $emp->company_id }}</td>
                                                <td>{{ $emp->email }}</td>
                                                <td class="text-center">{{ $emp->phone }}</td>
                                                <td>{{ $emp->created_at }}</td>
                                                <td>
                                                    <a data-bs-toggle="modal" data-bs-target="#editModal" class="btn btn-primary">Edit</a>
                                                    <a data-bs-toggle="modal" data-bs-target="#deleteModal" class="btn btn-danger">Delete</a>
                                                </td>

                                                <!-- Edit Modal -->
                                                <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="editModalLabel">Edit Employee</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('employees.update') }}">
                                                                @csrf
                                                                <div class="mb-3">
                                                                    <label class="form-label">First Name</label>
                                                                    <input type="text" class="form-control" name="fname" value="{{ $emp->first_name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Last Name</label>
                                                                    <input type="text" class="form-control" name="lname" value="{{ $emp->last_name }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Company</label>
                                                                    <select name="company_id" class="form-control" required>
                                                                        <option value="" selected disabled>Select a company</option>
                                                                        @foreach($data['companies'] as $comp)
                                                                        <option value="{{ $comp->id }}" @if($comp->id == $emp->company_id) selected @endif>{{ $comp->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Email</label>
                                                                    <input type="email" class="form-control" name="email" value="{{ $emp->email }}">
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label class="form-label">Phone</label>
                                                                    <input type="tel" class="form-control" name="phone" value="{{ $emp->phone }}">
                                                                </div>
                                                                <input type="hidden" value="{{ $emp->id }}" name="employee_id">
                                                            
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
                                                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel">Delete Company</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post" action="{{ route('employees.delete') }}">
                                                                @csrf
                                                                <p>Are you sure you want to delete this employee?</p>
                                                                <input type="hidden" value="{{ $emp->id }}" name="employee_id">
                                                            
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
                                    {{ $data['employees']->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                   
                </div>
            </div>
        </div>
    </div>

</x-app-layout>