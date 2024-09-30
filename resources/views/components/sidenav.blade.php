<a class="nav-link {{ Route::currentRouteName() == 'dashboard' ? 'active' : '' }}" href="{{ route('dashboard') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
    Dashboard
</a>
@if(auth()->user()->user_type === 'admin')
<a class="nav-link {{ Route::is('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-pills"></i></div>
    Products
</a>
@endif
<a class="nav-link {{ Route::is('pos.*') ? 'active' : '' }}" href="{{ route('pos.index') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-cash-register"></i></div>
    POS
</a>
@if(auth()->user()->user_type === 'admin')
<a class="nav-link {{ Route::currentRouteName() != 'orders.myOrders' && Route::is('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-cart-shopping"></i></div>
    Orders
</a>
@endif
<a class="nav-link" href="{{ route('register') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-user-plus"></i></div>
    Register Cashier
</a>
{{-- <a class="nav-link {{ Route::currentRouteName() == 'orders.myOrders' ? 'active' : '' }}" href="{{ route('orders.myOrders') }}">
    <div class="sb-nav-link-icon"><i class="fas fa-basket-shopping"></i></div>
    My Orders
</a> --}}
