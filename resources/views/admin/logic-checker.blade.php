@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4" style="margin-top: 13vh;">
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
                    <div>
                        <h1 class="h3 mb-1">Diagnòstic de lògica</h1>
                        <p class="text-muted mb-0">Executa comprovacions automàtiques sobre rutes i controladors un per un.</p>
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Tornar al panell
                    </a>
                </div>

                <div class="alert alert-warning mb-3" role="alert">
                    Aquesta execució prova rutes GET/POST/PUT/PATCH/DELETE i fa rollback automàtic en operacions mutadores.
                </div>

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <button id="runLogicCheckBtn" class="btn btn-primary">
                        <i class="fas fa-play me-2"></i>Executar
                    </button>
                    <div class="form-check m-0">
                        <input class="form-check-input" type="checkbox" id="includeLocalizedRoutes">
                        <label class="form-check-label" for="includeLocalizedRoutes">
                            Incloure rutes localitzades (`localized.*`)
                        </label>
                    </div>
                    <span id="runStatus" class="text-muted"></span>
                </div>
            </div>
        </div>

        <div class="row g-3 mb-3" id="summaryRow" style="display:none;">
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card active" data-filter="all" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Total</small><div class="h4 mb-0" id="sumTotal">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="ok" role="button" tabindex="0"><div class="card-body"><small class="text-muted">OK</small><div class="h4 mb-0 text-success" id="sumOk">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="redirect" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Redirect</small><div class="h4 mb-0 text-info" id="sumRedirect">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="client" role="button" tabindex="0"><div class="card-body"><small class="text-muted">4xx reals</small><div class="h4 mb-0 text-warning" id="sumClient">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="server" role="button" tabindex="0"><div class="card-body"><small class="text-muted">5xx</small><div class="h4 mb-0 text-danger" id="sumServer">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="auth" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Auth</small><div class="h4 mb-0" id="sumProtectedAuth">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="csrf" role="button" tabindex="0"><div class="card-body"><small class="text-muted">CSRF</small><div class="h4 mb-0" id="sumProtectedCsrf">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="expected" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Exp. validació</small><div class="h4 mb-0 text-secondary" id="sumExpectedValidation">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="expected" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Exp. no trobat</small><div class="h4 mb-0 text-secondary" id="sumExpectedNotFound">0</div></div></div></div>
            <div class="col-md-2"><div class="card border-0 shadow-sm logic-filter-card" data-filter="other" role="button" tabindex="0"><div class="card-body"><small class="text-muted">Exc/Skip</small><div class="h4 mb-0" id="sumOther">0</div></div></div></div>
        </div>

        <div class="card border-0 shadow-sm" id="resultsCard" style="display:none;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Route</th>
                                <th>Mètode</th>
                                <th>URI</th>
                                <th>Controller</th>
                                <th>Estat</th>
                                <th>Resultat</th>
                                <th>Error</th>
                            </tr>
                        </thead>
                        <tbody id="resultsBody"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const runBtn = document.getElementById('runLogicCheckBtn');
            const runStatus = document.getElementById('runStatus');
            const includeLocalizedRoutes = document.getElementById('includeLocalizedRoutes');
            const summaryRow = document.getElementById('summaryRow');
            const resultsCard = document.getElementById('resultsCard');
            const resultsBody = document.getElementById('resultsBody');
            const filterCards = Array.from(document.querySelectorAll('.logic-filter-card'));
            let activeFilter = 'all';

            const parseJsonResponse = async (response) => {
                const payload = await response.json().catch(() => null);
                if (!response.ok) {
                    throw new Error((payload && payload.message) || 'Error desconegut executant la sol·licitud.');
                }
                return payload;
            };

            function getRowFilterKey(row) {
                if (row.result === 'PROTECTED (AUTH)') return 'auth';
                if (row.result === 'PROTECTED (CSRF)') return 'csrf';
                if (row.result === 'EXPECTED (VALIDATION)' || row.result === 'EXPECTED (NOT FOUND)') return 'expected';
                if (typeof row.status === 'number' && row.status >= 500) return 'server';
                if (typeof row.status === 'number' && row.status >= 400 && row.status < 500) return 'client';
                if (typeof row.status === 'number' && row.status >= 300 && row.status < 400) return 'redirect';
                if (typeof row.status === 'number' && row.status >= 200 && row.status < 300) return 'ok';
                return 'other';
            }

            function applyFilter() {
                resultsBody.querySelectorAll('tr[data-filter-key]').forEach(function (row) {
                    const matches = activeFilter === 'all' || row.dataset.filterKey === activeFilter;
                    row.classList.toggle('d-none', !matches);
                });

                filterCards.forEach(function (card) {
                    card.classList.toggle('active', card.dataset.filter === activeFilter);
                });
            }

            filterCards.forEach(function (card) {
                card.addEventListener('click', function () {
                    activeFilter = this.dataset.filter || 'all';
                    applyFilter();
                });

                card.addEventListener('keydown', function (event) {
                    if (event.key === 'Enter' || event.key === ' ') {
                        event.preventDefault();
                        activeFilter = this.dataset.filter || 'all';
                        applyFilter();
                    }
                });
            });

            function badgeForStatus(status) {
                if (status === 'EXC') return '<span class="badge bg-danger">EXC</span>';
                if (status === 'SKIP') return '<span class="badge bg-secondary">SKIP</span>';
                if (status >= 500) return '<span class="badge bg-danger">' + status + '</span>';
                if (status >= 400) return '<span class="badge bg-warning text-dark">' + status + '</span>';
                if (status >= 300) return '<span class="badge bg-info text-dark">' + status + '</span>';
                return '<span class="badge bg-success">' + status + '</span>';
            }

            const style = document.createElement('style');
            style.textContent = `
                .logic-filter-card {
                    cursor: pointer;
                    transition: transform 0.15s ease, box-shadow 0.15s ease, border-color 0.15s ease;
                }

                .logic-filter-card:hover {
                    transform: translateY(-1px);
                    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.08);
                }

                .logic-filter-card.active {
                    border: 2px solid #0d6efd !important;
                    box-shadow: 0 0 0 0.2rem rgba(13, 110, 253, 0.12);
                }
            `;
            document.head.appendChild(style);

            function updateFilterCounts(rows) {
                const counts = {
                    all: rows.length,
                    server: 0,
                    client: 0,
                    auth: 0,
                    csrf: 0,
                    expected: 0,
                    ok: 0,
                    redirect: 0,
                };

                rows.forEach(function (row) {
                    const key = getRowFilterKey(row);

                    if (key in counts) {
                        counts[key] += 1;
                    }
                });

                Object.entries(counts).forEach(function ([key, value]) {
                    const badge = document.querySelector('[data-filter-count="' + key + '"]');
                    if (badge) {
                        badge.textContent = value;
                    }
                });
            }

            runBtn.addEventListener('click', async function () {
                runBtn.disabled = true;
                runStatus.textContent = 'Executant comprovacions...';
                resultsBody.innerHTML = '';

                try {
                    const response = await fetch('{{ route('admin.logic-checker.run') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: JSON.stringify({
                            locale: '{{ app()->getLocale() }}',
                            include_localized: includeLocalizedRoutes.checked
                        })
                    });

                    const data = await parseJsonResponse(response);

                    if (!data.success) {
                        throw new Error(data.message || 'Error desconegut executant el diagnòstic.');
                    }

                    document.getElementById('sumTotal').textContent = data.summary.total;
                    document.getElementById('sumOk').textContent = data.summary.ok;
                    document.getElementById('sumRedirect').textContent = data.summary.redirect;
                    document.getElementById('sumClient').textContent = data.summary.client_error;
                    document.getElementById('sumServer').textContent = data.summary.server_error;
                    document.getElementById('sumProtectedAuth').textContent = data.summary.protected_auth ?? 0;
                    document.getElementById('sumProtectedCsrf').textContent = data.summary.protected_csrf ?? 0;
                    document.getElementById('sumExpectedValidation').textContent = data.summary.expected_validation ?? 0;
                    document.getElementById('sumExpectedNotFound').textContent = data.summary.expected_not_found ?? 0;
                    document.getElementById('sumOther').textContent = data.summary.exceptions + data.summary.skipped;

                    updateFilterCounts(data.results || []);

                    data.results.forEach(function (row) {
                        const tr = document.createElement('tr');
                        tr.dataset.filterKey = getRowFilterKey(row);
                        tr.innerHTML = `
                            <td>${row.route ?? '-'}</td>
                            <td><code>${row.method ?? '-'}</code></td>
                            <td><code>${row.uri ?? '-'}</code></td>
                            <td><small>${row.controller ?? '-'}</small></td>
                            <td>${badgeForStatus(row.status)}</td>
                            <td>${row.result ?? '-'}</td>
                            <td><small class="text-danger">${row.error ?? ''}</small></td>
                        `;
                        resultsBody.appendChild(tr);
                    });

                    activeFilter = 'all';
                    applyFilter();

                    summaryRow.style.display = '';
                    resultsCard.style.display = '';
                    runStatus.textContent = 'Diagnòstic completat.';
                } catch (error) {
                    runStatus.textContent = error.message;
                } finally {
                    runBtn.disabled = false;
                }
            });
        });
    </script>
@endsection
