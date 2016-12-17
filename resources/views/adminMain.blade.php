<!DOCTYPE html>
<html lang="en">
    <head>

    @include('partials._head')
        
    </head>
    <body>

        @include('partials._adminNav')
    
        <div class="container">

            @include('partials._messages')

            @yield('content')

        </div>
            <br>
            <br>
            <br>

        @include('partials._footer') 

        @include('partials._javascript') 

        @yield('scripts')

    </body>
</html>

