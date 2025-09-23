<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
<script>
  AOS.init();
</script>
<script>
    // Toggle Mobile Navigation
    function toggleMobileNav() {
        const mainNav = document.getElementById('mainNav');
        const mobileToggle = document.querySelector('.mobile-toggle');
        
        mainNav.classList.toggle('active');
        mobileToggle.classList.toggle('active');
    }

    // Close Mobile Navigation
    function closeMobileNav() {
        const mainNav = document.getElementById('mainNav');
        const mobileToggle = document.querySelector('.mobile-toggle');
        
        mainNav.classList.remove('active');
        mobileToggle.classList.remove('active');
    }

    // Smooth scrolling for navigation links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
            // Tambahkan ini untuk menutup nav setelah klik link
            closeMobileNav();
        });
    });

    // Toggle Dropdown menu on click (for mobile)
    document.querySelectorAll('.dropdown-toggle').forEach(toggle => {
        toggle.addEventListener('click', function (e) {
            // Mencegah navigasi atau event lain
            e.preventDefault();
            // Menghentikan event dari "menggelembung" ke dokumen
            e.stopPropagation();

            // Sembunyikan semua dropdown menu yang lain
            document.querySelectorAll('.dropdown-menu.show').forEach(menu => {
                if (menu !== this.nextElementSibling) {
                    menu.classList.remove('show');
                }
            });

            // Toggle dropdown yang terkait
            this.nextElementSibling.classList.toggle('show');
        });
    });

    // Close mobile nav and dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const mainNav = document.getElementById('mainNav');
        const navbar = document.querySelector('.nav-content');
        
        // Tutup nav mobile jika klik di luar navbar
        if (!navbar.contains(event.target) && mainNav.classList.contains('active')) {
            closeMobileNav();
        }

        // Tutup semua dropdown
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.classList.remove('show');
        });
    });
</script>