<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class ResourceController extends Controller
{


    public function store(Request $request)
    {
       $body = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'pdf' => ['nullable','required_if:type,==,pdf', 'mimes:pdf'],
            'url' => ['required_if:type,==,url' ],
            'html' => ['required_if:type,==,html'],
            'new_tab' => 'nullable',
        ]);

        if($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfName = "pdf/".time() . '.' . $pdf->getClientOriginalExtension();
            Storage::disk('public')->put($pdfName, File::get($pdf));
            $body['pdf'] = Storage::url($pdfName);
        }

        $resource = Resource::create($body);
        return redirect()->route('admin');
    }

    public function update(Request $request, Resource $resource)
    {
        $body = $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'pdf' => ['required_if:type,==,pdf', 'mimes:pdf'],
            'url' => ['required_if:type,==,url' ],
            'html' => ['required_if:type,==,html'],
            'new_tab' => 'nullable',
        ]);

        if($request->hasFile('pdf')) {
            $pdf = $request->file('pdf');
            $pdfName = "pdf/".time() . '.' . $pdf->getClientOriginalExtension();
            Storage::disk('public')->put($pdfName, File::get($pdf));
            $body['pdf'] = Storage::url($pdfName);
        }
        $rr = $resource->update($body);

        return redirect()->route('admin');    }

    public function destroy(Resource $resource)
    {
        $resource->delete();
        return redirect()->route('admin');
    }

}
