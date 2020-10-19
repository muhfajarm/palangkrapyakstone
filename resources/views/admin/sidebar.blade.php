    <aside class="main-sidebar">
      <section class="sidebar">
        <!-- search form (Optional) -->
        {{-- <form action="#" method="get" class="sidebar-form">
          <div class="input-group">
            <input type="text" name="q" class="form-control" placeholder="Cari...">
            <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
          </div>
        </form> --}}
        <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
          <li>
            <a href="{{ route('front.index') }}">
              <i class="glyphicon glyphicon-home"></i><span>Home</span>
            </a>
          </li>
          <li class="header">SIDEBAR</li>
          <!-- Optionally, you can add icons to the links -->
          {{-- <li class="{{set_active('admin/kategori')}}"> --}}
          {{-- <li class="{{set_active('user.index')}}">
            <a href="{{route('user.index')}}">
              <i class="glyphicon glyphicon-th-list"></i> <span>User</span>
            </a>
          </li> --}}
          <li class="{{set_active('kategori.index')}}">
            <a href="{{route('kategori.index')}}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Kategori</span>
            </a>
          </li>
          <li class="{{set_active('produk.index')}}">
            <a href="{{route('produk.index')}}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Produk</span>
            </a>
          </li>
          {{-- <li class="{{set_active('kurir.index')}}">
            <a href="{{route('kurir.index')}}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Kurir</span>
            </a>
          </li> --}}
          {{-- <li class="treeview">
            <a href="#"><i class="glyphicon glyphicon-list"></i> <span>Wilayah</span>
              <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{url('admin/provinsi')}}">
                  <i class="glyphicon glyphicon-th-list"></i> <span>Provinsi</span>
                </a>
              </li>
              <li>
                <a href="{{url('admin/kota')}}">
                  <i class="glyphicon glyphicon-th-list"></i> <span>Kota/Kabupaten</span>
                </a>
              </li>
              <li>
                <a href="{{url('admin/kecamatan')}}">
                  <i class="glyphicon glyphicon-th-list"></i> <span>Kecamatan</span>
                </a>
              </li>
            </ul>
          </li> --}}
          <li class="{{set_active('orders.index')}}">
            <a href="{{ route('orders.index') }}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Order</span>
            </a>
          </li>
          <li class="{{set_active('report.order')}}">
            <a href="{{ route('report.order') }}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Laporan Order</span>
            </a>
          </li>
          {{-- <li class="{{set_active('report.return')}}">
            <a href="{{ route('report.return') }}">
              <i class="glyphicon glyphicon-th-list"></i> <span>Laporan Return</span>
            </a>
          </li>
 --}}          {{-- <li class="treeview {{set_active('report.order', 'report.return')}}">
            <a href="#"><i class="glyphicon glyphicon-list"></i><span>Laporan</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class="{{set_active('report.order')}}">
                <a href="{{ route('report.order') }} }}">
                  <i class="glyphicon glyphicon-th-list"></i> <span>Order</span>
                </a>
              </li>
              <li class="{{set_active('report.return')}}">
                <a href="{{ route('report.return') }} }}">
                  <i class="glyphicon glyphicon-th-list"></i> <span>Return</span>
                </a>
              </li>
            </ul>
          </li> --}}
        </ul>
        <!-- /.sidebar-menu -->
      </section>
      <!-- /.sidebar -->
    </aside>