<div class="mb-3">
  <label>Name</label>
  <input type="text" name="name" class="form-control" required>
</div>

<div class="mb-3">
  <label>Slug</label>
  <input type="text" name="slug" class="form-control">
</div>

<div class="mb-3">
  <label>Main Category</label>
  <select name="category_id" class="form-control" required>
    <option value="">Select Main Category</option>
    @foreach ($categories as $cat)
      <option value="{{ $cat->id }}">{{ $cat->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-12">
    <label>Description</label>
    <textarea name="description" id="editDescriptionEditor" class="form-control"></textarea>
</div>

<div class="mb-3">
  <label>Image</label>
  <input type="file" name="image" class="form-control">
</div>

<div class="mb-3">
  <label>Status</label>
  <select name="status" class="form-control">
    <option value="1">Active</option>
    <option value="0">Inactive</option>
  </select>
</div>

<script>
let editSubCategoryEditor;
function initEditSubCategoryEditor() {
    if (editSubCategoryEditor) {
        editSubCategoryEditor.destroy().then(() => {
            ClassicEditor.create(document.querySelector('#editDescriptionEditor'))
                .then(editor => { editSubCategoryEditor = editor; });
        });
    } else {
        ClassicEditor.create(document.querySelector('#editDescriptionEditor'))
            .then(editor => { editSubCategoryEditor = editor; });
    }
}

$('#edit_subcategory_Modal').on('shown.bs.modal', function () {
    initEditSubCategoryEditor();
});
</script>
