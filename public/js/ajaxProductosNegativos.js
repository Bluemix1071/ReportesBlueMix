$(document).ready(function(){


$('#form').on('submit',function(e){
e.preventDefault();

var data =$(this).serialize();
var text = document.getElementById('xd').value;
var excel= document.getElementById('valorBuscar').value = text;
 
var form = $(this);
var url = form.attr('action');


console.log(excel);


$.post(url,data,function(result){
    //console.log(result.productos);
    let res =document.querySelector('#res');
    res.innerHTML='';

for(let item of result.productos){
    res.innerHTML += `
    <tr>
    <th>${item.nombre}</th>
    <td>${item.ubicacion}</td>
    <td>${item.codigo}</td>
    <td>${item.bodega_stock}</td>
    <td>${item.sala_stock}</td>
    </tr>
    
    `

}


}).fail(function(){

    alert('algo salio mal ');
    //console.log(result.productos);
});

});



});

