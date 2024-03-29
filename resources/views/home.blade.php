@extends('layouts.layout')
@section('title')
@parent - {{$title}}
@endsection

@section('content')
<main>
  <form class="mt-5" action="{{route('home2')}}" method="POST">
    @csrf
    <div class="container">
      <input type="text" name="search" id="search" value="{{ request()->get('search') }}" class="form-control" placeholder="Search..." aria-label="Search" aria-describedby="button-addon2">
    </div>
    <br>
    <div class="container">
      <select class="form-select mb-3" id="Cat" name="Cat">
        <option selected>Выберите категорию</option>
        @foreach ($categories as $cat)
        <option value="{{ $cat->id }}" @if(old('Cat')==$cat) selected @endif>{{ $cat->CategoryName }}</option>
        @endforeach
      </select>
      <button type="submit" class="btn btn-primary" style="background-color: #212529; border-color: #212529">Отправить</button>
    </div>
  </form>

  <br>

  <div class="album py-5 bg-body-tertiary">
    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
        @foreach ($Ads as $Ad)
        @if($Ad->Status == 'Y')
        <div class="col">
          <div class="card shadow-sm">
            @if($Ad->AdPhoto!= null)
            <img src="{{ asset('storage/'.str_replace('public/', '', $Ad->AdPhoto))}}" alt="" width="100%" height="225">
            @else
            <svg class="bd-placeholder-img card-img-top" width="100%" height="225" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
              <title>Placeholder</title>
              <rect width="100%" height="100%" fill="#55595c"></rect><text x="50%" y="50%" fill="#eceeef" dy=".3em">Thumbnail</text>
            </svg>
            @endif
            <div class="card-body">
              <h5 class="card-title">{{$Ad->Title}}</h5>
              <p class="card-text">{{$Ad->Description}}</p>
              <div class="d-flex justify-content-between align-items-center">
                @foreach ($categories as $cat2)
                @if($cat2->id==$Ad->CategoryID)
                <div class="card-cat">{{$cat2->CategoryName}}</div>
                @endif
                @endforeach
                <small class="text-body-secondary">{{$Ad->created_at}}</small>
                <div class="btn-group">
                  <form action="{{route('post.cart')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post" id="post" value="{{$Ad->id}}">
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="color: #2C232B; border-color: #2C232B">
                      <img src="{{  asset('storage/images/1/6.jpg') }}" alt="" height="20">
                    </button>
                  </form>
                  @if(Auth::check() && Auth::user()->Role)
                  <form action="{{route('post.red')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post" id="post" value="{{$Ad->id}}">
                    <button type="submit" class="btn btn-sm btn-outline-secondary" style="color: #3A3D30; border-color: #3A3D30">
                      <img src="{{  asset('storage/images/1/7.jpg') }}" alt="" height="20">
                    </button>
                  </form>
                  <form action="{{route('post.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="post" id="post" value="{{$Ad->id}}">
                    <button type="submit" class="btn btn-sm btn-outline-danger" style="color: #2C232B; border-color: #2C232B">
                      <img src="{{  asset('storage/images/1/8.png') }}" alt="" height="20"></button>
                  </form>
                  @endif
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        @endforeach
        <div class='col-md-12'>
          {{$Ads->appends(['test'=>request()->test])->links('vendor.pagination.bootstrap-4')}}
        </div>
        @yield('content')
</main>
@include('layouts.footer')
</body>

</html>
@endsection