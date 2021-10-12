@extends('layout.main')

@section('title', 'Work Order Payments')


@section('content')

@if($payments->count()>0)
<h4 class="mt-4 text-center">(Work Order Payments)</h4>
<div class="table-responsive">
  <table class="table table-striped mt-4 table-bordered">
      <thead>
          <th>Service Name</th>
          <th>Transacted To </th>
          <th>OR #</th>
          <th>Paid</th>
          <th>Paid on</th>
        </thead>
        <tbody>
        
            @foreach ($payments as $payment)
              <tr>
                  <td>{{ $payment->service->prettyServiceType() }}</td>
                  <td>{{ $payment->customer_id }}</td>
                  <td>{{ $payment->or_no }}</td>
                  <td>{{ $payment->prettyPaymentAmount() }}</td>
                  <td>{{ $payment->created_at }}</td>

              </tr>
            @endforeach
        </tbody>
  </table>
</div>
@else
<div class="mt-4">
  <p class="text-center text-muted">No payments to show!</p>
</div>
@endif

@endsection

