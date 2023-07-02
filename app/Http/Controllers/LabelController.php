<?php

namespace App\Http\Controllers;

use App\Http\Requests\LabelRequest;
use App\Models\Label;
use Illuminate\Http\Request;

class LabelController extends Controller
{
    public function store(LabelRequest $request)
    {
        return Label::create($request->validated());
    }

    public function update(LabelRequest $request, Label $label)
    {
        $label->update($request->validated());
        return response()->json($label)->setStatusCode(200);
    }
}
