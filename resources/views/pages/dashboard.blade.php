@extends('layout.main')
@section('title', 'Dashboard')

@section('content')

<div class="justify-content-center mx-3 my-5 ms-lg-0">
    <h1 class="text-center mt-3">Welcome ! {{ Auth::user()->name }}</h1>
    <h2 class="text-center mt-3" style="letter-spacing: 0.07rem; font-weight: 400;"><span id="date" class="me-3"></span>|<span id="time" class="ms-3"></span></h2>
    <!-- <h3 class="text-center" id="time" style="letter-spacing: 0.07rem;"></h3> -->
    <div class="row mt-4">
    @foreach ($data as $datum)
        <x-dashboard-card :title="$datum['title']" :count="$datum['count']" :url="$datum['url']" :icon="$datum['icon']">
        </x-dashboard-card>
    @endforeach
    </div>
</div>
<script>
    startTime()

    function formatAMPM(date) {
        var hours = date.getHours();
        var minutes = date.getMinutes();
        var seconds = date.getSeconds();
        var ampm = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12;
        hours = hours ? hours : 12;
        minutes = minutes < 10 ? '0'+ minutes : minutes;
        seconds = seconds < 10 ? '0'+ seconds : seconds;
        var strTime = hours + ':' + minutes + ':' + seconds + ' ' + ampm;
        return strTime;
    }

    function startTime() {
        document.getElementById('time').innerHTML = formatAMPM(new Date());
        setTimeout(startTime, 1000);
    }

    var date =  new Date()
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]

    document.getElementById('date').innerHTML = cleanDate
</script>

@endsection
