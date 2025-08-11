<div class="col-md-6">
                        <label>Name</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>

                    <div class="col-md-6">
                        <label>Phone</label>
                        <input type="number" name="phone" class="form-control" value="{{ $user->phone }}">
                    </div>

                    <div class="col-md-6">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Leave blank to keep current">
                    </div>

                    <div class="col-md-6">
                        <label>Status</label>
                        <select name="status" class="form-select">
                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>Active</option>
                            <option value="0" {{ $user->status == 0 ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label>Profile Photo</label>
                        <input type="file" name="profile_photo" class="form-control" accept="image/*"
                               onchange="previewEditPhoto(this, 'editUserPhotoPreview{{ $user->id }}')">
                        <img id="editUserPhotoPreview{{ $user->id }}"
                             src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : '#' }}"
                             class="mt-2 border rounded {{ $user->profile_photo ? '' : 'd-none' }}"
                             width="60" height="60">
                    </div>