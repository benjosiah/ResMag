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
                <router-link to="/" class="text-2xl font-bold text-gray-800">
                    Rosource Managemer
                </router-link>
            </div>
        </div>
    </header>
    @yield('content')

    <script>

        function copyToClipboard(text) {
            var dummy = document.createElement("textarea");
            document.body.appendChild(dummy);
            dummy.value = text;
            dummy.select();
            document.execCommand("copy");
            document.body.removeChild(dummy);
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
    </script>
</body>
</html>
