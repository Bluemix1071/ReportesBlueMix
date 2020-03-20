window.addEventListener("load",()=>{
    CargarRoles();
    CargarUsuarios();
   

var FormAgregarRoles = document.querySelector("#AgregarRoles");

    FormAgregarRoles.addEventListener('submit',(e)=>{
        e.preventDefault();

      // trabajar en el añadir roles 
        var rol = document.querySelector("#rol").value;
      

        fetch("AddRol",{
            headers:{
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'Content-Type':'application/json',
                //'Content-Type': 'application/x-www-form-urlencoded',
                
            },
            method:'POST',
            body: JSON.stringify( {rol:rol})
        })
            .then(data=>data.json())
            .then(data=>{
                //mostrar mensaje de respuesta a la insercion
                //console.log(data.code);
               MostrarMensaje(data.code);
               CargarRoles();
            });
    });

    var SelectRoles = document.querySelector("#selectRoles");

    SelectRoles.addEventListener("change",()=>{
       var valor = SelectRoles.value;
       var LiPermisos = document.querySelector("#RolesUsers");
       LiPermisos.innerHTML='';
       fetch('ShowPermisos/'+valor)
       //fetch("http://jsonplaceholder.typicode.com/posts")
            .then(data=>data.json())
            .then(data=>{
               // console.log(data);
                CargarPermisosYRoles(data.permisos,data.permisosFaltantes,id='Permisos');
            })

    });

    var FormPermisos = document.querySelector("#agregarPermisos");

    FormPermisos.addEventListener('submit',(e)=>{

        e.preventDefault();

        //var Permisos = document.que ("permisos[]");
        //console.log(Permisos);
        
        var check=ObtenerCheck(name='Permisos');
       // console.log("console",check);
        var rolvalor = document.querySelector("#selectRoles").value;
        //console.log(rolvalor);
        fetch("AddPermisoRol",{
            headers:{
                'X-CSRF-TOKEN': window.CSRF_TOKEN,
                'Content-Type':'application/json',
              
            },
            method:'POST',
            body: JSON.stringify( {
                check:check,
                rol: rolvalor
            
            })
        })
            .then(data=>data.json())
            .then(data=>{
               // console.log(data);
               MostrarMensajeAsignacionPermisos(data.code);
              // CargarRoles();
            })
    });


    var SelectUsers = document.querySelector("#SelectUsers");

    SelectUsers.addEventListener("change",()=>{
        User=SelectUsers.value;
        var LiPermisos = document.querySelector("#Permisos");
        LiPermisos.innerHTML='';
        fetch('ShowRolesUser/'+User)
        .then(data =>data.json())
        .then(data=>{
           // console.log(data.data);
            CargarPermisosYRoles(data.Roles,data.RolesFaltantes,id='RolesUsers');
        });

    });


    var FormUsersRol = document.querySelector("#FormUsersRol");

    FormUsersRol.addEventListener("submit",(e)=>{

        e.preventDefault();

        //var Permisos = document.que ("permisos[]");
        //console.log(Permisos);
        var UserId = document.querySelector("#SelectUsers").value;
        var checkRolesUsers=ObtenerCheck(name='RolesUsers');

        //console.log(checkRolesUsers,UserId);

        fetch("AddRolPermiso",{
            headers:{
            'X-CSRF-TOKEN': window.CSRF_TOKEN,
            'Content-Type':'application/json',
            },
            method:'post',
            body:JSON.stringify({
                UserId:UserId,
                Roles:checkRolesUsers,

            }),
        })
        .then(data=>data.json())
        .then(data=>{

            MensajesRolesUsers(data.code);
            CargarRoles();
        });






    });
    





});


// funciones apartes 

function CargarRoles (){
    fetch("ShowRoles")
    .then(data =>data.json())
    .then(data=>{
        
         options(data.data,id='selectRoles');
    });
}

