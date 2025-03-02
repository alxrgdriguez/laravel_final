<?php
return [
    // Validaciones generales
    'required' => 'El campo :attribute es obligatorio.',
    'email' => 'El campo :attribute debe ser un correo válido.',
    'confirmed' => 'Las contraseñas no coinciden. Por favor, asegúrate de que ambas sean iguales.',
    'unique' => 'El :attribute ya está en uso.',
    'min' => [
        'string' => 'El campo :attribute debe tener al menos :min caracteres.',
    ],
    'max' => [
        'string' => 'El campo :attribute no puede superar los :max caracteres.',
        'numeric' => 'El campo :attribute no puede ser mayor de :max.',
    ],
    'numeric' => 'El campo :attribute debe ser un número.',
    'string' => 'El campo :attribute debe ser una cadena de texto.',
    'in' => 'El campo :attribute seleccionado no es válido.',

    // Personalización de los nombres de los atributos
    'attributes' => [
        'dni' => 'DNI',
        'name' => 'nombre',
        'surnames' => 'apellidos',
        'email' => 'correo electrónico',
        'password' => 'contraseña',
        'password_confirmation' => 'confirmación de contraseña',
        'phone_number' => 'número de teléfono',
        'address' => 'dirección',
        'city' => 'ciudad',
        'role' => 'rol',
    ],
];
