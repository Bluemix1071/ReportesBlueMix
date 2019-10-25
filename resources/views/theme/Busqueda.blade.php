<div class="form-group">
<form action="{{route('filtrar')}}" role="search" method="POST" id="form">
    @csrf
            <div class="input-group">
                <input id="xd" type="text" name="searchText" class="form-control" placeholder="Buscar...">
                <span class="input-group-btn">
                   <button id="boton" type="submit" class="btn btn-primary">Buscar </button> 
                </span>
            </div>
         </form>
     </div>