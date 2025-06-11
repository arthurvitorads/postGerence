<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetLinkController extends Controller
{
    public function store(Request $request)
    {
        // Validação manual com mensagens customizadas
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
        ], [
            'email.required' => 'O email é obrigatório.',
            'email.email'    => 'O email deve ser válido.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => implode(' | ', $validator->errors()->all())
            ], 422);
        }

        // Envio do link
        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return response()->json([
                'message' => 'Enviamos o link de recuperação para seu email!'
            ], 200);
        }

        // Se falhou (por exemplo, email não existe)
        return response()->json([
            'message' => 'Não encontramos um usuário com esse email.'
        ], 422);
    }
}
