{{-- @extends('Restaurant.layout.App')
@section('main_section') --}}
<table border="2" style="margin-bottom: 6px;">
    <thead>
        <tr>
            <th style="padding-left: 10px;padding-right: 10px;">TOTAL EARNING :-  €{{$earning}}</th>    
            </tr> 
    </thead>
</table>
<table class="table" border="2">
    <thead>
        {{-- <tr>
            <th>TOTAL EARNING : € {{$earning}}</th>    
            </tr> --}}
        <tr>
            {{-- <th>ID</th> --}}
            <th style="padding-left: 10px;padding-right: 10px;">ORDER ID</th>
            <th style="padding-left: 10px;padding-right: 10px;">STAFF NAME</th>
            <th style="padding-left: 10px;padding-right: 10px;">TOTAL PAYMENT</th>
            {{-- <th>PAYMENT STATUS</th> --}}
            {{-- <th>ORDER ITEMS</th> --}}
            <th>ORDER AT</th>
        </tr>
       
    </thead>
    <tbody>
        @foreach($orders as $order)
        <tr>
            {{-- <td>{{$order->}}</td> --}}
            <td style="text-align: center;">00{{$order->id }}</td>
            <td style="text-align: center;">{{$staff}}</td>
            <td style="text-align: center;">€{{number_format($order->total_payment,2)}}</td>
            {{-- <td>{{$order->payment_status}}</td> --}}
            {{-- <td>{{$order->count}}</td> --}}
            <td style="padding-left: 10px;padding-right: 10px;">{{($order->created_at)->format('d/m/Y H:i:s A')}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
{{-- @endsection --}}
