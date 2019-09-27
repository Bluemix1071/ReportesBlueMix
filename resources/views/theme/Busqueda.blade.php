<div class="form-group">
<form action="{{route('ProductosNegativos')}}" role="search" method="GET">
            <div class="input-group">
                <input type="text" name="searchText" class="form-control" placeholder="Buscar..." value="{{$query}}">
                <span class="input-group-btn">
                   <button type="submit" class="btn btn-primary">Buscar </button> 
                </span>
            </div>
         </form>
     </div>