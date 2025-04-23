# letterfly
Una página para guardar reseñas de libros

Ahora mismo tiene:

header.php: Es el menú superior de la página, además incluye la referecnia a bootstrap

registro.php: Permite a cualquiera registrarse, contiene tambien un captcha y comprueba si el campo contraseña y confirmar contraseña son la misma.

login.php: Es la parte que permite iniciar sesión, comprueba si el correo y contraseña están en la base de datos y además comprueba también si el usuario tiene el rol "bann" en la base de datos en cuyo caso no permitirá el inicio de sesión. Si ya tenias la sesión iniiciada la idea es que te redirija automaticamente a la pagina de inicio/la pagina donde aparecerán los libros

==============================================

Luego en .htaccess se especifica las páginas de error 403 (Forbbiden) y 404 (Not Found) las cuales se encuentran en /include/errores
ademas tambien está puesto la opcion de desactivar la indexación por seguridad por lo que si intentas acceder a una carpeta devuelve un error 403
