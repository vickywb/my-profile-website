<nav class="navbar">
    <div class="container" style="display:flex">
        <div class="nav-content">
            <div class="logo">{{ $user->name }}</div>
            
            <!-- Desktop Navigation -->
            <ul class="nav-links" id="mainNav">
                <li><a href="#home">{{ __('Home') }}</a></li>
                <li><a href="#skills">{{ __('Skills') }}</a></li>
                <li><a href="#experience">{{ __('Experiences') }}</a></li>
                <li><a href="#projects">{{ __('Projects') }}</a></li>
                <li class="dropdown">
                    <a href="" class="dropdown-toggle">{{ __('Languages') }}</a>
                    <ul class="dropdown-menu">
                        <li><a href="{{ route('lang.switch', ['lang' => 'en']) }}" class="{{ app()->getLocale() === 'en' ? 'active' : '' }}">English</a></li>
                        <li><a href="{{ route('lang.switch', ['lang' => 'id']) }}" class="{{ app()->getLocale() === 'id' ? 'active' : '' }}">Indonesia</a></li>
                    </ul>
                </li>
            </ul>
            
            <div class="mobile-toggle" onclick="toggleMobileNav()">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>
</nav>