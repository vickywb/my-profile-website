{{-- Projects Section --}}
<section id="projects" class="section" data-aos="fade-up" data-aos-duration="2000">
    <div class="container">
        <h2 class="section-title">{{ __('Featured Projects') }}</h2>
 
        <div class="projects-grid">
            @foreach ($user->projects as $index => $project)
                <div class="project-card {{ $index >= 3 ? 'project-hidden' : '' }}">
                    <div class="project-image">
                        <img src="{{ asset($project->file->file_url ?? 'https://placehold.co/600x400') }}"
                            alt="{{ Str::slug($project->project_title ?? 'no-title') }}">
                    </div>
                    <div class="project-content">
                        <h3 class="project-title">{{ $project->project_title }}</h3>
                        <p>{!! $project->description !!}</p>
 
                        @if ($project->technologies->isNotEmpty())
                            <div class="project-tech">
                                @foreach ($project->technologies as $technology)
                                    <span class="tech-tag">{{ $technology->name }}</span>
                                @endforeach
                            </div>
                        @endif
 
                        <div class="project-links">
                            @if (!empty($project->live_url))
                                <a href="{{ $project->live_url }}" target="_blank" class="project-link">Live Demo</a>
                            @endif
                            @if (!empty($project->github_url))
                                <a href="{{ $project->github_url }}" target="_blank" class="project-link">Source Code</a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
 
        @if ($user->projects->count() > 3)
            <div class="load-more-container">
                <button id="loadMoreBtn" class="btn-load-more">
                    Show All Projects
                    <span id="projectCount">({{ $user->projects->count() - 3 }} more)</span>
                </button>
            </div>
        @endif
    </div>
</section>

<script>
    const loadMoreBtn = document.getElementById('loadMoreBtn');
 
    if (loadMoreBtn) {
        loadMoreBtn.addEventListener('click', function () {
            const hiddenProjects = document.querySelectorAll('.project-hidden');
 
            hiddenProjects.forEach(function (project, i) {
                project.classList.remove('project-hidden');
                // Stagger animation tiap card
                project.style.animationDelay = (i * 0.08) + 's';
                project.classList.add('reveal');
            });
 
            // Sembunyikan tombol setelah semua muncul
            this.style.display = 'none';
        });
    }
</script>