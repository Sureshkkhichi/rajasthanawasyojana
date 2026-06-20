<div>
    <!-- Start footer -->
    <footer class="custom-footer bg-dark py-5 position-relative">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mt-4">
                    <div>
                        <div>
                            <img src="{{ asset('assets/images/logo-light.png') }}" alt="logo light" height="17">
                        </div>
                        <div class="mt-4 fs-13">
                            <p>Premium Multipurpose Admin & Dashboard Template</p>
                            <p class="ff-secondary">You can build any type of web application like eCommerce, CRM,
                                CMS, Project management apps, Admin Panels, etc using Velzon.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7 ms-lg-auto">
                    <div class="row">
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">Quick Links</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list">
                                    <li><a href="pages-profile.html">Term and Condition</a></li>
                                    <li><a href="pages-gallery.html">Privacy policy</a></li>
                                    <li><a href="apps-projects-overview.html">Cancellation Refund policy</a></li>
                                    <li><a href="pages-timeline.html">Contact Us</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">Active Projects</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list">
                                    @foreach ($projects as $project)
                                        <li>
                                            <a href="{{ route('project.show', $project->slug) }}">{{ $project->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <h5 class="text-white mb-0">Upcoming Project</h5>
                            <div class="text-muted mt-3">
                                <ul class="list-unstyled ff-secondary footer-list">
                                    @foreach ($upcoming_projects as $project)
                                        <li>
                                            <a href="{{ route('project.show', $project->slug) }}">{{ $project->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row text-center text-sm-start align-items-center mt-5">
                <div class="col-sm-6">
                    <div>
                        <p class="copy-rights mb-0">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © {{ config('constants.site_name') }} - <a href="https://sureshkhichi.com"
                                class="text-light">{{ config('constants.site_author') }}</a>
                        </p>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="text-sm-end mt-3 mt-sm-0">
                        <ul class="list-inline mb-0 footer-social-link">
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-facebook-fill"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-github-fill"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-linkedin-fill"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-google-fill"></i>
                                    </div>
                                </a>
                            </li>
                            <li class="list-inline-item">
                                <a href="javascript: void(0);" class="avatar-xs d-block">
                                    <div class="avatar-title rounded-circle">
                                        <i class="ri-dribbble-line"></i>
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end footer -->

    <!-- Call Us -->
    {{-- <a href="tel:+9186193035" style="display: unset;">
        <button class="callme-button">
            <i class="bx bx-mobile"></i>
            <span class="callme-text">Call Us</span>
        </button>
    </a> --}}

    <!-- Whatsapp No. -->
    {{-- <a href="https://wa.me/918619303509?text=&quot;Send%20me%20Your%20Project%20Details.&quot;"
        style="display: unset;" target="_blank">
        <button class="whatsapp-button">
            <i class="la la-whatsapp"></i>
            <span class="whatsapp-text">How Can I help You</span>
        </button>
    </a> --}}

    <!--start back-to-top-->
    <button onclick="topFunction()" class="btn btn-danger btn-icon landing-back-top" id="back-to-top">
        <i class="ri-arrow-up-line"></i>
    </button>
    <!--end back-to-top-->
</div>