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
            <!--begin::Actions-->
            <div class="d-flex align-items-center flex-nowrap text-nowrap py-1">
                <a href="{{route('admin.users.create')}}" class="btn btn-primary">Create New User</a>
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
            <h2 class="fw-bold me-5 my-1">Users ({{count($users)}})</h2>
            <!--begin::Search-->
            <div class="d-flex align-items-center position-relative my-1">
                <!--begin::Svg Icon | path: icons/stockholm/General/Search.svg-->
                <span class="svg-icon svg-icon-3 position-absolute ms-3">
												<svg xmlns="http://www.w3.org/2000/svg"
                                                     xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
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
                        <th class="min-w-250px">Account Holder</th>
                        <th class="min-w-150px">Created</th>
                        <th class="min-w-90px">Account Type</th>
                        <th class="min-w-90px">Status</th>
                        <th class="min-w-50px text-end">Details</th>
                    </tr>
                    </thead>
                    <!--end::Head-->
                    <!--begin::Body-->
                    <tbody class="fs-5">
                    @foreach($users as $user)
                        <tr>
                            <td>
                                <!--begin::User-->
                                <div class="d-flex align-items-center">
                                    <!--begin::Wrapper-->
                                    <div class="me-5 position-relative">
                                        <!--begin::Avatar-->
                                        <div class="symbol symbol-35px symbol-circle">
                                            <span
                                                class="symbol-label bg-light-danger text-danger fw-bold">{{$user->getInitials()}}</span>
                                        </div>
                                        <!--end::Avatar-->
                                    </div>
                                    <!--end::Wrapper-->
                                    <!--begin::Info-->
                                    <div class="d-flex flex-column justify-content-center">
                                        <a href="" class="mb-1 text-gray-800 text-hover-primary">{{$user->name}}</a>
                                        <div class="fw-bold fs-6 text-gray-400">{{$user->email}}</div>
                                    </div>
                                    <!--end::Info-->
                                </div>
                                <!--end::User-->
                            </td>
                            <td>{{$user->created_at}}</td>
                            <td>
                                <span
                                    class="{{$user->getAccountTypeBadge()}}">{{$user->getAccountType()}}</span>
                            </td>
                            <td>
                                <span
                                    class="{{$user->getEmailVerificationStatusBadge()}}">{{$user->getEmailVerificationStatus()}}</span>
                            </td>
                            <td class="text-end">
                                <a href="{{route('users.show', $user)}}" class="btn btn-light btn-sm">View</a>
                                <a href="{{route('users.delete', $user)}}" class="btn btn-light btn-sm">Delete</a>
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
@endsection
