@livewireScripts
{{-- jquery --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
    integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.js"
    integrity="sha512-eSeh0V+8U3qoxFnK3KgBsM69hrMOGMBy3CNxq/T4BArsSQJfKVsKb5joMqIPrNMjRQSTl4xG8oJRpgU2o9I7HQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/@eonasdan/tempus-dominus@6.9.4/dist/js/tempus-dominus.min.js"
    crossorigin="anonymous"></script>


<script>
    $(".cms").chosen({
        allow_single_deselect: true,
        no_results_text: "No results matched"
    });
    document.addEventListener('DOMContentLoaded', function() {
        const elements = document.querySelectorAll('[data-time]');

        Array.from(elements).forEach(function(element) {
            new tempusDominus.TempusDominus(element, {
                display: {
                    components: {
                        calendar: true,
                        date: true,
                        month: true,
                        year: true,
                        decades: true,
                        clock: true,
                        hours: true,
                        minutes: true,
                        seconds: false,
                        useTwentyfourHour: undefined
                    },
                    inline: false,
                    theme: 'auto'
                }
            });
        });
    });
</script>
{{-- editor --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js" integrity="sha512-6F1RVfnxCprKJmfulcxxym1Dar5FsT/V2jiEUvABiaEiFWoQ8yHvqRM/Slf0qJKiwin6IDQucjXuolCfCKnaJQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
{{-- apx chart --}}
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

{{-- custom script --}}
<script src="{{ asset('js/admin/script.js') }}"></script>
<script src="{{ asset('js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('js/admin/theme.js') }}"></script>
<script src="{{ asset('js/uploader.js') }}"></script>
<script src="{{ asset('js/cropper.js') }}"></script>
<script src="{{ asset('js/sw.js') }}"></script>
<script src="{{ asset('js/webcam.min.js') }}"></script>
<script type="module" src="{{ asset('js/admin/module.js') }}"></script>
@if (session('keepModalOpen'))
    <script>
        $(document).ready(function() {
            $('#openModal').modal('show');
        });
    </script>
@endif
