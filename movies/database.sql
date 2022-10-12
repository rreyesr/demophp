
create database Peliculas;
use Peliculas;
create table clasificaciones
(
	idClasificacion int auto_increment primary key not null,
    descripcion char(4)
);

insert into clasificaciones(descripcion)values('A'),('B'),('B-12'),('B-15'),('C');

create table generos
(
	idGenero int auto_increment primary key not null,
    descripcion varchar(30)
);

insert into clasificaciones(descripcion)values('Accion'),('Aventura'),('Supsenso'),('Comedia'),('Documental');

create table peliculas
(
	idPelicula int auto_increment primary key not null,
    titulo varchar(50) not null,
    anio char(4) not null,
    sinopsis text not null,
    idClasificacion int not null,
    idGenero int not null,
    FOREIGN KEY (idClasificacion) REFERENCES clasificaciones(idClasificacion),
    FOREIGN KEY (idGenero) REFERENCES generos(idGenero)
);

