<div class="container-fluid p-0">
    <div class="row">
        <div class="col-12">
            <h4 class="mb-3">{{ __('messages.admin.productes.edit_title') }}</h4>

            <div class="modal-body-scroll">
                <form id="editProducteForm" method="POST" action="{{ route('admin.productes.update', $producte->id) }}" 
                      enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="card mb-3 form-card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">{{ __('messages.admin.productes.info_title') }}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="nom" class="form-label">{{ __('messages.admin.productes.name') }} <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" id="nom" name="nom" value="{{ $producte->nom }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="categoria" class="form-label">{{ __('messages.admin.productes.category') }} <span class="text-danger">*</span></label>
                                <select class="form-select" id="categoria" name="categoria" required>
                                    <option value="">{{ __('messages.admin.productes.select_category') }}</option>
                                    <option value="Deixalleria" {{ $producte->categoria == 'Deixalleria' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_waste') }}</option>
                                    <option value="Envasos" {{ $producte->categoria == 'Envasos' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_packaging') }}</option>
                                    <option value="Especial" {{ $producte->categoria == 'Especial' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_special') }}</option>
                                    <option value="Medicaments" {{ $producte->categoria == 'Medicaments' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_meds') }}</option>
                                    <option value="Organica" {{ $producte->categoria == 'Organica' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_organic') }}</option>
                                    <option value="Paper" {{ $producte->categoria == 'Paper' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_paper') }}</option>
                                    <option value="Piles" {{ $producte->categoria == 'Piles' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_batteries') }}</option>
                                    <option value="RAEE" {{ $producte->categoria == 'RAEE' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_raee') }}</option>
                                    <option value="Resta" {{ $producte->categoria == 'Resta' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_rest') }}</option>
                                    <option value="Vidre" {{ $producte->categoria == 'Vidre' ? 'selected' : '' }}>{{ __('messages.admin.productes.category_glass') }}</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="imatge" class="form-label">{{ __('messages.admin.productes.image') }}</label>
                                <input type="file" class="form-control" id="imatge" name="imatge">
                                <div class="form-text">{{ __('messages.admin.productes.image_help') }}</div>

                                @if($producte->imatge)
                                    <div class="mt-2">
                                        <label>{{ __('messages.admin.productes.current_image') }}:</label>
                                        <div>
                                            <img src="{{ asset($producte->imatge) }}" class="preview-image rounded" 
                                                 alt="{{ __('messages.admin.productes.product_image') }}">
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelEditBtn">{{ __('messages.common.cancel') }}</button>
                        <button type="submit" class="btn btn-primary" id="updateProducteBtn">{{ __('messages.admin.productes.update_button') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>