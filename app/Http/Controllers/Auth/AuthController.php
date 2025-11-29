<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Mostrar formulario de login
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Procesar el login
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->boolean('remember');

        // Intentar autenticación
        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Verificar si el usuario está activo
            if (!$user->activo) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'email' => 'Tu cuenta está desactivada. Contacta al administrador.',
                ]);
            }

            $request->session()->regenerate();

            // Redirigir según el tipo de usuario
            return $this->redirectAfterLogin($user);
        }

        throw ValidationException::withMessages([
            'email' => 'Las credenciales proporcionadas no son válidas.',
        ]);
    }

    /**
     * Redirección después del login
     */
    protected function redirectAfterLogin(User $user)
    {
        // Limpiar sesión de empresa anterior
        Session::forget(['empresa_id', 'empresa_nombre', 'empresa_esquema']);

        // Si es administrador, redirigir al panel admin
        if ($user->es_admin) {
            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Bienvenido al panel administrativo');
        }

        // Para usuarios normales, verificar si tienen empresas asignadas
        $empresasCount = $user->empresas()->where('empresa_user.activo', true)->count();

        if ($empresasCount === 0) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'No tienes empresas asignadas. Contacta al administrador.',
            ]);
        }

        // Si solo tiene una empresa, seleccionarla automáticamente
        if ($empresasCount === 1) {
            $empresa = $user->empresas()->first();
            Session::put('empresa_id', $empresa->id);
            Session::put('empresa_nombre', $empresa->nombre);
            Session::put('empresa_esquema', $empresa->esquema);

            return redirect()->intended(route('dashboard.empresa'))
                ->with('success', "Bienvenido a {$empresa->nombre}");
        }

        // Si tiene múltiples empresas, redirigir a selección
        return redirect()->route('seleccionar-empresa')
            ->with('info', 'Por favor, selecciona una empresa para continuar');
    }

    /**
     * Procesar registro (opcional - depende si quieres registro público)
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'es_admin' => false, // Por defecto no es admin
            'activo' => true, // O false hasta que sea aprobado por admin
        ]);

        // Opcional: asignar a empresa por defecto si existe
        // $empresaPorDefecto = Empresa::where('codigo', 'default')->first();
        // if ($empresaPorDefecto) {
        //     $user->empresas()->attach($empresaPorDefecto->id, [
        //         'rol' => 'lector',
        //         'activo' => true,
        //         'fecha_inicio' => now()
        //     ]);
        // }

        Auth::login($user);

        return redirect()->route('seleccionar-empresa')
            ->with('success', 'Cuenta creada exitosamente. Por favor selecciona una empresa.');
    }

    /**
     * Cerrar sesión
     */
    public function logout(Request $request)
    {
        // Limpiar sesión de empresa
        Session::forget('empresa_id');
        Session::forget('empresa_nombre');
        Session::forget('empresa_esquema');

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')
            ->with('success', 'Sesión cerrada exitosamente.');
    }

    /**
     * Mostrar formulario de recuperación de contraseña
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Mostrar formulario de restablecimiento de contraseña
     */
    public function showResetPasswordForm(Request $request)
    {
        return view('auth.reset-password', ['token' => $request->token]);
    }

    /**
     * Verificar email (si usas verificación de email)
     */
    public function verifyEmail(Request $request, $id, $hash)
    {
        $user = User::findOrFail($id);

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            abort(403, 'Enlace de verificación inválido.');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
        }

        return redirect()->route('login')
            ->with('success', 'Email verificado exitosamente. Ya puedes iniciar sesión.');
    }

    /**
     * Reenviar email de verificación
     */
    public function resendVerificationEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'El email ya está verificado.');
        }

        // Aquí enviarías el email de verificación
        // $user->sendEmailVerificationNotification();

        return back()->with('success', 'Se ha enviado un nuevo enlace de verificación a tu email.');
    }

    /**
     * Mostrar perfil del usuario
     */
    public function showProfile()
    {
        $user = Auth::user();
        $empresas = $user->empresas()
            ->where('empresa_user.activo', true)
            ->withPivot('rol')
            ->get();

        return view('auth.profile', compact('user', 'empresas'));
    }

    /**
     * Actualizar perfil del usuario
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id)
            ],
            'current_password' => ['required', 'current_password'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return back()->with('success', 'Perfil actualizado exitosamente.');
    }

    /**
     * Cambiar empresa actual (para usuarios con múltiples empresas)
     */
    public function cambiarEmpresa(Empresa $empresa)
    {
        $user = Auth::user();

        // Verificar que el usuario pertenece a la empresa
        if (!$user->empresas()->where('empresa_id', $empresa->id)->where('empresa_user.activo', true)->exists()) {
            return back()->with('error', 'No tienes acceso a esta empresa.');
        }

        // Actualizar sesión
        Session::put('empresa_id', $empresa->id);
        Session::put('empresa_nombre', $empresa->nombre);
        Session::put('empresa_esquema', $empresa->esquema);

        return back()->with('success', "Has cambiado a la empresa: {$empresa->nombre}");
    }
}