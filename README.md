# Laravel Runtime

**Laravel Runtime** is the development runtime layer that powers **Elymod**, providing a standardized environment for building modules that integrate seamlessly with a Laravel application.

It was created to solve a common challenge in modular architectures: **developing modules with the same developer experience as Laravel while maintaining strict control over what can be generated and executed inside a module.**

Laravel Runtime is intended for **module development**, not for production execution. Once a module is built, it runs directly on the host Laravel application.

---

## 🎯 Purpose

Laravel Runtime provides a familiar Laravel development experience when creating Elymod modules.

It allows module developers to use Laravel-style generators and tooling while enforcing the conventions and boundaries required by a modular architecture.

Instead of creating a separate framework, Laravel Runtime acts as a development layer that inherits Laravel's behavior and exposes only the features needed for module creation.

---

## 🧩 The Problem It Solves

When building modular systems, developers often need:

- Laravel generators (`make:model`, `make:controller`, `make:component`, etc.)
- Consistent file structures
- Standardized namespaces
- Predictable module conventions

However, exposing the entire Laravel framework during module development can lead to:

- Uncontrolled resource generation
- Inconsistent module structures
- Framework-specific artifacts that do not belong inside modules
- Increased maintenance complexity

Laravel Runtime solves this by providing a controlled development environment that mirrors Laravel's workflow while enforcing modular standards.

---

## ✨ Core Features

### Laravel-Like Development Experience

Develop modules using familiar Artisan commands and workflows.

```bash
php artisan make:model User
php artisan make:controller UserController
php artisan make:component UserCard
```

### Controlled Artisan Environment

Laravel Runtime exposes only a curated set of commands required for module development.

This prevents accidental generation of resources that do not belong within a module while preserving the familiar Laravel developer experience.

### Module-Aware Generators

Generated resources automatically follow Elymod conventions, including:

- Namespaces
- View namespaces
- Directory structures
- Module prefixes

### Runtime Inheritance

Laravel Runtime inherits Laravel's behavior and development tooling rather than reimplementing it.

This allows developers to benefit from Laravel's ecosystem while maintaining Elymod's modular architecture.

### Consistent Module Structure

All generated resources follow the same conventions, making modules predictable and easier to maintain.

### Upgrade-Safe Design

Laravel Runtime does not modify, fork, or patch Laravel.

Instead, it builds on top of Laravel's existing infrastructure, making framework upgrades significantly easier.

---

## 🏗 Development Workflow

Laravel Runtime is used only while developing modules.

```text
Module Development
        │
        ▼
 Laravel Runtime
        │
        ▼
 Laravel Framework
```

Once a module is completed and installed:

```text
Host Laravel Application
        │
        ▼
      Elymod
        │
        ▼
      Module
```

The module executes directly on the host Laravel application.

Laravel Runtime is no longer required at runtime.

---

## 🏗 Real-World Usage: Elymod

Elymod uses Laravel Runtime as its module development environment.

Developers can create module resources using familiar Artisan commands while ensuring that every generated file adheres to Elymod's conventions.

Examples include:

- Models
- Controllers
- Requests
- Components
- Migrations
- Seeders
- Factories
- Commands

This allows developers to work as if they were inside a standard Laravel application while producing fully modular resources.

---

## 🧠 Design Philosophy

Laravel Runtime is not a framework.

It is not a Laravel replacement.

It is a development layer that:

- Inherits Laravel's developer experience
- Restricts execution to approved tooling
- Standardizes module generation
- Preserves modular architecture

The goal is simple:

**Develop modules like Laravel. Deploy modules into Elymod. Run modules on the host application.**

---

## 📦 Installation

```bash
composer require elyerr/laravel-runtime
```

Laravel Runtime is intended for module development and should be integrated into systems that require a controlled Laravel-based modular workflow.

---

## 🧪 Compatibility

- Laravel 12.x
- PHP 8.2+

---

## 📄 License

MIT License

---

## 👤 Author

**Elvis Yerel Roman Concha**

Modular Architecture & Runtime Systems
