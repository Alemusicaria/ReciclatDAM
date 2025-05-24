/**
 * Gestión de estadísticas de navegación
 * 
 * Este script maneja la visualización de gráficos, exportación de datos
 * y funcionalidades de actualización automática para la página de estadísticas.
 */
document.addEventListener('DOMContentLoaded', function() {
    // ----- CONFIGURACIÓN DE GRÁFICOS -----
    
    // Paleta de colores para gráficos
    const colorPalette = [
        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b',
        '#5a5c69', '#6f42c1', '#fd7e14', '#20c997', '#6610f2'
    ];
    
    // Detectar modo oscuro y configurar colores adecuados
    const isDarkMode = document.body.classList.contains('dark');
    const gridColor = isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)';
    const textColor = isDarkMode ? '#f7fafc' : '#2d3748';
    
    // Configuración global para los gráficos
    Chart.defaults.color = textColor;
    Chart.defaults.borderColor = gridColor;
    
    /**
     * Crea un gráfico con configuración consistente
     * @param {string} elementId - ID del elemento canvas para el gráfico
     * @param {string} type - Tipo de gráfico (pie, bar, doughnut, etc)
     * @param {Array} labels - Etiquetas para el gráfico
     * @param {Array} data - Datos para el gráfico
     * @param {string} title - Título del gráfico
     */
    function createChart(elementId, type, labels, data, title) {
        const ctx = document.getElementById(elementId);
        if (!ctx) return null;
        
        return new Chart(ctx, {
            type: type,
            data: {
                labels: labels,
                datasets: [{
                    label: title,
                    data: data,
                    backgroundColor: colorPalette.slice(0, labels.length),
                    borderWidth: isDarkMode ? 0 : 1,
                    borderColor: isDarkMode ? 'transparent' : colorPalette.map(color => color + '80'),
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: type === 'pie' || type === 'doughnut' ? 'right' : 'top',
                        labels: {
                            color: textColor,
                            font: {
                                size: 12
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: isDarkMode ? '#2d3748' : '#fff',
                        titleColor: isDarkMode ? '#e2e8f0' : '#333',
                        bodyColor: isDarkMode ? '#e2e8f0' : '#333',
                        borderColor: isDarkMode ? '#4a5568' : '#e3e6f0',
                        borderWidth: 1,
                        displayColors: true,
                        padding: 10
                    }
                },
                scales: type !== 'pie' && type !== 'doughnut' ? {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            color: textColor,
                            precision: 0
                        },
                        grid: {
                            color: gridColor,
                            drawBorder: false
                        }
                    },
                    x: {
                        ticks: {
                            color: textColor
                        },
                        grid: {
                            display: false
                        }
                    }
                } : undefined
            }
        });
    }
    
    // ----- INICIALIZAR GRÁFICOS -----
    
    // Inicializar todos los gráficos usando la configuración común
    const chartConfigs = [
        { id: 'platformChart', type: 'bar', labels: window.chartData.platformLabels, data: window.chartData.platformValues, title: window.chartData.translations.operatingSystems },
        { id: 'browserChart', type: 'pie', labels: window.chartData.browserLabels, data: window.chartData.browserValues, title: window.chartData.translations.browsers },
        { id: 'deviceChart', type: 'doughnut', labels: window.chartData.deviceLabels, data: window.chartData.deviceValues, title: window.chartData.translations.deviceTypes },
        { id: 'cookieChart', type: 'pie', labels: [window.chartData.translations.cookiesEnabled, window.chartData.translations.cookiesDisabled], data: [window.chartData.cookiesEnabled, window.chartData.cookiesDisabled], title: window.chartData.translations.cookieSupport },
        { id: 'languageChart', type: 'bar', labels: window.chartData.languageLabels, data: window.chartData.languageValues, title: window.chartData.translations.languages }
    ];
    
    chartConfigs.forEach(config => {
        createChart(config.id, config.type, config.labels, config.data, config.title);
    });
    
    // ----- EXPORTACIÓN DE DATOS -----
    
    // Configurar el botón de exportación de datos
    const exportBtn = document.getElementById('exportDataBtn');
    if (exportBtn) {
        exportBtn.addEventListener('click', function() {
            // Crear el contenido CSV
            let csvContent = "data:text/csv;charset=utf-8,";
            
            // Añadir encabezado
            csvContent += "Categoria,Element,Quantitat,Percentatge\n";
            
            // Añadir cada grupo de datos
            addDataToCSV('Sistemes Operatius', window.chartData.platformLabels, window.chartData.platformValues);
            addDataToCSV('Navegadors', window.chartData.browserLabels, window.chartData.browserValues);
            addDataToCSV('Dispositius', window.chartData.deviceLabels, window.chartData.deviceValues);
            
            // Añadir datos de resoluciones
            Object.entries(window.chartData.resolutionData).forEach(([resolution, count]) => {
                const percentage = ((count / window.chartData.limit) * 100).toFixed(1);
                csvContent += `Resolucions,${resolution},${count},${percentage}%\n`;
            });
            
            // Añadir datos de idiomas
            addDataToCSV('Idiomes', window.chartData.languageLabels, window.chartData.languageValues);
            
            // Añadir datos de cookies
            const cookiesEnabledPerc = ((window.chartData.cookiesEnabled / window.chartData.totalRecords) * 100).toFixed(1);
            const cookiesDisabledPerc = ((window.chartData.cookiesDisabled / window.chartData.totalRecords) * 100).toFixed(1);
            
            csvContent += `Cookies,Habilitades,${window.chartData.cookiesEnabled},${cookiesEnabledPerc}%\n`;
            csvContent += `Cookies,Deshabilitades,${window.chartData.cookiesDisabled},${cookiesDisabledPerc}%\n`;
            
            // Añadir datos técnicos
            csvContent += `Dades Tècniques,Promig Nuclis CPU,${window.chartData.avgConcurrency},N/A\n`;
            csvContent += `Dades Tècniques,Total Registres,${window.chartData.totalRecords},100%\n`;
            
            // Añadir metadatos
            const timestamp = new Date().toISOString().replace(/[:.]/g, '-');
            csvContent += `\nInforme generat el,${new Date().toLocaleString()}\n`;
            
            // Descargar CSV
            downloadCSV(csvContent, `estadistiques-navegacio-${timestamp}.csv`);
            
            // Mostrar notificación
            showNotification(window.chartData.translations.exportingData);
            
            /**
             * Añade un grupo de datos al contenido CSV
             */
            function addDataToCSV(category, labels, values) {
                labels.forEach((label, i) => {
                    const percentage = ((values[i] / window.chartData.limit) * 100).toFixed(1);
                    csvContent += `${category},${label},${values[i]},${percentage}%\n`;
                });
            }
            
            /**
             * Descarga el contenido CSV como un archivo
             */
            function downloadCSV(content, filename) {
                const encodedUri = encodeURI(content);
                const link = document.createElement("a");
                link.setAttribute("href", encodedUri);
                link.setAttribute("download", filename);
                
                document.body.appendChild(link);
                link.click();
                
                setTimeout(() => {
                    document.body.removeChild(link);
                }, 100);
            }
        });
    }
    
    // ----- AUTO-REFRESH -----
    
    // Variables para control de auto-refresh
    let refreshInterval;
    const toggleBtn = document.getElementById('toggleAutoRefreshBtn');
    
    /**
     * Inicia el auto-refresh de la página
     */
    function startAutoRefresh() {
        refreshInterval = setInterval(function() {
            showNotification('');
            setTimeout(function() {
                window.location.reload();
            }, 1000);
        }, 10000); // Actualizar cada 10 segundos
    }
    
    /**
     * Muestra una notificación toast
     */
    function showNotification(message) {
        const toast = document.getElementById('update-notification');
        if (!toast) return;
        
        if (message) {
            toast.innerHTML = `<div class="update-toast-content"><i class="fas fa-sync-alt me-2"></i>${message}</div>`;
        }
        
        toast.classList.add('show');
        
        // Ocultar la notificación después de 2 segundos
        setTimeout(() => {
            toast.classList.remove('show');
        }, 2000);
    }
    
    // Configurar toggle de auto-refresh si existe
    if (toggleBtn) {
        // Establecer estado y estilo inicial
        startAutoRefresh();
        updateButtonState(true);
        
        // Manejar clics en el botón
        toggleBtn.addEventListener('click', function() {
            const isActive = refreshInterval !== undefined;
            
            if (isActive) {
                clearInterval(refreshInterval);
                refreshInterval = undefined;
            } else {
                startAutoRefresh();
            }
            
            updateButtonState(!isActive);
        });
    }
    
    /**
     * Actualiza el estado visual del botón de auto-refresh
     */
    function updateButtonState(isActive) {
        if (!toggleBtn) return;
        
        if (isActive) {
            toggleBtn.innerHTML = `<i class="fas fa-sync-alt"></i> ${window.chartData.translations.autoRefreshOn}`;
            toggleBtn.classList.add('btn-primary');
            toggleBtn.classList.remove('btn-danger');
        } else {
            toggleBtn.innerHTML = `<i class="fas fa-sync"></i> ${window.chartData.translations.autoRefreshOff}`;
            toggleBtn.classList.remove('btn-primary');
            toggleBtn.classList.add('btn-danger');
        }
    }
});