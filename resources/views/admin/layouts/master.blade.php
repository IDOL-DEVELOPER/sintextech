<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    @include('admin.layouts.style')
</head>

<body class="" id="body">
    <div class="container-fluid m-0 p-0 overflow-x-hidden" id="scrollbar">
        <div class="row g-0">
            <div class="position-fixed sidebar overflow-hidden card-rounded" id="sidebar">
                {{-- sidebar --}}
                @include('admin.layouts.sidebar')
            </div>
            <div class="main-content position-absolute" id="main-content">
                @include('admin.layouts.navbar')
                <div class="content p-3 py-5" id="csroll">
                    @yield('content')
                </div>
               <div class="px-3">
                    <footer class="bg-csub py-3  rounded-top-4">
                        <div class="text-center font-bold fs-14">
                            Design And Developed By@ <a href="https://www.linkedin.com/in/vikash-kumar-bishnoi">Vikas
                                Kumar
                                Bishnoi</a>
                        </div>
                    </footer>
                </div>
                <x-error-component />
            </div>
        </div>
    </div>
    @include('admin.layouts.modal')
    @include('admin.layouts.rightside')
    @include('uploader.view')
    @access('delete')
        @livewire('confirm-modal')
    @endaccess
    {{-- script --}}
    @include('admin.layouts.script')
    <script>
        new PerfectScrollbar("#asideforscroll");
    </script>
    @yield('script')
</body>

</html>
<script>
    document.getElementById('main-content').addEventListener('scroll', function() {
        var mainContent = this;
        let nav = document.getElementById('navbarmainfor');
        if (mainContent.scrollTop > 0) {
            nav.classList.add('shadow');
        } else {
            nav.classList.remove('shadow');
        }
    });
    if (window.innerWidth > 768) {
        const mainContent = document.getElementById('main-content');
        new PerfectScrollbar(mainContent, {
            wheelPropagation: true,
            suppressScrollX: false
        });
    }
</script>
