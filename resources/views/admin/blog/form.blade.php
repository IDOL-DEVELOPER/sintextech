@extends('admin.layouts.master')
@section('title', 'Blogs')
@section('content')
    <x-back class="mb-2" />
    <x-form-view title="Blog">
        <form action="{{ route('admin.blogAction') }}" method="post">
            <div class="row">
                <div class="col-md-4">
                    <div class="text-center mb-2">
                        <span class="font-bold">Categories</span>
                    </div>
                    <ul class="overflow-auto bg-light card-rounded" style="max-height: 500px">
                        @foreach ($categories as $item)
                            @php
                                $selectedCategories = [];
                                if ($blog->id) {
                                    $selectedCategories = $blog->categories->pluck('id')->toArray();
                                }
                                $isChecked = in_array($item->id, $selectedCategories) ? 'checked' : '';

                            @endphp
                            <div class="d-flex align-items-center">
                                <label for="categories-{{ $item->id }}"
                                    class="font-bold mt-1 custom-checkbox-label position-relative me-4 pointer">
                                    <input type="checkbox" name="categories[]" value="{{ $item->id }}"
                                        class="custom-checkbox d-none" id="categories-{{ $item->id }}" {{$isChecked}} />&nbsp;
                                    <span class="checkbox-custom me-3">
                                    </span>
                                </label>
                                <label for="categories-{{ $item->id }}" class="mt-2 pointer">
                                    <span class="font-bold text-black">
                                        {{ $item->name }}
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-8">
                    @csrf
                    <x-input type="hidden" label="id" name="id" value="{{ $blog->id }}" extraClass="d-none"
                        old />
                    <x-input type="hidden" extraClass="d-none" value="{{ $blog->id ? 'update' : 'create' }}" label="action"
                        name="action" />
                    <div class="row">
                        <div class="col-md-6">
                            {{-- <x-input type="file" name="image" attr="accept=image/*" id="file" attr="accept="
                                label="Image" /> --}}
                            <x-input-file fn="fetchFiles('image', '', 'BlogImage')"
                                classPreview="{{ $blog->id ? 'd-block' : 'd-none' }}" name="image" id="BlogImage"
                                value="{{ $blog->image_id }}" src="{{ $blog->upload->external_link ?? '' }}"
                                label="Image" />
                        </div>
                        <div class="col-md-6">
                            <x-input type="text" attr="max=255" name="title" value="{{ $blog->title ?? '' }}"
                                id="title" label="title" required />
                        </div>
                        <div class="">
                            <x-input label="content" id="content" type="text" value="{{ $blog->content }}"
                                name="content" required />
                        </div>
                        <div class="col-md-4">
                            <x-textarea label="Brief Description" value="{{ $blog->brief }}" name="breif_description"
                                cols="1" rows="1" id="brief">{{ $blog->brief }}</x-textarea>
                        </div>
                        <div class="col-md-4">
                            <x-input type="text" name="tags" id="tags" value="{{ $blog->tags ?? '' }}"
                                label="tags" />
                        </div>
                        <div class="col-md-4">
                            <x-input type="text" id="meta_key" name="meta_keywords" label="meta keywords"
                                value="{{ $blog->meta_key }}" />
                        </div>
                        <div class="col-md-4">
                            <x-input type="text" name="meta_title" id="meta_title" value="{{ $blog->meta_title ?? '' }}"
                                label="meta title" />
                        </div>
                        <div class="col-md-4">
                            <x-textarea label="meta Description" value="{{ $blog->meta_desc }}" name="meta_description"
                                cols="1" rows="1" id="meta_desc">{{ $blog->meta_desc }}</x-textarea>
                        </div>
                        <div class="col-md-4">
                            <x-select id="status" name="status" label="status">
                                <x-option value="1" text="Publish" :selected="$blog->status == 1" />
                                <x-option value="0" text="Draft" :selected="$blog->status == 0" />
                            </x-select>
                        </div>
                    </div>
                    <div class="w-100">
                        <x-submit-btn class="w-100" />
                    </div>
                </div>
            </div>
        </form>
    </x-form-view>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            @if ($blog->content)
                $('#content').summernote('code', @json($blog->content));
            @endif
            $('#content').summernote({
                placeholder: 'Description',
                tabsize: 2,
                height: 120,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'underline', 'clear']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', []]
                ],
                callbacks: {
                    onChange: function(contents, $editable) {
                        $('#content').val(contents);
                    }
                }
            });
            $('.note-btn[data-toggle="dropdown"]').each(function() {
                $(this).attr('data-bs-toggle', 'dropdown').removeAttr('data-toggle');
            });
        });
    </script>
@endsection
