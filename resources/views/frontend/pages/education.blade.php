<!-- Education Section -->
<section id="education" class="section bg-white" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
        <h2 class="section-title">{{ __('Educations') }}</h2>
        <div class="timeline">
            <!-- Loop dari table EDUCATION -->
            <div class="timeline-item">
                <div class="timeline-content">
                    <div class="timeline-date">{{ $user->education->start_at }} - {{ $user->education->end_at }}</div>
                    @if (App::getLocale() === 'en')
                        <h3>{{ $user->education->degree }} in {{ $user->education->field_of_study }}</h3>
                    @else
                        <h3>Tenik Informatika</h3>
                    @endif
                    <h4>{{ $user->education->institution_name }}</h4>
                    <p>{{ __('GPA') }}: {{ $user->education->grade_gpa }}</p>
                </div>
            </div>
        </div>
    </div>
</section>