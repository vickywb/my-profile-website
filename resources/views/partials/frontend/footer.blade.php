<!-- Footer -->
<footer class="footer">
    <div class="container">
        <!-- Loop dari table SOCIAL_LINKS (ORDER BY display_order) -->
            <div class="social-links">
                
        @foreach ($user->socialLinks as $socialLink)
            <a href="{{ $socialLink->platform_url }}" class="social-link">
                <i class="{{ $socialLink->icon_class }}"></i>
            </a>
        @endforeach

        </div>
        <p>&copy; {{ date('Y') }}. Vicky Wibisono. {{ __('All rights reserved') }}.</p>
    </div>
</footer>