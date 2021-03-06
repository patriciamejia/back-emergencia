@extends('layouts.default')

@section('content')
<div class="container-fluid grey lighten-3">
<div class="container section">
  <form action="{{action('CausaController@store') }}" method="POST">
  {{ csrf_field() }}
  
  <div class="row">

    <div class="col s12 m8 l8">
      @if (count($errors) > 0)
        <div class="card red">
          <div class="card-content white-text">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
          </div>
        </div>
      @endif
      <div class="card-panel">

        <div class="row reduceRow">         
          <div class="input-field col s12 m12 l12">
            <input value="{{$eventDetails['name'] or ''}}" name="name" id="title" type="text" class="validate">
            <label class="active" for="title">Nombre del Evento</label>
          </div>
        </div>        
        
        <p>Mapa</p>
        <p><img src="http://maps.google.com/mapfiles/ms/icons/green-dot.png">Punto de encuentro</p>
        <p><img src="http://maps.google.com/mapfiles/ms/icons/red-dot.png">Punto en el que se brindará ayuda</p>
        <div id="map" style="width: 100%; height: 400px;"></div>
          <div class="row reduceRow">
            <div class="input-field col s12 m12 l12">
              <input name="expected_volunteers" id="expected_volunteers" type="text" class="validate">
              <label for="last_name">Número de Voluntarios Esperados</label>
            </div>
          </div>

          <div class="row reduceRow">
            <div class="input-field col s6">
              <input name="start_time" placeholder="18 de mayo 8:00 p.m." id="start_time" type="date" value="{{$eventDetails['start_time'] or ''}}" class="validate datepicker">
              <label for="start_time">Fecha de Inicio</label>
            </div>
            <div class="input-field col s6">
              <input name="end_time" placeholder="18 de mayo 8:00 p.m." id="end_time" type="date" class="validate datepicker">
              <label for="end_time">Fecha de Fin</label>
            </div>
          </div>
        </div>
        <div class="row">
            <div class="col s12">              
              <input type="submit" class="btn-large waves-effect waves-light red" value="Publica tu evento"></input>
            </div>
        </div>
    </div>

    <div class="col s12 m4 l4">
      <div class="card">
        @if(!empty($picture['cover']['source']))
        <div class="card-image">
          <img src="{{ $picture['cover']['source'] }}">
          <input type="hidden" name="picture" value="{{ $picture['cover']['source'] }}">
        </div>
        @endif
        <div class="card-content">
          <div class="row reduceRow">
            <div class="input-field s12 m12 l12">
              <textarea name="description" id="description" class="materialize-textarea">{{$eventDetails['description'] or ''}}</textarea>
              <label for="description">Descripción</label>
            </div>              
          </div>
        </div>
      </div>
    </div>
    <input type="hidden" id="gather_point_lat" name="gather_point_lat" value="{{$eventDetails['place']['location']['latitude'] or '-12.0552608'}}">
    <input type="hidden" id="gather_point_lng" name="gather_point_lng" value="{{$eventDetails['place']['location']['longitude'] or '-77.0627323'}}">
    <input type="hidden" name="street" value="{{$eventDetails['place']['location']['street'] or ''}}">
    <input type="hidden" name="city" value="{{$eventDetails['place']['location']['city'] or ''}}">
    <input type="hidden" id="work_zone_lat" name="work_zone_lat" value="{{ isset($eventDetails['place']['location']['latitude']) ? $eventDetails['place']['location']['latitude'] - 0.0010 : '-12.0552608'}}">
    <input type="hidden" id="work_zone_lng" name="work_zone_lng" value="{{ isset($eventDetails['place']['location']['longitude']) ? $eventDetails['place']['location']['longitude'] + 0.0050 : '-77.0627323'}}">
    <input type="hidden" name="work_zone_radious" value="">
    <input type="hidden" name="facebook_id" value="{{$eventDetails['id'] or ''}}">
  </div>
  </form>
</div>
</div>
@stop

@section('js')
<script type="text/javascript" src="{{URL::asset('js/picker-es.js')}}"></script>
<script>
var $startTime = $('#start_time').pickadate();
var picker = $startTime.pickadate('picker');
console.log(new Date("{{$eventDetails['start_time'] or ''}}"));
picker.set('select', new Date("{{$eventDetails['start_time'] or ''}}"));

var $endTime = $('#end_time').pickadate();
var picker = $endTime.pickadate('picker');
picker.set('select', new Date("{{$eventDetails['end_time'] or ''}}"));

// The following example creates a marker in Stockholm, Sweden using a DROP
// animation. Clicking on the marker will toggle the animation between a BOUNCE
// animation and no animation.
var marker;
function initMap() {
  var map = new google.maps.Map(document.getElementById('map'), {
    zoom: 13,
    center: {lat: {{$eventDetails['place']['location']['latitude'] or '-12.0552608'}}, lng: {{$eventDetails['place']['location']['longitude'] or '-77.0627323'}} }
  });
  marker = new google.maps.Marker({
    map: map,
    draggable: true,
    animation: google.maps.Animation.DROP,
    position: {lat: {{$eventDetails['place']['location']['latitude'] or '-12.0552608'}}, lng: {{$eventDetails['place']['location']['longitude'] or '-77.0627323'}} },
    icon: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png'  
  });
  marker1 = new google.maps.Marker({
    map:map,
    draggable:true,
    animation:google.maps.Animation.DROP,
    position:{lat:{{ isset($eventDetails['place']['location']['latitude']) ? $eventDetails['place']['location']['latitude'] - 0.0010 : '-12.0552608'}}, lng: {{ isset($eventDetails['place']['location']['longitude']) ? $eventDetails['place']['location']['longitude'] + 0.0050 : '-77.0627323'}} },
    icon: 'http://maps.google.com/mapfiles/ms/icons/red-dot.png'
  });
  marker.addListener('click', toggleBounce);
  marker1.addListener('click',toggleBounce);
  google.maps.event.addListener(marker, 'dragend', function (event) {
    $("#gather_point_lat").val(marker1.getPosition().lat);
    $("#gather_point_lng").val(marker1.getPosition().lng);
  });

  google.maps.event.addListener(marker1, 'dragend', function (event) {
    $("#work_zone_lat").val(marker1.getPosition().lat);
    $("#work_zone_lng").val(marker1.getPosition().lng);
  });

}


function toggleBounce() {
  if (marker.getAnimation() !== null) {
    marker.setAnimation(null);
  } else {
    marker.setAnimation(google.maps.Animation.BOUNCE);
  }
}
</script>

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAvZtQOIf5GmXC4r_DymvtBuYIGdnENXb4&callback=initMap"></script>

@stop