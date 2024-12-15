<div>
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
        </div>
    @endif
    <!-- Display Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0 list-style-none">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        $selectedLoginType = session('loginType');
    @endphp
    <form action="{{ route('login.post') }}" method="POST">
        @csrf
        <x-input type='email' name='email' id='AdminLoginEmail' label='Email' old required />
        <x-input type='password' name='password' id='AdminLoginPassword' label='Password' required />
        <div class="row mb-3 align-items-center">
            <div class="col-auto">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember me</label>
                </div>
            </div>
            <div class="col text-end">
                <a href="{{ route('password.forgot') }}" class="text-decoration-none">Forgot password?</a>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>
