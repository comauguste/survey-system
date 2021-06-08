@extends("layouts.auth")

@section("content")
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Authentication - Signup Verify Email -->
        <div class="d-flex flex-column flex-column-fluid">
            <!--begin::Content-->
            <div class="d-flex flex-column flex-column-fluid text-center p-10 py-lg-20">
                <!--begin::Logo-->
                <a href="index.html" class="pt-lg-20 mb-12">
                    <img alt="Logo" src="{{asset('media/logos/logo-compact.svg')}}" class="h-60px" />
                </a>
                <!--end::Logo-->
                <!--begin::Wrapper-->
                <div class="text-center">
                    <!--begin::Title-->
                    <h1 class="fw-bolder fs-2qx text-dark mb-7">Verify Your Email</h1>
                    <!--end::Title-->
                    <!--begin::Message-->
                    <div class="fs-3 fw-bold text-gray-400 mb-10">We have sent an email to
                        <a href="#" class="link-primary fw-bolder">{{$email}}</a>
                        <br />please follow a link to verify your email.</div>
                    <!--end::Message-->
                    <!--begin::Link-->
                    <div class="mb-10">
                        <a href="{{route('login')}}" class="btn btn-lg btn-primary">Skip for now</a>
                    </div>
                    <!--end::Link-->
                    <!--begin::Link-->
                    <div class="fs-5">
                        <span class="fw-bold text-gray-700">Didn’t receive an email?</span>
                        <a href="{{route('password.request')}}" class="link-primary fw-bolder">Resend</a>
                    </div>
                    <!--end::Link-->
                </div>
                <!--end::Wrapper-->
            </div>
            <!--end::Content-->
            <!--begin::Illustration-->
            <div class="d-flex flex-row-fluid bgi-no-repeat bgi-position-x-center bgi-size-contain bgi-size-lg-auto bgi-position-y-bottom min-h-100px min-h-lg-350px" style="background-image: url(assets/media/svg/illustrations/counting.svg)"></div>
            <!--end::Illustration-->
        </div>
        <!--end::Authentication - Signup Verify Email-->
    </div>
@endsection
