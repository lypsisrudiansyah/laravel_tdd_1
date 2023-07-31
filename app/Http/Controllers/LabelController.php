<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Http\Resources\LabelResource;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{

    public function index()
    {
        $labels = auth()->user()->labels;

        return response()->json($labels)->setStatusCode(200);
        // return LabelResource::collection($labels);
    }
    
    public function store(LabelRequest $request)
    {
        // return Label::create($request->validated());
        return auth()->user()->labels()->create($request->all());
    }

    public function update(Request $request, Label $label)
    {
        // $label->update($request->validated());
        $label->update($request->all());
        return response()->json($label)->setStatusCode(200);
    }

    public function destroy(Label $label)
    {
        $label->delete();
        return response()->json($label)->setStatusCode(204);
    }
}
