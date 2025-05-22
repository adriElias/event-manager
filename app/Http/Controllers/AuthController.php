<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        error_log("ESTOY EN EL ENDPOINT DE REGISTER");
        error_log('Contenido recibido en register: ' . json_encode($request->all()));
        // Validando los datos del form del register
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:3|confirmed',
            'userTypeId' => 'required|string|in:1,2', // valores posibles del radiobutton
        ]);

        //si en la validación hay un error devolveremos el error 422
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        // Crear usuario 
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'userTypeId' => $request->userTypeId
        ]);
        // Retornar respuesta register correcto
        return response()->json([
            'message' => 'Usuario registrado correctamente',
            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        //validamos el formato del email y password
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        //si hay error en la validación lanzamos errror
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }
        //las credentials solo serán el email y password
        $credentials = $request->only('email', 'password');
        //enviamos las credenciales al método attempt a la clase Auth
        //El método attempt de la clase Auth verificara si el email existe y si la contraseña coincide(hash), solo nos devuelve true|false
        $valido = Auth::attempt($credentials);
        error_log('Respuesta de Auth::attempt: ' . json_encode($valido));

        //si no son validas las credenciales, mostramos error
        if (!$valido) {
            return response()->json([
                'message' => 'Credenciales incorrectas'
            ], 401);
        }
        //recuperar el/lx usuarix autenticado
        $user = Auth::user();
        //creamos un token y lo guardamos en la tabla personal_access_token con el paquete Sanctum
        $token = $user->createToken('api-token')->plainTextToken;

        //devolvemos un json con nuestro mensaje de inicio de sesión exitoso, nuestro objeto user y nuestro token creado
        return response()->json([
            'message' => 'Inicio de sesión exitoso',
            'user' => $user,
            'token' => $token
        ]);
    }
}
