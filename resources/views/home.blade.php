@extends('layouts.app')

@section('content')
<home-page-component :user="{{ json_encode(auth()->user()) }}"></home-page-component>
@endsection
