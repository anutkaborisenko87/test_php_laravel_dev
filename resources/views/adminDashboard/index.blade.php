@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card m-3">
            <div class="card-header">
                <h3 class="card-title">Admin dashboard</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ __('Create new category') }}
                </button>
                @if($categories->count() > 0)
                    <table class="table table-success table-striped">
                        <tr>
                            <th>{{ __('Category title') }}</th>
                            <th>{{ __('Category description') }}</th>
                            <th>{{ __('Category lots') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                        @foreach($categories as $category)
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td>{{ $category->description }}</td>
                                <td>
                                    @if($category->lots()->count() > 0)
                                        @foreach($category->lots as $lotCat)
                                            <span class="badge rounded-pill text-bg-secondary mx-2">
                                                {{ $lotCat->title }}
                                            </span>
                                        @endforeach
                                    @else
                                        -
                                    @endif

                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            id="editModalButton"
                                            data-bs-target="#editLotModal">
                                        {{ __('Edit category') }}
                                    </button>
                                    <form action="{{ route('admin-dashboard.delete_category', $category->id) }}" method="post"
                                          id="deleteForm-{{ $category->id }}" style="display: none">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                    <a class="btn btn-danger btn-sm ml-2" href="" onclick="
                                            if(confirm('Do you really want to delete this category?')){
                                            event.preventDefault();
                                            document.getElementById('deleteForm-{{ $category->id }}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"> Delete
                                    </a>
                                    <div class="modal fade" id="editLotModal" tabindex="-1"
                                         aria-labelledby="editLotModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h1 class="modal-title fs-5" id="editLotModalLabel">Edit
                                                        category {{ $category->title }}</h1>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                </div>
                                                <form action="{{ route('admin-dashboard.update_category', $category->id) }}"
                                                      method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="title"
                                                                   class="form-label">{{ __('Category title:') }}</label>
                                                            <input type="text"
                                                                   class="form-control @error('title') is-invalid @enderror"
                                                                   name="title"
                                                                   id="title"
                                                                   placeholder="{{ __('Input title of lot') }}"
                                                                   value="{{ $category->title }}"
                                                            >
                                                            @error('title')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="description"
                                                                   class="form-label">{{ __('Category description:') }}</label>
                                                            <input type="text"
                                                                   class="form-control @error('description') is-invalid @enderror"
                                                                   name="description"
                                                                   id="description"
                                                                   placeholder="{{ __('Input description of lot') }}"
                                                                   value="{{ $category->description }}"
                                                            >
                                                            @error('description')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        @if($lots->count() > 0)
                                                        <div class="mb-3">
                                                            <label
                                                                for="lots"><strong>{{ __('Lots:') }}</strong></label>
                                                            <select name="lots[]" id="categories"
                                                                    class="form-control @error('lots') is-invalid @enderror"
                                                                    multiple>
                                                                @if($category->lots->count() > 0)
                                                                    @foreach($lots as $lot)
                                                                        <option value="{{ $lot->id }}"
                                                                                @if(in_array($lot->id, $category->lots->pluck('id')->toArray())) selected @endif>
                                                                            {{ $lot->title }}
                                                                        </option>
                                                                    @endforeach
                                                                @else
                                                                    @foreach($lots as $lot)
                                                                        <option value="{{ $lot->id }}">
                                                                            {{ $lot->title }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif

                                                            </select>
                                                            @error('lots')
                                                            <div class="alert alert-danger">{{ $message }}</div>
                                                            @enderror
                                                        </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close
                                                        </button>
                                                        <button type="submit"
                                                                class="btn btn-primary">{{ __('Update category') }}</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @endif
            </div>
        </div>
    </div>
    <!--Create new Lot Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Create new lot</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin-dashboard.create_category') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Category title:') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                   id="title" placeholder="{{ __('Input title of lot') }}"
                                   value="{{ old('title') }}"
                            >
                            @error('title')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Category description:') }}</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror"
                                   name="description"
                                   id="description" placeholder="{{ __('Input description of lot') }}"
                                   value="{{ old('description') }}"
                            >
                            @error('description')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        @if($lots->count() > 0)
                            <div class="mb-3">
                                <label for="lots"><strong>{{ __('Lots:') }}</strong></label>
                                <select name="lots[]" id="lots" class="form-control @error('lots') is-invalid @enderror"
                                        multiple>
                                    @foreach($lots as $lot)
                                        <option value="{{ $lot->id }}">
                                            {{ $lot->title }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('lots')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        @endif

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save new category') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
