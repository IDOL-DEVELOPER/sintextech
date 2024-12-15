<div class="">
    @if ($errors->any())
        @error('error')
            <div class="toast-alert {{ $errors->has('error') ? ' show' : '' }}" role="alert" aria-live="assertive"
                aria-atomic="true">
                <div class="toast-content">
                    <i class="fas fa-solid fa-circle-exclamation check bg-danger"></i>
                    <div class="message">
                        <span class="text text-1 text-danger">Error</span>
                        <span class="text text-2">{{ $message }}</span>
                    </div>
                </div>
                <i class="fa-solid fa-xmark close " data-close-btn aria-label="Close"></i>
                <div class="progress {{ $errors->has('error') ? ' active' : '' }}"></div>
            </div>
        @enderror
    @elseif (session('success') || session()->has('success'))
        <div class="toast-alert show" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-content">
                <i class="fas fa-solid fa-check check bg-success"></i>
                <div class="message">
                    <span class="text text-1 text-success">Success</span>
                    <span class="text text-2"> {{ session('success') }}</span>
                </div>
            </div>
            <i class="fa-solid fa-xmark close " data-close-btn aria-label="Close"></i>
            <div class="pr progress active"></div>
        </div>
    @endif
</div>

<div class="" id="alertmessage">
</div>
