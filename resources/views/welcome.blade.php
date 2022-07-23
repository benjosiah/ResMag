@extends('layouts.main')
@section('content')
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-10 mt-10 mx-auto">
            <h1 class="text-2xl font-bold text-gray-800">
                Resource list
            </h1>
        </div>

        <div class="flex justify-between items-center mb-10 mt-10 mx-auto">
            <div class="flex items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    Filter by type
                </h2>
            </div>
            <div class="flex items-center">
                <select id="filter" value="pdf" class="w-full h-10 p-2 bg-white border border-gray-400 rounded-lg" onchange="filterResource(this.options[this.selectedIndex].value)">
                    <option value="" {{$filter==''?'selected':''}}>All</option>
                    <option value="pdf" {{$filter=='pdf'?'selected':''}} >PDF</option>
                    <option value="html" {{$filter=='html'?'selected':''}}>HTML</option>
                    <option value="url" {{$filter=='url'?'selected':''}}>URL</option>
                </select>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($resources as $resource)
                <div class="bg-white shadow-lg rounded-lg p-10">
                    <div class="flex justify-between items-center">
                        <h2 class="text-2xl font-bold text-gray-800">
                          {{$resource->title}}
                        </h2>
                        <div class="flex items-center">
                            <span class="p-2 bg-blue-600 rounded text-white ">
                                {{$resource->type}}
                            </span>
                        </div>
                    </div>
                    <div class="w-full mt-2 rounded ">
                        <p class="text-gray-800 p-1">
                            {{$resource->description}}
                        </p>
                    </div>
                    @if ($resource->type == 'url')
                        <div onclick="openUrl(`{{$resource->url}}`, `{{$resource->new_tab}}`)"  class="text-center cursor-pointer text-gray-100 bg-gray-900 w-full p-2 mt-1 font-mono relative">
                            <span>
                                {{substr($resource->url,0, 20)}}..
                            </span>
                            <button class=" absolute bg-transparent text-white p-1 rounded-full right-1">
                                <i class="fas fa-link"></i>
                            </button>
                        </div>
                    @endif
                    @if ($resource->type == 'html')
                        <div class="text-center text-gray-100 bg-gray-900 w-full p-2 mt-1 font-mono relative">
                            <span class="cursor-pointer"  onclick="copyToClipboard(`{{$resource->html}}`)" >
                                {{$resource->html}}
                            </span>
                            <button onclick="copyToClipboard(`{{$resource->html}}`)"  class=" absolute bg-transparent text-white p-1 rounded-full right-1" >
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    @endif
                    @if ($resource->type == 'pdf')
                        @php
                            $pdf = $resource->pdf;
                            $pdf_name = explode('/', $pdf);
                            $pdf_name = end($pdf_name);
                            if(strpos($resource->pdf, 'http') !== false){
                                $data = file_get_contents($resource->pdf);
                                $base64 = base64_encode($data);
                                $pdf = 'data:application/pdf;base64,'.$base64;
                            }
                        @endphp
                        <div  class="text-center text-gray-100 bg-gray-900 w-full p-2 mt-1 font-mono relative">
                            <a href="{{$pdf}}" download="{{$pdf_name}}">
                                <span class="w-28 h-10">
                                    PDF<i class="fa-regular fa-file-pdf"></i>
                                </span>
                                <button class=" absolute bg-transparent text-white p-1 rounded-full right-1">
                                    <i class="fas fa-download"></i>
                                </button>
                            </a>
                        </div>
                    @endif

                    
                </diiv>
            </div>
            @endforeach
        
        </div>

    </div>

    @endsection