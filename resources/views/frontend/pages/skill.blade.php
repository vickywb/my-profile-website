<!-- Skills Section -->
<section id="skills" class="section bg-white" data-aos="fade-up" data-aos-duration="2000">
        <div class="container">

        <h2 class="section-title">{{ __('Skills & Expertise') }}</h2>
        
        <!-- Loop dari table SKILLS -->
        <div class="skills-grid">
            @foreach ($categorySkill as $categoryName => $skills)
                <div class="skill-category">
                    <div class="skill-name">{{ $categoryName }}</div>
                    <div class="skill-item d-flex gap-2 flex-wrap" style="">
                        @foreach ($skills as $skillItem)
                            <span class="skill-tag">{{ $skillItem->skill_name }}</span>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>