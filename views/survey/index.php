<!-- views/survey/index.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de Evaluación de Aplicaciones 2024</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hidden {
            display: none;
        }
        .application-section {
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
        }
        .readonly-field {
            background-color: #e9ecef;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Encuesta de Evaluación de Aplicaciones 2024</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success">
                Encuesta guardada exitosamente.
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger">
                Hubo un error al guardar la encuesta.
            </div>
        <?php endif; ?>

        <form id="surveyForm" method="POST" action="index.php?action=save">
            <!-- Sección de identificación -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Identificación del Colaborador</h3>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="doc_identidad" class="form-label">Documento de Identidad</label>
                            <input type="text" class="form-control" id="doc_identidad" name="doc_identidad" required>
                        </div>
                        <div class="col-md-6">
                            <label for="nombres_apellidos" class="form-label">Nombres y Apellidos</label>
                            <input type="text" class="form-control readonly-field" id="nombres_apellidos" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="correo" class="form-label">Correo Electrónico</label>
                            <input type="email" class="form-control readonly-field" id="correo" readonly>
                        </div>
                        <div class="col-md-6">
                            <label for="area" class="form-label">Área</label>
                            <input type="text" class="form-control readonly-field" id="area" readonly>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección de selección de aplicaciones -->
            <div class="card mb-4">
                <div class="card-body">
                    <h3 class="card-title">Selección de Aplicaciones</h3>
                    <div class="mb-3">
                        <label class="form-label">¿Has usado alguna de las aplicaciones?</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_used" id="has_used_yes" value="yes">
                            <label class="form-check-label" for="has_used_yes">Sí</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_used" id="has_used_no" value="no">
                            <label class="form-check-label" for="has_used_no">No</label>
                        </div>
                    </div>

                    <div id="applications_section" class="hidden">
                        <label class="form-label">Selecciona las aplicaciones que has utilizado:</label>
                        <?php foreach ($applications as $app): ?>
                        <div class="form-check">
                            <input class="form-check-input app-checkbox" type="checkbox" 
                                   name="applications[]" value="<?php echo $app['id']; ?>" 
                                   id="app_<?php echo $app['id']; ?>">
                            <label class="form-check-label" for="app_<?php echo $app['id']; ?>">
                                <?php echo htmlspecialchars($app['nombre_aplicacion']); ?>
                            </label>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Sección dinámica para preguntas por aplicación -->
            <div id="application_questions" class="hidden">
                <!-- Las secciones de preguntas se generarán dinámicamente aquí -->
            </div>

            <button type="submit" class="btn btn-primary" id="submitBtn" disabled>
                Enviar Encuesta
            </button>
        </form>
    </div>

    <!-- Template para preguntas por aplicación -->
    <template id="application_template">
        <div class="application-section mb-4" id="questions_APP_ID">
            <h4 class="mb-3">Preguntas sobre APP_NAME</h4>
            
            <div class="mb-3">
                <label class="form-label">¿Con qué frecuencia utilizas la aplicación?</label>
                <select class="form-select" name="frecuencia_uso_APP_ID" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Diaria">Diaria</option>
                    <option value="Semanal">Semanal</option>
                    <option value="Mensual">Mensual</option>
                    <option value="Ocasional">Ocasional</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Recibiste capacitación sobre el uso de la aplicación?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="capacitacion_APP_ID" value="Si" required>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="capacitacion_APP_ID" value="No">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Has notado alguna falla en la aplicación después de su implementación?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="fallas_APP_ID" value="Si" required>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="fallas_APP_ID" value="No">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">¿La aplicación cubre las necesidades para las que fue creada?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="cubre_necesidades_APP_ID" value="Si" required>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="cubre_necesidades_APP_ID" value="No">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Cuánto tiempo te ahorra en comparación con el proceso anterior?</label>
                <div class="row g-3">
                    <div class="col-md-6">
                        <select class="form-select" name="tiempo_unidad_APP_ID" required>
                            <option value="">Selecciona unidad</option>
                            <option value="Dias">Días</option>
                            <option value="Horas">Horas</option>
                        </select>
                    </div>
                    <div class="col-md-6">
                        <input type="number" class="form-control" name="tiempo_ahorro_APP_ID" 
                               min="0" step="0.5" required placeholder="Cantidad">
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Consideras que la aplicación añade valor a tu trabajo?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="agrega_valor_APP_ID" value="Si" required>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="agrega_valor_APP_ID" value="No">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">¿Recomendarías esta aplicación a un compañero de tu área?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="recomendaria_APP_ID" value="Si" required>
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="recomendaria_APP_ID" value="No">
                    <label class="form-check-label">No</label>
                </div>
            </div>
        </div>
    </template>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            // Manejo del documento de identidad
            $('#doc_identidad').on('change', function() {
                const docIdentidad = $(this).val();
                if (docIdentidad) {
                    // Realizar petición AJAX para obtener datos del empleado
                    $.get('index.php', {
                        controller: 'Employee',
                        action: 'findByDocument',
                        doc: docIdentidad
                    })
                    .done(function(response) {
                        const data = JSON.parse(response);
                        $('#nombres_apellidos').val(data.APELLIDOS_NOMBRES_COLABORADOR);
                        $('#correo').val(data.CORREO_ELECTRONICO);
                        $('#area').val(data.AREA);
                    })
                    .fail(function() {
                        alert('No se encontró el colaborador');
                        $('#nombres_apellidos').val('');
                        $('#correo').val('');
                        $('#area').val('');
                    });
                }
            });

            // Manejo de la selección "¿Has usado alguna aplicación?"
            $('input[name="has_used"]').on('change', function() {
                const hasUsed = $(this).val();
                if (hasUsed === 'yes') {
                    $('#applications_section').removeClass('hidden');
                } else {
                    $('#applications_section').addClass('hidden');
                    $('.app-checkbox').prop('checked', false);
                    $('#application_questions').addClass('hidden').empty();
                }
                updateSubmitButton();
            });

            // Manejo de la selección de aplicaciones
            $('.app-checkbox').on('change', function() {
                const appId = $(this).val();
                const appName = $(this).next('label').text().trim();
                const isChecked = $(this).is(':checked');

                if (isChecked) {
                    // Agregar sección de preguntas
                    const template = $('#application_template').html()
                        .replace(/APP_ID/g, appId)
                        .replace(/APP_NAME/g, appName);
                    $('#application_questions').append(template);
                } else {
                    // Remover sección de preguntas
                    $(`#questions_${appId}`).remove();
                }

                // Mostrar u ocultar sección de preguntas
                if ($('.app-checkbox:checked').length > 0) {
                    $('#application_questions').removeClass('hidden');
                } else {
                    $('#application_questions').addClass('hidden');
                }

                updateSubmitButton();
            });

            // Función para actualizar el estado del botón de envío
            function updateSubmitButton() {
                const hasUsedValue = $('input[name="has_used"]:checked').val();
                const hasAppsSelected = $('.app-checkbox:checked').length > 0;

                if (hasUsedValue === 'no') {
                    $('#submitBtn').prop('disabled', false);
                } else if (hasUsedValue === 'yes' && hasAppsSelected) {
                    $('#submitBtn').prop('disabled', false);
                } else {
                    $('#submitBtn').prop('disabled', true);
                }
            }

            // Validación del formulario antes de enviar
            $('#surveyForm').on('submit', function(e) {
                const hasUsedValue = $('input[name="has_used"]:checked').val();
                if (hasUsedValue === 'yes' && $('.app-checkbox:checked').length === 0) {
                    e.preventDefault();
                    alert('Por favor, selecciona al menos una aplicación.');
                    return false;
                }
                return true;
            });
        });
    </script>
</body>
</html>