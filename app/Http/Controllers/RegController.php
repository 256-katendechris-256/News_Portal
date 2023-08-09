<?php
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class RegController extends Controller
{
    public function store(Request $request)
    {
        $user = new User();

        $user->name = $request->input('first_name');
        $user->name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));

        $user->save();

        return redirect('/')->with('success', 'Registration completed successfully');
    }
}
