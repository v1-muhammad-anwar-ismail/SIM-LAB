<footer class="public-footer">
    <div class="footer-container">
        <!-- Brand & Tagline -->
        <div class="footer-brand">
            <a href="{{ url('/') }}" style="text-decoration: none;">
                <h2 class="footer-logo" style="margin-bottom: 0.5rem;">SIM-LAB <span class="text-cyan">UNESA</span></h2>
            </a>
            <p class="footer-tagline">{{ __('public.footer.tagline') }}</p>
            
            <div class="footer-socials">
                <a href="https://www.instagram.com/tiunesa/" target="_blank" title="Instagram TI Unesa">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path><line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line></svg>
                </a>
                <a href="https://www.linkedin.com/school/universitas-negeri-surabaya/" target="_blank" title="LinkedIn Universitas Negeri Surabaya">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
                </a>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="footer-links">
            <h3 class="footer-heading">{{ __('public.footer.nav_title') }}</h3>
            <ul>
                <li><a href="{{ url('/') }}">{{ __('public.footer.nav_home') }}</a></li>
                <li><a href="{{ url('/schedule') }}">{{ __('public.footer.nav_schedule') }}</a></li>
                <li><a href="{{ url('/about') }}">{{ __('public.footer.nav_about') }}</a></li>
                @guest
                    <li><a href="{{ route('login') }}">{{ __('public.footer.nav_login') }}</a></li>
                @endguest
            </ul>
        </div>

        <!-- Contact & Support -->
        <div class="footer-contact">
            <h3 class="footer-heading">{{ __('public.footer.contact_title') }}</h3>
            <p><strong>{{ __('public.footer.contact_building') }}</strong></p>
            <p>{{ __('public.footer.contact_campus') }}</p>
            <p class="mt-2">
                <a href="tel:+62318280009" style="display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                    +6231 - 8280009
                </a>
            </p>
            <p>
                <a href="mailto:s1-ti@unesa.ac.id" style="display:flex; align-items:center; gap:8px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
                    s1-ti@unesa.ac.id
                </a>
            </p>
        </div>
    </div>
    
    <div class="footer-bottom">
        <p>&copy; {{ date('Y') }} Universitas Negeri Surabaya. {{ __('public.footer.copyright') }} <span class="motto">"Growing With Character"</span></p>
    </div>
</footer>

<style>
    .public-footer {
        background: #02040a;
        border-top: 1px solid rgba(0, 217, 255, 0.15);
        padding-top: 2rem;
        font-family: 'Inter', sans-serif;
        color: var(--text-muted, #94a3b8);
        position: relative;
        z-index: 10;
        margin-top: 2rem;
    }
    
    .footer-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 2rem 1.5rem 2rem;
        display: grid;
        grid-template-columns: 2fr 1fr 1.5fr;
        gap: 2rem;
    }

    .footer-logo {
        color: #fff;
        font-size: 1.5rem;
        font-weight: 900;
        letter-spacing: 0.1em;
        margin: 0 0 1rem 0;
    }
    .footer-logo .text-cyan { color: #00d9ff; }

    .footer-tagline {
        font-size: 0.95rem;
        line-height: 1.6;
        max-width: 350px;
    }

    .footer-heading {
        color: #fff;
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 1.25rem 0;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .footer-links ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li { margin-bottom: 0.75rem; }

    .footer-links a {
        color: var(--text-muted, #94a3b8);
        text-decoration: none;
        transition: color 0.3s;
        font-size: 0.95rem;
    }
    
    .footer-links a:hover { color: #00d9ff; }

    .footer-contact p {
        margin: 0 0 0.5rem 0;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    
    .footer-contact a {
        color: var(--text-muted, #94a3b8);
        text-decoration: none;
        transition: color 0.3s;
    }
    
    .footer-contact a:hover {
        color: #00d9ff;
    }
    
    .footer-contact .mt-2 { margin-top: 1rem; }

    .footer-socials {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .footer-socials a {
        color: var(--text-muted);
        transition: all 0.3s;
        display: flex;
        align-items: center;
        justify-content: center;
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        text-decoration: none;
    }

    .footer-socials a:hover {
        color: #00d9ff;
        background: rgba(0, 217, 255, 0.15);
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 217, 255, 0.2);
    }

    .footer-bottom {
        border-top: 1px solid rgba(255,255,255,0.05);
        text-align: center;
        padding: 1rem;
        font-size: 0.8rem;
        background: #010205;
    }

    .footer-bottom .motto {
        color: #00d9ff;
        font-weight: 600;
        font-style: italic;
    }

    @media (max-width: 768px) {
        .footer-container {
            grid-template-columns: 1fr;
            gap: 2rem;
            text-align: center;
        }
        .footer-tagline { margin: 0 auto; }
        .public-footer { padding-top: 3rem; margin-top: 2rem; }
    }
</style>
