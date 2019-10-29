$(document).ready(function(){

/*
$('#form').on('submit',function(e){
e.preventDefault();

var data =$(this).serialize();*/
var text = document.getElementById('xd').value;
var excel= document.getElementById('valorBuscar').value = text;
console.log(excel);
 /*
var form = $(this);
var url = form.attr('action');




$.post(url,data,function(result){
    //console.log(result.productos);
    let res =document.querySelector('#res');
   // let pagination = document.querySelector('#productos_paginate');
   
    $(".productosNegativos").html(result);


}).fail(function(){

    alert('algo salio mal ');
    //console.log(result.productos);
});

});
*/

/*
});

$(document).on('click','.pagination a',function(e){
e.preventDefault();


var text = document.getElementById('xd').value;
if(text==''){ 
var page = $(this).attr('href').split('page=')[1];
var route= "ProductosNegativos"
$.ajax({
    url:route,
    data: {page :page},
    type: 'GET',
    dataType: 'json',
    success: function (data){
    $(".productosNegativos").html(data);
    }
});

}else{
var page = $(this).attr('href').split('page=')[1];
var route= "ProductosNegativos2"
$.ajax({
    url:route,
    data: {page: page},
    type: 'GET',
    dataType: 'json',
    success: function (data){
    $(".productosNegativos").html(data);
    }
});

}
*/

});

