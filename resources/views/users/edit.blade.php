@extends('layout.template')

@section('content')

<form action="{{ route('update.user', ['id' => $user->id]) }}" method="POST" class="border p-4 rounded shadow bg-white" style="width: 1000px">
    @csrf
    @method('PUT')
    <h4>Produk</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Nama</label>
          <input type="text" class="form-control" name="name" id="name" placeholder="Masukan nama"  value="{{ $user->name }}"">
        </div>
        <div class="mb-3">
          <label class="form-label">Email</label>
          <input type="email" class="form-control" name="email" id="email" placeholder="Masukan email" value="{{ $user->email }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
            <label class="form-label">Role</label>
            <select class="form-select" name="role" id="role">
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="petugas" {{ old('role', $user->role) == 'petugas' ? 'selected' : '' }}>Petugas</option>
            </select>
        </div>    
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" class="form-control" name="password" id="password" placeholder="Masukan password">
        </div>
      </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
  </form>
</div>
@endsection