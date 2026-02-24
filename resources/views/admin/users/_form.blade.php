<div class="row g-3">

    <div class="col-md-6">
        <label class="form-label">Full Name</label>
        <input type="text"
               name="name"
               class="form-control"
               value="{{ old('name', $user->name ?? '') }}"
               required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Email Address</label>
        <input type="email"
               name="email"
               class="form-control"
               value="{{ old('email', $user->email ?? '') }}"
               required>
    </div>

    <div class="col-md-6">
        <label class="form-label">Phone</label>
        <input type="text"
               name="phone"
               class="form-control"
               value="{{ old('phone', $user->phone ?? '') }}">
    </div>

    <div class="col-md-6">
        <label class="form-label">Role</label>
        <select name="role" class="form-select" required>
            <option value="user"
                {{ old('role', $user->role ?? '') == 'user' ? 'selected' : '' }}>
                User
            </option>
            <option value="admin"
                {{ old('role', $user->role ?? '') == 'admin' ? 'selected' : '' }}>
                Admin
            </option>
        </select>
    </div>

    @isset($user)
        <div class="col-md-6">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-select" required>
                <option value="1"
                    {{ old('is_active', $user->is_active ?? 1) == 1 ? 'selected' : '' }}>
                    Active
                </option>
                <option value="0"
                    {{ old('is_active', $user->is_active ?? 1) == 0 ? 'selected' : '' }}>
                    Inactive
                </option>
            </select>
        </div>
    @endisset

    <div class="col-md-6">
        <label class="form-label">
            Password {{ isset($user) ? '(Leave blank to keep current)' : '' }}
        </label>
        <input type="password"
               name="password"
               class="form-control"
            {{ isset($user) ? '' : 'required' }}>
    </div>

    <div class="col-md-6">
        <label class="form-label">Confirm Password</label>
        <input type="password"
               name="password_confirmation"
               class="form-control"
            {{ isset($user) ? '' : 'required' }}>
    </div>

</div>
