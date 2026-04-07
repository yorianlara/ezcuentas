@extends('layouts.master-vertical')

@section('title') Muebles | Products @endsection
@section('content')
@section('pagetitle') Forms @endsection

@section('content')
    <div class="container">
        <h1>Create New Form</h1>

        <form action="{{ route('forms.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="title" class="form-label">Form Title</label>
                <input type="text" class="form-control" id="title" name="title" placeholder="Enter the title of the form" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" placeholder="Enter a description" rows="3"></textarea>
            </div>

            <h3>Form Fields</h3>

            <div id="fields-container">
                <!-- Aquí se agregarán los campos dinámicamente -->
            </div>

            <button type="button" class="btn btn-secondary" onclick="addField()">Add Field</button>
            <button type="submit" class="btn btn-primary">Save Form</button>
        </form>
    </div>
@endsection
@section('script')
<script>
    let cont = 0;
    function addField() {
        const container = document.getElementById('fields-container');
        const field = document.createElement('div');
        field.classList.add('mb-3');
        field.innerHTML = `
            <div class="mb-2">
                <label for="label" class="form-label">Label</label>
                <input type="text" class="form-control" name="fields[${cont}][label]" placeholder="Enter the field label" required>
            </div>
            
            <div class="mb-2">
                <label for="type" class="form-label">Field Type</label>
                <select class="form-select" name="fields[${cont}][type]" required>
                    <option value="text">Text</option>
                    <option value="textarea">Text Area</option>
                    <option value="select">Select</option>
                    <option value="checkbox">Checkbox</option>
                    <option value="radio">Radio</option>
                </select>
            </div>
            
            <div class="mb-2">
                <label for="options" class="form-label">Options (if applicable)</label>
                <input type="text" class="form-control" name="fields[${cont}][options]" placeholder="Enter options separated by commas (only for select, radio, checkbox)">
            </div>
            
            <div class="form-check mb-2">
                <input class="form-check-input" type="checkbox" name="fields[${cont}][required]" id="required${cont}">
                <label class="form-check-label" for="required${cont}">Required</label>
            </div>

            <hr>
        `;
        container.appendChild(field);
        cont ++;
    }
</script>
@endsection
