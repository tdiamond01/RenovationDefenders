<x-public-layout>
    <div class="container">
        <!-- Hero Section -->
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto text-center">
                <h1 class="display-5 fw-bold mb-3">About Renovation Defenders</h1>
                <p class="lead text-muted">
                    Empowering homeowners and contractors with the knowledge and tools
                    to succeed in every renovation project.
                </p>
            </div>
        </div>

        <!-- Mission Section -->
        <div class="row mb-5">
            <div class="col-lg-6 mb-4 mb-lg-0">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-primary mb-3">
                            <i class="bi bi-bullseye" style="font-size: 2.5rem;"></i>
                        </div>
                        <h3>Our Mission</h3>
                        <p class="text-muted">
                            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
                            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                        </p>
                        <p class="text-muted mb-0">
                            Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore
                            eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div class="text-success mb-3">
                            <i class="bi bi-eye" style="font-size: 2.5rem;"></i>
                        </div>
                        <h3>Our Vision</h3>
                        <p class="text-muted">
                            Pellentesque habitant morbi tristique senectus et netus et malesuada fames
                            ac turpis egestas. Vestibulum tortor quam, feugiat vitae, ultricies eget,
                            tempor sit amet, ante. Donec eu libero sit amet quam egestas semper.
                        </p>
                        <p class="text-muted mb-0">
                            Aenean ultricies mi vitae est. Mauris placerat eleifend leo. Quisque sit amet
                            est et sapien ullamcorper pharetra.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Our Story Section -->
        <div class="row mb-5">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4 p-lg-5">
                        <h2 class="mb-4">Our Story</h2>
                        <div class="row">
                            <div class="col-lg-6">
                                <p class="text-muted">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam in dui mauris.
                                    Vivamus hendrerit arcu sed erat molestie vehicula. Sed auctor neque eu tellus
                                    rhoncus ut eleifend nibh porttitor. Ut in nulla enim.
                                </p>
                                <p class="text-muted">
                                    Phasellus molestie magna non est bibendum non venenatis nisl tempor.
                                    Suspendisse dictum feugiat nisl ut dapibus. Mauris iaculis porttitor posuere.
                                    Praesent id metus massa, ut blandit odio.
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <p class="text-muted">
                                    Proin quis tortor orci. Etiam at risus et justo dignissim congue. Donec
                                    congue lacinia dui, a porttitor lectus condimentum laoreet. Nunc eu ullamcorper
                                    orci. Quisque eget odio ac lectus vestibulum faucibus eget in metus.
                                </p>
                                <p class="text-muted mb-0">
                                    In pellentesque faucibus vestibulum. Nulla at nulla justo, eget luctus tortor.
                                    Nulla facilisi. Duis aliquet egestas purus in blandit.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructor Section -->
        <div class="row mb-5">
            <div class="col-12 text-center mb-4">
                <h2>Your Instructor</h2>
                <p class="text-muted">Meet the expert behind Renovation Defenders</p>
            </div>
            <div class="col-lg-6 mx-auto mb-4">
                <div class="card border-0 shadow-sm text-center h-100">
                    <div class="card-body p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 120px; height: 120px;">
                            <i class="bi bi-person-fill text-primary" style="font-size: 4rem;"></i>
                        </div>
                        <h4 class="card-title mb-1">Stephen Selby</h4>
                        <p class="text-muted mb-3">Lead Instructor</p>
                        <p class="text-muted mb-0">
                            With years of experience in the renovation industry, Stephen brings
                            practical knowledge and expert guidance to help you succeed in your
                            renovation projects.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Meet Stephen Video Section (Logged-in users only) -->
        @auth
        <div class="row mb-5">
            <div class="col-lg-8 mx-auto">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary text-white text-center py-3">
                        <h4 class="mb-0"><i class="bi bi-play-circle me-2"></i>Meet Stephen</h4>
                    </div>
                    <div class="card-body p-0">
                        <video
                            class="w-100"
                            controls
                            preload="metadata"
                            poster=""
                        >
                            <source src="https://renovation-defenders-videos.s3.us-west-2.amazonaws.com/meet_stephen.mp4" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    </div>
                </div>
            </div>
        </div>
        @endauth

        <!-- CTA Section -->
        <div class="row">
            <div class="col-12">
                <div class="card bg-primary text-white border-0">
                    <div class="card-body p-4 p-lg-5 text-center">
                        <h3 class="mb-3">Ready to Get Started?</h3>
                        <p class="mb-4 opacity-75">
                            Join thousands of satisfied customers who trust Renovation Defenders
                            for their training and certification needs.
                        </p>
                        <a href="{{ route('catalog.index') }}" class="btn btn-light btn-lg">
                            <i class="bi bi-shop me-2"></i> Browse Our Courses
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
