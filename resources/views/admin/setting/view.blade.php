@extends('admin.layouts.master')
@section('title', 'Settings')
@section('content')
    <x-back />
    <div class="row">
        <div class="col-lg-4 col-md-6 p-2">
            <x-form-view>
                <div class="">
                    <span class="font-bold text-primary word-wrap">General Setting</span>
                </div>
                <div class="">
                    <ul class="nav nav-tabs p-0 m-0 border-none d-flex flex-column text-uppercase font-bold" id="myTab"
                        role="tablist">
                        {{-- web setting --}}
                        <li class="nav-item justify-content-start" role="presentation">
                            <a class="nav-link word-wrap  w-100 border-none  text-dark active" id="home-tab"
                                data-bs-toggle="tab" href="#home" role="tab" aria-controls="home"
                                aria-selected="true">Website Setting</a>
                        </li>
                        {{-- web logo --}}
                        <li class="nav-item justify-content-start" role="presentation">
                            <a class="nav-link word-wrap  w-100 border-none  text-dark " id="logo-tab" data-bs-toggle="tab"
                                href="#logo" role="tab" aria-controls="logo" aria-selected="true">Website Logo</a>
                        </li>
                        {{-- seo setting --}}
                        <li class="nav-item justify-content-start" role="presentation">
                            <a class="nav-link word-wrap  w-100 border-none  text-dark" id="seo-tab" data-bs-toggle="tab"
                                href="#seo" role="tab" aria-controls="seo" aria-selected="true">Seo configuration</a>
                        </li>
                        {{-- google setting --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link word-wrap w-100 text-dark border-none " id="google-tab" data-bs-toggle="tab"
                                href="#google" role="tab" aria-controls="google" aria-selected="false">Social Login</a>
                        </li>
                        {{-- Contact Details --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link word-wrap w-100 text-dark border-none " id="contact-tab" data-bs-toggle="tab"
                                href="#contact" role="tab"  aria-controls="contact" aria-selected="false">Contact
                                Details</a>
                        </li>
                        {{-- Firm Details --}}
                        <li class="nav-item" role="presentation">
                            <a class="nav-link word-wrap w-100 text-dark border-none " id="firm-tab" data-bs-toggle="tab"
                                href="#firm" role="tab" aria-controls="firm" aria-selected="false">Firm Details</a>
                        </li>
                        {{-- email setting --}}
                        <div class="">
                            <span class="font-bold text-primary word-wrap">Email</span>
                        </div>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link word-wrap w-100 text-dark border-none " id="profile-tab" data-bs-toggle="tab"
                                href="#profile" role="tab" aria-controls="profile" aria-selected="false">Email
                                configuration</a>
                        </li>
                    </ul>
                </div>
            </x-form-view>
        </div>
        <div class="col-lg-8 col-md-6 p-2">
            <x-form-view>
                <div class="tab-content" id="myTabContent">
                    {{-- web setting --}}
                    <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Website Setting</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-1" extraClass="d-none" />
                                    @csrf
                                    <div class="">
                                        {{-- <div class="mb-2 d-flex flex-column">
                                            <input type="hidden" hidden name="maintance_mode" value="0">
                                            <input type="checkbox" hidden id="togglebtn1" class="toggleswitch"
                                                name="maintance_mode" value="1"
                                                {{ setting('maintance_mode') == 1 ? 'checked' : '' }}>
                                            <label for="togglebtn1" class="text-dark form-label">Maintance Mode</label>
                                            <label for="togglebtn1" class="togglelabel">
                                                <div class="outer-toogle position-relative d-flex align-items-center p-1">
                                                    <div class="position-absolute inner-toggle"></div>
                                                </div>
                                            </label>
                                        </div> --}}
                                        {{-- <span class="note text-danger"> Make sure you remmber this link to get access
                                            Maintenance mode before you active.</span> <br>
                                        <span class="text-primary word-wrap">{{ url('/maintenance/access') }}</span> --}}
                                    </div>

                                    <div class="">
                                        <div class="mb-2 d-flex flex-column">
                                            <input type="hidden" hidden name="header-sticky" value="0">
                                            <input type="checkbox" hidden id="header-sticky" class="toggleswitch"
                                                name="header-sticky" value="1"
                                                {{ setting('header-sticky') == 1 ? 'checked' : '' }}>
                                            <label for="header-sticky" class="text-dark form-label">Admin Header
                                                Sticky</label>
                                            <label for="header-sticky" class="togglelabel">
                                                <div class="outer-toogle position-relative d-flex align-items-center p-1">
                                                    <div class="position-absolute inner-toggle"></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <x-input type='text' id='primary-color' name='primary-color'
                                        label='Admin primary color' value="{{ setting('primary-color') }}" />
                                    <x-input type='text' id='btn-radius' name='btn-radius'
                                        label='Button Border Curve(px/%)' value="{{ setting('btn-radius') }}" />
                                    <x-input type='text' id='border-radius-menu' name='border-radius-menu'
                                        label='Menu Border Curve(px/%)' value="{{ setting('border-radius-menu') }}" />
                                    <x-input type='text' id='card-radius' name='card-radius'
                                        label='Card Border Curve(px/%)' value="{{ setting('card-radius') }}" />

                                    <x-input type='text' id='site_name' name='site_name' label='Site Name'
                                        value="{{ setting('site_name') }}" required />
                                    <x-input type='text' id='site_short_name' name='site_short_name'
                                        label='Site Short Name' value="{{ setting('site_short_name') }}" required />
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- web data --}}
                    <div class="tab-pane fade" id="logo" role="tabpanel" aria-labelledby="logo-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Website Logo</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="webData"
                                        id="action-1" extraClass="d-none" />
                                    <x-input label="action" type="hidden" name="id" value="{{ $websiteData->id }}"
                                        id="action-web-id" extraClass="d-none" />
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-6">
                                            <x-input-file fn="fetchFiles('image', '', 'BlogImage')" name="logo"
                                                id="BlogImage" value="{{ $websiteData->websitelogo }}"
                                                classPreview="d-block"
                                                src="{{ $websiteData->logo->external_link ?? '' }}"
                                                label="Website Logo" />
                                        </div>
                                        <div class="col-md-6">
                                            <x-input-file fn="fetchFiles('image', '', 'favicon')" name="favicon"
                                                id="favicon" value="{{ $websiteData->websitesmallogo }}"
                                                classPreview="d-block"
                                                src="{{ $websiteData->favicon->external_link ?? '' }}"
                                                label="Website Favicon" />
                                        </div>
                                    </div>
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- Seo setting --}}
                    <div class="tab-pane fade" id="seo" role="tabpanel" aria-labelledby="seo-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">SEO Configuration</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-1" extraClass="d-none" />
                                    @csrf
                                    <div class="">
                                        {{-- <div class="mb-2 d-flex flex-column">
                                            <input type="hidden" hidden name="maintance_mode" value="0">
                                            <input type="checkbox" hidden id="togglebtn1" class="toggleswitch"
                                                name="maintance_mode" value="1"
                                                {{ setting('maintance_mode') == 1 ? 'checked' : '' }}>
                                            <label for="togglebtn1" class="text-dark form-label">Maintance Mode</label>
                                            <label for="togglebtn1" class="togglelabel">
                                                <div class="outer-toogle position-relative d-flex align-items-center p-1">
                                                    <div class="position-absolute inner-toggle"></div>
                                                </div>
                                            </label>
                                        </div> --}}
                                        {{-- <span class="note text-danger"> Make sure you remmber this link to get access
                                            Maintenance mode before you active.</span> <br>
                                        <span class="text-primary word-wrap">{{ url('/maintenance/access') }}</span> --}}
                                    </div>
                                    <x-input type='text' id='site_title' name='site_title' label='Title'
                                        value="{{ setting('site_title') }}" required />

                                    <x-input type='text' id='site_keywords' name='site_keywords' label='keywords'
                                        value="{{ setting('site_keywords') }}" />


                                    <div class="mb-2">
                                        <x-textarea name="site_discription" label="site description"
                                            id="site_discription"
                                            rows="3">{{ setting('site_discription') }}</x-textarea>
                                    </div>
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- google setting --}}
                    <div class="tab-pane fade" id="google" role="tabpanel" aria-labelledby="google-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Social Login</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    @csrf
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-2" extraClass="d-none" />
                                    <div class="">
                                        <div class="mb-2 d-flex flex-column">
                                            <input type="hidden" hidden name="google_login" value="0">
                                            <input type="checkbox" hidden id="togglebtn2" class="toggleswitch"
                                                name="google_login" value="1"
                                                {{ setting('google_login') == 1 ? 'checked' : '' }}>
                                            <label for="togglebtn2" class="text-dark form-label">Google Login</label>
                                            <label for="togglebtn2" class="togglelabel">
                                                <div class="outer-toogle position-relative d-flex align-items-center p-1">
                                                    <div class="position-absolute inner-toggle"></div>
                                                </div>
                                            </label>
                                        </div>
                                    </div>
                                    <x-input type='text' id='google_client' name='google_client'
                                        label='Google Client Id' value="{{ setting('google_client') }}" required />
                                    <x-input type='text' id='google_seceret' name='google_seceret'
                                        label='Google Seceret Key' value="{{ setting('google_seceret') }}" required />
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- contact details --}}
                    <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Contact Details</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-3" extraClass="d-none" />
                                    @csrf
                                    <x-input type='text' id='site_email' name='site_email' label='E-mail'
                                        value="{{ setting('site_email') }}" />
                                    <x-input type='text' id='phone no.' name='site_phone' label='Phone No'
                                        value="{{ setting('site_phone') }}" />
                                    <x-input type='text' id='site_helpline' name='site_helpline' label='Helpline No'
                                        value="{{ setting('site_helpline') }}" />
                                    <x-input type='text' id='site_address' name='site_address' label='address'
                                        value="{!! setting('site_address') !!}" />
                                    <x-input type='text' id='site_state' name='site_state' label='state'
                                        value="{{ setting('site_state') }}" />
                                    <x-input type='text' id='site_city' name='site_city' label='city'
                                        value="{{ setting('site_city') }}" />
                                    <x-input type='text' id='site_zip' name='site_zip' label='Zip Code'
                                        value="{{ setting('site_zip') }}" />
                                    <x-input type='text' id='site_country' name='site_country' label='Country'
                                        value="{{ setting('site_country') }}" />
                                    <x-input type='text' id='Working Hour' name='working_hour' label='Working Hours'
                                        value="{{ setting('working_hour') }}" />
                                    <x-input type='text' id='footer_content' name='footer_content'
                                        label='footer content' value="{{ setting('footer_content') }}" />
                                    <span class="text-primary">Social Media Links</span>
                                    <x-input type='text' id='instagram' name='instagram' label='instagram'
                                        value="{{ setting('instagram') }}" />
                                    <x-input type='text' id='facebook' name='facebook' label='facebook'
                                        value="{{ setting('facebook') }}" />
                                    <x-input type='text' id='youtube' name='youtube' label='youtube'
                                        value="{{ setting('youtube') }}" />
                                    <x-input type='text' id='whatsapp' name='whatsapp' label='whatsapp'
                                        value="{{ setting('whatsapp') }}" />
                                    <x-input type='text' id='twitter' name='twitter' label='twitter'
                                        value="{{ setting('twitter') }}" />
                                    <x-input type='text' id='linkedin' name='linkedin' label='linkedin'
                                        value="{{ setting('linkedin') }}" />
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- email setting --}}
                    <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Email Configuration</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-4" extraClass="d-none" />
                                    @csrf
                                    <x-input type='text' id='mail_name' name='mail_name' label='Mail Name'
                                        value="{{ setting('mail_name') }}" required />
                                    <x-input type='text' id='mail_host' name='mail_host' label='smtp server'
                                        value="{{ setting('mail_host') }}" required />
                                    <x-input type='text' id='mail_port' value="{{ setting('mail_port') }}"
                                        name='mail_port' label='Mail Port' required />
                                    <x-select name="mail_encryption" label="Mail Encryption" id="mail_encryption">
                                        <x-option value="tls" text="TLS" :selected="setting('mail_encryption') == 'tls'" />
                                        <x-option value="ssl" text="SSL" :selected="setting('mail_encryption') == 'ssl'" />
                                    </x-select>
                                    <x-input type='text' id='mail_username' value="{{ setting('mail_username') }}"
                                        name='mail_username' label='Mail From' required />
                                    <x-input type='text' id='mail_password' name='mail_password'
                                        value="{{ setting('mail_password') }}" label='Mail Password' required />
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    {{-- firm setting --}}
                    <div class="tab-pane fade" id="firm" role="tabpanel" aria-labelledby="firm-tab">
                        <div class="p-3">
                            <div class="text-center">
                                <span class="text-primary font-bold text-center fs-5 word-wrap">Firm Setting</span>
                            </div>
                            <div class="">
                                <form action="{{ route('admin.settingAction') }}" method="POST">
                                    <x-input label="action" type="hidden" name="action" value="createUpdate"
                                        id="action-1" extraClass="d-none" />
                                    @csrf
                                    <x-input type='text' id='firm_name' name='' label='Firm Name'
                                        value="{{ setting('firm_name') }}" required />
                                    <x-input type='text' id='gst_no' name='gst_no' label='gst no'
                                        value="{{ setting('gst_no') }}" required />
                                    <x-input type='text' id='state' name='state' label='State'
                                        value="{{ setting('state') }}" required />
                                    <x-input type='text' id='email' name='email' label='email'
                                        value="{{ setting('email') }}" required />
                                    <x-input type='text' id='mobile' name='mobile' label='mobile no'
                                        value="{{ setting('mobile') }}" required />
                                    <x-input type='text' id='url' name='url' label='url'
                                        value="{{ setting('url') }}" required />
                                    <x-input type='text' id='toll_free_no' name='toll_free_no' label='toll_free_no'
                                        value="{{ setting('toll_free_no') }}" required />
                                    <x-input type='text' id='bank_name' name='bank_name' label='bank name'
                                        value="{{ setting('bank_name') }}" required />
                                    <x-input type='text' id='account_no' name='account_no' label='account no'
                                        value="{{ setting('account_no') }}" required />
                                    <x-input type='text' id='ifsc_code' name='ifsc_code' label='ifsc_code'
                                        value="{{ setting('ifsc_code') }}" required />
                                    <x-textarea name="address" label="address" value="{{ setting('address') }}"
                                        id="address">{{ setting('address') }}</x-textarea>
                                    <div class="w-100">
                                        <button class="btn btn-primary w-100 btn-rounded" type="submit">Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </x-form-view>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function() {
            const updateCSSVariable = (id, variableName) => {
                const value = $(`#${id}`).val();
                document.documentElement.style.setProperty(variableName, value || 'default');
            };

            $('#primary-color').on('input', function() {
                updateCSSVariable('primary-color', '--primary');
            });

            $('#btn-radius').on('input', function() {
                updateCSSVariable('btn-radius', '--btn-raduis');
            });

            $('#border-radius-menu').on('input', function() {
                updateCSSVariable('border-radius-menu', '--border-radius-menu');
            });

            $('#card-radius').on('input', function() {
                updateCSSVariable('card-radius', '--card-raduis');
            });
        });
    </script>
@endsection
