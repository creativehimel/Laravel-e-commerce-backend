<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {

        if ($request->ajax()) {
            $brands = Brand::orderBy('id', 'desc');
            if ($request->status != null) {
                $brands = $brands->where('status', $request->status);
            }
            $brands = $brands->get();
            return DataTables::of($brands)
                ->addIndexColumn()
                ->addColumn('status', function ($brand) {
                    if ($brand->status == 1) {
                        return '<span class="badge bg-success changeStatus" data-id="'.$brand->id.'">Active</span>';
                    } else {
                        return '<span class="badge bg-danger changeStatus" data-id="'.$brand->id.'">Inactive</span>';
                    }
                })
                ->addColumn('created_at', function ($brand) {
                    return $brand->created_at->format('d-m-Y');
                })
                ->addColumn('image', function ($brand) {
                    return '<img src="'.asset('uploads/brands/'.$brand->image).'" alt="'.$brand->name.'" width="50">';
                })
                ->addColumn('action', function ($brand) {
                    $html = '<a href="'.route('brands.edit',
                            $brand->id).'" class="btn btn-sm btn-primary me-2"><i class="ti ti-edit"></i></a>';
                    $html .= '<button type="button" class="btn btn-danger btn-sm deleteBrand" data-id="'.$brand->id.'"> <i class="ti ti-trash"></i> </button>';
                    return $html;
                })
                ->rawColumns(['status', 'image', 'action'])
                ->make(true);
        }
        return view('backend.brand.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:brands,name',
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = 'brands-'.time().'.'.$image->getClientOriginalExtension();
            $destination = public_path('/uploads/brands/');
            $image->move($destination, $image_name);
            $data['image'] = $image_name;
        }
        Brand::create($data);
        toastr()->success('Brand created successfully');
        return redirect()->route('brands.index');
    }

    public function create()
    {
        return view('backend.brand.create');
    }

    public function edit(Brand $brand)
    {
        return view('backend.brand.edit', compact('brand'));
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
    }

    public function changeStatus($id)
    {
        $brand = Brand::find($id);
        if ($brand->status == 1) {
            $brand->update(['status' => 0]);
        } else {
            $brand->update(['status' => 1]);
        }
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|unique:brands,name,'.$brand->id,
            'slug' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required',
        ]);

        $data = [
            'name' => $request->name,
            'slug' => $request->slug,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'status' => $request->status
        ];

        if ($request->hasFile('image')) {
            if ($request->old_image) {
                unlink(public_path('uploads/brands/'.$request->old_image));
            }
            $image = $request->file('image');
            $image_name = 'brands-'.time().'.'.$image->getClientOriginalExtension();
            $destination = public_path('/uploads/brands/');
            $image->move($destination, $image_name);
            $data['image'] = $image_name;
        }
        $brand->update($data);
        toastr()->success('Brand updated successfully');
        return redirect()->route('brands.index');
    }


}
