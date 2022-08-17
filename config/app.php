<?php 
    const server_url = "http://localhost/sistema-control-ppp/";
    const server_url_image = "http://localhost/sistema-control-ppp/assets/img/";
    const regex_string = '/^[a-zA-ZáéíóñÁÉÍÓÚÑ, ]+$/';
    const regex_email = '/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/i';
    const regex_numbers = '/^[0-9]+$/';
    const regex_username = '/^[a-z0-9_-]{3,16}$/';
    const regex_password = '/^[a-zA-Z0-9_-]{4,18}$/';
    const regex_fechas = '/^([0-9]{4}[-](0[1-9]|1[0-2])[-]([0-2]{1}[0-9]{1}|3[0-1]{1})|([0-2]{1}[0-9]{1}|3[0-1]{1})[-](0[1-9]|1[0-2])[-][0-9]{4})$/';
    const regex_cedula =  '/^[0-9]{0,10}$/';
    const regex_imagen = '/^[^\\s]+(.*?)\\.(jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF)$/';
    const regex_hora = '/^(0?[1-9]|1[0-2]):([0-5]\d)\s?((?:A|P)\.?M\.?)$/i';

    const libs = "libraries/";
    const views = "views/";
    const company = "Sistema Control ppp";
    date_default_timezone_set("America/Guayaquil");
