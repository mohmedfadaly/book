@extends('layouts.app')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

@section('content')

@foreach ($books as $book)
<x-book-card :book="$book" />
@endforeach

@endsection
