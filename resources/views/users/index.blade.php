@extends('layout.template')

@section('content')

<a href="{{ route('create.user') }}" class="btn btn-primary m-3">Create Users</a>

<div class="container border p-3 rounded shadow bg-white">
<table class="table"> 
    <thead>
        <tr>
            <th>#</th>
        <th>Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($user as $item)
        <tr>
            <th scope="row">{{ $loop->iteration }}</th>

        <td class="text-secondary">{{ $item->name }}</td>
        <td class="text-secondary">{{ $item->email }}</td>
        <td class="text-secondary">{{ $item->role }}</td>
        <td><a href="{{ route('edit.user', $item->id) }}" class="btn btn-warning">Update</a>
                <form action="{{ route('delete.user', $item->id) }}" method="POST" style="display: inline-block;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin?')">Delete</button>
                </form>
        </td>
        {{-- <td><a href="" class="btn btn-warning">Delete</a></td> --}}
        </tr>
        @endforeach
    </tbody>
</table>
</div>
@endsection