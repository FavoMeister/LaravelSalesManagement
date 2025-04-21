<div class="box box-default">
    <div class="box-header width-border">
        <h3 class="box-title">Productos más vendidos</h3>
    </div>

    <div class="box-body">
        <div class="row">
            <div class="col-md-7">
                <div class="chart-responsive">
                    <canvas id="pieChart" height="150"></canvas>
                </div>
            </div>
            <div class="col-md-5">
                <ul class="chart-legend clearfix">
                    @foreach ($bestSellingProducts as $product)
                        <li>
                            <i class="fa fa-circle-o" style="color: {{ $colorVariables[$loop->index] }}"></i>
                            {{ $product->name . ' ' . $product->description }}
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
        
    </div>
    <div class="box-footer no-padding">
        <ul class="nav nav-pills nav-stacked">
            @foreach ($bestSellingProducts as $product)
            @if ($product->image == "")
                @php
                    $image = "products/deafault.png";
                @endphp
            @else
                @php
                    $image = $product->image;
                @endphp
            @endif
                <li>
                    <a href="">
                        <img src="{{ url('storage/'. $image) }}" alt="" class="img-thumbnail" width="60px;" style="margin-right: 10px;">
                        <span class="pull-right" style="color: {{ $colorVariables[$loop->index] }}">
                            {{ $product->percentage }} %
                        </span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>