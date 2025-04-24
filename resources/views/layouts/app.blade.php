<!DOCTYPE html>
<html lang="en">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Book Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    <style type="text/tailwindcss">
        @layer utilities {
            .container {
                @apply px-12 mx-auto;
            }
        }
    </style>
    <style>
      [x-cloak] {
         display: none !important;
            }
      @media (max-width: 767px) {
         #content {
              margin-left: 0 !important;
              padding: 0 !important;
        }
      }
 </style>
 
</head>

<body class="min-h-screen bg-gray-100" x-data="{ open: true }">
    <!-- Navbar -->
    @include('layouts.navbar')

    <div class="flex flex-1">
        <!-- Sidebar -->
        @include('layouts.sidebar')
  
        <!-- Page Content -->
        <div id="content" class="flex-1 transition-all duration-300  ml-60">
            @yield('content')
        </div>
    </div>
</body>
</html>
