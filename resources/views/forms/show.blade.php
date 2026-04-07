@extends('layouts.master-vertical')

@section('title') Muebles | Products @endsection
@section('content')
@section('pagetitle') Trailers @endsection

@section('content')
    <div class="container">
        <h1>{{ $form->title }}</h1>
        <p>{{ $form->description }}</p>

        <form action="{{ route('forms.submit', $form->id) }}" method="POST">
            @csrf

            @foreach($form->fields as $field)
                <div class="mb-3">
                    <label class="form-label">{{ $field->label }} @if($field->required) <span class="text-danger">*</span> @endif</label>

                    @if($field->type == 'text')
                        <input type="text" class="form-control" name="{{ $field->id }}" @if($field->required) required @endif>
                    @elseif($field->type == 'textarea')
                        <textarea class="form-control" name="{{ $field->id }}" rows="3" @if($field->required) required @endif></textarea>
                    @elseif($field->type == 'select')
                        <select class="form-select" name="{{ $field->id }}" @if($field->required) required @endif>
                            @foreach(explode(',', $field->options) as $option)
                                <option value="{{ $option }}">{{ $option }}</option>
                            @endforeach
                        </select>
                    @elseif($field->type == 'checkbox')
                        @foreach(explode(',', $field->options) as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="{{ $field->id }}[]" value="{{ $option }}">
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                    @elseif($field->type == 'radio')
                        @foreach(explode(',', $field->options) as $option)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="{{ $field->id }}" value="{{ $option }}" @if($field->required) required @endif>
                                <label class="form-check-label">{{ $option }}</label>
                            </div>
                        @endforeach
                    @endif
                </div>
            @endforeach
        </form>
    </div>
@endsection
