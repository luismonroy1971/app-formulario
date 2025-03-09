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
        /* Estilos para el control deslizante */
       /* Actualiza estos estilos en la sección de <style> */
       body {
            background-color:rgb(170, 158, 158); /* Plomo claro */
        }

        .container {
            background-color:rgb(199, 199, 206);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .card-body {
            background-color:rgb(145, 145, 182);
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .hidden {
            display: none;
        }

        .application-section {
            border: 1px solidrgb(98, 145, 192);
            border-radius: 0.25rem;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            background-color: rgb(158, 158, 240);
        }

        .readonly-field {
            background-color: #e9ecef;
        }


        /* Estilos para el control deslizante */
        input[type="range"] {
            -webkit-appearance: none !important;
            width: 100% !important;
            height: 8px !important;
            border-radius: 5px !important;
            background: #666666 !important; /* Color plomo oscuro */
            outline: none !important;
            margin: 25px 0 !important; /* Espacio para los números */
        }

        /* Estilo del "pulgar" */
        input[type="range"]::-webkit-slider-thumb {
            -webkit-appearance: none !important;
            appearance: none !important;
            width: 20px !important;
            height: 20px !important;
            border-radius: 50% !important;
            background: #0d6efd !important;
            cursor: pointer !important;
            border: 2px solid #fff !important;
            box-shadow: 0 0 2px rgba(0,0,0,0.3) !important;
        }

        /* Para Firefox */
        input[type="range"]::-moz-range-track {
            background: #666666 !important;
            height: 8px !important;
            border-radius: 5px !important;
        }

        input[type="range"]::-moz-range-thumb {
            width: 20px !important;
            height: 20px !important;
            border-radius: 50% !important;
            background: #0d6efd !important;
            cursor: pointer !important;
            border: 2px solid #fff !important;
            box-shadow: 0 0 2px rgba(0,0,0,0.3) !important;
        }
        /* Contenedor para el range y los números */
        .range-container {
            position: relative;
            padding: 10px 0 30px;
        }

        /* Estilo para los números */
        .range-numbers {
            display: flex;
            justify-content: space-between;
            margin-top: 10px;
            padding: 0 10px;
            position: relative;
        }

        .range-numbers span {
            font-size: 12px;
            color: #666666;
            position: relative;
            text-align: center;
        }

        /* Estilo para las etiquetas min/max */
        .range-labels {
            display: flex;
            justify-content: space-between;
            margin-top: 5px;
            font-size: 0.875rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <h1 class="mb-4">Encuesta de Evaluación de Aplicaciones 2024</h1>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" id="successMessage">
                Encuesta guardada exitosamente.
                <br>
                Fecha de registro: <?php echo date('d/m/Y H:i:s'); ?>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" id="errorMessage">
                Hubo un error al guardar la encuesta.
            </div>
        <?php endif; ?>

        <form id="surveyForm" method="POST" action="index.php?action=save">
            <!-- Sección de identificación -->
             <!-- Agregar esto dentro del form -->
            <input type="hidden" name="fecha_local" id="fecha_local">
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
                            <input class="form-check-input" type="radio" name="has_used" id="has_used_yes" value="Si" required>
                            <label class="form-check-label" for="has_used_yes">Sí</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="has_used" id="has_used_no" value="No">
                            <label class="form-check-label" for="has_used_no">No</label>
                        </div>
                        <div class="invalid-feedback">
                            Por favor, selecciona una opción
                        </div>
                    </div>

                    <!-- Sección de razones para no usar (inicialmente oculta) -->
                    <div id="reasons_section" class="hidden">
                        <div class="card mb-4">
                            <div class="card-body">
                                <h4 class="card-title">Razones por las que no has usado las aplicaciones</h4>
                                
                                <div class="mb-4">
                                    <label for="razon_1" class="form-label">Principal razón por la que no usas las aplicaciones <span class="text-danger">*</span></label>
                                    <textarea class="form-control" id="razon_1" name="razon_no_uso_1" rows="2" placeholder="Ingresa la razón principal"></textarea>
                                    <div class="invalid-feedback">Por favor, ingresa al menos la razón principal.</div>
                                </div>

                                <div class="mb-4">
                                    <label for="razon_2" class="form-label">Segunda razón (opcional)</label>
                                    <textarea class="form-control" id="razon_2" name="razon_no_uso_2" rows="2" placeholder="Ingresa otra razón si la tienes"></textarea>
                                </div>

                                <div class="mb-4">
                                    <label for="razon_3" class="form-label">Tercera razón (opcional)</label>
                                    <textarea class="form-control" id="razon_3" name="razon_no_uso_3" rows="2" placeholder="Ingresa otra razón si la tienes"></textarea>
                                </div>
                            </div>
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
                <label class="form-label">¿Cómo te enteraste de la aplicación?</label>
                <select class="form-select" name="como_se_entero_APP_ID" required>
                    <option value="">Selecciona una opción</option>
                    <option value="Correo">Correo institucional</option>
                    <option value="Compañero">Por un compañero</option>
                    <option value="Jefe">Por mi jefe</option>
                    <option value="Capacitacion">En una capacitación</option>
                    <option value="Otro">Otro medio</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">¿Recibiste capacitación sobre el uso de la aplicación?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input capacitacion-radio" name="capacitacion_APP_ID" value="Si" required 
                           data-app-id="APP_ID">
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input capacitacion-radio" name="capacitacion_APP_ID" value="No" 
                           data-app-id="APP_ID">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <!-- Preguntas adicionales para cuando recibió capacitación -->
            <div class="capacitacion-preguntas-si-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿Te resultó útil para aprender a usar la aplicación?</label>
                    <div class="range-container">
                        <input type="range" class="form-range" min="0" max="10" step="1" 
                            name="utilidad_capacitacion_APP_ID" value="5">
                        <div class="range-numbers">
                            <span>0</span>
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                            <span>6</span>
                            <span>7</span>
                            <span>8</span>
                            <span>9</span>
                            <span>10</span>
                        </div>
                        <div class="range-labels">
                            <span>Nada útil</span>
                            <span>Muy útil</span>
                        </div>
                        <div class="value-display">
                            Valor: <span class="utilidad-value">5</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preguntas adicionales para cuando NO recibió capacitación -->
            <div class="capacitacion-preguntas-no-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿Qué aspectos te gustaría reforzar?</label>
                    <textarea class="form-control" name="aspectos_reforzar_APP_ID" rows="3" 
                            placeholder="Describe los aspectos que te gustaría reforzar"></textarea>
                </div>
            </div>

            <!-- Pregunta común para ambos casos -->
            <div class="facilidad-uso-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿Cómo calificarías la facilidad de uso de la aplicación?</label>
                    <div class="range-container">
                        <input type="range" class="form-range" min="0" max="10" step="1" 
                            name="facilidad_uso_APP_ID" value="5">
                        <div class="range-numbers">
                            <span>0</span>
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                            <span>6</span>
                            <span>7</span>
                            <span>8</span>
                            <span>9</span>
                            <span>10</span>
                        </div>
                        <div class="range-labels">
                            <span>Malo</span>
                            <span>Muy bueno</span>
                        </div>
                        <div class="value-display">
                            Valor: <span class="facilidad-value">5</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Reemplazar la sección de fallas en el template -->
            <div class="mb-3">
                <label class="form-label">¿Has notado alguna falla en la aplicación después de su implementación?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input fallas-radio" name="fallas_APP_ID" 
                           value="Si" required data-app-id="APP_ID">
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input fallas-radio" name="fallas_APP_ID" 
                           value="No" data-app-id="APP_ID">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <!-- Preguntas adicionales cuando hay fallas (Sí) -->
            <div class="fallas-si-preguntas-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿Se presentan de manera remota?</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input fallas-remoto-radio" 
                               name="fallas_remoto_APP_ID" value="Si" data-app-id="APP_ID">
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input fallas-remoto-radio" 
                               name="fallas_remoto_APP_ID" value="No" data-app-id="APP_ID">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <!-- Frecuencia de errores (solo si es remoto) -->
                <div class="fallas-frecuencia-APP_ID hidden mb-3">
                    <label class="form-label">¿Con qué frecuencia ocurren estos errores?</label>
                    <div class="input-group">
                        <input type="number" class="form-control" name="fallas_frecuencia_APP_ID" 
                               min="0" max="100" step="1" placeholder="Ingrese el porcentaje">
                        <span class="input-group-text">%</span>
                    </div>
                </div>

                <!-- Tipo de falla -->
                <div class="mb-3">
                    <label class="form-label">¿Qué tipo de falla has experimentado en la aplicación?</label>
                    <select class="form-select fallas-tipo-select" name="fallas_tipo_APP_ID" data-app-id="APP_ID">
                        <option value="">Seleccione una opción</option>
                        <option value="paraliza">Aplicación se paraliza y deja de responder</option>
                        <option value="incorrectos">Genera resultados incorrectos</option>
                        <option value="mensajes">Mensajes de errores sin explicación clara</option>
                        <option value="otros">Otros</option>
                    </select>
                </div>

                <!-- Campo para especificar otro tipo de falla -->
                <div class="fallas-otro-APP_ID hidden mb-3">
                    <label class="form-label">Especifique el tipo de falla:</label>
                    <textarea class="form-control" name="fallas_otro_tipo_APP_ID" rows="2" 
                             placeholder="Describa el tipo de falla"></textarea>
                </div>
            </div>

            <!-- Preguntas adicionales cuando no hay fallas (No) -->
            <div class="fallas-no-preguntas-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿La aplicación funciona correctamente en todos tus dispositivos que usas?</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input dispositivos-radio" 
                               name="funciona_dispositivos_APP_ID" value="Si" data-app-id="APP_ID">
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input dispositivos-radio" 
                               name="funciona_dispositivos_APP_ID" value="No" data-app-id="APP_ID">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <!-- Campo para especificar problema en dispositivos -->
                <div class="dispositivos-problema-APP_ID hidden mb-3">
                    <label class="form-label">¿Cuál es, y qué ocurre?</label>
                    <textarea class="form-control" name="dispositivos_problema_APP_ID" rows="2" 
                             placeholder="Describa el dispositivo y el problema"></textarea>
                </div>
            </div>

<!-- Reemplazar la sección de necesidades en el template -->
<div class="mb-3">
                <label class="form-label">¿La aplicación cubre las necesidades para las que fue creada?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input necesidades-radio" 
                           name="cubre_necesidades_APP_ID" value="Si" required data-app-id="APP_ID">
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input necesidades-radio" 
                           name="cubre_necesidades_APP_ID" value="No" data-app-id="APP_ID">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <!-- Preguntas adicionales cuando sí cubre necesidades -->
            <div class="necesidades-si-preguntas-APP_ID hidden">
                <div class="mb-3">
                    <label class="form-label">¿Te ha ayudado a reducir errores o reprocesos en tu trabajo?</label>
                    <div class="form-check">
                        <input type="radio" class="form-check-input reduce-errores-radio" 
                               name="reduce_errores_APP_ID" value="Si" data-app-id="APP_ID">
                        <label class="form-check-label">Sí</label>
                    </div>
                    <div class="form-check">
                        <input type="radio" class="form-check-input reduce-errores-radio" 
                               name="reduce_errores_APP_ID" value="No" data-app-id="APP_ID">
                        <label class="form-check-label">No</label>
                    </div>
                </div>

                <!-- Campo para describir reducción de errores -->
                <div class="reduce-errores-si-APP_ID hidden mb-3">
                    <label class="form-label">¿Puedes describir brevemente?</label>
                    <textarea class="form-control" name="descripcion_reduce_errores_APP_ID" 
                             rows="2" placeholder="Describe cómo ha ayudado a reducir errores"></textarea>
                </div>

                <!-- Campo para sugerir optimizaciones -->
                <div class="reduce-errores-no-APP_ID hidden mb-3">
                    <label class="form-label">¿Qué crees que podríamos optimizar?</label>
                    <textarea class="form-control" name="sugerencias_optimizacion_APP_ID" 
                             rows="2" placeholder="Describe qué podríamos optimizar"></textarea>
                </div>
            </div>

            <!-- Preguntas adicionales cuando no cubre necesidades -->
            <div class="necesidades-no-preguntas-APP_ID hidden mb-3">
                <label class="form-label">¿Qué funcionalidades consideras que podría mejorar o agregar?</label>
                <textarea class="form-control" name="mejoras_funcionalidades_APP_ID" 
                         rows="2" placeholder="Describe las funcionalidades que se podrían mejorar o agregar"></textarea>
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

<!-- Reemplazar la sección de valor agregado en el template -->
<div class="mb-3">
                <label class="form-label">¿Consideras que la aplicación añade valor a tu trabajo?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input valor-radio" 
                           name="agrega_valor_APP_ID" value="Si" required data-app-id="APP_ID">
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input valor-radio" 
                           name="agrega_valor_APP_ID" value="No" data-app-id="APP_ID">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <!-- Preguntas adicionales cuando sí agrega valor -->
            <div class="valor-si-preguntas-APP_ID hidden">
                <!-- Valor en términos de calidad -->
                <div class="mb-3">
                    <label class="form-label">¿Cuánto valor ha agregado en términos de calidad?</label>
                    <div class="range-container">
                        <input type="range" class="form-range" min="1" max="10" step="1" 
                               name="valor_calidad_APP_ID" value="5">
                        <div class="range-numbers">
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                            <span>6</span>
                            <span>7</span>
                            <span>8</span>
                            <span>9</span>
                            <span>10</span>
                        </div>
                        <div class="range-labels">
                            <span>Más baja</span>
                            <span>Más alta</span>
                        </div>
                        <div class="value-display">
                            Valor: <span class="calidad-value">5</span>
                        </div>
                    </div>
                </div>

                <!-- Valor en términos de tiempo -->
                <div class="mb-3">
                    <label class="form-label">¿Cuánto valor ha agregado en términos de tiempo?</label>
                    <div class="range-container">
                        <input type="range" class="form-range" min="1" max="10" step="1" 
                               name="valor_tiempo_APP_ID" value="5">
                        <div class="range-numbers">
                            <span>1</span>
                            <span>2</span>
                            <span>3</span>
                            <span>4</span>
                            <span>5</span>
                            <span>6</span>
                            <span>7</span>
                            <span>8</span>
                            <span>9</span>
                            <span>10</span>
                        </div>
                        <div class="range-labels">
                            <span>Más baja</span>
                            <span>Más alta</span>
                        </div>
                        <div class="value-display">
                            Valor: <span class="tiempo-value">5</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preguntas adicionales cuando no agrega valor -->
            <div class="valor-no-preguntas-APP_ID hidden mb-3">
                <label class="form-label">¿Por qué consideras que la aplicación no ha agregado valor a tu trabajo?</label>
                <textarea class="form-control" name="razon_no_valor_APP_ID" 
                         rows="2" placeholder="Explica por qué la aplicación no ha agregado valor"></textarea>
            </div>

            <!-- Reemplazar la sección de recomendación en el template -->
            <div class="mb-3">
                <label class="form-label">¿Recomendarías esta aplicación a un compañero de tu área?</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input recomendacion-radio" 
                           name="recomendaria_APP_ID" value="Si" required data-app-id="APP_ID">
                    <label class="form-check-label">Sí</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input recomendacion-radio" 
                           name="recomendaria_APP_ID" value="No" data-app-id="APP_ID">
                    <label class="form-check-label">No</label>
                </div>
            </div>

            <!-- Preguntas adicionales cuando sí recomienda -->
            <div class="recomendacion-si-preguntas-APP_ID hidden mb-3">
                <label class="form-label">¿En qué aspectos quisieras que la aplicación mejore?</label>
                <textarea class="form-control" name="aspectos_mejora_APP_ID" 
                         rows="2" placeholder="Describe los aspectos que podrían mejorar"></textarea>
            </div>

            <!-- Preguntas adicionales cuando no recomienda -->
            <div class="recomendacion-no-preguntas-APP_ID hidden mb-3">
                <label class="form-label">¿Por qué?</label>
                <textarea class="form-control" name="razon_no_recomienda_APP_ID" 
                         rows="2" placeholder="Explica por qué no recomendarías la aplicación"></textarea>
            </div>

        </div>
    </template>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {

            $('#surveyForm').on('submit', function() {
                const now = new Date();
                // Formato: YYYY-MM-DD HH:mm:ss
                const fechaLocal = now.getFullYear() + '-' + 
                                String(now.getMonth() + 1).padStart(2, '0') + '-' + 
                                String(now.getDate()).padStart(2, '0') + ' ' + 
                                String(now.getHours()).padStart(2, '0') + ':' + 
                                String(now.getMinutes()).padStart(2, '0') + ':' + 
                                String(now.getSeconds()).padStart(2, '0');
                $('#fecha_local').val(fechaLocal);
            });
            // Manejo del mensaje de éxito
            const successMessage = $('#successMessage');
            if (successMessage.length) {
                setTimeout(function() {
                    successMessage.fadeOut('slow');
                }, 3000);
            }

            // Manejo del mensaje de error
            const errorMessage = $('#errorMessage');
            if (errorMessage.length) {
                setTimeout(function() {
                    errorMessage.fadeOut('slow');
                }, 3000);
            }

            $(document).on('input', 'input[type="range"]', function() {
                const value = $(this).val();
                const parentContainer = $(this).closest('.range-container');
                
                if($(this).attr('name').includes('utilidad_capacitacion')) {
                    parentContainer.find('.utilidad-value').text(value);
                } else if($(this).attr('name').includes('facilidad_uso')) {
                    parentContainer.find('.facilidad-value').text(value);
                }
            });

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

            // Manejo de respuesta a recomendación
            $(document).on('change', '.recomendacion-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                // Ocultar todas las secciones primero
                $(`.recomendacion-si-preguntas-${appId}`).addClass('hidden');
                $(`.recomendacion-no-preguntas-${appId}`).addClass('hidden');
                
                // Mostrar la sección correspondiente y resetear campos
                if (value === 'Si') {
                    $(`.recomendacion-si-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`textarea[name="aspectos_mejora_${appId}"]`).val('');
                    $(`textarea[name="razon_no_recomienda_${appId}"]`).val('');
                } else {
                    $(`.recomendacion-no-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`textarea[name="aspectos_mejora_${appId}"]`).val('');
                    $(`textarea[name="razon_no_recomienda_${appId}"]`).val('');
                }
            });

        // Manejo de respuesta a valor agregado
        $(document).on('change', '.valor-radio', function() {
            const appId = $(this).data('app-id');
            const value = $(this).val();
            
            // Ocultar todas las secciones primero
            $(`.valor-si-preguntas-${appId}`).addClass('hidden');
            $(`.valor-no-preguntas-${appId}`).addClass('hidden');
            
            // Mostrar la sección correspondiente
            if (value === 'Si') {
                $(`.valor-si-preguntas-${appId}`).removeClass('hidden');
                // Resetear campos
                $(`input[name="valor_calidad_${appId}"]`).val(5);
                $(`input[name="valor_tiempo_${appId}"]`).val(5);
                $(`.calidad-value`).text('5');
                $(`.tiempo-value`).text('5');
                $(`textarea[name="razon_no_valor_${appId}"]`).val('');
            } else {
                $(`.valor-no-preguntas-${appId}`).removeClass('hidden');
                // Resetear campos
                $(`textarea[name="razon_no_valor_${appId}"]`).val('');
            }
        });

        // Actualizar valores mostrados en las escalas
        $(document).on('input', 'input[name^="valor_calidad_"]', function() {
            const value = $(this).val();
            $(this).closest('.range-container').find('.calidad-value').text(value);
        });

        $(document).on('input', 'input[name^="valor_tiempo_"]', function() {
            const value = $(this).val();
            $(this).closest('.range-container').find('.tiempo-value').text(value);
        });

            // Manejo de la visualización de preguntas de capacitación
            $(document).on('change', '.capacitacion-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                // Ocultar todas las secciones primero
                $(`.capacitacion-preguntas-si-${appId}`).addClass('hidden');
                $(`.capacitacion-preguntas-no-${appId}`).addClass('hidden');
                
                // Mostrar la sección correspondiente
                if (value === 'Si') {
                    $(`.capacitacion-preguntas-si-${appId}`).removeClass('hidden');
                    $(`.facilidad-uso-${appId}`).removeClass('hidden');
                    // Resetear valores
                    $(`input[name="utilidad_capacitacion_${appId}"]`).val(5);
                    $(`input[name="facilidad_uso_${appId}"]`).val(5);
                    $(`textarea[name="aspectos_reforzar_${appId}"]`).val('');
                } else {
                    $(`.capacitacion-preguntas-no-${appId}`).removeClass('hidden');
                    $(`.facilidad-uso-${appId}`).removeClass('hidden');
                    // Resetear valores
                    $(`input[name="facilidad_uso_${appId}"]`).val(5);
                    $(`textarea[name="aspectos_reforzar_${appId}"]`).val('');
                }
            });

            // Manejo de respuesta a necesidades cubiertas
            $(document).on('change', '.necesidades-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                // Ocultar todas las secciones primero
                $(`.necesidades-si-preguntas-${appId}`).addClass('hidden');
                $(`.necesidades-no-preguntas-${appId}`).addClass('hidden');
                $(`.reduce-errores-si-${appId}`).addClass('hidden');
                $(`.reduce-errores-no-${appId}`).addClass('hidden');
                
                // Mostrar la sección correspondiente
                if (value === 'Si') {
                    $(`.necesidades-si-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`input[name="reduce_errores_${appId}"]`).prop('checked', false);
                    $(`textarea[name="descripcion_reduce_errores_${appId}"]`).val('');
                    $(`textarea[name="sugerencias_optimizacion_${appId}"]`).val('');
                } else {
                    $(`.necesidades-no-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`textarea[name="mejoras_funcionalidades_${appId}"]`).val('');
                }
            });

            // Manejo de respuesta a reducción de errores
            $(document).on('change', '.reduce-errores-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                // Ocultar ambas secciones primero
                $(`.reduce-errores-si-${appId}`).addClass('hidden');
                $(`.reduce-errores-no-${appId}`).addClass('hidden');
                
                // Mostrar la sección correspondiente
                if (value === 'Si') {
                    $(`.reduce-errores-si-${appId}`).removeClass('hidden');
                    $(`textarea[name="sugerencias_optimizacion_${appId}"]`).val('');
                } else {
                    $(`.reduce-errores-no-${appId}`).removeClass('hidden');
                    $(`textarea[name="descripcion_reduce_errores_${appId}"]`).val('');
                }
            });

            // Manejo de la selección "¿Has usado alguna aplicación?"
            $('input[name="has_used"]').on('change', function() {
                const hasUsed = $(this).val();
                
                if (hasUsed === 'No') {
                    // Mostrar sección de razones
                    $('#reasons_section').removeClass('hidden');
                    // Ocultar sección de aplicaciones y limpiar selecciones
                    $('#applications_section').addClass('hidden');
                    $('.app-checkbox').prop('checked', false);
                    $('#application_questions').addClass('hidden').empty();
                    // Hacer obligatorio el primer campo de razón
                    $('#razon_1').prop('required', true);
                    // Limpiar validaciones visuales
                    $('#razon_1').removeClass('is-invalid');
                } else {
                    // Ocultar sección de razones y limpiar campos
                    $('#reasons_section').addClass('hidden');
                    $('#razon_1, #razon_2, #razon_3').val('');
                    // Quitar required del primer campo
                    $('#razon_1').prop('required', false);
                    // Mostrar sección de aplicaciones
                    $('#applications_section').removeClass('hidden');
                }
                
                updateSubmitButton();
            });

            // Agregar estos manejadores de eventos dentro de $(document).ready(function() { ... })

            // Manejo de respuesta a fallas
            $(document).on('change', '.fallas-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                // Ocultar todas las secciones primero
                $(`.fallas-si-preguntas-${appId}`).addClass('hidden');
                $(`.fallas-no-preguntas-${appId}`).addClass('hidden');
                
                // Mostrar la sección correspondiente
                if (value === 'Si') {
                    $(`.fallas-si-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`input[name="fallas_remoto_${appId}"]`).prop('checked', false);
                    $(`input[name="fallas_frecuencia_${appId}"]`).val('');
                    $(`select[name="fallas_tipo_${appId}"]`).val('');
                    $(`textarea[name="fallas_otro_tipo_${appId}"]`).val('');
                } else {
                    $(`.fallas-no-preguntas-${appId}`).removeClass('hidden');
                    // Resetear campos
                    $(`input[name="funciona_dispositivos_${appId}"]`).prop('checked', false);
                    $(`textarea[name="dispositivos_problema_${appId}"]`).val('');
                }
            });

            // Manejo de fallas remotas
            $(document).on('change', '.fallas-remoto-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                if (value === 'Si') {
                    $(`.fallas-frecuencia-${appId}`).removeClass('hidden');
                } else {
                    $(`.fallas-frecuencia-${appId}`).addClass('hidden');
                    $(`input[name="fallas_frecuencia_${appId}"]`).val('');
                }
            });

            // Manejo de tipo de falla
            $(document).on('change', '.fallas-tipo-select', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                if (value === 'otros') {
                    $(`.fallas-otro-${appId}`).removeClass('hidden');
                } else {
                    $(`.fallas-otro-${appId}`).addClass('hidden');
                    $(`textarea[name="fallas_otro_tipo_${appId}"]`).val('');
                }
            });

            // Manejo de funcionamiento en dispositivos
            $(document).on('change', '.dispositivos-radio', function() {
                const appId = $(this).data('app-id');
                const value = $(this).val();
                
                if (value === 'No') {
                    $(`.dispositivos-problema-${appId}`).removeClass('hidden');
                } else {
                    $(`.dispositivos-problema-${appId}`).addClass('hidden');
                    $(`textarea[name="dispositivos_problema_${appId}"]`).val('');
                }
            });

            // Validación de campos requeridos para razones
            $('#razon_1').on('input', function() {
                    const value = $(this).val().trim();
                    if (value === '') {
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
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

            function updateSubmitButton() {
                const hasUsedValue = $('input[name="has_used"]:checked').val();
                const hasRazon1 = $('#razon_1').val().trim() !== '';
                const hasAppsSelected = $('.app-checkbox:checked').length > 0;

                if (hasUsedValue === 'No') {
                    // Habilitar botón solo si hay al menos una razón
                    $('#submitBtn').prop('disabled', !hasRazon1);
                } else if (hasUsedValue === 'Si') {
                    // Habilitar botón solo si hay aplicaciones seleccionadas
                    $('#submitBtn').prop('disabled', !hasAppsSelected);
                } else {
                    // Si no hay selección, deshabilitar botón
                    $('#submitBtn').prop('disabled', true);
                }
            }

            // Validación del formulario antes de enviar
            $('#surveyForm').on('submit', function(e) {
                const hasUsedValue = $('input[name="has_used"]:checked').val();
                let isValid = true;

                if (hasUsedValue === 'No') {
                    const razon1 = $('#razon_1').val().trim();
                    if (razon1 === '') {
                        $('#razon_1').addClass('is-invalid');
                        isValid = false;
                    }
                }

                if (!isValid) {
                    e.preventDefault();
                    $('html, body').animate({
                        scrollTop: $('#reasons_section').offset().top - 100
                    }, 500);
                }

                return isValid;
            });
        });
    </script>
</body>
</html>