@extends('layouts.app')

@section('title', 'Home Page')

@section('content')

{{-- Home Page Content --}}
@include('frontend.pages.hero')

@include('frontend.pages.skill')

@include('frontend.pages.experience')

@include('frontend.pages.education')

@include('frontend.pages.project')

@include('frontend.pages.certificate')

@endsection