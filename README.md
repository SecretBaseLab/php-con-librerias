# php-con-librerias
usando librerias para generar las rutas, conexion con la base, validacion de datos, manejo de peticiones http

hacer un push a github
  git remote add <nombre de la conexion> <url del repo>
  git remote pa ver la lista de conexiones creadas
  git push <nombre de la conexion>  <nombre de la rama git ej: master>

    para acceder a la base desde otra pc 
revisar q este asi en mi.ini de mysql
  [mysqld]
port=3306
skip-grant-tables
 #bind-address = 0.0.0.0  //opcional en caso de q no funcione con la linea de arriba
