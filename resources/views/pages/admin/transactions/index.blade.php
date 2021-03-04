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
                        <th scope="col">Status</th>
                    </tr>
                </thead>
                <tbody>

                    @if (count($transactions) > 0)
                      @foreach ($transactions as $key => $transac)
                      <tr>
                          <td>{{ $loop->iteration }}</td>
                          <td>{{ $products[$key]->name }}</td>

                          @if ($transac->transaction_status == 'settlement')
                            <td class="badge badge-success">{{ $transac->transaction_status }}</td>
                          @elseif($transac->transaction_status == 'pending')
                            <td class="badge badge-warning">{{ $transac->transaction_status }}</td>
                          @elseif($transac->transaction_status == 'expire')
                            <td class="badge badge-danger">{{ $transac->transaction_status }}</td>
                          @endif
                      </tr>
                      @endforeach

                    @else
                    <tr>
                      <td>
                        <p><strong>Belum ada transaksi</strong></p>
                      </td>
                    </tr>
                    @endif

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
