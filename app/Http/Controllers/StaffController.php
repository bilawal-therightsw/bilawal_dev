<?php
namespace App\Http\Controllers;

use Yajra\DataTables\Facades\DataTables;
use App\Models\User;

class StaffController extends Controller
{
   
    public function index()
    {
        return view('staff.index');
    }

   
    public function datatable()
    {
        $dt = DataTables::of(User::where('user_type',User::Staff)->get());

        $dt->editColumn('status', function ($record) {
            return '<span class="badge badge-dot badge-dot-xs badge-' . statusClasses($record->status) . '">' . ucfirst($record->status ? 'active' : 'inactive') . '</span>';
        });

        $dt->editColumn('user_type', function ($record) {
            return ucfirst($record->user_type);
        });

 

        $dt->rawColumns(['status']);

        $dt->addIndexColumn();

        return $dt->make(true);

    }
}
