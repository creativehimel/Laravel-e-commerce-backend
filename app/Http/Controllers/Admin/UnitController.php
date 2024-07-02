<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class UnitController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $units = Unit::orderBy('id', 'desc');
            if ($request->status != null) {
                $units = $units->where('status', $request->status);
            }
            $units = $units->get();
            return DataTables::of($units)
                ->addIndexColumn()
                ->addColumn('status', function ($unit) {
                    if ($unit->status == 1) {
                        return '<span class="badge bg-success changeStatus cursor-pointer" data-id="'.$unit->id.'">Active</span>';
                    } else {
                        return '<span class="badge bg-danger changeStatus cursor-pointer" data-id="'.$unit->id.'">Inactive</span>';
                    }
                })
                ->addColumn('created_at', function ($unit) {
                    return $unit->created_at->format('d-m-Y');
                })
                ->addColumn('action', function ($unit) {
                    $html = '<a href="'.route('units.edit',
                            $unit->id).'" class="btn btn-sm btn-primary me-2"><i class="ti ti-edit"></i></a>';
                    $html .= '<button type="button" class="btn btn-danger btn-sm deleteUnit" data-id="'.$unit->id.'"> <i class="ti ti-trash"></i> </button>';
                    return $html;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
        return view('backend.unit.index');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:units,name',
            'slug' => 'required',
            'status' => 'required',
        ]);

        Unit::create($data);

        toastr()->success('Unit added successfully');
        return redirect()->route('units.index');
    }

    public function create()
    {
        return view('backend.unit.create');
    }

    public function edit(Unit $unit)
    {
        return view('backend.unit.edit', compact('unit'));
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
    }

    public function changeStatus($id)
    {
        $unit = Unit::find($id);
        if ($unit->status == 1) {
            $unit->update(['status' => 0]);
        } else {
            $unit->update(['status' => 1]);
        }
    }

    public function update(Request $request, Unit $unit)
    {
        $data = $request->validate([
            'name' => 'required|unique:units,name,'.$unit->id,
            'slug' => 'required',
            'status' => 'required',
        ]);
        $unit->update($data);
        toastr()->success('Unit updated successfully');
        return redirect()->route('units.index');
    }

}
