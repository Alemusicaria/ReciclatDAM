/**
 * Scripts para el panel de administración
 */
const AdminDashboard = {
    /**
     * Objeto para gestión de códigos
     */
    Codis: {
        init: function () {
            // Inicializar el generador de códigos
            const generateBtn = document.getElementById('generateCode');
            if (generateBtn) {
                generateBtn.addEventListener('click', this.generateRandomCode);
            }

            // Control de tipo de código (único/múltiple)
            const tipusUnic = document.getElementById('tipus_unic');
            const tipusMulti = document.getElementById('tipus_multi');
            const multiUsesContainer = document.getElementById('multiUsesContainer');

            if (tipusUnic && tipusMulti && multiUsesContainer) {
                const updateUsosVisibility = () => {
                    multiUsesContainer.style.display = tipusMulti.checked ? 'block' : 'none';
                };

                tipusUnic.addEventListener('change', updateUsosVisibility);
                tipusMulti.addEventListener('change', updateUsosVisibility);
            }

            // Control de formulario
            const form = document.getElementById('createCodiForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const submitBtn = document.getElementById('submitCreateCodiForm');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processant...';
                    }
                    this.submit();
                });
            }
        },

        generateRandomCode: function () {
            const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
            let result = '';
            for (let i = 0; i < 12; i++) {
                result += chars.charAt(Math.floor(Math.random() * chars.length));
            }
            document.getElementById('codi').value = result;
        }
    },

    /**
     * Objeto para gestión de eventos
     */
    Events: {
        init: function () {
            // Control de formulario
            const form = document.getElementById('createEventForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateEventForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardant...';

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                const modal = document.getElementById('detailModal');
                                if (modal && bootstrap.Modal.getInstance(modal)) {
                                    bootstrap.Modal.getInstance(modal).hide();
                                }

                                // Recargar lista de eventos
                                setTimeout(() => {
                                    const eventsButton = document.querySelector('[data-content-type="events"]');
                                    if (eventsButton) {
                                        eventsButton.click();
                                    } else {
                                        window.location.reload();
                                    }
                                }, 500);
                            } else {
                                // Restaurar botón
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = 'Guardar Event';

                                // Mostrar error
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear l\'event'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Restaurar botón
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = 'Guardar Event';

                            // Mostrar error
                            alert('Error al crear l\'event: ' + error.message);
                        });
                });
            }

            // Inicialización de fechas
            const dataInici = document.getElementById('data_inici');
            const dataFi = document.getElementById('data_fi');
            if (dataInici && dataFi) {
                // Establecer fecha inicial como hoy
                const today = new Date();
                const todayStr = today.toISOString().slice(0, 16);
                dataInici.value = todayStr;

                // Establecer fecha final como mañana
                const tomorrow = new Date();
                tomorrow.setDate(tomorrow.getDate() + 1);
                const tomorrowStr = tomorrow.toISOString().slice(0, 16);
                dataFi.value = tomorrowStr;

                // Validación de fechas
                dataInici.addEventListener('change', function () {
                    if (dataFi.value && this.value > dataFi.value) {
                        dataFi.value = this.value;
                    }
                });

                dataFi.addEventListener('change', function () {
                    if (dataInici.value && this.value < dataInici.value) {
                        alert('La data de fi no pot ser anterior a la data d\'inici');
                        this.value = dataInici.value;
                    }
                });
            }
        }
    },
    /**
 * Objeto para gestión de premios
 */
    Premis: {
        init: function () {
            // Control de formulario
            const form = document.getElementById('createPremiForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreatePremiForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.premis?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch(form.action, {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista de premios
                                setTimeout(() => {
                                    const premisBtn = document.querySelector('[data-content-type="premis"]');
                                    if (premisBtn) premisBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                // Restaurar botón
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.premis?.save_button || 'Guardar Premi';

                                // Mostrar error
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el premi'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);

                            // Restaurar botón
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.premis?.save_button || 'Guardar Premi';

                            // Mostrar error
                            alert('Error al crear el premi: ' + error.message);
                        });
                });
            }
        }
    },
    /**
     * Objeto para gestión de productos
     */
    Productes: {
        init: function () {
            const form = document.getElementById('createProducteForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateProducteForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.productes?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch('/admin/productes', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista de productos
                                setTimeout(() => {
                                    const productesBtn = document.querySelector('[data-content-type="productes"]');
                                    if (productesBtn) productesBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.productes?.save_button || 'Guardar Producte';
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el producte'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.productes?.save_button || 'Guardar Producte';
                            alert('Error al crear el producte: ' + error.message);
                        });
                });
            }
        }
    },

    /**
     * Objeto para gestión de puntos de reciclaje
     */
    PuntsReciclatge: {
        init: function () {
            const form = document.getElementById('createPuntForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreatePuntForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.punts?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch('/admin/punts', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista de puntos
                                setTimeout(() => {
                                    const puntsBtn = document.querySelector('[data-content-type="punt-reciclatge"]');
                                    if (puntsBtn) puntsBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.punts?.save_button || 'Guardar Punt';
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el punt de recollida'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.punts?.save_button || 'Guardar Punt';
                            alert('Error al crear el punt: ' + error.message);
                        });
                });
            }
        }
    },

    /**
     * Objeto para gestión de tipos de alertas
     */
    TipusAlertes: {
        init: function () {
            const form = document.getElementById('createTipusAlertaForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateTipusAlertaForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.tipus_alertes?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch('/admin/tipus-alertes', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista
                                setTimeout(() => {
                                    const tipusAlertesBtn = document.querySelector('[data-content-type="tipus-alertes"]');
                                    if (tipusAlertesBtn) tipusAlertesBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                // Restaurar botón
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.tipus_alertes?.save_button || 'Guardar';

                                // Mostrar error
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el tipus d\'alerta'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.tipus_alertes?.save_button || 'Guardar';
                            alert('Error al crear el tipus d\'alerta: ' + error.message);
                        });
                });
            }
        }
    },

    /**
     * Objeto para gestión de roles
     */
    Rols: {
        init: function () {
            const form = document.getElementById('createRolForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateRolForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.rols?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch('/admin/rols', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Cerrar modal
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista 
                                setTimeout(() => {
                                    const rolsBtn = document.querySelector('[data-content-type="rols"]');
                                    if (rolsBtn) rolsBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                // Restaurar botón
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.rols?.save_button || 'Guardar Rol';

                                // Mostrar error
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el rol'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.rols?.save_button || 'Guardar Rol';
                            alert('Error al crear el rol: ' + error.message);
                        });
                });
            }
        }
    },
    /**
     * Objeto para gestión de tipos de eventos
     */
    TipusEvents: {
        init: function () {
            const form = document.getElementById('createTipusEventForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateTipusEventForm');
                    submitBtn.disabled = true;
                    submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                        (window.translations?.admin?.tipus_events?.saving || 'Guardant...');

                    // Enviar formulario via AJAX
                    const formData = new FormData(form);

                    fetch('/admin/tipus-events', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                if (typeof closeAnyModal === 'function') {
                                    closeAnyModal('detailModal');
                                } else if (typeof bootstrap !== 'undefined') {
                                    const modal = document.getElementById('detailModal');
                                    if (modal && bootstrap.Modal.getInstance(modal)) {
                                        bootstrap.Modal.getInstance(modal).hide();
                                    }
                                }

                                // Recargar lista
                                setTimeout(() => {
                                    const tipusEventsBtn = document.querySelector('[data-content-type="tipus-events"]');
                                    if (tipusEventsBtn) tipusEventsBtn.click();
                                    else window.location.reload();
                                }, 300);
                            } else {
                                submitBtn.disabled = false;
                                submitBtn.innerHTML = window.translations?.admin?.tipus_events?.save_button || 'Guardar';
                                alert('Error: ' + (data.message || 'No s\'ha pogut crear el tipus d\'event'));
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = window.translations?.admin?.tipus_events?.save_button || 'Guardar';
                            alert('Error al crear el tipus d\'event: ' + error.message);
                        });
                });
            }
        }
    },

    /**
     * Objeto para gestión de usuarios
     */
    Users: {
        init: function () {
            // Control de formulario
            const form = document.getElementById('createUserForm');
            if (form) {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();

                    // Validación básica
                    let isValid = true;
                    form.querySelectorAll('[required]').forEach(input => {
                        if (!input.value.trim()) {
                            input.classList.add('is-invalid');
                            isValid = false;
                        } else {
                            input.classList.remove('is-invalid');
                        }
                    });

                    if (!isValid) return;

                    // Mostrar indicador de carga
                    const submitBtn = document.getElementById('submitCreateUserForm');
                    if (submitBtn) {
                        submitBtn.disabled = true;
                        submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Processant...';
                    }

                    this.submit();
                });
            }
        }
    },    /**
     * Objeto para gestión de premios reclamados
     */
    PremisReclamats: {
        init: function () {
            // Configurar botones de aprobación/rechazo
            document.querySelectorAll('.approveBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    this.handleAction('approve', id);
                });
            });

            document.querySelectorAll('.rejectBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    this.handleAction('reject', id);
                });
            });

            // Botón de actualización de estado
            document.querySelectorAll('.editStatusBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.getAttribute('data-id');
                    this.showStatusUpdateModal(id);
                });
            });
        },

        handleAction: function (action, id) {
            const confirmMsg = action === 'approve' ? 'aprovar' : 'rebutjar';

            if (confirm(`${window.translations?.admin?.claimed_prizes?.confirm_action?.replace(':action', confirmMsg) || `Estàs segur que vols ${confirmMsg} aquesta sol·licitud?`}`)) {
                const url = action === 'approve'
                    ? `/admin/premis-reclamats/${id}/approve`
                    : `/admin/premis-reclamats/${id}/reject`;

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert(`${window.translations?.admin?.claimed_prizes?.request_action_success?.replace(':action', confirmMsg + 'ada') || `Sol·licitud ${confirmMsg}ada correctament`}`);

                            if (typeof closeAnyModal === 'function') {
                                closeAnyModal('detailModal');
                            }

                            setTimeout(() => {
                                const premisReclamatsBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                                if (premisReclamatsBtn) premisReclamatsBtn.click();
                                else window.location.reload();
                            }, 300);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(`${window.translations?.admin?.claimed_prizes?.request_action_error?.replace(':action', confirmMsg) || `Error al ${confirmMsg} la sol·licitud`}`);
                    });
            }
        },

        showStatusUpdateModal: function (id) {
            // Crear el modal dinámicamente
            const modalHtml = `
                <div class="modal fade" id="updateStatusModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">${window.translations?.admin?.claimed_prizes?.update_status || 'Actualitzar estat'}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="updateStatusForm">
                                    <div class="mb-3">
                                        <label for="estatSelect" class="form-label">${window.translations?.admin?.claimed_prizes?.status || 'Estat'}</label>
                                        <select class="form-select" id="estatSelect" name="estat">
                                            <option value="pendent">${window.translations?.admin?.claimed_prizes?.pending || 'Pendent'}</option>
                                            <option value="procesant">${window.translations?.admin?.claimed_prizes?.processing || 'Processant'}</option>
                                            <option value="entregat">${window.translations?.admin?.claimed_prizes?.delivered || 'Entregat'}</option>
                                            <option value="cancelat">${window.translations?.admin?.claimed_prizes?.canceled || 'Cancel·lat'}</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="codiSeguiment" class="form-label">${window.translations?.admin?.claimed_prizes?.tracking_code || 'Codi de seguiment'}</label>
                                        <input type="text" class="form-control" id="codiSeguiment" name="codi_seguiment">
                                    </div>
                                    <div class="mb-3">
                                        <label for="comentaris" class="form-label">${window.translations?.admin?.claimed_prizes?.comments || 'Comentaris'}</label>
                                        <textarea class="form-control" id="comentaris" name="comentaris" rows="3"></textarea>
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">${window.translations?.common?.cancel || 'Cancel·lar'}</button>
                                <button type="button" class="btn btn-primary" id="saveStatusBtn">${window.translations?.common?.save || 'Guardar'}</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;

            const modalContainer = document.createElement('div');
            modalContainer.innerHTML = modalHtml;
            document.body.appendChild(modalContainer);

            const modal = new bootstrap.Modal(document.getElementById('updateStatusModal'));
            modal.show();

            document.getElementById('saveStatusBtn').addEventListener('click', function () {
                // Crear FormData con el formulario
                const formData = new FormData(document.getElementById('updateStatusForm'));
                formData.append('_method', 'PUT');
                formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

                // Mostrar indicador de carga
                this.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                    (window.translations?.common?.saving || 'Guardant...');
                this.disabled = true;

                // Realizar petición AJAX
                fetch(`/admin/premis-reclamats/${id}`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(window.translations?.admin?.claimed_prizes?.server_error || 'Error en la resposta del servidor');
                        }
                        return response.json();
                    })
                    .then(data => {
                        // Mostrar mensaje de éxito
                        alert(window.translations?.admin?.claimed_prizes?.status_updated || 'Estat actualitzat correctament');

                        // Cerrar modal y recargar
                        modal.hide();

                        if (typeof closeAnyModal === 'function') {
                            closeAnyModal('detailModal');
                        }

                        setTimeout(() => {
                            const contentTypeBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                            if (contentTypeBtn) contentTypeBtn.click();
                            else window.location.reload();
                        }, 300);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert(`${window.translations?.admin?.claimed_prizes?.update_error || 'Error al actualitzar l\'estat'}: ${error.message}`);
                        this.innerHTML = window.translations?.common?.save || 'Guardar';
                        this.disabled = false;
                    });
            });

            document.getElementById('updateStatusModal').addEventListener('hidden.bs.modal', function () {
                document.body.removeChild(modalContainer);
            });
        }
    },
    /**
 * Objeto para gestión de formularios de edición
 */
    EditForms: {
        init: function () {
            // Ampliar el mapa de formularios para incluir todos los tipos
            const editFormMap = {
                'editAlertaForm': this.setupAlertaEditForm,
                'editCodiForm': this.setupCodiEditForm,
                'editEventForm': this.setupEventEditForm,
                'editProducteForm': this.setupProducteEditForm,
                'editPremiForm': this.setupPremiEditForm,
                'editPremiReclamatForm': this.setupPremiReclamatEditForm,
                'editPuntForm': this.setupPuntEditForm,
                'editRolForm': this.setupRolEditForm,
                'editTipusAlertaForm': this.setupTipusAlertaEditForm,
                'editTipusEventForm': this.setupTipusEventEditForm,
                'editUserForm': this.setupUserEditForm
            };

            // Activar el formulario correspondiente
            for (const [formId, setupFunction] of Object.entries(editFormMap)) {
                const form = document.getElementById(formId);
                if (form) {
                    setupFunction.call(this, form);
                    break;
                }
            }
        },

        // Nuevo método base para reducir duplicación de código
        setupBaseEditForm: function (form, submitBtnId, contentType) {
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Validación básica
                let isValid = true;
                form.querySelectorAll('[required]').forEach(input => {
                    if (!input.value.trim()) {
                        input.classList.add('is-invalid');
                        isValid = false;
                    } else {
                        input.classList.remove('is-invalid');
                    }
                });

                if (!isValid) return;

                // Mostrar indicador de carga
                const submitBtn = document.getElementById(submitBtnId);
                if (!submitBtn) return;

                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> ' +
                    (window.translations?.common?.updating || 'Actualitzant...');

                // Preparar datos del formulario
                const formData = new FormData(form);
                formData.append('_method', 'PUT');

                // Enviar formulario
                fetch(form.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Cerrar modal
                            if (typeof closeAnyModal === 'function') {
                                closeAnyModal('detailModal');
                            }

                            // Recargar lista correspondiente
                            setTimeout(() => {
                                const btn = document.querySelector(`[data-content-type="${contentType}"]`);
                                if (btn) btn.click();
                                else window.location.reload();
                            }, 300);
                        } else {
                            // Restaurar botón
                            submitBtn.disabled = false;
                            submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Actualitzar';
                            alert('Error: ' + (data.message || 'No s\'ha pogut actualitzar'));
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        submitBtn.disabled = false;
                        submitBtn.innerHTML = submitBtn.getAttribute('data-original-text') || 'Actualitzar';
                        alert('Error: ' + error.message);
                    });
            });

            // Guardar texto original del botón
            const submitBtn = document.getElementById(submitBtnId);
            if (submitBtn) {
                submitBtn.setAttribute('data-original-text', submitBtn.innerHTML);
            }

            // Botón cancelar
            document.getElementById('cancelEditBtn')?.addEventListener('click', function () {
                if (typeof closeAnyModal === 'function') {
                    closeAnyModal('detailModal');
                }
            });
        },

        // Actualizar los métodos existentes para usar el método base
        setupAlertaEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateAlertaBtn', 'alertes-punts');
        },

        setupCodiEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateCodiBtn', 'codis');
        },

        setupEventEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateEventBtn', 'events');
        },

        // Añadir los nuevos métodos que faltan
        setupProducteEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateProducteBtn', 'productes');
        },

        setupPremiEditForm: function (form) {
            this.setupBaseEditForm(form, 'updatePremiBtn', 'premis');
        },

        setupPremiReclamatEditForm: function (form) {
            this.setupBaseEditForm(form, 'updatePremiReclamatBtn', 'premis-reclamats');
        },

        setupPuntEditForm: function (form) {
            this.setupBaseEditForm(form, 'updatePuntBtn', 'punts');
        },

        setupRolEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateRolBtn', 'rols');
        },

        setupTipusAlertaEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateTipusAlertaBtn', 'tipus-alertes');
        },

        setupTipusEventEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateTipusEventBtn', 'tipus-events');
        },

        setupUserEditForm: function (form) {
            this.setupBaseEditForm(form, 'updateUserBtn', 'users');
        }
    },
    /**
 * Objeto para gestión de tablas administrativas
 */
    AdminTables: {
        init: function () {
            // Verificar si DataTables está disponible
            if (typeof $.fn.DataTable === 'undefined') {
                console.warn('DataTables no está disponible.');
                return;
            }

            // Configurar el idioma por defecto para todas las tablas
            const defaultLanguage = {
                url: '//cdn.datatables.net/plug-ins/1.13.7/i18n/ca.json'
            };

            // Inicializar todas las tablas posibles
            const tables = {
                'activitatsTable': { order: [[0, 'desc']], noOrderCols: [4] },
                'codisTable': { order: [[0, 'desc']], noOrderCols: [5] },
                'alertasTable': { order: [[0, 'desc']], noOrderCols: [4] },
                'eventsTable': { order: [[0, 'desc']], noOrderCols: [5] },
                'opinionsTable': { order: [[4, 'desc']], noOrderCols: [5] },
                'premisReclamatsTable': { order: [[5, 'desc']], noOrderCols: [6] },
                'usersRankingTable': { order: [[4, 'desc']], noOrderCols: [5] },
                'dynamicTable': { order: [[0, 'desc']], noOrderCols: [4] }
            };

            // Inicializar cada tabla si existe en la página
            for (const [tableId, config] of Object.entries(tables)) {
                const table = document.getElementById(tableId);
                if (table) {
                    // Destruir cualquier inicialización existente
                    if ($.fn.DataTable.isDataTable('#' + tableId)) {
                        $('#' + tableId).DataTable().destroy();
                    }

                    // Configuración común para todas las tablas
                    const tableConfig = {
                        language: defaultLanguage,
                        order: config.order || [[0, 'desc']],
                        pageLength: 10,
                        responsive: true,
                        dom: '<"top"f>rt<"bottom"lp><"clear">',
                        columnDefs: [
                            { orderable: false, targets: config.noOrderCols || [] }
                        ]
                    };

                    // Inicializar la tabla
                    const dataTable = $('#' + tableId).DataTable(tableConfig);

                    // Configuraciones adicionales específicas para ciertas tablas
                    if (tableId === 'premisReclamatsTable') {
                        this.setupPremisReclamatsFilters(dataTable);
                    }
                }
            }

            // Configurar eventos adicionales
            this.setupActivityDetailsButtons();
            this.setupItemActions();
        },

        setupPremisReclamatsFilters: function (table) {
            // Filtro para todos los estados
            $('#filterAllBtn').on('click', () => {
                table.search('').columns().search('').draw();
                this.setActiveFilterButton('filterAllBtn');
            });

            // Filtro para pendientes
            $('#filterPendingBtn').on('click', () => {
                table.column(4).search('pendent|Pendent').draw();
                this.setActiveFilterButton('filterPendingBtn');
            });

            // Filtro para procesando
            $('#filterProcessingBtn').on('click', () => {
                table.column(4).search('procesant|Processant').draw();
                this.setActiveFilterButton('filterProcessingBtn');
            });

            // Filtro para entregados
            $('#filterDeliveredBtn').on('click', () => {
                table.column(4).search('entregat|Entregat').draw();
                this.setActiveFilterButton('filterDeliveredBtn');
            });

            // Filtro para cancelados
            $('#filterCanceledBtn').on('click', () => {
                table.column(4).search('cancelat|Cancel·lat').draw();
                this.setActiveFilterButton('filterCanceledBtn');
            });

            // Activar filtro de pendientes por defecto
            setTimeout(() => {
                document.getElementById('filterPendingBtn')?.click();
            }, 100);
        },

        setActiveFilterButton: function (buttonId) {
            document.querySelectorAll('.filter-buttons .btn').forEach(btn => {
                btn.classList.remove('active');
            });
            document.getElementById(buttonId)?.classList.add('active');
        },

        setupActivityDetailsButtons: function () {
            // Delegación de eventos para botones de detalle de actividad
            document.querySelectorAll('.view-activity-details').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    const activityId = btn.dataset.detailId;

                    // Configurar y abrir modal de detalles
                    const detailModal = document.getElementById('detailModal');
                    const modalTitle = document.getElementById('detailModalLabel');
                    const modalLoader = document.getElementById('detail-modal-loader');
                    const detailContent = document.getElementById('detail-content');

                    if (modalTitle) {
                        modalTitle.textContent = window.translations?.admin?.activities?.details_title || "Detalls de l'Activitat";
                    }

                    if (modalLoader) modalLoader.classList.remove('d-none');
                    if (detailContent) detailContent.classList.add('d-none');

                    if (detailModal && typeof bootstrap !== 'undefined') {
                        const bsModal = new bootstrap.Modal(detailModal);
                        bsModal.show();
                    }

                    // Cargar contenido
                    fetch(`/admin/detail/activitat/${activityId}`)
                        .then(response => {
                            if (!response.ok) throw new Error('Error al cargar los detalles');
                            return response.text();
                        })
                        .then(html => {
                            if (modalLoader) modalLoader.classList.add('d-none');
                            if (detailContent) {
                                detailContent.innerHTML = html;
                                detailContent.classList.remove('d-none');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            if (modalLoader) modalLoader.classList.add('d-none');
                            if (detailContent) {
                                detailContent.innerHTML = `
                                    <div class="alert alert-danger">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        Error al cargar los detalles: ${error.message}
                                    </div>
                                `;
                                detailContent.classList.remove('d-none');
                            }
                        });
                });
            });
        },

        setupItemActions: function () {
            // Configurar botones de aprobar/rechazar reclamaciones
            document.querySelectorAll('.approveClaimBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    if (confirm(window.translations?.admin?.claimed_prizes?.confirm_approve || 'Estàs segur que vols aprovar aquesta sol·licitud?')) {
                        this.handleClaimAction(id, 'approve');
                    }
                });
            });

            document.querySelectorAll('.rejectClaimBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.id;
                    if (confirm(window.translations?.admin?.claimed_prizes?.confirm_reject || 'Estàs segur que vols rebutjar aquesta sol·licitud?')) {
                        this.handleClaimAction(id, 'reject');
                    }
                });
            });

            // Configurar botones de editar
            this.setupEditButtons();

            // Configurar botones de eliminar
            this.setupDeleteButtons();
        },

        setupEditButtons: function () {
            const editButtonsMap = {
                '.editCodiBtn': { param: 'codi-id', type: 'codi' },
                '.editAlertaBtn': { param: 'alerta-id', type: 'alerta-punt' },
                '.editEventBtn': { param: 'event-id', type: 'event' },
                '.editPremiBtn': { param: 'premi-id', type: 'premi' },
                '.editPremiReclamatBtn': { param: 'id', type: 'premi-reclamat' },
                '.editPuntBtn': { param: 'punt-id', type: 'punt-reciclatge' },
                '.editRolBtn': { param: 'rol-id', type: 'rol' },
                '.editTipusAlertaBtn': { param: 'tipus-alerta-id', type: 'tipus-alerta' },
                '.editTipusEventBtn': { param: 'tipus-event-id', type: 'tipus-event' },
                '.editUserBtn': { param: 'user-id', type: 'user' },
                '.editProducteBtn': { param: 'producte-id', type: 'producte' }
            };

            // Configurar cada tipo de botón de edición
            for (const [selector, config] of Object.entries(editButtonsMap)) {
                document.querySelectorAll(selector).forEach(btn => {
                    btn.addEventListener('click', () => {
                        const id = btn.dataset[config.param] || btn.dataset.id;
                        this.loadEditForm(id, config.type);
                    });
                });
            }
        },

        loadEditForm: function (id, type) {
            const detailModal = document.getElementById('detailModal');
            const modalTitle = document.getElementById('detailModalLabel');
            const modalLoader = document.getElementById('detail-modal-loader');
            const detailContent = document.getElementById('detail-content');

            // Traducción del título según tipo
            const titleKeys = {
                'codi': 'messages.admin.codes.edit_title',
                'alerta-punt': 'messages.admin.alerts.edit_title',
                'event': 'messages.admin.events.edit_title',
                'premi': 'messages.admin.premis.edit_title',
                'premi-reclamat': 'messages.admin.claimed_prizes.edit_title',
                'punt-reciclatge': 'messages.admin.punts.edit_title',
                'rol': 'messages.admin.roles.edit_title',
                'tipus-alerta': 'messages.admin.tipus_alertes.edit_title',
                'tipus-event': 'messages.admin.tipus_events.edit_title',
                'user': 'messages.admin.users.edit_title',
                'producte': 'messages.admin.productes.edit_title'
            };

            const defaultTitles = {
                'codi': 'Editar Codi',
                'alerta-punt': 'Editar Alerta',
                'event': 'Editar Event',
                'premi': 'Editar Premi',
                'premi-reclamat': 'Editar Premi Reclamat',
                'punt-reciclatge': 'Editar Punt de Recollida',
                'rol': 'Editar Rol',
                'tipus-alerta': 'Editar Tipus d\'Alerta',
                'tipus-event': 'Editar Tipus d\'Event',
                'user': 'Editar Usuari',
                'producte': 'Editar Producte'
            };

            if (modalTitle) {
                const translationKey = titleKeys[type];
                modalTitle.textContent = window.translations?.admin?.[translationKey] || defaultTitles[type];
            }

            if (modalLoader) modalLoader.classList.remove('d-none');
            if (detailContent) detailContent.classList.add('d-none');

            if (detailModal && typeof bootstrap !== 'undefined') {
                const bsModal = new bootstrap.Modal(detailModal);
                bsModal.show();
            }

            // Cargar formulario de edición
            fetch(`/admin/edit/${type}/${id}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error al cargar el formulario');
                    return response.text();
                })
                .then(html => {
                    if (modalLoader) modalLoader.classList.add('d-none');
                    if (detailContent) {
                        detailContent.innerHTML = html;
                        detailContent.classList.remove('d-none');

                        // Inicializar formulario de edición
                        if (AdminDashboard.EditForms && typeof AdminDashboard.EditForms.init === 'function') {
                            AdminDashboard.EditForms.init();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (modalLoader) modalLoader.classList.add('d-none');
                    if (detailContent) {
                        detailContent.innerHTML = `
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Error al cargar el formulario: ${error.message}
                            </div>
                        `;
                        detailContent.classList.remove('d-none');
                    }
                });
        },

        setupDeleteButtons: function () {
            // Manejar botones de eliminación
            document.querySelectorAll('.deleteBtn').forEach(btn => {
                btn.addEventListener('click', () => {
                    const id = btn.dataset.itemId;
                    const name = btn.dataset.itemName;
                    const type = btn.dataset.itemType;

                    if (confirm(`${window.translations?.admin?.common?.confirm_delete || 'Estàs segur que vols eliminar'} ${name}?`)) {
                        this.deleteItem(id, type);
                    }
                });
            });
        },

        handleClaimAction: function (id, action) {
            const url = action === 'approve'
                ? `/admin/premis-reclamats/${id}/approve`
                : `/admin/premis-reclamats/${id}/reject`;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(action === 'approve'
                            ? (window.translations?.admin?.claimed_prizes?.approved_success || 'Sol·licitud aprovada correctament')
                            : (window.translations?.admin?.claimed_prizes?.rejected_success || 'Sol·licitud rebutjada correctament'));

                        // Recargar la tabla
                        setTimeout(() => {
                            const contentTypeBtn = document.querySelector('[data-content-type="premis-reclamats"]');
                            if (contentTypeBtn) contentTypeBtn.click();
                            else window.location.reload();
                        }, 300);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(action === 'approve'
                        ? (window.translations?.admin?.claimed_prizes?.approve_error || 'Error al aprovar la sol·licitud')
                        : (window.translations?.admin?.claimed_prizes?.reject_error || 'Error al rebutjar la sol·licitud'));
                });
        },

        deleteItem: function (id, type) {
            fetch(`/admin/${type}/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Mostrar mensaje de éxito
                        alert(window.translations?.admin?.common?.delete_success || 'Element eliminat correctament');

                        // Recargar la tabla
                        setTimeout(() => {
                            const contentTypeBtn = document.querySelector(`[data-content-type="${type}s"]`) ||
                                document.querySelector(`[data-content-type="${type}"]`);
                            if (contentTypeBtn) contentTypeBtn.click();
                            else window.location.reload();
                        }, 300);
                    } else {
                        alert(`${window.translations?.admin?.common?.delete_error || 'Error al eliminar'}: ${data.message}`);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert(`${window.translations?.admin?.common?.delete_error || 'Error al eliminar'}: ${error.message}`);
                });
        }
    },


    /**
     * Inicialización general del dashboard
     */
    init: function () {
        console.log("Admin Dashboard initialized");

        // Inicializar módulos según el contenido de la página
        if (document.getElementById('createCodiForm') || document.getElementById('editCodiForm')) {
            this.Codis.init();
        }

        if (document.getElementById('createEventForm') || document.getElementById('editEventForm')) {
            this.Events.init();
        }

        if (document.getElementById('createPremiForm') || document.getElementById('editPremiForm')) {
            this.Premis.init();
        }

        if (document.getElementById('createProducteForm') || document.getElementById('editProducteForm')) {
            this.Productes.init();
        }

        if (document.getElementById('createPuntForm') || document.getElementById('editPuntForm')) {
            this.PuntsReciclatge.init();
        }

        if (document.getElementById('createTipusAlertaForm') || document.getElementById('editTipusAlertaForm')) {
            this.TipusAlertes.init();
        }

        if (document.getElementById('createRolForm') || document.getElementById('editRolForm')) {
            this.Rols.init();
        }

        if (document.getElementById('createTipusEventForm') || document.getElementById('editTipusEventForm')) {
            this.TipusEvents.init();
        }

        if (document.getElementById('createUserForm') || document.getElementById('editUserForm')) {
            this.Users.init();
        }

        // Inicialización de tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        if (tooltipTriggerList.length && typeof bootstrap !== 'undefined') {
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        }

        this.EditForms.init();
        this.AdminTables.init();

        // Cleanup de modales
        this.setupModalCleanup();
    },








    /**
     * Configura limpieza de modales para evitar duplicidad
     */
    setupModalCleanup: function () {
        // Limpiar estado de modales al cerrarlos
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function () {
                // Resetear formularios dentro del modal
                const forms = this.querySelectorAll('form');
                forms.forEach(form => form.reset());

                // Quitar clases de validación
                this.querySelectorAll('.is-invalid').forEach(el => {
                    el.classList.remove('is-invalid');
                });
            });
        });
    }
};

// Inicialización cuando el DOM está listo
document.addEventListener('DOMContentLoaded', function () {
    AdminDashboard.init();
});