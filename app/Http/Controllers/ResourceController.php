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
        $body = $this->ResourceValidate($request);
        try{
            

            if($request->hasFile('pdf')) {
                $pdf = $request->file('pdf');
                $body['pdf']= $this->uploadfile($pdf);
            }

            $resource = Resource::create($body);
            return redirect()->route('admin');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function update(Request $request, Resource $resource)
    {
        $body = $this->ResourceValidate($request);
        try{

            if($request->hasFile('pdf')) {
               $body['pdf']= $this->uploadfile($request->file('pdf'));
            }
            $resource->update($body);

            return redirect()->route('admin');    
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function destroy(Resource $resource)
    {
        try{
            $resource->delete();
            return redirect()->route('admin');
        }catch(\Exception $e){
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function ResourceValidate($request)
    {
        return $request->validate([
            'title' => ['required'],
            'description' => ['required'],
            'type' => ['required'],
            'pdf' => ['nullable','required_if:type,==,pdf', 'mimes:pdf'],
            'url' => ['required_if:type,==,url' ],
            'html' => ['required_if:type,==,html'],
            'new_tab' => 'nullable',
        ]);
    }

    public function uploadfile($file){
        $pdf = $file;
        $pdfName = "pdf/".time() . '.' . $pdf->getClientOriginalExtension();
        Storage::disk('public')->put($pdfName, File::get($pdf));
        return Storage::url($pdfName);
    }

}
