## Changelog

### v1.1.3

- Add custom console make command

---

### v1.1.2

- Fix make component command

---

### v1.1.1

- Update composer dependencies

---

### v1.1.0

- Remove storage:link command

---

### v1.0.9

- Fixed symlink creation failure in the `assets:publish` command under Docker/staging environments.

---

### v1.0.8

- Fixed assets:publish command

### v1.0.7

- Fixed make:test command

---

### v1.0.6

- Removed db:seed command

---

### v1.0.5

- Fix command make:model to generate migrations

---

### v1.0.4

#### Added

- Modular migration system with automatic **module-based table prefixes**.
- Custom `make:migration` command adapted to the Laravel Runtime.
- New command `assets:publish` added to make publish resources.
- Automatic prefix resolution based on the module/package name defined in `composer.json`.

#### Changed

- Migration generation now enforces prefixed table names to prevent database collisions.
- Internal migration naming strategy updated to ensure uniqueness across modules.
- Runtime command registration adjusted to support custom migration generators without relying on traditional Service Providers.

#### Fixed

- Prevented table name collisions between modules and third-party packages.
- Resolved dependency resolution issues related to `MigrationCreator` in a Service Provider–less runtime.
- Ensured migrations can coexist safely in shared databases across multiple modules.

#### Architecture

- Established a **critical foundation for true modularity** by isolating database schema per module.
- Enabled safe installation and coexistence of multiple modules within the same application and database.
