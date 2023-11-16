@include('admin.layout.base.head')

@include('admin.layout.partial.header')

@include('admin.layout.partial.sidebar')

<main id="main" class="main">

    @include('admin.layout.partial.breadcrumb')

    @yield('content')

</main><!-- End #main -->

{{-- @include('admin.layout.partial.footer') --}}

@include('admin.layout.base.foot')
