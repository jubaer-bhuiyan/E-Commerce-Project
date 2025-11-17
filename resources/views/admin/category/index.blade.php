@extends('admin.layouts.app')

@push('styles')
    <style>
        .dd-item.custom-cat-item {
            border: none;
            padding: 0;
            margin-bottom: 0;
            background: none;
            border-radius: 0;
        }

        .dd-item-row.custom-cat-row {
            user-select: text;
            background: none;
            gap: 4px;
            border: 1px solid #e9ecef;
            min-height: 38px;
            display: flex;
            align-items: center;
            padding-left: 0.75rem;
            /* px-2 */
            padding-right: 0.75rem;
            padding-top: 0.25rem;
            /* py-1 */
            padding-bottom: 0.25rem;
        }

        .dd-handle.custom-cat-handle {
            cursor: move;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 0.5rem;
            /* me-2 */
        }

        .cat-folder-icon {
            font-size: 16px;
            color: #6c757d;
        }

        .cat-label.custom-cat-label {
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 2px;
            flex: 1 1 auto;
        }

        .dd-list .dd-list {
            padding-left: 50px;
        }

        .dd-item-row {
            margin-bottom: 5px;
        }

        .dd-item>button {
            height: 44px;
            margin: 0;
            border: 1px solid #e9ecef;
            background-color: #ededed;
        }
    </style>
@endpush

@section('contents')
    <div class="container-fluid mt-4">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Categories</span>
                        <button class="btn btn-primary" id="btn-new">New</button>
                    </div>
                    <div class="card-body">
                        <div id="category-tree" class="dd">

                        </div>
                        <div id="tree-loading" class="text-center my-2 d-none">
                            <div class="spinner-border"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><span id="category-title">Create Category</span></div>
                    <div class="card-body">
                        <form id="category-form" action="">
                            <div class="mb-2">
                                <label for="" class="form-label">Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control" required id="name">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Slug <span class="text-danger">*</span></label>
                                <input type="text" name="slug" class="form-control" required id="slug">
                            </div>
                            <div class="mb-2">
                                <label for="" class="form-label">Parent Category <span
                                        class="text-danger">*</span></label>
                                <select name="parent_id" class="form-select" id="parent_id">
                                </select>
                            </div>

                            <div class="mb-2">
                                <label class="form-check form-switch form-switch-3">
                                    <input class="form-check-input" type="checkbox" checked="" name="is_active"
                                        id="is_active">
                                    <span class="form-check-label">Active</span>
                                </label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary" id="btn-save">Save</button>
                                <button type="button" class="btn btn-danger" id="btn-delete">Delete</button>
                                <button type="button" class="btn btn-secondary" id="btn-cancel">Cancel</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(function() {
            $("#category-form").submit(function(e) {
                e.preventDefault();

                let method = "POST";
                let url = "{{ route('admin.categories.store') }}";

                let data = {
                    name: $("#name").val(),
                    slug: $("#slug").val(),
                    parent_id: $("#parent_id").val(),
                    is_active: $("#is_active").is(":checked") ? 1 : 0,
                    _token: "{{ csrf_token() }}"
                };

                $.ajax({
                    url: url,
                    method: method,
                    data: data,
                    success: function(response) {
                        notyf.success(response.message);
                        clearForm(); // or reload category tree
                    },
                    error: function(xhr, status, error) {
                        console.log(xhr);
                        let errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value) {
                            notyf.error(errors[key][0]);
                        })
                    }
                });
            });
        });

        // load parent dropdown
        function loadParentDropdown(selectedId, excludeId) {
            $.get("{{ route('admin.categories.nested') }}", function(data) {
                let options = '<option value="">None (Root)</option>';

                function addOptions(cats, prefix, depth) {
                    cats.forEach(function(cat) {
                        if (cat.id == excludeId) return;
                        options +=
                            `<option value="${cat.id}" ${selectedId == cat.id ? 'selected' : '' } > ${prefix}${cat.name}</option>`;
                        if (cat.children_nested && cat.children_nested.length) {
                            addOptions(cat.children_nested, prefix + '--', depth + 1);
                        }
                    })
                }

                addOptions(data, '', 0);

                $('#parent_id').html(options);

            })
        }

        // clear form
        function clearForm() {
            $("#name").val('');
            $("#slug").val('');
            $("#parent_id").val('');
            $("#is_active").prop('checked', true);
            loadParentDropdown(null, null);
        }

        // Initial Load
        clearForm();
    </script>
@endpush
