@extends('backend.layouts.app')
@section('title', 'Profile')
@section('content')
    {{-- breadcrumb --}}
    <ol class="breadcrumb breadcrumb-style1">
        <li class="breadcrumb-item">
            <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active">Profile</li>
    </ol>

    <div class="row">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-6">
                <div class="card-body pt-12">
                    <div class="customer-avatar-section">
                        <div class="d-flex align-items-center flex-column">
                            <img class="img-fluid rounded mb-4" src="../../assets/img/avatars/1.png" height="120"
                                width="120" alt="User avatar">
                            <div class="customer-info text-center mb-6">
                                <h5 class="mb-0">{{ auth()->user()->name }}</h5>
                                <span>Admin</span>
                            </div>
                        </div>
                    </div>

                    <div class="info-container">
                        <h5 class="pb-2 border-bottom text-capitalize mt-6">Details</h5>
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="h6 me-1">Full Name:</span>
                                <span>{{ auth()->user()->name }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Email:</span>
                                <span>{{ auth()->user()->email }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Status:</span>
                                @if (auth()->user()->status == 1)
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif

                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Contact:</span>
                                <span>{{ auth()->user()->phone ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1">Address:</span>
                                <span>{{ auth()->user()->address ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                    <div class="info-container">
                        <h5 class="pb-2 border-bottom text-capitalize mt-6 pt-2">Social Links</h5>
                        <ul class="list-unstyled mb-6">
                            <li class="mb-2">
                                <span class="h6 me-1"><i class="ti ti-brand-facebook"></i> Facebook:</span>
                                <span>{{ auth()->user()->fb_link ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1"><i class="ti ti-brand-instagram"></i> Instagram:</span>
                                <span>{{ auth()->user()->instagram_link ?? 'N/A' }}</span>
                            </li>
                            <li class="mb-2">
                                <span class="h6 me-1"><i class="ti ti-brand-twitter"></i> Twitter:</span>
                                <span>{{ auth()->user()->twitter_link ?? 'N/A' }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <div class="card mb-6">
                <div class="card-header flex-column flex-md-row py-0 mt-6 mt-md-0">
                    <div class="head-label pt-2 pt-md-0">
                        <h5 class="card-title my-3 text-nowrap">Edit Profile</h5>
                    </div>
                    <form action="#" method="post" class="mb-4">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter your name" value="{{ auth()->user()->name }}" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email"
                                        placeholder="Enter your email" value="{{ auth()->user()->email }}" readonly />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="text" class="form-control" id="phone" name="phone"
                                        placeholder="Enter your phone" value="{{ auth()->user()->phone }}" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter your address" value="{{ auth()->user()->address }}" />
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="fb_link">Facebook Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-brand-facebook"></i></span>
                                        <input type="text" name="fb_link" id="fb_link" class="form-control"
                                            placeholder="Facebook Link" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="instagram_link">Instagram Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-brand-instagram"></i></span>
                                        <input type="text" name="instagram_link" id="instagram_link"
                                            class="form-control" placeholder="Instagram Link" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="mb-3">
                                    <label class="form-label" for="twitter_link">Twitter Link</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="ti ti-brand-twitter"></i></span>
                                        <input type="text" name="twitter_link" id="twitter_link" class="form-control"
                                            placeholder="Twitter Link" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="image">Image</label>
                                    <input type="file" class="form-control" id="image" name="image"
                                        placeholder="Enter your address" />
                                </div>
                            </div>

                            <div class="col-sm-12">
                                <button type="submit" class="btn btn-primary">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- /Invoice table -->
    </div>
    <div class="row mt-3">
        <div class="col-xl-4 col-lg-5 col-md-5 order-1 order-md-0">
            <div class="card mb-6">
                <div class="card-header">
                    <h5 class="card-title mb-0">Change Password</h5>
                </div>
                <div class="card-body pt-12">
                    <form action="#" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="old-password">Current Password</label>
                                    <input type="password" class="form-control" id="old-password" name="old-password"
                                        placeholder="Enter your old password" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="password">New Password</label>
                                    <input type="password" class="form-control" id="password" name="password"
                                        placeholder="Enter new password" />
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <div class="mb-3">
                                    <label class="form-label" for="email">Confirm Password</label>
                                    <input type="password" class="form-control" id="email" name="email"
                                        placeholder="Enter confirm password" />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--/ Customer Content -->
    </div>
@endSection
