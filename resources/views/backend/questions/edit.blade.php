@extends("layouts.main-body")
@section('toolbar')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Question Management
                    <small class="text-muted fs-6 fw-normal ms-1"></small></h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark">Update Your Question</li>
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
                                <span class="menu-title">Survey name: {{$survey->name}}</span>
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
            <form method="POST" action="{{route('questions.update', ['survey' => $survey, 'question' => $question])}}">
                @csrf
                <div class="card mb-6">
                    <!--begin::Content-->
                    <div id="kt_account_signin_method" class="collapse show">
                        <!--begin::Card body-->
                        <div class="card-body border-top p-9">
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap align-items-center mb-8">
                                <div id="kt_signin_password_edit" class="flex-row-fluid">
                                    <div class="row mb-6">
                                        <div class="col-lg-8 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="password" class="form-label fs-6 fw-bolder mb-3">
                                                    Question</label>
                                                <textarea class="form-control form-control-solid" rows="3"
                                                          name="description">{{$question->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Description-->
                        </div>
                        <!--end::Card body-->
                    </div>

                </div>
                <div class="card mb-6 mb-xl-9">
                    <div id="kt_account_deactivate" class="collapse show">
                        <!--begin::Card footer-->
                        <div class="card-footer d-flex justify-content-end py-6 px-9">
                            <button id="kt_account_deactivate_account_submit" type="submit"
                                    class="btn btn-primary fw-bold ">Update Question
                            </button>
                        </div>
                        <!--end::Card footer-->
                    </div>
                </div>
            </form>
        </div>
        <!--end::Layout-->
    </div>
    <!--end::Main-->
@endsection
@section('javascript')
    <script src="{{asset('js/custom/account/settings/signin-methods.js')}}"></script>
@endsection
