@extends('layouts.adminBase')

@section('content')

@if ($products->count() > 0)
@foreach ($products as $product)
<ul>
    <li>
        {{ $product->name }}
        @foreach ($product->product_galleries as $gallery)
        <img src="{{ $gallery->image }}" alt="">
        <a class="btn btn-primary" href="{{ route('product.edit', Crypt::encrypt($product->id)) }}"><i class="fas fa-pen"></i></a>
       
        <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModalCenter" data-remote="{{ route('product.detail', $product->id) }}">
            <i class="fas fa-eye"></i>
        </button>
        <a class="btn btn-danger" href="{{ route('product.destroy', $product->id) }}"><i class="fas fa-trash"></i></a>
        @endforeach
    </li>
</ul>
@endforeach
@else
<p>Gak ada produk nih</p>
@endif
<!-- Large modal -->

<!-- Modal for Product Detail -->
<div class="modal fade modalProductDetail" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('after-script')
<script>
    $('.modalProductDetail').on('show.bs.modal', function (event) {
        
        var button = $(event.relatedTarget) // Button that triggered the modal
        var link = button.data('remote') // Extract info from data-* attributes

        var modal = $(this)
        modal.find('.modal-title').text('Details Product')

        $.ajax({
            type: 'get',
            url: link,
            success: (response) => {
                modal.find('.modal-body').html(response)
            }
        })
        
    })

</script>
@endpush

@endsection
