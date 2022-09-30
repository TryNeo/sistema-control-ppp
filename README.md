<p align="center">
  <a href="https://i.ibb.co/DQstGsn/favicon1.png">
    <img src="https://i.ibb.co/DQstGsn/favicon1.png" alt="Logo" width="80" height="80">
  </a>

  <h3 align="center">Sistema control de practicas pre profesionales</h3>
  <p align="center">
    <a href="#">
        <img alt="Bug" src="https://img.shields.io/static/v1?label=REPORT&message=BUG&color=red&style=for-the-badge&logo=openbugbounty&logoColor=white">
    </a>
    <a href="#">
        <img alt="Version" src="https://img.shields.io/static/v1?label=VERSION&message=1.0.1&color=blue&style=for-the-badge">
    </a>
    <a href="#">
        <img alt="Build" src="https://img.shields.io/static/v1?label=BUILD&message=En proceso&color=blue&style=for-the-badge&logo=buildkite&logoColor=white">
    </a>
    <a href="#">
        <img alt="Django" src="https://img.shields.io/static/v1?label=php&message=7.4.29&color=green&style=for-the-badge&logo=php&logoColor=white">
    </a>
     <a href="#">
       <img alt="Python" src="https://img.shields.io/static/v1?label=xampp&message=3.3.0&color=blue&style=for-the-badge&logo=xampp&logoColor=white">
    </a>
  </p>
</p>

<details open="open">
  <summary>Tabla de contenido</summary>
  <ol>
    <li>
      <a href="#acerca-del-proyecto">Acerca del proyecto</a>
      <ul>
        <li><a href="#construido-con">Construido con</a></li>
      </ul>
    </li>
    <li><a href="#Instrucciones">Insrucciones</a></li>
    <li><a href="#license">Licencia</a></li>
    <li><a href="#contact">Contacto</a></li>
  </ol>
</details>

## Acerca del proyecto

Creador a partir de la necesidad del Instituto Superior Tecnológico Tres de Marzo de no poder tener un buen control para las practicas pre profesionales de sus alumnos donde esta nueva plataforma facilitaria a sus alumnos y docentes de poder llevar un registro de control de las pasantias que haga el estudiante en el instituto
en cada empresa

[![ppp](https://i.ibb.co/N168wxY/Screenshot-7.jpg)](https://i.ibb.co/N168wxY/Screenshot-7.jpg)

<hr>

[![ppp](https://i.ibb.co/31VFGSR/Screenshot-8.jpg)](https://i.ibb.co/31VFGSR/Screenshot-8.jpg)

<hr>

[![ppp](https://i.ibb.co/wSR4yVx/Screenshot-5.jpg)](https://i.ibb.co/wSR4yVx/Screenshot-5.jpg)

<hr>

[![ppp](https://i.ibb.co/L1vx09w/Screenshot-12.jpg)](https://i.ibb.co/L1vx09w/Screenshot-12.jpg)

<hr>



### Construido con 

En esta sección se mostrará una lista de tecnologías que se usaron para la creación de este proyecto.

* [Bootstrap](https://getbootstrap.com)
* [JQuery](https://jquery.com)
* [Xampp](https://www.apachefriends.org/es/index.html)
* [Stila](https://getstisla.com/)
* [Php](https://www.php.net/)
* [Sweetalert2](https://sweetalert2.github.io/)
* [Select2](https://select2.org/)
* [jQuery LoadingOverlay](https://gasparesganga.com/labs/jquery-loading-overlay/)
* [Jbvalidator](https://emretulek.github.io/jbvalidator/)
* [reCAPTCHA](https://www.google.com/recaptcha/about/)


## Instrucciones para instalar el sistema control ppp
* 1.Tener instalado xampp la version 7.9.29 [Xampp](https://downloadsapachefriends.global.ssl.fastly.net/7.4.29/xampp-windows-x64-7.4.29-1-VC15-installer.exe?from_af=true)
* 2.Descargar el proyecto en htdocs
* 3.Irse a la carpeta ./database y modificar el script controlppp_bd.sql, dirigirse al insert que crea el super usuario, cambiando el correo por defecto por uno que ustedes utilicen, es importante que el correo que se coloque ahí deba permitir que se envíen correos desde aplicaciones no seguras, eso se encuentra en Gmail y se tendrá configurar(la contraseña por defecto que se refleja ahi es : <b>12345</b>).
[![ppp](https://i.ibb.co/cxW0mp6/Screenshot-6.jpg)](https://i.ibb.co/cxW0mp6/Screenshot-6.jpg) 
* 4.Luego de haber modificado el Insert , se tendra que ejecutar el script en el administrador de base de datos , de preferencia phpmyadmin
* 5.Se debera crear un nuevo archivo con el nombre <b>secretinfo.php</b> en la siguiente ruta ./config.
[![ppp](https://i.ibb.co/LRJDrQd/Screenshot-7.jpg)](https://i.ibb.co/LRJDrQd/Screenshot-7.jpg)
* 6.En el contenido de este archivo se va encontrar datos sencibles , tales como el correo,contraseña y GOOGLE_KEY para el reCAPTCHA y envio de 
correo electronico , el cual esto es importante para la correcta ejecucion del programa.
[![ppp](https://i.ibb.co/0YPJKVK/Screenshot-8.jpg)](https://i.ibb.co/0YPJKVK/Screenshot-8.jpg)
* 7.Se va a necesitar que se genere KEYS para el reCAPTCHAV3 de google, aqui se encontrara mas informacion sobre eso 
[reCAPTCHA](https://www.google.com/recaptcha/about/).
* 8.Una vez generado las GOOGLE_KEY_PUBLIC Y GOOGLE_KEY_SECRET, la cual la GOOGLE_KEY_PUBLIC se va ir a configurar 
a los siguiente archivos 

[![ppp](https://i.ibb.co/JnZFnW5/Screenshot-9.jpg)](https://i.ibb.co/JnZFnW5/Screenshot-9.jpg)

Y LA GOOGLE_KEY_SECRET se va ir a configurar en el archivo secretinfo.php

* 9.Y Finalmente una vez echo todo estos pasos, el proyecto estaria funcionando de manera correcta.


## Licencia

Distributed under the MIT License. See `LICENSE` for more information.



<!-- CONTACT -->
## Contacto

Josue Lopez - ts.josu3@gmail.com

Project Link: [https://github.com/TryNeo/sistema-control-ppp](https://github.com/TryNeo/sistema-control-ppp)
