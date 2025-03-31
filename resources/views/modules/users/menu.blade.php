<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          @if (!auth()->user()->photo)
            <img src="{{ url('storage/users/anonymous.png') }}" class="img-circle" alt="User Image">  
          @else
            <img src="{{ url('storage/'.auth()->user()->photo) }}" class="img-circle" alt="User Image">  
          @endif
        </div>
        <div class="pull-left info">
          <p>{{ auth()->user()->name }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>
      <!-- /.search form -->
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MAIN NAVIGATION</li>
        <li>
          <a href="{{ url('index') }}">
            <i class="fa fa-home"></i> 
            <span>Inicio</span>
          </a>
        </li>
        <li>
          <a href="{{ url('usuarios') }}">
            <i class="fa fa-users"></i> 
            <span>Usuarios</span>
          </a>
        </li>
        <li>
          <a href="{{ url('branches') }}">
            <i class="fa fa-home"></i> 
            <span>Sucursales</span>
          </a>
        </li>
        
        <li>
          <a href="{{ url('categorias') }}">
            <i class="fa fa-home"></i> 
            <span>Catgorías</span>
          </a>
        </li>
        <li>
          <a href="{{ url('productos') }}">
            <i class="fa fa-cubes"></i> 
            <span>Productos</span>
          </a>
        </li>
        <li>
          <a href="{{ url('clientes') }}">
            <i class="fa fa-user-plus"></i> 
            <span>Clientes</span>
          </a>
        </li>
        <li>
          <a href="{{ url('sales') }}">
            <i class="fa fa-shopping-cart"></i> 
            <span>Administrar Ventas</span>
          </a>
        </li>
        <li>
          <a href="{{ url('reports') }}">
            <i class="fa fa-bar-chart"></i> 
            <span>Reportes de Ventas</span>
          </a>
        </li>
      </ul>
    </section>
    <!-- /.sidebar -->
</aside>