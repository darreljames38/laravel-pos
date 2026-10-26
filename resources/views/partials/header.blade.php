<header class="site-header">
    <nav class="navbar">
        <a href="{{ route('home') }}" class="logo">
            POS System
        </a>

        <div class="nav-links">
            <a
                href="{{ route('home') }}"
                class="{{ request()->routeIs('home') ? 'active' : '' }}"
            >
                Home
            </a>

            <a
                href="{{ route('customers.index') }}"
                class="{{ request()->routeIs('customers.*') ? 'active' : '' }}"
            >
                Customers
            </a>

            <a
                href="{{ route('users.index') }}"
                class="{{ request()->routeIs('users.*') ? 'active' : '' }}"
            >
                Users
            </a>

            <a
                href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'active' : '' }}"
            >
                About
            </a>
        </div>
    </nav>
</header>