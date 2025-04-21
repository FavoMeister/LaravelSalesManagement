<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title">Productos Agregados Recientemente</h3>
    </div>

    <div class="box-body">
        <ul class="products-list product-list-in-box">
            @foreach ($latestProducts as $product)
                <li class="item">
                    <div class="product-img">
                        @if ($product->image != '')
                            <img src="{{ url('storage/'.$product->image) }}" alt="" class="img-thumbnail" width="40px">
                        @else
                            <img src="{{ url('storage/products/default.png') }}" alt="" class="img-thumbnail" width="40px">
                        @endif
                    </div>

                    <div class="product-info">
                        <a href="#" class="product-title">
                            {{ $product->name . ' ' . $product->description }}
                            <span class="label label-warning pull-right">$ {{ number_format($product->selling_price, 2, '.', ',') }}</span>
                        </a>
                    </div>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="box-footer text-center">
        <a href="productos" class="uppercase">Ver todos los productos</a>
    </div>
</div>