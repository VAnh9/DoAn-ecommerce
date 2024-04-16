@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Manage User</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create User</h4>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.manage-user.create') }}" method="POST">
                      @csrf

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Name</label>
                        <input type="text"  name="name" class="form-control" value="{{ old('name') }}">
                        @if ($errors->has('name'))
                          <code>{{ $errors->first('name') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label>Email</label>
                        <input type="email"  name="email" class="form-control" value="{{ old('email') }}">
                        @if ($errors->has('email'))
                          <code>{{ $errors->first('email') }}</code>
                        @endif
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label>Password</label>
                            <input type="password"  name="password" class="form-control" value="">
                            @if ($errors->has('password'))
                              <code>{{ $errors->first('password') }}</code>
                            @endif
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group" style="margin-bottom: 1rem">
                            <label>Confirm Password</label>
                            <input type="password"  name="password_confirmation" class="form-control" value="">
                            @if ($errors->has('password_confirmation'))
                              <code>{{ $errors->first('password_confirmation') }}</code>
                            @endif
                          </div>
                        </div>
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Role</label>
                         <select name="role" id="inputState" class="form-control">
                            <option value="">Select</option>
                            <option value="user">User</option>
                            <option value="vendor">Vendor</option>
                            <option value="admin">Admin</option>
                         </select>
                         @if ($errors->has('role'))
                          <code>{{ $errors->first('role') }}</code>
                        @endif
                      </div>

                      <button type="submit" class="btn btn-primary">Create</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>



@endsection

