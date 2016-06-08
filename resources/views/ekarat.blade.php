
<!DOCTYPE html>
<html>
@include('includes.head')
<body>
@include('includes.menu')
@include('includes.header')
<div id="saveimg">
@include('includes.page_head')
@yield('content')
</div>
@yield('script')
</body>
</html>
@include('includes.end_script')