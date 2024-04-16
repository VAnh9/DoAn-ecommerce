@extends('admin.layouts.master')

@section('content')

      <!-- Main Content -->
        <section class="section">
          <div class="section-header">
            <h1>Blog</h1>
          </div>

          <div class="section-body">
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Create Blog</h4>
                    <div class="card-header-action">
                      <a href="{{ route('admin.blog.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
                      @csrf
                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Thumb Image <span class="field-required">*</span></label>
                        <input type="file" id="" name="image" class="form-control">
                        @if ($errors->has('image'))
                          <code>{{ $errors->first('image') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Title <span class="field-required">*</span></label>
                        <input type="text" id="" name="title" class="form-control" value="{{ old('title') }}">
                        @if ($errors->has('title'))
                          <code>{{ $errors->first('title') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Category <span class="field-required">*</span></label>
                          <select name="category" id="inputState" class="form-control main-category">
                            <option value="">Select</option>
                            @foreach ($categories as $category )
                              <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                          </select>
                          @if ($errors->has('category'))
                          <code>{{ $errors->first('category') }}</code>
                        @endif
                      </div>


                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Description <span class="field-required">*</span></label>
                        <textarea name="description" class="form-control summernote"></textarea>
                        @if ($errors->has('description'))
                          <code>{{ $errors->first('description') }}</code>
                        @endif
                      </div>


                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Seo Title</label>
                        <input type="text" name="seo_title" class="form-control" value="{{ old('seo_title') }}">
                        @if ($errors->has('seo_title'))
                          <code>{{ $errors->first('seo_title') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="">Seo Description</label>
                        <textarea name="seo_description" class="form-control"></textarea>
                        @if ($errors->has('seo_description'))
                          <code>{{ $errors->first('seo_description') }}</code>
                        @endif
                      </div>

                      <div class="form-group" style="margin-bottom: 1rem">
                        <label for="inputState">Status</label>
                         <select name="status" id="inputState" class="form-control">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                         </select>
                         @if ($errors->has('status'))
                          <code>{{ $errors->first('status') }}</code>
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


<style>
  .note-editor.note-frame.card {
    margin-bottom: 0;
  }
</style>
