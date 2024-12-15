@extends('admin.layouts.master')

@section('content')
    {!! Menu::render() !!}
@endsection
@section('script')
    {!! Menu::scripts() !!}
@endsection
