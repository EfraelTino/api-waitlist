# API de Lista de Espera Básica

## Descripción

Esta API permite a los usuarios registrarse en una lista de espera para un proyecto o producto. Los usuarios pueden ingresar su dirección de correo electrónico para unirse a la lista y recibir actualizaciones cuando el proyecto esté disponible.

## Características

- Registro de usuarios en una lista de espera mediante correo electrónico.
- Validación de correos electrónicos para asegurar que se ingresen direcciones válidas.
- Respuestas claras en caso de éxito o error durante el registro.
- Mensajes de confirmación personalizados para los usuarios.

## Endpoints

### 1. `POST https://tudominio.com/action.php`

Este endpoint se encarga de agregar un usuario a la lista de espera.

#### Parámetros

- **email** (requerido): Dirección de correo electrónico del usuario.
- **project** (requerido): Nombre del proyecto o producto para el cual se está registrando el usuario.

#### Ejemplo de Solicitud

```javascript
let info = new FormData();
info.append('action', 'insertwaitlist');
info.append('email', email);
info.append('project', '**nombre del proyecto**');

const response = await fetch('https://tudominio.com/action.php', {
    method: 'POST',
    body: info,
});

if (!response.ok) {
    throw new Error('Error en la solicitud');
}

const data = await response.json();
console.log(data);
