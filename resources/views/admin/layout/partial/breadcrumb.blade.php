<div class="pagetitle">
    @if($data && $data['page_title'])
    <h1> {{$data['page_title']}}</h1>
    @endif
    <nav>
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('admin.dashboard.index')}}">Home</a></li>
            @if($data && $data['breadcrumbs'] && count($data['breadcrumbs']) > 0)
            <li class="breadcrumb-item"><a href="{{$data['breadcrumbs'][0]['url']}}">{{$data['breadcrumbs'][0]['title']}}</a></li>
            @endif
            @if($data && $data['breadcrumbs'] && count($data['breadcrumbs']) > 1)
            <li class="breadcrumb-item active"><a href="{{$data['breadcrumbs'][1]['url']}}">{{$data['breadcrumbs'][1]['title']}}</a></li>
            @endif
        </ol>
    </nav>
</div><!-- End Page Title -->
