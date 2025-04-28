@extends('adminlte::page')

@section('title', 'Registro de Nuevo Usuario')

@section('content_header')
    <h1 class="text-bold">Registro de Nuevo Usuario</h1>
    <hr>
@stop

@section('content')
<div class="container-fluid">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">Datos del Usuario</h3>
        </div>

        <form action="{{ route('usuarios.store') }}" method="POST" autocomplete="off">
            @csrf
            <div class="card-body">
                <div class="row">
                    <!-- Sección de Roles -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="role">Seleccionar Rol <span class="text-danger">*</span></label>
                            <select name="role" class="form-control @error('role') is-invalid @enderror" required>
                                <option value="">-- Seleccione un Rol --</option>
                                @foreach ($roles as $role)
                                    <option value="{{ $role->name }}" {{ old('role') == $role->name ? 'selected' : '' }}>
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Sección de Datos Personales -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="name">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="email">Correo Electrónico <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Sección de Contraseña -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password">Contraseña <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                       name="password" id="password" required>
                                <div class="input-group-append">
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" 
                                   name="password_confirmation" id="password_confirmation" required>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-footer">
                <div class="d-flex justify-content-between">
                    <a href="{{ route('usuarios.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Regresar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Registrar Usuario
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@stop

@section('css')
    <style>
        .invalid-feedback {
            display: block;
        }
        .required-asterisk::after {
            content: "*";
            color: red;
            margin-left: 3px;
        }
    </style>
@stop

@section('js')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toggle para mostrar/ocultar contraseña
        const togglePassword = document.querySelector('#togglePassword');
        const password = document.querySelector('#password');
        
        togglePassword.addEventListener('click', function() {
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            this.querySelector('i').classList.toggle('fa-eye-slash');
        });

        // Validación en tiempo real para coincidencia de contraseñas
        const passwordConfirmation = document.querySelector('#password_confirmation');
        
        passwordConfirmation.addEventListener('input', function() {
            if (password.value !== this.value) {
                this.setCustomValidity('Las contraseñas no coinciden');
            } else {
                this.setCustomValidity('');
            }
        });
    });
</script>
@stop