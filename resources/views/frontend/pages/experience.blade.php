<!-- Experience Section -->
<section id="experience" class="section" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
        <h2 class="section-title">{{ __('Work Experiences') }}</h2>
        <div class="timeline">
            <!-- Loop dari table EXPERIENCES -->
            @foreach ($user->experiences as $experience)
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-date">{{ $experience->start_date }} - {{ $experience->end_date }}</div>
                    <h3>{{ $experience->position }}</h3>
                    <h4>{{ $experience->company_name }}</h4>
                    <p>{{ $experience->location }}</p>
                    <div class="job-description">
                        {!! $experience->job_description !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>