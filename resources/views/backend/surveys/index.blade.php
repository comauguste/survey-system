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
                    <li class="breadcrumb-item text-dark">Survey</li>
                </ul>
                <!--end::Breadcrumb-->
            </div>
            <!--end::Info-->
            <!--begin::Actions-->
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <a href="{{route('surveys.create')}}" class="btn btn-primary" data-bs-toggle="modal"
                   data-bs-target="#kt_modal_new_survey">Create New Survey</a>
            </div>
            <!--end::Actions-->
        </div>
    </div>
@endsection
@section("page")
    <!--begin::Main-->
    <!--begin::Root-->
    <!--begin::Toolbar-->
    <div class="d-flex flex-wrap flex-stack pb-7">
        <!--begin::Title-->
        <div class="d-flex flex-wrap align-items-center my-1">
            <h2 class="fw-bold me-5 my-1">Surveys ({{count($surveys)}})</h2>
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/stockholm/General/Search.svg-->
                <span class="svg-icon svg-icon-3 position-absolute ms-3">
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     width="24px"
                                                     height="24px" viewBox="0 0 24 24" version="1.1">
													<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
														<rect x="0" y="0" width="24" height="24"/>
														<path
                                                            d="M14.2928932,16.7071068 C13.9023689,16.3165825 13.9023689,15.6834175 14.2928932,15.2928932 C14.6834175,14.9023689 15.3165825,14.9023689 15.7071068,15.2928932 L19.7071068,19.2928932 C20.0976311,19.6834175 20.0976311,20.3165825 19.7071068,20.7071068 C19.3165825,21.0976311 18.6834175,21.0976311 18.2928932,20.7071068 L14.2928932,16.7071068 Z"
                                                            fill="#000000" fill-rule="nonzero" opacity="0.3"/>
														<path
                                                            d="M11,16 C13.7614237,16 16,13.7614237 16,11 C16,8.23857625 13.7614237,6 11,6 C8.23857625,6 6,8.23857625 6,11 C6,13.7614237 8.23857625,16 11,16 Z M11,18 C7.13400675,18 4,14.8659932 4,11 C4,7.13400675 7.13400675,4 11,4 C14.8659932,4 18,7.13400675 18,11 C18,14.8659932 14.8659932,18 11,18 Z"
                                                            fill="#000000" fill-rule="nonzero"/>
													</g>
												</svg>
											</span>
                <!--end::Svg Icon-->
                <input type="text" id="kt_filter_search"
                       class="form-control form-control-white form-control-sm w-150px ps-9" placeholder="Search"/>
            </div>
            <!--end::Search-->
        </div>
        <!--end::Title-->
    </div>
    <!--end::Toolbar-->
    <!--begin::Tab Content-->

    <!--begin::Card-->
    @if ($errors->any())
        <div class="card card-flush p-5 bg-danger mb-5 text-white">
            <strong>Oh snap!</strong><br>
            @foreach ($errors->all() as $error)
                {{ $error }}<br>
            @endforeach
        </div>
    @endif
    <!--begin::Card-->
    <div class="card card-flush">
        <!--begin::Card body-->
        <div class="card-body pt-0">
            <!--begin::Table container-->
            <div class="table-responsive">
                <!--begin::Table-->
                <table id="kt_project_users_table"
                       class="table table-row-bordered table-row-dashed gy-4 align-middle fw-boldest">
                    <!--begin::Head-->
                    <thead class="fs-7 text-gray-400 text-uppercase">
                    <tr>
                        <th class="min-w-250px">Name</th>
                        <th class="min-w-150px">Created</th>
                        <th class="min-w-150px">Created By</th>
                        <th class="min-w-90px">Status</th>
                        <th class="min-w-50px text-end">Details</th>
                    </tr>
                    </thead>
                    <!--end::Head-->
                    <!--begin::Body-->
                    <tbody class="fs-5">
                    @foreach($surveys as $survey)
                        <tr>
                            <td>
                                {{$survey->name}}
                            </td>
                            <td>{{$survey->created_at}}</td>
                            <td>
                                {{$survey->creator->name}}
                            </td>
                            <td>
                                {{ $survey->status }}
                            </td>
                            <td class="text-end">
                                <a href="{{route('surveys.show', $survey)}}" class="btn btn-light btn-sm">View</a>
                                <a href="{{route('surveys.delete', $survey)}}" class="btn btn-light btn-sm">Delete</a>
                            </td>
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
    </div>
    <!--end::Card-->
    <!--end::Tab Content-->
    <!--end::Main-->

    <!--begin::Modal - New Target-->
    <div class="modal fade" id="kt_modal_new_survey" tabindex="-1" aria-hidden="true">
        <!--begin::Modal dialog-->
        <div class="modal-dialog modal-dialog-centered mw-650px">
            <!--begin::Modal content-->
            <div class="modal-content rounded">
                <!--begin::Modal header-->
                <div class="modal-header pb-0 border-0 justify-content-end">
                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-icon-primary" data-bs-dismiss="modal">
                        <!--begin::Svg Icon | path: icons/duotone/Interface/Close-square.svg-->
                        <span class="svg-icon svg-icon-2x">
														<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             viewBox="0 0 24 24" fill="none">
															<path opacity="0.25" fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M2.36899 6.54184C2.65912 4.34504 4.34504 2.65912 6.54184 2.36899C8.05208 2.16953 9.94127 2 12 2C14.0587 2 15.9479 2.16953 17.4582 2.36899C19.655 2.65912 21.3409 4.34504 21.631 6.54184C21.8305 8.05208 22 9.94127 22 12C22 14.0587 21.8305 15.9479 21.631 17.4582C21.3409 19.655 19.655 21.3409 17.4582 21.631C15.9479 21.8305 14.0587 22 12 22C9.94127 22 8.05208 21.8305 6.54184 21.631C4.34504 21.3409 2.65912 19.655 2.36899 17.4582C2.16953 15.9479 2 14.0587 2 12C2 9.94127 2.16953 8.05208 2.36899 6.54184Z"
                                                                  fill="#12131A"/>
															<path fill-rule="evenodd" clip-rule="evenodd"
                                                                  d="M8.29289 8.29289C8.68342 7.90237 9.31658 7.90237 9.70711 8.29289L12 10.5858L14.2929 8.29289C14.6834 7.90237 15.3166 7.90237 15.7071 8.29289C16.0976 8.68342 16.0976 9.31658 15.7071 9.70711L13.4142 12L15.7071 14.2929C16.0976 14.6834 16.0976 15.3166 15.7071 15.7071C15.3166 16.0976 14.6834 16.0976 14.2929 15.7071L12 13.4142L9.70711 15.7071C9.31658 16.0976 8.68342 16.0976 8.29289 15.7071C7.90237 15.3166 7.90237 14.6834 8.29289 14.2929L10.5858 12L8.29289 9.70711C7.90237 9.31658 7.90237 8.68342 8.29289 8.29289Z"
                                                                  fill="#12131A"/>
														</svg>
													</span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Close-->
                </div>
                <!--begin::Modal header-->
                <!--begin::Modal body-->
                <div class="modal-body scroll-y px-10 px-lg-15 pt-0 pb-15">
                    <!--begin:Form-->
                    <form id="kt_modal_new_survey_form" class="form" method="POST" action="{{route('surveys.store')}}">
                    @csrf
                    <!--begin::Heading-->
                        <div class="pb-10 pb-lg-12 text-center">
                            <!--begin::Title-->
                            <h3 class="fw-boldest text-dark fs-2x">Create A New Survey</h3>
                            <!--end::Title-->
                        </div>
                        <!--end::Heading-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8 fv-row">
                            <!--begin::Label-->
                            <label class="d-flex align-items-center fs-6 fw-bold mb-2">
                                <span class="required">Title</span>
                                <i class="fas fa-exclamation-circle ms-2 fs-7" data-bs-toggle="tooltip"
                                   title="Specify a target name for future usage and reference"></i>
                            </label>
                            <!--end::Label-->
                            <input type="text" class="form-control form-control-solid" placeholder="Enter Title"
                                   name="name"/>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Input group-->
                        <div class="d-flex flex-column mb-8">
                            <label class="fs-6 fw-bold mb-2">Description</label>
                            <textarea class="form-control form-control-solid" rows="3" name="description"
                                      placeholder="Type Description"></textarea>
                        </div>
                        <!--end::Input group-->
                        <!--begin::Actions-->
                        <div class="text-center">
                            <button type="reset" id="kt_modal_new_survey_cancel" data-bs-dismiss="modal"
                                    class="btn btn-white me-3">Cancel
                            </button>
                            <button type="submit" id="kt_modal_new_survey_submit" class="btn btn-primary">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress">Please wait...
															<span
                                                                class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                        </div>
                        <!--end::Actions-->
                    </form>
                    <!--end:Form-->
                </div>
                <!--end::Modal body-->
            </div>
            <!--end::Modal content-->
        </div>
        <!--end::Modal dialog-->
    </div>
    <!--end::Modal - New Target-->
@endsection
