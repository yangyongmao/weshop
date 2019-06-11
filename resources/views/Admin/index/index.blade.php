@extends('layouts.app');
@section('content')
    @foreach($data as $v)
        <label for="">{{$v->a_id}}</label>
    @endforeach
@endsection