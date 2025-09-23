<!-- Certifications Section -->
<section id="certifications" class="section bg-white" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
        <h2 class="section-title">{{ __('Certifications') }}</h2>
        <div class="certificate-grid">
            <!-- Loop dari table CERTIFICATIONS -->
            @foreach ($user->certifications as $certification)
                <div class="certificate-item">
                <h3>{{ $certification->cert_name }}</h3>
                <p>{{ __('By') }}: {{ $certification->issuing_organization }}</p>
                <p>{{ __('Issued') }}: {{ $certification->issue_date }}</p>
                <p>{{ __('Expires') }}: {{ $certification->expired_date ?? '-' }}</p>
                <a href="{{ $certification->file->file_url ?? 'no-file-url' }}" style="text-decoration: none;">{{ __('View Certificate') }}</a>
            </div>
            @endforeach
        </div>
    </div>
</section>