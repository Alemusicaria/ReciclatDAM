<div class="d-flex justify-content-between align-items-center mb-3">
    <h5 class="mb-0">{{ __('messages.admin.users.list_title') }}</h5>
    <button id="newUserBtn" class="btn btn-success btn-sm admin-action-btn" data-bs-toggle="modal" data-bs-target="#detailModal"
        data-detail-type="create-user" data-detail-title="{{ __('messages.admin.users.new_user') }}">
        <i class="fas fa-plus-circle me-1"></i> {{ __('messages.admin.users.new_user') }}
    </button>
</div>

<div class="table-responsive">
    <table class="table table-striped admin-table" id="dynamicTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>{{ __('messages.admin.users.name') }}</th>
                <th>{{ __('messages.admin.users.email') }}</th>
                <th>{{ __('messages.admin.users.points') }}</th>
                <th>{{ __('messages.admin.common.actions') }}</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>
                        <div class="d-flex align-items-center">
                            @if($user->foto_perfil)
                                @if(str_starts_with($user->foto_perfil, 'https://'))
                                    <img src="{{ $user->foto_perfil }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                @elseif(file_exists(public_path('storage/' . $user->foto_perfil)))
                                    <img src="{{ asset('storage/' . $user->foto_perfil) }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                @else
                                    <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                                @endif
                            @else
                                <img src="{{ asset('images/default-profile.png') }}" class="user-avatar rounded-circle me-2" alt="{{ __('messages.admin.profile_photo') }}">
                            @endif
                            {{ $user->nom }} {{ $user->cognoms }}
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge bg-primary">
                            {{ $user->punts_actuals }} {{ __('messages.admin.common.points_abbreviation') }}
                        </span>
                    </td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#detailModal"
                                data-detail-type="user" data-detail-id="{{ $user->id }}" title="{{ __('messages.admin.common.view_details') }}">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-primary editUserBtn" data-user-id="{{ $user->id }}"
                                title="{{ __('messages.admin.common.edit') }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-danger btn-sm deleteBtn" 
                                data-item-id="{{ $user->id }}" 
                                data-item-name="{{ $user->nom }} {{ $user->cognoms }}"
                                data-item-type="user"
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