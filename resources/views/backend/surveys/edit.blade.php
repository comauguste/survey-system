@extends("layouts.main-body")
@section('toolbar')
    <div class="toolbar" id="kt_toolbar">
        <div class="container-fluid d-flex flex-stack flex-wrap flex-sm-nowrap">
            <!--begin::Info-->
            <div class="d-flex flex-column align-items-start justify-content-center flex-wrap me-2">
                <!--begin::Title-->
                <h1 class="text-dark fw-bolder my-1 fs-2">Survey Management
                    <small class="text-muted fs-6 fw-normal ms-1"></small></h1>
                <!--end::Title-->
                <!--begin::Breadcrumb-->
                <ul class="breadcrumb fw-bold fs-base my-1">
                    <li class="breadcrumb-item text-muted">
                        <a href="/" class="text-muted text-hover-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item text-dark">Edit Survey</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->
        </div>
    </div>
@endsection
@section("page")
    @if (Session::has('success'))
        <div class="alert alert-success">
            <strong>Success:</strong> {{ Session::get('success') }}
        </div>
    @endif

    @if (Session::has('warning'))
        <div class="alert alert-warning">
            <strong>Warning:</strong> {{ Session::get('warning') }}
        </div>
    @endif
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
                            <a class="menu-link px-3 nav-link">
															<span class="menu-bullet">
																<span class="bullet bullet-vertical"></span>
															</span>
                                <span class="menu-title">Survey Builder</span>
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
            <form method="POST" action="{{route('surveys.update', $survey)}}">
                @csrf
                <div class="card mb-6">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_account_deactivate" aria-expanded="true"
                         aria-controls="kt_account_deactivate">
                        <div class="card-title m-0">
                            <h3 class="fw-boldest m-0">Edit your Survey</h3>
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
                                        <div class="col-lg-8 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="name" class="form-label fs-6 fw-bolder mb-3">Name</label>
                                                <input type="text"
                                                       class="form-control form-control-lg form-control-solid fw-bold fs-6"
                                                       id="bane" name="name" value="{{$survey->name}}"
                                                    {{$survey->is_running ?'readonly' : '' }}
                                                />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Email Address-->
                            <!--begin::Description-->
                            <div class="d-flex flex-wrap align-items-center mb-8">
                                <div id="kt_signin_password_edit" class="flex-row-fluid">
                                    <div class="fs-6 fw-bold text-gray-600 mb-4">Please provide a thorough explanation
                                        of the objective of this survey
                                    </div>
                                    <div class="row mb-6">
                                        <div class="col-lg-8 mb-4 mb-lg-0">
                                            <div class="fv-row mb-0">
                                                <label for="password" class="form-label fs-6 fw-bolder mb-3">
                                                    Description</label>
                                                <textarea class="form-control form-control-solid" rows="3"
                                                          name="description"
                                                          placeholder="Type Description"
                                                          {{$survey->is_running ?'readonly' : '' }}
                                                >{{$survey->description}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Description-->
                        @if($survey->is_running)
                            <!--begin::Shareable Link-->
                                <div class="d-flex flex-wrap align-items-center">
                                    <div id="kt_signin_password_edit" class="flex-row-fluid">
                                        <div class="row mb-6">
                                            <div class="col-lg-9 mb-4 mb-lg-0">
                                                <div class="fv-row mb-0">
                                                    <label for="password" class="form-label fs-6 fw-bolder mb-3">
                                                        Internal Link</label>
                                                    <div class="fs-6 fw-bold text-gray-600 mb-4">
                                                        <a href="{{route('public_survey.show', $survey->uuid)}}">
                                                            {{Request::getHost().'/survey/'.$survey->uuid}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="fv-row mb-0">
                                                    <label for="password" class="form-label fs-6 fw-bolder mb-3">
                                                        Shareable Link</label>
                                                    <div class="fs-6 fw-bold text-gray-600 mb-4">
                                                        <a href="{{$survey->shareable_url}}">{{$survey->shareable_url}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--end::Shareable Link-->
                            @endif
                        </div>
                        <!--end::Card body-->
                    </div>

                </div>
                <div class="card mb-6 mb-xl-9">
                    <!--begin::Card header-->
                    <div class="card-header border-0 cursor-pointer" role="button" data-bs-toggle="collapse"
                         data-bs-target="#kt_account_signin_method">
                        <div class="card-title m-0">
                            <h3 class="fw-boldest m-0">Questions</h3>
                        </div>
                    </div>
                    <!--end::Card header-->
                    <!--begin::Content-->
                    <div id="kt_account_signin_method" class="collapse show">
                    @if(count($questions) === 0)
                        <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Email Address-->
                                <div class="d-flex flex-wrap align-items-center mb-8">
                                    <div class="flex-row-fluid">
                                        <div class="row">
                                            <h3><a href="{{route('questions.create', $survey->uuid)}}">Create</a> your
                                                first question.
                                            </h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--end::Card body-->
                    @else
                        <!--begin::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Table container-->
                                <div class="table-responsive">
                                    <!--begin::Table-->
                                    <table id="kt_project_users_table"
                                           class="table table-row-bordered table-row-dashed gy-4 align-middle fw-boldest">
                                        <!--begin::Head-->
                                        <thead class="fs-7 text-gray-400 text-uppercase">
                                        <tr>
                                            <th class="min-w-50px">#</th>
                                            <th class="min-w-250px">UUI</th>
                                            <th class="min-w-150px">Question</th>
                                            <th class="min-w-150px">Last Edit</th>
                                            @if (!$survey->is_running)
                                                <th class="min-w-50px text-end">Details</th>
                                            @endif
                                        </tr>
                                        </thead>
                                        <!--end::Head-->
                                        <!--begin::Body-->
                                        <tbody class="fs-5">
                                        @foreach($questions as $index => $question)
                                            <tr>
                                                <td>
                                                    {{ $question->order }}
                                                </td>
                                                <td>{{ $question->uuid }}</td>
                                                <td style="max-width: 100px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                                    {{ $question->description }}
                                                </td>
                                                <td>
                                                    <span
                                                        title="{{ $question->updated_at_rfc1123 }}">{{ $question->updated_at_diff }}</span>
                                                </td>
                                                @if (!$survey->is_running)
                                                    <td class="text-end">
                                                        <a href="{{route('questions.show', ['survey' => $survey, 'q_uuid' => $question->uuid])}}"
                                                           class="btn btn-light btn-sm">Edit</a>
                                                        <a href="{{route('questions.delete', ['survey' => $survey, 'q_uuid' => $question->uuid])}}"
                                                           class="btn btn-danger btn-sm">Delete</a>
                                                    </td>
                                                @endif
                                            </tr>
                                        @endforeach
                                        </tbody>
                                        <!--end::Body-->
                                    </table>
                                    <!--end::Table-->
                                </div>
                                <!--end::Table container-->
                            </div>
                            <!--end::Card body-->
                            <div class="card-body border-top p-9">
                                <!--begin::Email Address-->
                                <div class="d-flex flex-wrap align-items-center">
                                    <div class="flex-row-fluid">
                                        <div class="row text-center">
                                            <h3><a href="{{route('questions.create', $survey->uuid)}}">Create</a>
                                                another question.
                                            </h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!--end::Content-->
                </div>
                <div class="card mb-6 mb-xl-9">
                    <div class="collapse show">
                        <!--begin::Card footer-->
                        <div class="card-footer d-flex  flex-row justify-content-center py-6 px-9">
                            <div class="p-2">
                                <button id="kt_account_deactivate_account_submit" type="submit"
                                        class="btn btn-success fw-bold">Update
                                </button>
                            </div>
                            @if(count($questions) > 0)
                                @if($survey->status === 'draft')
                                    <div class="p-2">
                                        <a href="{{route('surveys.run', $survey->uuid)}}"
                                           class="btn btn-primary fw-bold">Run</a>
                                    </div>
                                @elseif($survey->status === 'ready')
                                    <div class="p-2">
                                        <a href="{{route('surveys.pause', $survey->uuid)}}"
                                           class="btn btn-danger fw-bold">Pause</a>
                                    </div>
                                @endif
                            @endif
                            <div class="p-2">
                                <a href="{{route('surveys')}}" class="btn btn-secondary fw-bold">Back</a>
                            </div>
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
