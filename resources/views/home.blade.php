@extends('layouts.default')

@section('content')
    <div class="grey lighten-4 ">
      <div class="container">
        <div class="row general-title-unidos">
          <div class="col s12 center unidos-heading">
            <h1>Unidos somos <strong>#unasolafuerza</strong></h1>
          </div>
          <div class="col s12 center unidos-buttons">
            <a href="http://unasolafuerza.pe/#voluntariado" class="waves-effect waves-light heading-button btn-large red" target="_blank">SER VOLUNTARIO</a>
          </div>
        </div>
      </div>
    </div>

    <div class="container">

      <div class="row">
        <div class="col s12">
          <h3 class="voluntariado-heading">Voluntariados nivel nacional</h3>
          <p class="text-crear-eventos">Hemos reunido las iniciativas de voluntariado para llevar ayuda a donde más lo necisitan. <a class="btn-flat waves-effect btn-large right agregar-evento" data-target="modal_agregar" >Agregar Evento</a></p>
        </div>
      </div>

      <div class="row eventos">
        <div class="col m12">
        
          <div class="card horizontal">
            <div class="card-image">
              <img src="https://scontent.xx.fbcdn.net/v/t31.0-8/s720x720/17389204_1343824832331687_5818148292517869280_o.jpg?oh=fbbf2dc58711cab3322170bd6072b4f8&oe=59634096">
            </div>
            <div class="card-stacked">
              <div class="card-content">
                <span class="card-title">ANGOLO Y ANCHOR</span>
                <p>
                  <i class="tiny material-icons">language</i> <span>Chosica, Lima</span>
                  <i class="tiny material-icons">date_range</i> <span>Mar 24, 2017</span>
                  <i class="tiny material-icons">av_timer</i> <span>8:30 pm</p></span>
                </p>
                <p><i class="tiny material-icons">perm_identity</i> 44 Voluntarios</p>
                <p><i class="tiny material-icons">verified_user</i> ORGANIZADO POR LIBELULA PERU</p>
              </div>
              <div class="card-action">
                <a href="#" class="red-text">Ver más</a>
                <a href="#" class="red-text">Inscribirse</a>
              </div>
            </div>
          </div>

        </div>

    </div>


    <!-- Agregar evento modal -->
    <div id="modal_agregar" class="modal">
      <div class="modal-content">
        <p>Ingresa la url de tu evento de Facebook</p>
        <div class="input-field col s12">
          <input placeholder="Ejemplo: https://www.facebook.com/events/1115929058529970/" id="facebook_event" type="text" class="validate">
          <label for="facebook_event">URL de Evento</label>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#!" class=" modal-action modal-close waves-effect waves-green btn-flat">CREAR EVENTO</a>
      </div>
    </div>
@stop
@section('js')
  <script type="text/javascript">
    $(document).ready(function(){
       $('#modal_voluntario').modal();
       $('#modal_refugio').modal();
        $('#modal_agregar').modal({
          complete: function() { 
            var facebook_url = $('#facebook_event').val();
            if(facebook_url) {
              var url_parts = facebook_url.match(/https?\:\/\/(?:www\.)?facebook\.com\/(\d+|[A-Za-z0-9\.]+)\/(\d+|[A-Za-z0-9\.]+)\/?/);
              window.location.replace("{{ url('causas/crear')}}" + "/" + url_parts[2]);
            }
            else {
              window.location.replace("{{ url('causas/crear')}}");
            }
          }
        });
      });
  </script>
@stop