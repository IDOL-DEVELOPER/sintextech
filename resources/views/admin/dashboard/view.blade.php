@extends('admin.layouts.master')

@section('title', 'DashBoard')

@section('content')
    @php
        // Capture PHP info
        ob_start();
        phpinfo(INFO_GENERAL);
        $phpinfo = ob_get_clean();

        // Extract PHP version
        preg_match('/PHP Version\s+([\d\.]+)/', $phpinfo, $matches);
        $php_version = $matches[1] ?? 'N/A';

        // Function to extract specific details
        function getPhpInfoDetail($phpinfo, $label)
        {
            preg_match('/' . preg_quote($label, '/') . '.*<td.*>(.*?)<\/td>/s', $phpinfo, $matches);
            return $matches[1] ?? 'N/A';
        }

        // Extract other details from phpinfo output
        $build_date = getPhpInfoDetail($phpinfo, 'Build Date');
        $build_system = getPhpInfoDetail($phpinfo, 'Build System');
        $compiler = getPhpInfoDetail($phpinfo, 'Compiler');
        $architecture = getPhpInfoDetail($phpinfo, 'Architecture');
        $configure_command = getPhpInfoDetail($phpinfo, 'Configure Command');
        $server_api = getPhpInfoDetail($phpinfo, 'Server API');
        $virtual_directory_support = getPhpInfoDetail($phpinfo, 'Virtual Directory Support');
        $config_file_path = getPhpInfoDetail($phpinfo, 'Configuration File \(php.ini\) Path');
        $loaded_config_file = getPhpInfoDetail($phpinfo, 'Loaded Configuration File');
        $upload_max_filesize = ini_get('upload_max_filesize');
        $post_max_size = ini_get('post_max_size');
        $memory_limit = ini_get('memory_limit');
        $max_execution_time = ini_get('max_execution_time');
        $max_input_vars = ini_get('max_input_vars');
        $max_file_uploads = ini_get('max_file_uploads');
    @endphp

    <div class="container">
        <h1>PHP Configuration Details</h1>
        <ul>
            <li><strong>PHP Version:</strong> {{ $php_version }}</li>
            <li><strong>Upload Max Size</strong> {{ $upload_max_filesize }}</li>
            <li><strong>Build System:</strong> {{ $build_system }}</li>
            <li><strong>Compiler:</strong> {{ $compiler }}</li>
            <li><strong>Architecture:</strong> {{ $architecture }}</li>
            <li><strong>Configure Command:</strong> {{ $configure_command }}</li>
            <li><strong>Server API:</strong> {{ $server_api }}</li>
            <li><strong>Virtual Directory Support:</strong> {{ $virtual_directory_support }}</li>
            <li><strong>Configuration File Path:</strong> {{ $config_file_path }}</li>
            <li><strong>Loaded Configuration File:</strong> {{ $loaded_config_file }}</li>
        </ul>
    </div>

    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#KVUploaderModal">Upload</button>
@endsection
