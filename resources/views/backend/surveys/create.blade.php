@extends("layouts.main-body")
@section('toolbar')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Account Management
                    <small class="text-muted fs-6 fw-normal ms-1"></small></h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark">Users</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->
        </div>
    </div>
@endsection
@section("page")
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissable">
            <strong>Oh snap!</strong><br>
            @foreach ($errors->all() as $error)
                {{ $error }}.<br>
            @endforeach
        </div>
    @endif
    <!--begin::Main-->
    <div class="d-flex flex-column flex-lg-row">
        <!--begin::Aside-->
        <div class="flex-column flex-md-row-auto w-100 w-lg-250px w-xxl-275px">
            <!--begin::Nav-->
            <div class="card mb-6 mb-xl-9" data-kt-sticky="true" data-kt-sticky-name="account-settings"
                 data-kt-sticky-offset="{default: false, lg: 300}" data-kt-sticky-width="{lg: '250px', xxl: '275px'}"
                 data-kt-sticky-left="auto" data-kt-sticky-top="100px" data-kt-sticky-zindex="95">
                <!--begin::Card body-->
                <div class="card-body py-10 px-6">
                    <!--begin::Menu-->
                    <ul id="kt_account_settings"
                        class="nav nav-flush menu menu-column menu-rounded menu-title-gray-600 menu-bullet-gray-300 menu-state-bg menu-state-bullet-primary fw-bold fs-6 mb-2">
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#kt_scroll_basic_info" class="menu-link px-3 nav-link">
															<span class="menu-bullet">
																<span class="bullet bullet-vertical"></span>
															</span>
                                <span class="menu-title">Basic Information</span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0 pb-1">
                            <a href="#kt_scroll_signin" class="menu-link px-3 nav-link">
															<span class="menu-bullet">
																<span class="bullet bullet-vertical"></span>
															</span>
                                <span class="menu-title">Credentials</span>
                            </a>
                        </li>
                        <li class="menu-item px-3 pt-0">
                            <a href="#kt_scroll_deactivate" class="menu-link px-3 nav-link">
															<span class="menu-bullet">
																<span class="bullet bullet-vertical"></span>
															</span>
                                <span class="menu-title">Create Account</span>
                            </a>
                        </li>
                    </ul>
                    <!--end::Menu-->
                </div>
                <!--end::Card body-->
            </div>
            <!--end::Nav-->
        </div>
        <!--end::Aside-->
        <!--begin::Layout-->
        <div class="flex-md-row-fluid ms-lg-12">
            <form method="Post" action="{{route('users.store')}}">
            @csrf
            <!--begin::Basic info-->
                <div class="card mb-6 mb-xl-9" id="kt_scroll_basic_info">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_account_basic_info" aria-expanded="true"
                         aria-controls="kt_account_basic_info">
                        <!--begin::Card title-->
                        <div class="card-title m-0">
                            <h3 class="fw-boldest m-0">Basic Info</h3>
                        </div>
                        <!--end::Card title-->
                    </div>
                    <!--begin::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_basic_info" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Full Name</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <!--begin::Row-->
                                    <input type="text" name="name"
                                           class="form-control form-control-lg form-control-solid"
                                           placeholder="Full name"/>
                                    <!--end::Row-->
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                            <!--begin::Input group-->
                            <div class="row mb-6">
                                <!--begin::Label-->
                                <label class="col-lg-4 col-form-label fw-bold fs-6">Account Type</label>
                                <!--end::Label-->
                                <!--begin::Col-->
                                <div class="col-lg-8 fv-row">
                                    <select name="account_type" aria-label="Select an account type"
                                            data-control="select2"
                                            data-placeholder="Select an account type.."
                                            class="form-select form-select-solid form-select-lg">
                                        <option value="">Select a currency..</option>
                                        <option value="1">Administrator</option>
                                        <option value="2">Surveyor</option>
                                        <option value="3">Surveyee</option>
                                    </select>
                                </div>
                                <!--end::Col-->
                            </div>
                            <!--end::Input group-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Basic info-->
                <!--begin::Sign-in Method-->
                <div class="card mb-6 mb-xl-9" id="kt_scroll_signin">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                            <h3 class="fw-boldest m-0">Credentials</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_signin_method" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Email Address-->
                            <div class="d-flex flex-wrap align-items-center mb-8">
                                <div id="kt_signin_email_edit" class="flex-row-fluid">
                                    <div class="row mb-6">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="emailaddress" class="form-label fs-6 fw-bolder mb-3">Enter
                                                    New Email Address</label>
                                                <input type="email"
                                                       class="form-control form-control-lg form-control-solid fw-bold fs-6"
                                                       id="emailaddress" placeholder="Email Address" name="email"
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Email Address-->
                            <!--begin::Password-->
                            <div class="d-flex flex-wrap align-items-center mb-8">
                                <div id="kt_signin_password_edit" class="flex-row-fluid">
                                    <div class="fs-6 fw-bold text-gray-600 mb-4">Password must be at least 8 character
                                        and
                                        contain symbols
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-6 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="password" class="form-label fs-6 fw-bolder mb-3">
                                                    Password</label>
                                                <input type="password"
                                                       class="form-control form-control-lg form-control-solid fw-bold fs-6"
                                                       name="password" id="password"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Password-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Sign-in Method-->
                <!--begin::Deactivate Account-->
                <div class="card" id="kt_scroll_deactivate">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_account_deactivate" aria-expanded="true"
                         aria-controls="kt_account_deactivate">
                        <div class="card-title m-0">
                            <h3 class="fw-boldest m-0">Please verify all the information is correct</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_deactivate" class="collapse show">
                        <!--begin::Card footer-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button id="kt_account_deactivate_account_submit" type="submit"
                                    class="btn btn-primary fw-bold">Create Account
                            </button>
                        </div>
                        <!--end::Card footer-->
                    </div>
                    <!--end::Content-->
                </div>
                <!--end::Deactivate Account-->
            </form>
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Main-->
@endsection
@section('javascript')
    <script src="{{asset('js/custom/account/settings/signin-methods.js')}}"></script>
@endsection
