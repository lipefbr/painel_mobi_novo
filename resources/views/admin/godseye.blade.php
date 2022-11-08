@extends('admin.layout.app')

@section('title', 'Olho de Deus ')

@section('styles')
<link rel="stylesheet" href="{{asset('main/vendor/jvectormap/jquery-jvectormap-2.0.3.css')}}">
@endsection

@section('content')
<?php $diff = ['-success', '-info', '-warning', '-danger']; ?>


<div class="page-content-wrapper">
    <div class="container-fluid">
        <div class="row">

            <div class="col-sm-3">
                <div class="card m-b-20">
                    <div class="card-header">
                        <h6 class="provider_title" style="margin-bottom: 3px;">Todos</h6>

                    </div>
                    <div class="card-body" style="padding: 0">
                        <div style="overflow: scroll;">
                        <div class="provider_list" style="height:590px; padding-top: 12px; padding-left: 8px"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-sm-9">
                <div class="card m-b-20">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3 ">
                                <h6 style="margin-bottom: 0px">Mapa</h6>
                            </div>

                            <div class="col-sm-9 d-flex justify-content-end button-items">
                                <button class="btn btn-primary godseye_menu" data-value="ALL">Todos</button>
                                <button class="btn btn-default godseye_menu" data-value="ACTIVE">Disponíveis</button>
                                <button class="btn btn-default godseye_menu" data-value="STARTED">A Caminho do Embarque</button>
                                <button class="btn btn-default godseye_menu" data-value="ARRIVED">No Local de Embarque</button>
                                <button class="btn btn-default godseye_menu" data-value="PICKEDUP">Em Viagem</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="padding: 0px">
                        <div id="map" style="width:100%; height:600px;background:#ccc"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script src="https://maps.googleapis.com/maps/api/js?key={{ setting('map_key')}}&libraries=places&language=en"></script>
<script>

var map, info;
var markers = [];
var status = "ALL";

if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(success, fail);
} else {
    console.log('Sorry, your browser does not support geolocation services');
    initialize();
}

function success(position)
{

    if (position.coords.longitude != "" && position.coords.latitude != "") {
        current_longitude = position.coords.longitude;
        current_latitude = position.coords.latitude;
    }

    initialize(current_latitude, current_longitude);
}

function fail()
{
    initialize();
}

function initialize(latitude = 0, longitude = 0) {

    var mapInterval = setInterval(getProviders, 30000);

    var mapOptions = {
        zoom: 12,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        center: new google.maps.LatLng(latitude, longitude)
    };

    map = new google.maps.Map(document.getElementById('map'), mapOptions);

    $('.godseye_menu').on('click', function () {
        $('.provider_title').text($(this).text());
        status = $(this).data('value');
        $(this).addClass('btn-primary').siblings().removeClass('btn-primary');
        clearInterval(mapInterval);
        getProviders();
        mapInterval = setInterval(getProviders, 30000);
    });


    function getProviders() {

        $.get("{{ route('admin.godseye_list') }}/?status=" + status, function (data) {
            var locations = data.locations;
            var providers = data.providers;

            removeMarkers();

            $('.provider_list').empty();

            for (i = 0; i < locations.length; i++) {

                var item = locations[i];

                console.log(providers[i].service.marker);

                var marker = new google.maps.Marker({
                    icon: {scaledSize: new google.maps.Size(35, 25), url: providers[i].service.service_type.marker},
                    map: map,
                    position: new google.maps.LatLng(locations[i].lat, locations[i].lng)
                });

                marker.provider = providers[i];

                marker.addListener('click', function (e) {
                    selectProvider(this);
                    scrollList(this);
                });


                var onClick = function (marker) {
                    return function () {
                        selectProvider(marker);
                    }
                }

                var image = "{{ asset('/asset/img/grey.png') }}";

                if (providers[i].service.status == 'active' && providers[i].status == 'approved') {
                    image = "{{ asset('/asset/img/green.png') }}";
                } else if (providers[i].service.status == 'riding' && providers[i].trips[0].status == 'STARTED') {
                    image = "{{ asset('/asset/img/grey.png') }}";
                } else if (providers[i].service.status == 'riding' && providers[i].trips[0].status == 'ARRIVED') {
                    image = "{{ asset('/asset/img/yellow.png') }}";
                } else if (providers[i].service.status == 'riding' && providers[i].trips[0].status == 'PICKEDUP') {
                    image = "{{ asset('/asset/img/blue.png') }}";
                } else {
                    image = "{{ asset('/asset/img/red.png') }}";
                }

                var avatar = (providers[i].avatar == null || providers[i].avatar == "") ? "{{asset('main/avatar.jpg')}}" : "{{asset('/storage/')}}" + "/" + providers[i].avatar;

                var li = $(`<a class="media" id="` + providers[i].id + `" href="#" style="margin-bottom: 8px;">
                                               
                                        <img src="` + avatar + `" class="d-flex thumb-md rounded-circle mr-2">
                                        <img src="` + image + `" width="10" style="margin-left: -13px; margin-top: -4px;">
                                        <div class="media-body chat-user-box" style="margin-left: 16px;">
                                            <p class="user-title m-0">` + providers[i].first_name + ` ` + providers[i].last_name + `</p>
                                            <p class="text-muted">` + providers[i].mobile + `</p>
                                        </div>
                                </a><hr>`).on('click', onClick(marker));

                $('.provider_list').append(li);

                markers.push(marker);

            }


        });
    }

    function selectProvider(marker) {
        return showinfoWindow(marker);
    }

    function scrollList(marker) {
        var item = $('.provider_list').find('li[id=' + marker.provider.id + ']');

        if (item) {
            var position = $(".provider_list").scrollTop() - $(".provider_list").offset().top + item.offset().top;
            $(".provider_list").animate({scrollTop: position}, 500);
        }
    }

    function removeMarkers() {
        for (var i in markers) {
            if (typeof markers[i] !== 'undefined')
                markers[i].setMap(null);
        }
    }

    function showinfoWindow(marker) {

        hideinfoWindow();

        var live_tarack = ((marker.provider.trips).length > 0) ? (marker.provider.trips[0].status == 'PICKEDUP') ?
                `<tr><td></td><td><a href="{{url('/track')}}/` + marker.provider.trips[0].id + `" target="_blank"><b>Live tracking</b></a></td></tr>` : `` : ``;

        var avatar = (marker.provider.avatar == null || marker.provider.avatar == "") ? "{{asset('main/avatar.jpg')}}" : "{{asset('/storage/')}}" + "/" + marker.provider.avatar;

        var html = `<table>
                        <tbody>
                                <tr><td rowspan="5"><img src="` + avatar + `" width="auto" height="70"></td></tr>
                                <tr><td>&nbsp;&nbsp;Nome: </td><td><b>` + marker.provider.first_name + ` ` + marker.provider.last_name + `</b></td></tr>
                                <tr><td>&nbsp;&nbsp;E-mail: </td><td><b>` + marker.provider.email + `</b></td></tr>
                                <tr><td>&nbsp;&nbsp;Contato: </td><td><b>` + marker.provider.mobile + `</b></td></tr>` + live_tarack +
                `</tbody>
                </table>`;

        info = new google.maps.InfoWindow({
            content: html,
            maxWidth: 350
        });

        info.open(map, marker);
    }

    getProviders();
}

function hideinfoWindow() {
    if (typeof info != 'undefined' && info != null) {
        info.close();
    }

}


</script>

@endsection