<div class="pagetitle">
    <h1> {{$data['page_title']}}</h1>
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('dashboard.index')}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{$data['breadcrumbs'][0]['url']}}">{{$data['breadcrumbs'][0]['title']}}</a></li>
            <li class="breadcrumb-item active"><a href="{{$data['breadcrumbs'][1]['url']}}">{{$data['breadcrumbs'][1]['title']}}</a></li>
        </ol>
    </nav>
</div><!-- End Page Title -->
