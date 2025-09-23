<!-- Projects Section -->
<section id="projects" class="section" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
        <h2 class="section-title">{{ __('Featured Projects') }}</h2>
        <div class="projects-grid">
            <!-- Loop dari table PROJECTS + PROJECT_TECHNOLOGIES -->
            @foreach ($user->projects as $project)
                <div class="project-card">
                <div class="project-image">
                    <img src="{{ asset($project->file->file_url ?? 'https://placehold.co/300') }}" alt="project-image-{{ Str::slug($project->project_title ?? 'no-title') ?? 'no-image' }}">
                </div>
                <div class="project-content">
                    <h3 class="project-title">{{ $project->project_title }}</h3>
                    <p>{!! $project->description !!}</p>
                    <div class="project-tech">
                        <!-- Loop PROJECT_TECHNOLOGIES -->
                       @foreach ($project->technologies as $technology)
                        <span class="tech-tag">{{ $technology->name }}</span>
                       @endforeach
                    </div>
                    <div class="project-links">
                        {{-- <a href="{{ $project->project_url ?? '-' }}" class="project-link">Live Demo</a> --}}
                        <a href="{{ $project->github_url ?? '-' }}" class="project-link">Source Code</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>