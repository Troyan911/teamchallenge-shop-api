<?php

namespace App\Http\Controllers\AdminPanel;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Inertia\Inertia;
class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('AddColor', [
            'listAllColors' => Color::all()
                ->map(function ($color) {
                    return [
                        'color_id'=>$color->id,
                        'color' => $color->name,
                        'hex_code' => $color->hex_code
                    ];
                })
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $newColor = new Color();
        $newColor->name = strtolower($request->get('colorName'));
        $newColor->hex_code = $request->get('hexCode');
        $newColor->save();

        return redirect()->back()->with([
            'message' => 'The color has been added successfully',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $itemDelete=Color::find($id);
        $itemDelete->delete();
        return redirect()->back()->with([
            'message' => 'The color has been deleted successfully',
        ]);
    }
}
