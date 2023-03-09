@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="card m-3">
            <div class="card-header">
                <h3 class="card-title">My dashboard</h3>
            </div>
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    {{ __('Create new lot') }}
                </button>
                @if($lots->count() > 0)
                        <table class="table table-success table-striped">
                            <tr>
                                <th>{{ __('Lot title') }}</th>
                                <th>{{ __('Lot description') }}</th>
                                <th>{{ __('Lot start price') }}</th>
                                <th>{{ __('Lot auction price') }}</th>
                                <th>{{ __('Lot categories') }}</th>
                                <th>{{ __('Last recommended new price user') }}</th>
                                <th>{{ __('Actions') }}</th>
                            </tr>
                            @foreach($lots as $lot)
                                <tr>
                                    <td>{{ $lot->title }}</td>
                                    <td>{{ $lot->description }}</td>
                                    <td>{{ $lot->start_price}}</td>
                                    <td>{{ !is_null($lot->auction_price) ? $lot->auction_price : ' - ' }}</td>
                                    <td>
                                        @foreach($lot->categories as $lotCat)
                                            <span class="badge rounded-pill text-bg-secondary mx-2">
                                                {{ $lotCat->title }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ !is_null($lot->auction_price) ? $lot->lastAuctionPriceUser()->name . '(' . $lot->lastAuctionPriceUser()->email . ')' : ' - ' }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                id="editModalButton"
                                                data-lot="{{ json_encode($lot) }}"
                                                data-bs-target="#editLotModal">
                                            {{ __('Edit lot') }}
                                        </button>
                                        <form action="{{ route('dashboard.lot.destroy', $lot->id) }}" method="post"
                                              id="deleteForm-{{ $lot->id }}" style="display: none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                        <a class="btn btn-danger btn-sm ml-2" href="" onclick="
                                            if(confirm('Do you really want to delete this lot?')){
                                            event.preventDefault();
                                            document.getElementById('deleteForm-{{ $lot->id }}').submit();
                                            }else{
                                            event.preventDefault();
                                            }"> Delete
                                        </a>
                                        <div class="modal fade" id="editLotModal" tabindex="-1" aria-labelledby="editLotModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h1 class="modal-title fs-5" id="editLotModalLabel">Edit lot {{ $lot->id }}</h1>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <form action="{{ route('dashboard.updateLot', $lot->id) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="mb-3">
                                                                <label for="title" class="form-label">{{ __('Lot title:') }}</label>
                                                                <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                                                       id="title" placeholder="{{ __('Input title of lot') }}"
                                                                       value="{{ $lot->title }}"
                                                                >
                                                                @error('title')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="description" class="form-label">{{ __('Lot description:') }}</label>
                                                                <input type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                                                                       id="description" placeholder="{{ __('Input description of lot') }}"
                                                                       value="{{ $lot->description }}"
                                                                >
                                                                @error('description')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="categories"><strong>{{ __('Categories:') }}</strong></label>
                                                                <select name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" multiple>
                                                                @foreach($categories as $category)
                                                                        <option value="{{ $category->id }}" @if(in_array($category->id, $lot->categories->pluck('id')->toArray())) selected @endif>
                                                                            {{ $category->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                @error('categories')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="start_price">{{ __('Start price') }}</label>
                                                                <span class="input-group-text">$</span>
                                                                <input type="number" name="start_price" id="start_price" class="form-control @error('start_price') is-invalid @enderror"
                                                                       min="0" step="10" value="{{ $lot->start_price }}">
                                                                @error('start_price')
                                                                <div class="alert alert-danger">{{ $message }}</div>
                                                                @enderror
                                                            </div>

                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-primary">{{ __('Update lot') }}</button>
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
                <form action="{{ route('dashboard.createLot') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Lot title:') }}</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                   id="title" placeholder="{{ __('Input title of lot') }}"
                                   value="{{ old('title') }}"
                            >
                            @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Lot description:') }}</label>
                            <input type="text" class="form-control @error('description') is-invalid @enderror" name="description"
                                   id="description" placeholder="{{ __('Input description of lot') }}"
                                   value="{{ old('description') }}"
                            >
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="categories"><strong>{{ __('Categories:') }}</strong></label>
                            <select name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" multiple>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}">
                                        {{ $category->title }}
                                    </option>
                                @endforeach
                            </select>
                            @error('categories')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="start_price">{{ __('Start price') }}</label>
                            <span class="input-group-text">$</span>
                            <input type="number" name="start_price" id="start_price" class="form-control @error('start_price') is-invalid @enderror"
                                   min="0" step="10" value="{{ old('start_price') }}">
                            @error('start_price')
                            <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('Save new lot') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

