@extends('layouts.adminBase')

@section('content')

<div class="container-fluid">
  <div class="row">
    <div class="col">
      <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Produk</th>
            <th scope="col">Jumlah (Kg)</th>
            <th scope="col">Stok(Kg)</th>
            <th scope="col">Pemesan</th>
            <th scope="col">Alamat</th>
            <th scope="col">Status</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            {{-- @if (count($orderedProducts) > 0)
              @foreach ($orders as $order)    
              <th scope="row">{{$loop->iteration}}</th>
              <td>{{$orderedProducts[$loop->index]->name}}</td>
              <td>{{$countOrdered[$orderedProducts[$loop->index]->name]}}</td>
              <td>{{$orderedProducts[$loop->index]->stock}}</td>
              <td>{{$order->name}}</td>
              <td>{{$order->address}}</td>
              @if ($order->status == 'pending')
                <td class="badge badge-danger">UNPAID</td>
              @elseif($order->status == 'success')
                <td class="badge badge-success">PAID</td>
              @endif
              @endforeach
            @endif --}}
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
@endsection