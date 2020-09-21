<?php   
namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Hash;
    use Illuminate\Support\Facades\Validator;
    use JWTAuth;
    use Tymon\JWTAuth\Exceptions\JWTException;

    class UserController extends Controller
    {
        public function list(){
            $todos = User::all();
            return $todos;
    
        }
        public function authenticate(Request $request)
        {
            $credentials = $request->only('email', 'password');
            try {
                if (! $token = JWTAuth::attempt($credentials)) {
                    return response()->json(['error' => 'invalid_credentials'], 400);
                }
            } catch (JWTException $e) {
                return response()->json(['error' => 'could_not_create_token'], 500);
            }
            return response()->json(compact('token'));
        }
        public function getAuthenticatedUser()
        {
            try {
                if (!$user = JWTAuth::parseToken()->authenticate()) {
                        return response()->json(['user_not_found'], 404);
                }
                } catch (Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
                        return response()->json(['token_expired'], $e->getStatusCode());
                } catch (Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
                        return response()->json(['token_invalid'], $e->getStatusCode());
                } catch (Tymon\JWTAuth\Exceptions\JWTException $e) {
                        return response()->json(['token_absent'], $e->getStatusCode());
                }
                return response()->json(compact('user'));
        }
        public function register(Request $request)
        {
            $id_rol=$request->get('id_rol');
            if($id_rol==4){
            
                $validator = Validator::make($request->all(), 
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    'id_rol' => 'required',
                    'tipo_documento'=>'required',
                    'numero_documento'=>'required',
                    'direccion'=>'required',
                    'telefono'=>'required|max:10',
                    
                ]);
                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
            }
            if($id_rol==5){
            
                $validator = Validator::make($request->all(), 
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|string|min:6',
                    'id_rol' => 'required',
                    'tipo_documento'=>'required',
                    'numero_documento'=>'required',
                    'telefono'=>'required|max:10',
                    
                    
                ]);
                if($validator->fails()){
                    return response()->json($validator->errors()->toJson(), 400);
                }
    
            }
                $user = User::create([
                    'name' => $request->get('name'),
                    'email' => $request->get('email'),
                    'password' => Hash::make($request->get('password')),
                    'id_rol' => $request->get('id_rol'),
                    'tipo_documento'=> $request->get('tipo_documento'),
                    'numero_documento'=> $request->get('numero_documento'),
                    'telefono'=> $request->get('telefono'),
                    'direccion'=> $request->get('direccion'),
                    'id_padre'=> $request->get('id_padre'),
                ]);
    
                $token = JWTAuth::fromUser($user);
    
                return response()->json(compact('user','token'),201);
            }
    }