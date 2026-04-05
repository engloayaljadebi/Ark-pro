<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        return response()->json(['debug' => 'وصل الطلب للكنترولر بنجاح!']);
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        // البحث عن المستخدم مع تحميل بيانات المنشأة والصلاحية
        $user = User::with(['business', 'role', 'person'])
            ->where('username', $request->username)
            ->first();

        // التحقق من وجود المستخدم وصحة كلمة المرور
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'بيانات الدخول غير صحيحة.'
            ], 401);
        }

        // إنشاء التوكن (Token)
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => [
                'id' => $user->id,
                'username' => $user->username,
                'full_name' => $user->person->full_name,
                'role' => $user->role->name,
                'business' => $user->business->business_name,
            ]
        ]);
    }
}
