<div class="row">
    <div class="col-12 mb-3">
        <label>Name</label>
        <input type="text" name="name" class="form-control form-control-lg" required>
    </div>

    <div class="col-12 mb-3">
        <label>Email</label>
        <input type="email" name="email" class="form-control form-control-lg" required>
    </div>

    <div class="col-12 mb-3">
        <label>Phone</label>
        <input type="text" name="phone" class="form-control form-control-lg">
    </div>

    <div class="col-12 mb-3">
        <label>Username</label>
        <input type="text" name="username" class="form-control form-control-lg">
    </div>

    <div class="col-12 mb-3">
        <label>Password</label>
        <input type="password" name="password" class="form-control form-control-lg" required>
    </div>

    <div class="col-12 mb-3">
        <label>Confirm Password</label>
        <input type="password" name="password_confirmation" class="form-control form-control-lg" required>
    </div>

    <div class="col-12 mb-3">
        <label for="status" class="form-label">Status</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="active" value="1" checked>
                <label class="form-check-label" for="active">Active</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="status" id="inactive" value="0">
                <label class="form-check-label" for="inactive">Inactive</label>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <label>Profile Photo</label>
        <input type="file" name="profile_photo" class="form-control form-control-lg" accept="image/*" onchange="previewPhoto(this)">
        <img id="photoPreview" src="#" class="mt-2 d-none border rounded" width="60" height="60">
    </div>
</div>
