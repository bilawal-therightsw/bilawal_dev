<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        return view('products.index');
    }

    public function create()
    {
        return view('products.modal');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'status' => ['required']
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }

        try {
            $data = $request->except('image');
            if($request->hasFile('image')){
                $data['image'] = saveResizeImage( $request->image,'images/products',550);
            }
            Product::create($data);
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Product Added successfully.'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function show($id)
    {
        $product = Product::find($id);
        return view('products.show',compact('product'));
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            return view('products.modal', compact('product'));
        } catch (\Exception $e) {
            return response()->json([
                'status' => JsonResponse::HTTP_INTERNAL_SERVER_ERROR,
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => ['required'],
            'description' => ['required'],
            'price' => ['required'],
            'status' => ['required']
        ];

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => JsonResponse::HTTP_UNPROCESSABLE_ENTITY,
                'message' => $validator->errors()->first()
            ], JsonResponse::HTTP_UNPROCESSABLE_ENTITY);
        }
        try {
            
            $data = $request->except(['_token','_method','image']);
            $product = Product::findOrfail($id);
            if($request->hasFile('image')){
               
                $data['image'] = saveResizeImage( $request->image,'images/products',550);
                if(File::exists($product->image)) {
                    File::delete($product->image);
                }
            }
           
            $product->update($data);
           
            return response()->json([
                'status' => JsonResponse::HTTP_OK,
                'message' => 'Product Updated successfully.'
            ], JsonResponse::HTTP_OK);
        } catch (\Exception $e) {
         
            return response()->json([
                'message' => $e->getMessage()
            ], JsonResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
 
    public function destroy($id)
    {
        try {
            $product = Product::findOrFail($id);
            if(File::exists($product->image)) {
                File::delete($product->image);
            }
            $product->delete();
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
        
        $dt = DataTables::of(Product::all());

        $dt->editColumn('status', function ($record) {
            return '<span class="badge badge-dot badge-dot-xs badge-' . statusClasses($record->status) . '">' . ucfirst($record->status ? 'active' : 'inactive') . '</span>';
        });

        if (auth()->user()->hasRole('staff|admin')) {
            $dt->addColumn('actions', function ($record) {
                $action = '<div>';
                $action .= '<a href="' . route('dashboard.products.show', $record->id) . '"
                    title="View Detail" class="btn btn-soft-success btn-sm mr-2 ml-2">
                    <i class="uil-eye"></i>
                </a>';
                $action .= '<a href="javascript:void(0);" class="btn btn-soft-warning btn-sm mr-2" title="Edit products" data-act="ajax-modal"
                                data-method="get" data-title="Edit Products" data-action-url="' . route('dashboard.products.edit', $record->id) . '">
                                <i class="uil uil-edit"></i>
                            </a>';
                if (auth()->user()->hasRole('admin')) {
                    $action .= '<a href="javascript:void(0);" class="btn btn-soft-danger btn-sm mr-2 delete" title="Delete Product"
                    data-url="'.route('dashboard.products.destroy',$record->id).'" data-table="stores-table">
                    <i class="uil uil-trash"></i>
                    </a>'; 
                }
                $action .= '</div>';
                return $action;
            });
        }

        $dt->rawColumns(['status', 'actions']);

        $dt->addIndexColumn();

        return $dt->make(true);
    }
}
