<?php

header('Content-Type: text/html; charset=UTF-8');

function correoTemplate($logoUrl, $logopita, $nombre, $encabezado, $parrafo) {
    $frases_motivacion = array(
        "Si puedes soñarlo, puedes lograrlo. - Walt Disney",
        "El éxito es la suma de pequeños esfuerzos repetidos día tras día. - Robert Collier",
        "Nunca te rindas, grandes cosas requieren tiempo y paciencia. - Anónimo",
        "El éxito no es la clave de la felicidad. La felicidad es la clave del éxito. Si amas lo que estás haciendo, tendrás éxito. - Albert Schweitzer",
        "No te rindas, las cosas buenas llevan tiempo. - Anónimo",
        "Cada día es una nueva oportunidad para ser mejor que ayer. - Anónimo",
        "El éxito no es el final, el fracaso no es fatal: es el coraje para continuar lo que cuenta. - Winston Churchill",
        "No midas tu éxito por el dinero que tienes, mide tu éxito por las cosas que has logrado. - Anónimo",
        "Los límites están en tu mente. - Anónimo",
        "Si quieres algo que nunca has tenido, tendrás que hacer algo que nunca has hecho. - Anónimo",
        "La motivación es lo que te pone en marcha, el hábito es lo que te mantiene en marcha. - Jim Rohn",
        "No te preocupes por los fracasos, preocúpate por las oportunidades que pierdes al no intentarlo. - Jack Canfield",
        "Siempre parece imposible, hasta que se hace. - Nelson Mandela",
        "La disciplina es el puente entre metas y logros. - Jim Rohn",
        "Si te caes, levántate, arréglate la corona y sigue adelante. - Anónimo",
        "La motivación te saca de la cama, pero la determinación te mantiene en marcha. - Anónimo",
        "La vida es 10% lo que te sucede y 90% cómo reaccionas ante ello. - Charles R. Swindoll",
        "No esperes el momento perfecto, toma el momento y hazlo perfecto. - Anónimo",
        "El éxito es la suma de pequeños esfuerzos repetidos día tras día. - Robert Collier",
        "El fracaso es una oportunidad para empezar de nuevo con más experiencia. - Anónimo"
    );
    
    global $random_frase_motivacion;

$random_frase_motivacion = $frases_motivacion[array_rand($frases_motivacion)];
    return "
    <!DOCTYPE html>
    <html lang='en'>
    <head>
        <meta charset='UTF-8'>
        <style>

            .p{
                color: black;
            }
            .email-container {
                font-family: Arial, sans-serif;
            }
            .header {
                background-color: #f1f1f1;
                padding: 20px;
                text-align: center;
            }
            .footer {
                background-color: #343A40;
                padding: 20px;
                text-align: center;
                position: relative;
            }
            .footer:before {
                content: '';
                position: absolute;
                left: 0;
                bottom: 0;
                height: 2px;
                width: 100%;
                background-color: white;
            }
            .content {
                padding: 20px;
            }
            .code {
                font-size: 30px;
                font-weight: bold;
                text-align: center;
            }
            .footer-right {
                position: absolute;
                bottom: 20px;
                right: 0;
                display: inline-block;
            }
        </style>
    </head>
    <body>
    <div class='email-container'>
        <div class='header'>
            <img src='{$logopita}' alt='Logo' width='200'>
        </div>
        <div class='content'>
            <h1>{$encabezado}</h1>
            <h3>¡Hola, {$nombre}!</h3>
            <br>
            <p class='p'>".$parrafo."</p>
            <br>
            <h4><i>- {$random_frase_motivacion}</i></h4>
        </div>
        <br>
        <div class='footer'>
            <div class='footer-right'>
                <img src='{$logoUrl}' alt='Logo' width='100'>
            </div>
        </div>
    </div>
</body>
    </html>
    ";
}
