<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Inscripción</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            color: #1e293b;
            margin-bottom: 10px;
        }
        p {
            font-size: 16px;
            color: #4b5563;
            margin-bottom: 20px;
        }
        .course-name {
            font-size: 20px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 30px;
        }
        .status-message {
            font-size: 18px;
            font-weight: bold;
            color: {{ $registration->statusReg->value === 'accepted' ? '#10b981' : '#ef4444' }};
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Icono de saludo -->
    <img src="https://cdn-icons-png.flaticon.com/512/2102/2102647.png" alt="Saludo" style="width: 80px; height: 80px; margin-bottom: 20px;">

    <!-- Título -->
    <h1>Hola, {{ $registration->user->name }} 👋</h1>

    <!-- Mensaje de estado -->
    <p class="status-message">{{ $statusMessage }}</p>

    <!-- Mensaje introductorio -->
    <p>Has solicitado inscribirte en el curso:</p>

    <!-- Nombre del curso -->
    <p class="course-name">{{ $registration->course->name }}</p>

    <!-- Mensaje adicional -->
    <p>
        @if ($registration->statusReg->value === 'accepted')
            ¡Felicidades! Ahora puedes acceder al curso y comenzar tu aprendizaje.
        @else
            Lamentamos informarte que tu solicitud ha sido rechazada. Por favor, contacta con el administrador para más detalles.
        @endif
    </p>
</div>
</body>
</html>
