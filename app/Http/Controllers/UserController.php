<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class UserController extends Controller
{
   
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.modal');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required'],
            'status' => ['required'],
            'password' => ['required'],
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            
            DB::beginTransaction();
            $data = $request->except('password');
            $data['password'] = Hash::make($request->password);
            $user = User::create($data);
            DB::commit();
            event(new Registered($user));
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'User Added successfully.'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show(User $user)
    {
        return view('users.show',compact('user'));
    }

    public function edit(User $user)
    {   
        return view('users.modal',compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
            'phone' => ['required'],
            'status' => ['required'],
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {            
            $data = $request->except(['_token','_method']);
            DB::beginTransaction();
            $user->update($data);
            DB::commit();

            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Product Updated successfully.'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            DB::rollBack();   
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Product deleted successfully'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function dataTable()
    {
        
        $dt = DataTables::of(User::where('user_type',User::User)->get());

        $dt->editColumn('status', function ($record) {
            return '<span class="badge badge-dot badge-dot-xs badge-' . statusClasses($record->status) . '">' . ucfirst($record->status ? 'active' : 'inactive') . '</span>';
        });

        $dt->editColumn('user_type', function ($record) {
            return ucfirst($record->user_type);
        });

        if (auth()->user()->hasRole('admin')) {
            $dt->addColumn('actions', function ($record) {
                    $action = '<div>';
                    $action .= '<a href="' . route('dashboard.users.show', $record->id) . '"
                        title="View Detail" class="btn btn-soft-success btn-sm mr-2 ml-2">
                        <i class="uil-eye"></i>
                    </a>';
                    
                    $action .= '<a href="javascript:void(0);" class="btn btn-soft-warning btn-sm mr-2" title="Edit User" data-act="ajax-modal"
                                    data-method="get" data-title="Edit User" data-action-url="' . route('dashboard.users.edit', $record->id) . '">
                                    <i class="uil uil-edit"></i>
                                </a>';
                
                    $action .= '<a href="javascript:void(0);" class="btn btn-soft-danger btn-sm mr-2 delete" title="Delete User"
                    data-url="'.route('dashboard.users.destroy',$record->id).'" data-table="stores-table">
                    <i class="uil uil-trash"></i>
                    </a>'; 
                    $action .= '</div>';
                    return $action;
            });
        }

        $dt->rawColumns(['status', 'actions']);

        $dt->addIndexColumn();

        return $dt->make(true);
    }
}
