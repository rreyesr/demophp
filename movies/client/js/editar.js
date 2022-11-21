function init()
{
    getGeneros();
    getClasificaciones();
    datosPelicula();
}


function datosPelicula()
{   
    const parametros = location.search;
    const id = parametros.substring(12,14);
    console.log(urlApis + peli + '?idPelicula=' + id);
    fetch(urlApis + peli + '?idPelicula=' + id)
    .then((response) => response.json())
    .then((peliculas) => 
        {
            console.log(peliculas);
            document.getElementById('idClasificacion').value = peliculas.peliculas.clasificacion.id;
            document.getElementById('idGenero').value = peliculas.peliculas.genero.id;
            document.getElementById('idPelicula').value = peliculas.peliculas.idPelicula;
            document.getElementById('titulo').value = peliculas.peliculas.titulo;
            document.getElementById('anio').value = peliculas.peliculas.anio;           
            document.getElementById('sinopsis').value = peliculas.peliculas.sinopsis;
            document.getElementById('img').src = './images/' + peliculas.peliculas.image;
            document.getElementById('idClasificacion').value = peliculas.peliculas.clasificacion.id;
            document.getElementById('idGenero').value = peliculas.peliculas.genero.id;

        })
    .catch(error => console.log(error.message))
}

function editar()
{
    let data = preparaDatos();
    fetch(urlApis + peli, data)
        .then((response) => 
                {
                    response.json().then((response) => 
                    {
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
                    })
                }
            )
}

function preparaDatos()
{
    let data = {
        idPelicula : document.getElementById('idPelicula').value,
        titulo : document.getElementById('titulo').value,
        anio : document.getElementById('anio').value,
        sinopsis : document.getElementById('sinopsis').value,
        idClasificacion : document.getElementById('idClasificacion').value,
        idGenero : document.getElementById('idGenero').value
    }

    let opciones = {
        method : "PUT",
        body: JSON.stringify(data)
    }

    return opciones;
}