@extends('layout.main')

@section('title', 'Register a Customer')


@section('content')
<h1>Register a Customer</h1>

<form action="" method="post">
    @csrf
    <input type="text" name="firstname" id="">
    <input type="text" name="middlename" id="">
    <input type="text" name="lastname" id="">
    <select name="civil_status" id="">
        @foreach($civilStatuses as $civilStatus)
        <option value="{{$civilStatus}}">{{$civilStatus}}</option>
        @endforeach
    </select>
    <input type="text" name="purok" id="">
    <select name="barangay" id="">
        @foreach($barangays as $barangay)
        <option value="{{$barangay}}">{{$barangay}}</option>
        @endforeach
    </select>
    <input type="number" name="contact_number" id="">
    <select name="connection_type" id="">
        @foreach($connectionTypes as $connectionType)
        <option value="{{$connectionType}}">{{$connectionType}}</option>
        @endforeach
    </select>
    <select name="connection_status" id="">
        @foreach($connectionStatuses as $connectionStatus)
        <option value="{{$connectionStatus}}">{{$connectionStatus}}</option>
        @endforeach
    </select>

    <button type="submit">Register</button>


</form>
@endsection

@section('custom-js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script>
    $(document).ready(function(){
        $("form").submit(function(e){
            e.preventDefault();

            $.post("{{route('admin.register-customer')}}",$(this).serialize(),function(response){
                console.log(response);
                if(response.created==true){
                    Swal.fire('Great!','Customer account was successfully created!','success');
                }
            })
        })
    })


</script>


@endsection