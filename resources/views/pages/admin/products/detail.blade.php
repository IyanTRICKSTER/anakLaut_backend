{{-- <div class="table-stats table-order ov-h"> --}}

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Nama Produk</th>
                <th>Tipe</th>
                <th>Berat</th>
                <th>Harga</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $products->name}}</td>
                <td>{{ $products->type}}</td>
                <td>{{ $products->weight}}</td>
                <td>{{ $products->price}}</td>
                <td>{{ $products->stock}}</td>
                {{-- {{ dd($products->name)}} --}}
            </tr>
        </tbody>
    </table>
{{-- </div> --}}
