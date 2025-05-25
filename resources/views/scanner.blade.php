@extends('layouts.app')

@section('content')
    <div class="container mt-5 pt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">Escanejar Codi</h4>
                        <button id="camera-permission" class="btn btn-sm btn-primary">
                            <i class="fas fa-camera me-1"></i> Activar càmera
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="camera-error" class="alert alert-danger d-none">
                            No s'ha pogut accedir a la càmera. Comprova els permisos.
                        </div>

                        <div id="scanner-container" style="position: relative;">
                            <div id="interactive" class="viewport"
                                style="width: 100%; max-height: 70vh; min-height: 300px; position: relative; background-color: #f8f9fa; border: 1px solid #dee2e6;">
                                <div class="camera-placeholder text-center py-5">
                                    <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                                    <p>Fes clic a "Activar càmera" per començar a escanejar</p>
                                </div>
                            </div>
                            <div id="loadingMessage" class="text-center py-3 d-none">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Carregant...</span>
                                </div>
                                <p class="mt-2">Iniciant la càmera...</p>
                            </div>
                        </div>

                        <div id="result" class="mt-3 d-none">
                            <div class="alert alert-success">
                                <strong>Codi detectat:</strong> <span id="code-result"></span>
                            </div>
                        </div>

                        <div class="mt-3 d-flex justify-content-between">
                            <button id="start-button" class="btn btn-primary d-none">
                                <i class="fas fa-play me-1"></i> Iniciar Escàner
                            </button>
                            <button id="stop-button" class="btn btn-danger d-none">
                                <i class="fas fa-stop me-1"></i> Aturar Escàner
                            </button>
                        </div>
                    </div>
                </div>

                <!-- ENTRADA MANUAL DE CÓDIGO -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="mb-0">Introduir codi manualment</h5>
                    </div>
                    <div class="card-body">
                        <form id="manual-code-form" action="{{ route('process-code') }}" method="POST">
                            @csrf
                            <div class="input-group mb-3">
                                <input type="text" id="manual-code" name="code" class="form-control"
                                    placeholder="Introdueix el codi" required>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-1"></i> Processar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- RESULTADO DEL PROCESAMIENTO -->
                <div id="process-result" class="d-none">
                    <div class="card mb-4">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0" id="result-title">Resultat</h5>
                        </div>
                        <div class="card-body">
                            <div id="loading-result" class="text-center">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="mt-2">Processant codi...</p>
                            </div>
                            <div id="success-result" class="d-none">
                                <div class="alert alert-success">
                                    <h5>¡Felicitats!</h5>
                                    <p>Has guanyat <span id="points-earned" class="fw-bold"></span> ECODAMS</p>
                                    <p>Ara tens <span id="total-points" class="fw-bold"></span> punts en total</p>
                                    <div class="mt-3 text-center">
                                        <button id="scan-again-button" class="btn btn-primary">
                                            <i class="fas fa-qrcode me-1"></i> Escanejar un altre codi
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div id="error-result" class="d-none">
                                <div class="alert alert-danger">
                                    <h5>Error</h5>
                                    <p id="error-message"></p>
                                    <p>Codi processat: <strong id="processed-code"></strong></p>
                                    <div class="mt-3 text-center">
                                        <button id="error-scan-again-button" class="btn btn-primary">
                                            <i class="fas fa-qrcode me-1"></i> Escanejar un altre codi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INFORMACIÓN DEL PRODUCTO -->
                <div id="product-info" class="d-none" data-current-code="">
                    <div class="card">
                        <div class="card-header bg-info text-white">
                            <h5 class="mb-0">Informació del Producte</h5>
                        </div>
                        <div class="card-body">
                            <div id="product-loading" class="text-center">
                                <div class="spinner-border text-info" role="status"></div>
                                <p>Obtenint informació del producte...</p>
                            </div>
                            <div id="product-data" class="d-none"></div>
                            <div id="product-error" class="alert alert-warning d-none">
                                No s'ha pogut trobar informació del producte a la base de dades.
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ALERTAR SOBRE CONTENEDOR -->
                <div class="card mb-4">
                    <div class="card-header bg-warning">
                        <h5 class="mb-0">Reportar problema en punt de recollida</h5>
                    </div>
                    <div class="card-body">
                        <p>Si estàs prop d'un punt de recollida i vols reportar un problema, fes clic aquí:</p>
                        <button id="report-container-issue" class="btn btn-warning">
                            <i class="fas fa-exclamation-triangle me-1"></i> Reportar problema
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@ericblade/quagga2/dist/quagga.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Elementos UI
            const cameraPermissionBtn = document.getElementById('camera-permission');
            const startButton = document.getElementById('start-button');
            const stopButton = document.getElementById('stop-button');
            const cameraError = document.getElementById('camera-error');
            const loadingMessage = document.getElementById('loadingMessage');
            const resultDiv = document.getElementById('result');
            const codeResult = document.getElementById('code-result');
            const manualCodeForm = document.getElementById('manual-code-form');
            const manualCodeInput = document.getElementById('manual-code');
            const processResult = document.getElementById('process-result');
            const loadingResult = document.getElementById('loading-result');
            const successResult = document.getElementById('success-result');
            const errorResult = document.getElementById('error-result');
            const pointsEarned = document.getElementById('points-earned');
            const totalPoints = document.getElementById('total-points');
            const errorMessage = document.getElementById('error-message');
            const processedCode = document.getElementById('processed-code');
            const productInfo = document.getElementById('product-info');
            const productLoading = document.getElementById('product-loading');
            const productData = document.getElementById('product-data');
            const productError = document.getElementById('product-error');
            const scanAgainButton = document.getElementById('scan-again-button');
            const errorScanAgainButton = document.getElementById('error-scan-again-button');
            const scannerContainer = document.getElementById('scanner-container');
            const interactiveElement = document.getElementById('interactive');

            let scanner = null;
            let hasPermission = false;
            let activeStream = null; // Para guardar la referencia al stream de la cámara

            // Cargar último producto escaneado del localStorage si existe
            try {
                const lastProduct = localStorage.getItem('lastScannedProduct');
                if (lastProduct) {
                    const product = JSON.parse(lastProduct);
                    productInfo.setAttribute('data-current-code', product.code || '');
                    productInfo.classList.remove('d-none');
                    productData.classList.remove('d-none');
                    productLoading.classList.add('d-none');
                    displayProductInfo(product);
                }
            } catch (e) {
                console.error('Error al cargar datos del localStorage:', e);
            }

            // Configurar botones para escanear de nuevo
            if (scanAgainButton) {
                scanAgainButton.addEventListener('click', startNewScan);
            }

            if (errorScanAgainButton) {
                errorScanAgainButton.addEventListener('click', startNewScan);
            }

            function startNewScan() {
                // Ocultar resultados anteriores, pero NO la información del producto
                processResult.classList.add('d-none');
                resultDiv.classList.add('d-none');

                // Mostrar el área de escaneo
                if (hasPermission) {
                    // Iniciar automáticamente el escáner si ya tenemos permisos
                    if (startButton) {
                        startButton.click();
                    }
                } else {
                    // Solicitar permisos de nuevo
                    cameraPermissionBtn.classList.remove('d-none');
                }
            }

            // Comprobar si Quagga está disponible
            if (!window.Quagga) {
                cameraError.textContent = "Error: No s'ha pogut carregar la biblioteca d'escaneig.";
                cameraError.classList.remove('d-none');
            }

            // Solicitar permiso de cámara
            cameraPermissionBtn.addEventListener('click', requestCameraPermission);

            function requestCameraPermission() {
                loadingMessage.classList.remove('d-none');
                cameraError.classList.add('d-none');

                navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: "environment",
                        width: { ideal: 1280 },
                        height: { ideal: 720 }
                    }
                })
                    .then(function (stream) {
                        hasPermission = true;
                        // Detener el stream inmediatamente
                        stream.getTracks().forEach(track => track.stop());
                        startButton.classList.remove('d-none');
                        cameraPermissionBtn.classList.add('d-none');
                        loadingMessage.classList.add('d-none');
                    })
                    .catch(function (err) {
                        console.error('Error accediendo a la cámara:', err);
                        cameraError.textContent = `Error de cámara: ${err.name === 'NotAllowedError' ? 'Permís denegat' : err.message}`;
                        cameraError.classList.remove('d-none');
                        loadingMessage.classList.add('d-none');
                    });
            }

            // Iniciar y parar el escáner
            startButton.addEventListener('click', startScanner);
            stopButton.addEventListener('click', stopScanner);

            function startScanner() {
                // Ocultar la interfaz de inicio y mostrar la de carga
                startButton.classList.add('d-none');
                stopButton.classList.remove('d-none');
                resultDiv.classList.add('d-none');
                cameraError.classList.add('d-none');
                loadingMessage.classList.remove('d-none');

                // Remover la plantilla de camera-placeholder
                const cameraPlaceholder = document.querySelector('.camera-placeholder');
                if (cameraPlaceholder) {
                    cameraPlaceholder.style.display = 'none';
                }

                console.log('Iniciando Quagga...');
                Quagga.init({
                    inputStream: {
                        name: "Live",
                        type: "LiveStream",
                        target: interactiveElement,
                        constraints: {
                            width: { min: 640 },
                            height: { min: 480 },
                            facingMode: "environment",
                            aspectRatio: { min: 1, max: 2 }
                        },
                        area: {
                            top: "0%",
                            right: "0%",
                            left: "0%",
                            bottom: "0%"
                        },
                        singleChannel: false
                    },
                    locator: {
                        patchSize: "medium",
                        halfSample: true
                    },
                    numOfWorkers: 2,
                    frequency: 10,
                    decoder: {
                        readers: ["ean_reader", "ean_8_reader", "code_128_reader", "code_39_reader", "upc_reader", "upc_e_reader"]
                    },
                    locate: true
                }, function (err) {
                    if (err) {
                        console.error('Error de inicialización Quagga:', err);
                        cameraError.textContent = `Error inicialitzant l'escàner: ${err.message || 'Error desconegut'}`;
                        cameraError.classList.remove('d-none');
                        loadingMessage.classList.add('d-none');
                        stopButton.classList.add('d-none');
                        startButton.classList.remove('d-none');
                        return;
                    }

                    // Guardar referencia al stream para poder cerrarlo después
                    const videoEl = interactiveElement.querySelector('video');
                    if (videoEl && videoEl.srcObject) {
                        activeStream = videoEl.srcObject;
                    }

                    loadingMessage.classList.add('d-none');
                    console.log("Escàner iniciat correctament");
                    Quagga.start();
                });

                Quagga.onDetected(function (result) {
                    console.log("Código detectado:", result.codeResult.code);
                    if (result.codeResult.code) {
                        const code = result.codeResult.code;
                        stopScanner();
                        codeResult.textContent = code;
                        resultDiv.classList.remove('d-none');

                        // Procesar el código detectado
                        processDetectedCode(code);
                    }
                });

                // Mostrar los cuadros de detección en tiempo real
                Quagga.onProcessed(function (result) {
                    var drawingCtx = Quagga.canvas.ctx.overlay,
                        drawingCanvas = Quagga.canvas.dom.overlay;

                    if (drawingCtx && drawingCanvas) {
                        // Limpiar canvas
                        drawingCtx.clearRect(0, 0, parseInt(drawingCanvas.getAttribute("width")), parseInt(drawingCanvas.getAttribute("height")));

                        if (result) {
                            // Dibujar si hay resultado
                            if (result.boxes) {
                                result.boxes.filter(function (box) {
                                    return box !== result.box;
                                }).forEach(function (box) {
                                    Quagga.ImageDebug.drawPath(box, { x: 0, y: 1 }, drawingCtx, { color: "green", lineWidth: 2 });
                                });
                            }

                            if (result.box) {
                                Quagga.ImageDebug.drawPath(result.box, { x: 0, y: 1 }, drawingCtx, { color: "#00F", lineWidth: 2 });
                            }

                            if (result.codeResult && result.codeResult.code) {
                                Quagga.ImageDebug.drawPath(result.line, { x: 'x', y: 'y' }, drawingCtx, { color: 'red', lineWidth: 3 });
                            }
                        }
                    }
                });
            }

            // Reemplaza la función stopScanner actual con esta versión mejorada
            function stopScanner() {
                console.log('Deteniendo escáner...');

                // Detener Quagga primero
                if (Quagga) {
                    try {
                        Quagga.offProcessed(); // Eliminar event listeners
                        Quagga.offDetected();
                        Quagga.stop();
                        console.log('Quagga detenido');
                    } catch (err) {
                        console.error('Error al detener Quagga:', err);
                    }
                }

                // Cerrar el stream de la cámara de diferentes maneras para asegurar compatibilidad
                try {
                    // Método 1: Usar activeStream si está disponible
                    if (activeStream) {
                        activeStream.getTracks().forEach(track => {
                            track.stop();
                            console.log('Track detenido:', track.kind);
                        });
                        activeStream = null;
                    }

                    // Método 2: Buscar directamente en el video
                    const videoElements = interactiveElement.querySelectorAll('video');
                    if (videoElements.length > 0) {
                        videoElements.forEach(video => {
                            if (video.srcObject) {
                                const tracks = video.srcObject.getTracks();
                                tracks.forEach(track => {
                                    track.stop();
                                    console.log('Video track detenido:', track.kind);
                                });
                                video.srcObject = null;
                            }
                            video.remove();
                        });
                    }

                    // Método 3: Usar navigator.mediaDevices si está disponible
                    if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                        const tracks = document.querySelectorAll('video').forEach(v => {
                            if (v.srcObject) {
                                v.srcObject.getTracks().forEach(t => t.stop());
                            }
                        });
                    }
                } catch (err) {
                    console.error('Error al cerrar stream de la cámara:', err);
                }

                // Limpiar los canvas
                try {
                    const canvasElements = interactiveElement.querySelectorAll('canvas');
                    if (canvasElements.length > 0) {
                        canvasElements.forEach(canvas => {
                            canvas.remove();
                        });
                    }
                } catch (err) {
                    console.error('Error al limpiar canvas:', err);
                }

                // Volver a mostrar la interfaz inicial
                stopButton.classList.add('d-none');
                startButton.classList.remove('d-none');

                // Limpiar el contenedor
                try {
                    while (interactiveElement.firstChild) {
                        interactiveElement.removeChild(interactiveElement.firstChild);
                    }

                    // Recrear el placeholder
                    const placeholder = document.createElement('div');
                    placeholder.className = 'camera-placeholder text-center py-5';
                    placeholder.innerHTML = `
                                            <i class="fas fa-camera fa-3x text-muted mb-3"></i>
                                            <p>Fes clic a "Iniciar Escàner" per començar a escanejar</p>
                                        `;
                    interactiveElement.appendChild(placeholder);
                } catch (err) {
                    console.error('Error al reconstruir la interfaz:', err);
                }

                console.log("Escáner detenido y recursos liberados completamente");
            }

            // Manejar envío de código manual
            manualCodeForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const code = manualCodeInput.value.trim();
                if (code) {
                    processDetectedCode(code);
                    manualCodeInput.value = '';
                }
            });

            // Función para procesar el código (ya sea escaneado o ingresado manualmente)
            function processDetectedCode(code) {
                // Mostrar sección de resultados
                processResult.classList.remove('d-none');
                loadingResult.classList.remove('d-none');
                successResult.classList.add('d-none');
                errorResult.classList.add('d-none');

                // Obtener información del producto (NO ocultamos la información anterior hasta tener la nueva)
                fetchProductInfo(code);

                // Crear un formulario y enviarlo directamente (más fiable que AJAX)
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = '{{ route("process-code") }}';
                form.style.display = 'none';

                // CSRF Token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                form.appendChild(csrfToken);

                // Código
                const codeInput = document.createElement('input');
                codeInput.type = 'hidden';
                codeInput.name = 'code';
                codeInput.value = code;
                form.appendChild(codeInput);

                // Target para recibir la respuesta
                const iframe = document.createElement('iframe');
                iframe.name = 'process-frame';
                iframe.style.display = 'none';
                document.body.appendChild(iframe);

                form.target = 'process-frame';
                document.body.appendChild(form);

                // Cuando se carga el iframe (respuesta recibida)
                iframe.onload = function () {
                    try {
                        const content = iframe.contentDocument.body.textContent;
                        const data = JSON.parse(content);

                        loadingResult.classList.add('d-none');

                        if (data.success) {
                            successResult.classList.remove('d-none');
                            pointsEarned.textContent = data.points;
                            totalPoints.textContent = data.new_total;

                            // Animación para destacar los puntos ganados
                            pointsEarned.classList.add('text-success', 'animate-pulse');
                            totalPoints.classList.add('text-success');
                        } else {
                            errorResult.classList.remove('d-none');
                            errorMessage.textContent = data.message || 'Error desconegut';
                            processedCode.textContent = code;
                        }
                    } catch (e) {
                        console.error('Error procesando respuesta:', e);
                        loadingResult.classList.add('d-none');
                        errorResult.classList.remove('d-none');
                        errorMessage.textContent = 'Error al processar la resposta del servidor';
                        processedCode.textContent = code;
                    }

                    // Limpiar
                    setTimeout(function () {
                        document.body.removeChild(iframe);
                        document.body.removeChild(form);
                    }, 1000);
                };

                // Si hay un error de carga
                iframe.onerror = function () {
                    loadingResult.classList.add('d-none');
                    errorResult.classList.remove('d-none');
                    errorMessage.textContent = 'Error de connexió amb el servidor';
                    processedCode.textContent = code;

                    document.body.removeChild(iframe);
                    document.body.removeChild(form);
                };

                // Enviar el formulario
                form.submit();
            }

            function fetchProductInfo(code) {
                // Mostrar sección de información del producto
                productInfo.classList.remove('d-none');

                // Solo mostrar el cargador y ocultar datos si es un nuevo producto
                const currentCode = productInfo.getAttribute('data-current-code');
                if (currentCode !== code) {
                    productLoading.classList.remove('d-none');
                    productData.classList.add('d-none');
                    productError.classList.add('d-none');

                    // Establecer el nuevo código
                    productInfo.setAttribute('data-current-code', code);

                    // Usar Image para probar si la URL está disponible
                    const testImage = new Image();
                    testImage.onload = function () {
                        // La imagen se cargó, lo que significa que la API está disponible
                        // Ahora hacemos la solicitud real
                        const script = document.createElement('script');
                        script.src = `https://world.openfoodfacts.org/api/v0/product/${code}.json?callback=handleProductData`;
                        document.body.appendChild(script);

                        // Manejar timeout
                        setTimeout(function () {
                            if (productLoading.style.display !== 'none') {
                                showProductError();
                            }
                        }, 5000);
                    };

                    testImage.onerror = function () {
                        // La imagen no se cargó, mostramos error
                        showProductError();
                    };

                    // Intentar cargar una imagen de prueba de OpenFoodFacts
                    testImage.src = "https://static.openfoodfacts.org/images/misc/openfoodfacts-logo-en.svg";
                }

                // Función global para manejar la respuesta JSONP
                window.handleProductData = function (data) {
                    if (data.status === 1 && data.product) {
                        displayProductInfo(data.product);
                    } else {
                        showProductError();
                    }
                };
            }

            function displayProductInfo(product) {
                productLoading.classList.add('d-none');
                productData.classList.remove('d-none');

                // Crear HTML para mostrar información del producto
                productData.innerHTML = `
                                        <div class="mb-3">
                                            <h4>${product.product_name || 'Producte desconegut'}</h4>
                                            <p class="text-muted">${product.brands || ''}</p>
                                            <small class="text-secondary">Codi: ${product.code || ''}</small>
                                        </div>

                                        ${product.image_front_url ?
                        `<div class="text-center mb-3">
                                             <img src="${product.image_front_url}" alt="${product.product_name}" 
                                              class="img-fluid rounded" style="max-height: 200px;">
                                           </div>` : ''}

                                        ${product.nutriscore_grade ?
                        `<div class="mb-3">
                                             <h5>Nutriscore:</h5>
                                             <span class="badge bg-${getNutriscoreColor(product.nutriscore_grade)}">
                                               ${product.nutriscore_grade.toUpperCase()}
                                             </span>
                                           </div>` : ''}

                                        ${product.allergens_tags && product.allergens_tags.length > 0 ?
                        `<div class="mb-3">
                                             <h5>Al·lèrgens:</h5>
                                             <p>${product.allergens_tags.map(a => formatAllergen(a)).join(', ')}</p>
                                           </div>` : ''}

                                        <a href="https://world.openfoodfacts.org/product/${product.code}" 
                                           target="_blank" class="btn btn-outline-primary btn-sm">
                                           Més informació
                                        </a>
                                    `;

                // Almacenar los datos del producto en el localStorage para persistencia
                try {
                    localStorage.setItem('lastScannedProduct', JSON.stringify(product));
                } catch (e) {
                    console.error('Error al guardar datos en localStorage:', e);
                }
            }

            function showProductError() {
                productLoading.classList.add('d-none');
                productData.classList.add('d-none');
                productError.classList.remove('d-none');
            }

            function getNutriscoreColor(grade) {
                const colors = {
                    'a': 'success',
                    'b': 'success',
                    'c': 'warning',
                    'd': 'warning',
                    'e': 'danger',
                    'unknown': 'secondary'
                };
                return colors[grade.toLowerCase()] || 'secondary';
            }

            function formatAllergen(allergen) {
                return allergen
                    .replace('en:', '')
                    .replace(/-/g, ' ')
                    .replace(/\b\w/g, l => l.toUpperCase());
            }
            // Manejar el botón de reportar problema en el punto de recogida
            const reportContainerButton = document.getElementById('report-container-issue');
            if (reportContainerButton) {
                reportContainerButton.addEventListener('click', function () {
                    // Verificar ubicación del usuario
                    if (navigator.geolocation) {
                        navigator.geolocation.getCurrentPosition(
                            // Éxito
                            function (position) {
                                const lat = position.coords.latitude;
                                const lng = position.coords.longitude;

                                // Redirigir a la página de creación de alertas con las coordenadas
                                window.location.href = `/alertes_punts_de_recollida/create?lat=${lat}&lng=${lng}`;
                            },
                            // Error
                            function (error) {
                                alert('No es pot accedir a la teva ubicació. Necessitem la teva ubicació per trobar punts de recollida propers.');
                            }
                        );
                    } else {
                        alert('El teu navegador no suporta la geolocalització');
                    }
                });
            }
        });
    </script>
    <style>
        .viewport {
            position: relative;
        }

        .viewport canvas,
        .viewport video {
            width: 100%;
            height: auto;
            max-height: 70vh;
        }

        .camera-placeholder {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .animate-pulse {
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }

            100% {
                transform: scale(1);
            }
        }

        .text-success {
            color: #28a745 !important;
        }

        .fw-bold {
            font-weight: bold;
        }
    </style>
@endsection