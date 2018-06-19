<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    function __construct(Request $request)
    {
        $this->middleware('throttle:5,1')->only('login');
    }

    /**
     * Login username and password.
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        if ($this->validator($request->all())) {
            return $this->error();
        }

        $credentials = [
            'name' => $request->get('username'),
            'password' => $request->get('password'),
        ];

        return Auth::once($credentials) ? $this->token() : $this->error();
    }

    /**
     * Validates the request.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    private function validator(array $data) {
        $v = Validator::make($data, [
            'username' => 'required|string',
            'password' => 'required|string|min:6'
        ]);

        return $v->fails();
    }

    /**
     * @param string $method
     * @return \Illuminate\Http\JsonResponse
     */
    private function token() {
        return $this->response([
            'success' => [
                'token' => Auth::user()->createToken('App', ['app-login'])->accessToken,
            ]
        ]);
    }

    /**
     * Send message with error.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private function error() {
        return $this->response(['message'=>'Unauthenticated.'], 401);
    }

    /**
     * Respone json
     *
     * @param array $data
     * @param int $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function response(array $data, int $status = 200)
    {
        return response()->json($data, $status);
    }
}
