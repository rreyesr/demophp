function init()
{
    getGeneros();
    getClasificaciones();
    getMovies();
}


function getMovies()
{
    fetch(urlApis + peli)
        .then((response) => response.json())
        .then((peliculas) => 
            {
                var peliculasTable = document.getElementById('peliculas');
                peliculasTable.innerHTML='';

                peliculas.peliculas.forEach(pelis => {

                    var row = document.createElement('tr');

                    var cellIdPelicula = document.createElement('td');
                    cellIdPelicula.innerHTML = pelis.idPelicula;

                    var cellImg = document.createElement('td');
                    var img = document.createElement('img');
                    img.style = 'width: 18rem;';
                    img.src = './images/' + pelis.image;
                    cellImg.appendChild(img);

                    console.log(pelis.image);

                    var cellTitulo = document.createElement('td');
                    cellTitulo.innerHTML = pelis.titulo;
                    
                    var cellClasificacion = document.createElement('td');
                    cellClasificacion.innerHTML = pelis.clasificacion.descripcion;

                    var cellGenero = document.createElement('td');
                    cellGenero.innerHTML = pelis.genero.descripcion;

                    var cellAnio = document.createElement('td');
                    cellAnio.innerHTML = pelis.anio;

                    var cellSinopsis = document.createElement('td');
                    cellSinopsis.innerHTML = pelis.sinopsis;

                    var cellAcciones = document.createElement('td');
                    var btnEditar = document.createElement('a');
                    btnEditar.innerHTML = 'Modificar';
                    btnEditar.className = 'btn btn-success';
                    btnEditar.href = 'editar.html?idPelicula=' +  pelis.idPelicula;
                    cellAcciones.appendChild(btnEditar)

                    var btnCancelar = document.createElement('a');
                    btnCancelar.id = 'borrar';
                    btnCancelar.className = 'btn btn-danger';
                    btnCancelar.style = 'margin-left: 1rem';
                    btnCancelar.innerHTML = 'Eliminar';
                    btnCancelar.onclick = function () {
                        eliminar(pelis.idPelicula);
                    }       
                    cellAcciones.appendChild(btnCancelar);
                    

                    row.appendChild(cellIdPelicula);
                    row.appendChild(cellImg);
                    row.appendChild(cellTitulo);
                    row.appendChild(cellAnio);
                    row.appendChild(cellClasificacion);
                    row.appendChild(cellGenero);
                    row.appendChild(cellSinopsis);
                    row.appendChild(cellAcciones);
                    peliculasTable.appendChild(row);
                });
            })
        .catch(error => console.log(error.message))
}

function eliminar(id)
{
    let data = preparaDatosEliminar(id);

    console.log(data);
    var confirma = confirm('Seguro que desea eliminar el registro? ');
    if(confirma)
    {
        fetch(urlApis + peli + '?idPelicula=' + id, data)
            .then((response) => 
                {
                    response.json().then((response) => {
                            console.log(response);
                            var alert = document.getElementById('alert');
                            var alerta = document.createElement('div');
                            if(response.estatus != 200){                            
                                alert.className = 'col-12 alert alert-danger';
                                alert.innerHTML = response.message;
                                
                            }
                            else{
                                alert.className = 'col-12 alert alert-success';
                                alert.innerHTML = response.message;
                                getMovies();
                            }
                            alert.appendChild(alerta);
                        })
                })
        
    }
}

function agregar()
{
    const data = preparaDatosGuardar();
    console.log(data);
    fetch(urlApis + peli,data)
        .then((response => 
        {
            response.json().then((response) =>
            {
                console.log(response);
                var alert = document.getElementById('alert');
                var alerta = document.createElement('div');
                console.log(response);
                if(response.estatus != 200){                            
                    alert.className = 'col-12 alert alert-danger';
                    alert.innerHTML = response.message;
                    
                }
                else{
                    alert.className = 'col-12 alert alert-success';
                    alert.innerHTML = response.message;
                }
                alert.appendChild(alerta);
                limpiar();
                getMovies();
            })
        }))
}

function preparaDatosGuardar()
{
    var formData = new FormData();
    //var file = document.getElementById('image');
    formData.append('titulo', document.getElementById('titulo').value);
    formData.append('anio', document.getElementById('anio').value);
    formData.append('sinopsis', document.getElementById('sinopsis').value);
    formData.append('idClasificacion', document.getElementById('idClasificacion').value);
    formData.append('idGenero', document.getElementById('idGenero').value);
    formData.append('image', document.getElementById('image').files[0]);

    let opciones = {
        method : "POST",
        body : formData
    }

    return opciones;
}

function preparaDatosEliminar()
{
    let opciones = {
        method : "DELETE"
    }

    return opciones;
}

function limpiar()
{
    document.getElementById('titulo').value = '';
    document.getElementById('titulo').value = '';
    document.getElementById('titulo').value = '';
    document.getElementById('titulo').value = '';
    document.getElementById('image').files[0]  = '';
}