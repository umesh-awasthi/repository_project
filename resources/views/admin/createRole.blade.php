@extends('admin.layouts.adminlayout')
    <!-- Main Content -->
   
    @section('content')
   
    <div class="flex-1 p-8">
        <h1 class="text-2xl font-bold text-gray-700 mb-4">Add New Role</h1>

     

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary">
                    <h5 class="text-black">Create Role</h5>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger text-red-800">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('admin.createRole') }}" method="POST" style="display: flex; justify-content: center; align-items: center; flex-direction: column;">
                        @csrf
                        <div class="form-group" style="margin-bottom: 20px;">
                            <label for="name" class="text-dark">Role Name:</label>
                            <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required >
                        </div>
                        <button type="submit"  class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 transition">Create Role</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
    </div>
@endsection
