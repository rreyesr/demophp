
DELIMITER $$
CREATE PROCEDURE peliculasGestionSP
(
	in	opcion int,
	in idPeliculaP int,
    in tituloP varchar(50),
    in anioP char(4),
    in sinopsisP text,
    in idClasificacionP int,
    in idGeneroP int
)
BEGIN
	CASE opcion
		WHEN 1 THEN
			select idGenero, descripcion from generos;
            
		WHEN 2 THEN
			select idClasificacion, descripcion from clasificaciones;
            
        WHEN 3 THEN
			select idPelicula, titulo, anio, sinopsis, idClasificacion, idGenero from peliculas;
        
        WHEN 4 THEN
			select idPelicula, titulo, anio, sinopsis, idClasificacion, idGenero from peliculas where idPelicula = idPeliculaP;
            
        WHEN 5 THEN
			insert into peliculas(titulo,anio,sinopsis,idClasificacion,idGenero)
				values(tituloP,anioP,sinopsisP,idClasificacionP,idGeneroP);
                
        WHEN 6 THEN     			
			update peliculas set titulo = tituloP, 
				anio = anioP, 
				sinopsis = sinopsisP, 
				idClasificacion = idClasificacionP, 
				idGenero = idGeneroP
			where idPelicula = idPeliculaP;
                
        WHEN  7 THEN
			delete from peliculas where idPelicula = idPeliculaP;
	END CASE;
END$$


call peliculasGestionSP (1,null,null,null,null,null,null)
call peliculasGestionSP (2,null,null,null,null,null,null)
call peliculasGestionSP (3,null,null,null,null,null,null)
call peliculasGestionSP (4,1,null,null,null,null,null)
call peliculasGestionSP (5,null,'test','2022','esto es un testing','1',1)
call peliculasGestionSP (6,1,'test123','2000','esto es un testing test','1',1)
call peliculasGestionSP (7,1,null,null,null,null,null)