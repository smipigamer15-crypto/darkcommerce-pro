# 🛍️ DarkCommerce Pro

![Laravel](https://img.shields.io/badge/Laravel-12.0-red?style=for-the-badge&logo=laravel)
![PHP](https://img.shields.io/badge/PHP-8.4-blue?style=for-the-badge&logo=php)
![Tailwind](https://img.shields.io/badge/Tailwind-CSS-38B2AC?style=for-the-badge&logo=tailwind-css)
![Docker](https://img.shields.io/badge/Docker-Ready-2496ED?style=for-the-badge&logo=docker)
![License](https://img.shields.io/badge/License-MIT-green?style=for-the-badge)

> A premium dark-themed eCommerce platform built with Laravel 12 and Docker.  
> Inspired by the design principles of Apple, Stripe, Linear, and Vercel.

---

# ✨ Features

## 🏠 Homepage

- Animated Hero section with modern gradients
- Brand marquee slider
- Featured products with hover effects
- Flash Sale with a live countdown timer (configurable from the admin panel)
- Animated statistics counters (products, customers, orders)
- Customer testimonials with star ratings
- Newsletter subscription
- CTA section for guest visitors

## 🛒 Product Catalog

- Product filtering by price and category
- Sorting (Newest, Price ↑↓)
- Search with query history
- Dark-themed pagination
- Quick View on hover
- Discount badges with percentage display

## 📱 Product Page

- Product image gallery
- Star rating system with rating distribution
- Verified customer reviews
- Related products
- Breadcrumb navigation
- Stock status (In Stock / Low Stock / Out of Stock)

## 🛒 Shopping Cart

- 60-minute cart reservation timer
- Discount coupons (WELCOME10, SAVE20, BLACKFRIDAY)
- Gift cards
- Loyalty points (5% cashback)
- Dynamic price recalculation

## 💳 Checkout

- Guest checkout (no registration required)
- Stripe payments (Test card: **4242 4242 4242 4242**)
- Cash on Delivery
- Loyalty points redemption
- Order confirmation emails

## 👤 User Dashboard

- Statistics dashboard with responsive grid
- Profile page with gradient cards
- Order history with status progress bars
- Product Returns (RMA system)
- Wishlist
- Recently viewed products carousel
- Loyalty points overview
- Newsletter subscription management

## 👑 Admin Panel

- Analytics dashboard
- Product management (CRUD)
- Order management with status updates
- User & role management
- Flash Sale configuration
- Newsletter subscribers management
- Returns (RMA) processing
- Livewire-powered support chat

## 🌐 Additional Features

- Multi-language support (EN / UA / PL)
- SEO optimization (Sitemap, Meta tags, Open Graph, Canonical URLs)
- Toast push notifications
- Fully responsive mobile-first design
- Dark mode by default
- Custom pagination
- Font Awesome icons

---

# 🛠 Tech Stack

| Category | Technology |
|----------|------------|
| **Backend** | Laravel 12, PHP 8.4 |
| **Frontend** | Blade, Tailwind CSS, Alpine.js, Font Awesome |
| **Database** | MySQL 8.0 |
| **Cache** | Redis |
| **Payments** | Stripe (Test Mode) |
| **DevOps** | Docker, Docker Compose, Nginx |
| **Architecture** | SOLID, Repository Pattern, DTO, Service Layer |

---

# 🚀 Quick Start

## Requirements

- Docker Desktop
- Git

## Installation

```bash
# Clone the repository
git clone https://github.com/your-username/darkcommerce-pro.git
cd darkcommerce-pro

# Start Docker containers
docker compose up -d --build

# Install dependencies
docker compose exec app composer install

# Run migrations and seeders
docker compose exec app php artisan migrate:fresh --seed

# Open in your browser
http://localhost:8000
```

## Demo Credentials

| Role | Email | Password |
|------|-------|----------|
| **Administrator** | admin@darkcommerce.com | password |
| **User** | user@darkcommerce.com | password |

## Stripe Testing

- **Card Number:** 4242 4242 4242 4242
- **Expiration Date:** Any future date
- **CVC:** Any 3 digits

---

# 📁 Project Structure

```text
darkcommerce-pro/
├── app/
│   ├── DTO/
│   ├── Enums/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Livewire/
│   │   └── Middleware/
│   ├── Livewire/
│   ├── Mail/
│   ├── Models/
│   ├── Repositories/
│   └── Services/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── docker/
│   ├── Dockerfile
│   └── nginx/
├── lang/
│   ├── en/
│   ├── uk/
│   └── pl/
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   ├── auth/
│   │   ├── cart/
│   │   ├── checkout/
│   │   ├── components/
│   │   ├── layouts/
│   │   ├── livewire/
│   │   ├── newsletter/
│   │   ├── orders/
│   │   ├── products/
│   │   ├── profile/
│   │   ├── returns/
│   │   ├── search/
│   │   └── wishlist/
│   ├── css/
│   └── js/
├── routes/
│   └── web.php
├── docker-compose.yml
└── README.md
```

---

# 🎨 Design Highlights

- Dark background (`#09090B`)
- Indigo accent (`#6366F1`)
- Beautiful gradients (Indigo → Purple → Pink)
- Glassmorphism UI effects
- Smooth hover animations
- Modern micro-interactions (Toast, Pulse, Bounce)
- Skeleton loading states
- Custom scrollbar
- Floating action buttons
- Sticky navigation bar with backdrop blur

---

# 📊 Demo Data

- 100+ Products (Electronics, Fashion, Sports, Home & Living)
- 10 Brands
- 10 Categories
- Coupons: `WELCOME10`, `SAVE20`, `BLACKFRIDAY`
- Gift Cards
- Flash Sale products

---

# 🔄 API (Coming Soon)

- REST API for mobile applications
- Laravel Sanctum authentication
- API Resources
- Swagger documentation

---

# 📝 License

This project is licensed under the **MIT License**.

You are free to use it for both personal and commercial projects.

---

# 👨‍💻 Author

Made with ❤️ for the Laravel community.

**DarkCommerce Pro** © 2024–2026. All rights reserved.