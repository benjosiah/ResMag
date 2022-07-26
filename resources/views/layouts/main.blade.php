<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet" />
    <script src="{{ mix('/js/app.js') }}" defer></script>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title> @yield('title') </title>
</head>
<body class="bg-gray-100">
    <header class="w-full h-32 bg-white shadow-md pt-10">
        <div class="container mx-auto flex justify-between items-center">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-gray-800">
                    Rosource Managemer
                </a>
            </div>
        </div>
    </header>
    @yield('content')

    <script>

        function copyToClipboard(text) {
            console.log(text);
            var dumptext = document.createElement("textarea");
            document.body.appendChild(dumptext);
            dumptext.value = `${text}`;
            dumptext.select();
            document.execCommand("copy");
            document.body.removeChild(dumptext);
            alert("Copied the text: " + text);
        }
        var filter = document.getElementById('filter').value
        function filterResource(type) {
            if(type == ''){
                window.location.href = '/'
            }else{
                window.location.href = `/?filter=${type}`       
            }
        }
        function openUrl(url, is_blank){
            window.open(url, is_blank ? '_blank' : '_self')
        }
    </script>
</body>
</html>
