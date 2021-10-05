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
    function startTime() {
        const today = new Date();
        let h = today.getHours();
        let m = today.getMinutes();
        let s = today.getSeconds();
        m = checkTime(m);
        s = checkTime(s);
        document.getElementById('time').innerHTML =  h + ":" + m + ":" + s;
        setTimeout(startTime, 1000);
    }

    function checkTime(i) {
        if (i < 10) {i = "0" + i};  // add zero in front of numbers < 10
        return i;
    }

    var date =  new Date()
    var newDate = date.toDateString().split(' '),
        cleanDate = date.toLocaleString('default', { month: 'long' }) + ' ' + newDate[2] + ', ' + newDate[3]

    document.getElementById('date').innerHTML = cleanDate
</script>

@endsection
