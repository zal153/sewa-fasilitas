@extends('layouts.landing')
@section('title', 'Landing Page')

@section('contentLanding')
    <main class="main">

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">

            <img src="landing/assets/img/hero.jpg" alt="" data-aos="fade-in">

            <div class="container">
                <h2 data-aos="fade-up" data-aos-delay="100">Selamat Datang di,<br>Website Sewa Fasilitas Kampus</h2>
                <p data-aos="fade-up" data-aos-delay="200">Universitas Bahaudin Mudhary Madura</p>
                <div class="d-flex mt-4" data-aos="fade-up" data-aos-delay="300">
                    {{-- <a href="courses.html" class="btn-get-started"></a> --}}
                </div>
            </div>

        </section><!-- /Hero Section -->

    </main>
@endsection
