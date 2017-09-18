<p align="center"><img src="http://www.endeev.com/wp-content/themes/incubator/images/endeev-colorlogo.png"></p>

# Endeev - Ejercicio práctico

Este repositorio incluye una resolución a un ejercicio de programación que se explica a continuación.

## Consigna:

Se debe desarrollar una API que permita a la empresa contar con un sistema de reserva para organizar sus eventos, la misma debe persistir los datos.

## Requisitos:

1. La API debe ser RESTful.

1. Los tipos de eventos incluyen:
  * Green Friday: Es un evento que se organiza el último viernes de cada mes.
  * Dog’s Day: Aquí, un integrante puede traer su mascota a la empresa, no se permite más de una mascota por día.
  * Meeting Room: Esta es la sala en la cual la empresa realiza daily, meetings, capacitaciones y clases de inglés.

1. Con respecto a los eventos se debe:
  * Crear una evento, con los siguientes campos: nombre, fecha, hora inicio, hora finalización, descripción (opcional).
  * Listar los eventos (aplicar opciones de filtrado).
  * Obtener los detalles de un evento.
  * Con respecto a los Usuarios se debe:
  * Crear un Usuario, con los siguientes campos: nombre, apellido, email.
  * Listar usuarios.
  * Obtener el perfil de un usuario.

1. Se debe permitir autenticar los usuarios.

## Reglas:
	
* Se dispone de 1 fin de semana (o 3 días hábiles) para resolver ejercicio.
* El ejercicio debería llevar unas 6 a 10 hs para resolverlo.
* El proyecto debe ser publicado en un repositorio de GitHub.
* Se debe enviar la resolución del ejercicio el día lunes hasta las 9am.
* Se debe hacer una demostración de que fue lo que se hizo ante el equipo de desarrollo.


## Sugerencia de tecnologías a utilizar:

**Laravel / Symfony / node.js**

## Herramientas Sugeridas:

**Postman:** para hacer las pruebas de la API. https://www.getpostman.com/

## Herramientas:

* [Optimus\Heimdal](https://github.com/esbenp/heimdal): A modern exception handler for APIs with Sentry and Bugsnag integration out-of-the-box
* [Optimus\Bruno](https://github.com/esbenp/bruno): A base controller class that gives sorting, filtering, eager loading and pagination for your endpoints
