# Laravel Runtime

Laravel Runtime is a lightweight **bridge library** built on top of the Laravel framework. It is designed to help you create **modular applications or mini-frameworks** that rely on Laravel only where it adds real value.

Instead of extending or forking Laravel, this library constrains it.

---

## 🎯 Purpose

Laravel Runtime exists to support **custom runtimes and mini-frameworks** that:

- Use Laravel as a dependency
- Do not require the full Laravel feature set
- Need a clean, controlled Artisan environment
- Want to stay upgrade-safe over time

A real-world example is **Elymod**, a modular mini-framework built on top of Laravel Runtime. Elymod uses familiar Laravel `make:*` commands while enforcing a reduced and predictable runtime.

---

## ✨ Core Features

- **Selective Artisan Commands**
  Only explicitly allowed commands are exposed (for example, `make:*`).

- **Custom Runtime Bootstrap**
  Overrides Laravel’s Application and Console Kernel to control initialization.

- **Command Map Filtering**
  Internally filters Laravel’s command registry without modifying vendor files.

- **Upgrade-Safe by Design**
  No forks, no vendor hacks, no fragile overrides.

- **Framework-Oriented**
  Ideal for building modular systems, internal platforms, or opinionated runtimes.

---

## 📦 Installation

```bash
composer require elyerr/laravel-runtime
```

Laravel Runtime is meant to be **embedded**, not used as a standalone framework.

---

## 🏗 Architecture

```
project
 └── laravel-runtime
      ├── composer.json
      ├── README.md
      └── src
           ├── App
           │    ├── Application.php
           │    └── ApplicationBuilder.php
           └── Console
                ├── Application.php
                └── Kernel.php
```

```
application (elymod)
   → laravel-runtime
       → laravel/framework
```

---

## 🧠 Design Philosophy

Laravel Runtime is **not a Laravel replacement**.

It is a **control layer** that allows you to:

- Expose only what your system needs
- Keep developer ergonomics familiar
- Prevent framework sprawl in modular applications
- Build long-lived architectures on top of Laravel

---

## 🧪 Compatibility

- Laravel 12.x
- PHP 8.2+

---

## 📄 License

[MIT License](./LINCESE.md)

---

## 👤 Author

**Elvis Yerel Roman Concha**
Framework & Runtime Architecture
