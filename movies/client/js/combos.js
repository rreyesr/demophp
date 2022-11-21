function getGeneros()
{
    fetch(urlApis + gen)
    .then((response) => response.json())
    .then((generos) => 
        {
            var generoSelect = document.getElementById('idGenero');
            generoSelect.innerHTML='';
            var option = document.createElement('option');
            option.value = 0;
            option.innerHTML = 'Selecciona un genero..';
            generoSelect.add(option);
            generos.generos.forEach(genero => {
                var option = document.createElement('option');
                option.value = genero.id;
                option.innerHTML = genero.descripcion;
                generoSelect.add(option)
            });
        })
    .catch(error => console.log(error.message))
}

function getClasificaciones()
{
    fetch(urlApis + clas)
        .then((response) => response.json())
        .then((clasificaciones) => 
            {
                var clasiSelect = document.getElementById('idClasificacion');
                clasiSelect.innerHTML='';
                var option = document.createElement('option');
                option.value = 0;
                option.innerHTML = 'Selecciona una clasificacion..';
                clasiSelect.add(option);
                clasificaciones.clasificaciones.forEach(clasi =>
                    {
                        var option = document.createElement('option');
                        option.value = clasi.id;
                        option.innerHTML = clasi.descripcion;
                        clasiSelect.add(option);
                    });
            })
        .catch(error => console.log(error.message))
}