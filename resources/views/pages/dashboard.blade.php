@extends('layout.main')
@section('title', 'Dashboard')

@section('content')

<div class="row justify-content-center mx-3 ms-lg-0">
    @foreach ($data as $datum)
        <x-dashboard-card :title="$datum['title']" :count="$datum['count']" :url="$datum['url']"/>
    @endforeach

</div>

@endsection
