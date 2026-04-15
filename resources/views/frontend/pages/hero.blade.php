<!-- Hero Section -->
<section id="home" class="hero" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
    
        <div class="about-grid">
            <div class="about-image">
                <img src="{{ asset($user->userProfile->profileImage->file_url ?? 'no-photo-available') }}" alt="profile-image-{{ Str::slug($user->name ?? 'no-name') ?? 'no-image' }}">
            </div>
        <div>

        <div class="about-text">

            <div class="text-white">
                <h1>Hi, {{ __("I'm") }} {{ $user->name ?? 'No Name Available' }}</h1>
                <h2>{{ __('A FullStack Web Developer') }}</h2>
                <p>{{ $user->userProfile->bio_translation ?? 'No Bio Available' }}</p>
            </div>

            <div class="cta-buttons">
                <a href="#projects" class="btn btn-primary">Portofolio</a>
                <a href="mailto:{{ $user->email }}" class="btn">{{ __('Get In Touch') }}</a>
                @if ($user->userCvUploaded)
                    <a href="{{ route('download.cv') }}" class="btn">{{ __('Download CV') }}</a>
                @else
                    <a href="#" class="btn disabled" aria-disabled="true" tabindex="-1">{{ __('No CV Available') }}</a>
                @endif
            </div>

        </div>
        
    </div>
</section>