@extends('layouts.web')
@section('content')
<section class="hero-wrap hero-wrap-2 js-fullheight" style="background-image: url('images/bg_1.jpg');"
    data-stellar-background-ratio="0.5">
    <div class="overlay"></div>
    <div class="container">
        <div class="row no-gutters slider-text js-fullheight align-items-end justify-content-center">
            <div class="col-md-9 ftco-animate pb-5 text-center">
                <h1 class="mb-3 bread">Places to Travel</h1>
                {{-- <p class="breadcrumbs"><span class="mr-2"><a href="index.html">Home <i class="ion-ios-arrow-forward"></i></a></span> <span>About us <i class="ion-ios-arrow-forward"></i></span></p> --}}
            </div>
        </div>
    </div>
</section>

<section class="ftco-section ftco-no-pb ftco-no-pt" style="margin-top:-50px;">
    <div class="container">
        <div class="row">
            <div class="col-md-12 mb-5">
                <div class="search-wrap-1 search-wrap-notop ftco-animate p-4">
                    <form action="/destinations" class="search-property-1" method="get">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 align-items-end">
                                <!-- hide fileds of long and lat -->
                                <input type="hidden" id="lat" name="lat" class="form-control" >
                                <input type="hidden" id="lng" name="lng" class="form-control" >
                                <div class="form-group">
                                    <label for="#">Destination</label>
                                    <div class="form-field">
                                        <div class="icon"><span class="ion-ios-search"></span></div>
                                        <input type="text" id="search_input" name="city" class="form-control"
                                            placeholder="Search place">
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg align-items-end">
                                <div class="form-group">
                                    <label for="#">Closer</label>
                                    <div class="select-wrap">
                                        <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                        <select name="orderby" id="" class="form-control"  style="color:#838288 !important;">
                                            <option value="price">Price</option>
                                            <option value="proximity">Proximity</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg align-items-end">
                                <div class="form-group">
                                    <label for="#">Itens Per Page</label>
                                    <div class="form-field">
                                        <div class="select-wrap">
                                            <div class="icon"><span class="ion-ios-arrow-down"></span></div>
                                            <select name="itensPerPage" id="" class="form-control"  style="color:#838288 !important;">
                                                <option value="6"> 6</option>
                                                <option value="10"> 10</option>
                                                <option value="30"> 30</option>
                                                <option value="50"> 50</option>
                                                <option value=""> all</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg align-self-end">
                                <div class="form-group">
                                    <div class="form-field">
                                        <input type="submit" value="Search" class="form-control btn btn-primary">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="ftco-section ftco-no-pt">
    <div class="container">
        <div class="row justify-content-center pb-4">
            <div class="col-md-12 heading-section text-center ftco-animate">
                <h2 class="mb-4">Tour Destination</h2>
            </div>
        </div>
        <div class="row">
            @foreach ($destinations as $destination)
              
            <div class="col-md-4 ftco-animate">
                <div class="project-wrap">
                    <a href="#" class="img" style="background-image: url(images/destination-1.jpg);"></a>
                    <div class="text p-4">
                        <span class="price">${{ $destination['price'] }}/day</span>
                        <span class="ion-ios-star"></span>
                        <span class="ion-ios-star"></span>
                        <span class="ion-ios-star"></span>
                        <h3><a href="#">{{ $destination['address'] }}</a></h3>
                        <p class="location"><span class="ion-ios-map"></span> {{ $destination['country'] }}</p>
                        <ul>
                            <li><span class="ion-ios-car"></span>{{ $destination['distance'] }} km</li>
                            <li><span class="flaticon-king-size"></span>3</li>
                            <li><a href="https://www.google.com.br/maps/search/{{ $destination['address'] }}/@{{ $destination['lat'] }},@{{ $destination['lng'] }},5.75z/data=!3m1!4b1"><span class="flaticon-map"></span>View on Maps</a></li>
                        </ul>
                    </div>
                </div>
            </div>
              
            @endforeach
        </div>
        <div class="row mt-5">
            <div class="col text-center">
                <div class="block-27">
                    <ul>
                        <li><a href="#">&lt;</a></li>
                        <li class="active"><span>1</span></li>
                        <li><a href="#">&gt;</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