function CargarUsuarios(){
    fetch("ShowUsers")
        .then(data=>data.json())
        .then(data=>{
            console.log(data);
            options(data.data,id='SelectUsers');
        })

}




 function options(data,id){
    var SelectRoles = document.querySelector("#"+id+"");
    SelectRoles.innerHTML='<option value="">...</option>';
    var index;
    for (index in data) {
        var option = document.createElement("option");

        option.setAttribute("value",data[index].id);
        option.setAttribute("label",data[index].name);
    
        SelectRoles.append(option);
      //  console.log(option);
    
    }

 }

 function MostrarMensaje(data){
    var ok = document.querySelector("#Ok");
    var Error = document.querySelector("#Error");
     if (data==200) {
         ok.innerHTML="El rol fue ingresado correctamente"
        ok.style.display ="";
         setTimeout(()=>{
            ok.style.display ="none";
         },3000);
     
     }else{
         Error.innerHTML="Algo a ocurrido mal .... :C"
        Error.style.display ="";
         setTimeout(()=>{
            Error.style.display ="none";
         },3000);
        
     }
 }

 function MostrarMensajeAsignacionPermisos(data){
    var ok = document.querySelector("#Ok");
    var Error = document.querySelector("#Error");
     if (data==200) {
         ok.innerHTML="los Permisos fueron asignados corectamente"
        ok.style.display ="";
         setTimeout(()=>{
            ok.style.display ="none";
         },3000);
     
     }else if(data==201){
         Error.innerHTML="Permisos quitados correctamente"
        Error.style.display ="";
         setTimeout(()=>{
            Error.style.display ="none";
         },3000);
        
     }
 }

 function MensajesRolesUsers(data){
    var ok = document.querySelector("#Ok");
    var Error = document.querySelector("#Error");
     if (data==200) {
         ok.innerHTML="Roles Asignados Correctamente :)"
        ok.style.display ="";
         setTimeout(()=>{
            ok.style.display ="none";
         },3000);
     
     }else if(data==201){
         Error.innerHTML="Roles quitados correctamente"
        Error.style.display ="";
         setTimeout(()=>{
            Error.style.display ="none";
         },3000);
        
     }
 }



 function CargarPermisosYRoles(permisos,permisosFaltantes,id){
    var LiPermisos = document.querySelector("#"+id+"");
    var index;
    LiPermisos.innerHTML="";
    
    for ( index in permisos) {
       
       
      var checkBox = document.createElement("input");
      var DivPermisos = document.createElement("div");
      var label = document.createElement("label");

      
      checkBox.setAttribute("type","checkbox");    
      checkBox.setAttribute("id",permisos[index].id);    
      checkBox.setAttribute("class","custom-control-input");   
      checkBox.setAttribute("name",id); 
      checkBox.setAttribute("checked",""); 
      checkBox.setAttribute("value",permisos[index].id); 

      DivPermisos.setAttribute("class","custom-control custom-checkbox");

      label.setAttribute("class","custom-control-label");
      label.setAttribute("for",permisos[index].id);
      label.innerHTML= permisos[index].name;

      DivPermisos.appendChild(checkBox);
      DivPermisos.appendChild(label);
      LiPermisos.append(DivPermisos);
    
      console.log(DivPermisos);
      
    }
    
    for (var key in permisosFaltantes) {
        var checkBox = document.createElement("input");
        var DivPermisos = document.createElement("div");
        var label = document.createElement("label");
  
        
        checkBox.setAttribute("type","checkbox");    
        checkBox.setAttribute("id",permisosFaltantes[key].id);    
        checkBox.setAttribute("class","custom-control-input");   
        checkBox.setAttribute("name",id); 
        checkBox.setAttribute("value",permisosFaltantes[key].id); 
        
  
        DivPermisos.setAttribute("class","custom-control custom-checkbox");
  
        label.setAttribute("class","custom-control-label");
        label.setAttribute("for",permisosFaltantes[key].id);
        label.innerHTML= permisosFaltantes[key].name;
  
        DivPermisos.appendChild(checkBox);
        DivPermisos.appendChild(label);
        LiPermisos.append(DivPermisos);
    }





 }

  function ObtenerCheck(name){
    var checked = [];
    //Recorremos todos los input checkbox con name = Colores y que se encuentren "checked"
    $("input[name="+name+"]:checked").each(function ()
    {
    //Mediante la función push agregamos al arreglo los values de los checkbox
    checked.push(($(this).attr("value")));
    });
    // Utilizamos console.log para ver comprobar que en realidad contiene algo el arreglo
   // console.log(checked);
   return checked;
  }
