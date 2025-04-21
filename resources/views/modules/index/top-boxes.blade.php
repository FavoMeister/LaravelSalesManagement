<div class="col-md-3 col-xs-6">
    <div class="small-box bg-aqua">
        <div class="inner">
            <h3>$ {{ number_format($sales, 2, '.', ',') }}</h3>
            <p>Ventas</p>
        </div>
        <div class="icon">
            <i class="ion ion-social-usd"></i>
        </div>
        <a href="ventas" class="small-box-footer">
            Más Info. <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-md-3 col-xs-6">
    <div class="small-box bg-green">
        <div class="inner">
            <h3>{{ $categories }}</h3>
            <p>Categorías</p>
        </div>
        <div class="icon">
            <i class="fa fa-th"></i>
        </div>
        <a href="categorias" class="small-box-footer">
            Más Info. <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-md-3 col-xs-6">
    <div class="small-box bg-yellow">
        <div class="inner">
            <h3>{{ $clients }}</h3>
            <p>Clientes</p>
        </div>
        <div class="icon">
            <i class="fa fa-user-plus"></i>
        </div>
        <a href="clientes" class="small-box-footer">
            Más Info. <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>
<div class="col-md-3 col-xs-6">
    <div class="small-box bg-red">
        <div class="inner">
            <h3>{{ $products }}</h3>
            <p>Productos</p>
        </div>
        <div class="icon">
            <i class="fa fa-cubes"></i>
        </div>
        <a href="productos" class="small-box-footer">
            Más Info. <i class="fa fa-arrow-circle-right"></i>
        </a>
    </div>
</div>