@extends('layouts.app')
@section('title')
404 Error
@endsection
@section('content')
 <!-- Start Error Area -->
        <section class="error-section">
            <div class="d-table"> 
                <div class="d-table-cell"> 
                    <div class="container">
                        <div class="error-text">
                            <h2>404!</h2>
                            <h4>Oops! Page Not Found</h4>
                            <p>The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.</p>
                            
                            <div class="return-home">
                                <a href="/" class="default-btn">Return Home</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- End Error Area -->
@endsection