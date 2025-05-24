<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.opinions.list_title') }}</h5>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="opinionsTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.opinions.author') }}</th>
                <th>{{ __('messages.admin.opinions.rating') }}</th>
                <th>{{ __('messages.admin.opinions.comment') }}</th>
                <th>{{ __('messages.admin.opinions.date') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($opinions as $opinio)
                <tr>
                    <td>{{ $opinio->id }}</td>
                    <td>{{ $opinio->autor }}</td>
                    <td>
                        <div class="stars">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $opinio->estrelles ? 'text-warning' : 'text-muted' }}"></i>
                            @endfor
                        </div>
                    </td>
                    <td>{{ \Illuminate\Support\Str::limit($opinio->comentari, 50) }}</td>
                    <td>{{ $opinio->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="opinio" data-detail-id="{{ $opinio->id }}" 
                                title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $opinio->id }}" 
                                data-item-name="{{ __('messages.admin.opinions.opinion') }} #{{ $opinio->id }}"
                                data-item-type="opinio"
                                title="{{ __('messages.admin.common.delete') }}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>