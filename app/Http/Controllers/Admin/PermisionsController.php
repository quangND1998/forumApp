<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;
use App\TextToSpeech\TextToSpeechFactory;
class PermisionsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:users_manage', ['only' => ['index', 'store', 'update', 'delete']]);
    }
    public function index()
    {
      
        $permissions = Permission::paginate(10);
        // $texToSpeech= TextToSpeechFactory::getTypeTextToSpeech('Viettel',$permissions, 'en','aaaaa');
        // return $texToSpeech->toSpeech('Viettel');
        return Inertia::render('Admin/Permission', compact('permissions'));
    }

    public function store(Request $request)
    {
       

            $this->validate($request, [
                'name' => 'required|unique:permissions',
            ]);

            Permission::create($request->all());

            return back()->with('success', 'Create permission successfully');
  
    }
    public function update(Request $request, $id)
    {
        
            $permission = Permission::findOrFail($id);
            $this->validate($request, [
                'name' => 'required|unique:permissions,name,' . $permission->id,
            ]);

            $permission->name = $request->name;
            $permission->save();

            return redirect()->back()->with('success', 'Update permission successfully');
      
    }
    public function delete($id)
    {

       
            $permission = Permission::find($id);

            if ($permission == null) {
                $msg = [
                    'msg' => 'The permission is not found'
                ];
                return response()->json($msg, Response::HTTP_BAD_REQUEST);
            }
            $permission->delete();
            return redirect()->back()->with('success', `Delete {{$permission->name}} permission successfully`);
      
    }
}
