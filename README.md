# Laracord.com

Welcome to the official website and documentation for [Laracord](https://laracord.com)!

## Bug Reports

If you discover any bugs in Laracord.com, please [open an issue](https://github.com/laracord/laracord.com/issues). Your feedback helps us improve!

## Contributing

We encourage contributions in various forms such as:

- **Pull Requests (PRs)**: Submit code changes or improvements.
- **Reporting Issues**: If you encounter any bugs or problems, report them.
- **Suggesting Ideas**: Have an idea to enhance the project? We welcome new ideas!

All contributions are appreciated.

## License

Laracord.com is open-source software licensed under the [MIT License](LICENSE.md).

---

# Project Setup Guide

Follow these steps to set up the `laracord.com` project on your local machine.

## Prerequisites

Before starting, make sure you have the following tools installed:

- [Git](https://git-scm.com/) - For version control and repository management.
- [Composer](https://getcomposer.org/) - PHP dependency manager.
- [PHP](https://www.php.net/) - Version 8.0 or higher.

---

## Steps to Set Up the Project

### 1. Clone the Git Repository

First, clone the repository to your local machine by running:

```bash
git clone git@github.com:laracord/laracord.com.git
```

### 2. Install PHP Dependencies

Navigate to the project directory:

```bash
cd laracord.com
```

Next, use Composer to install all required PHP dependencies:

```bash
composer install
```

This will download and install all the necessary packages listed in `composer.json.`

### 3. Copy the Environment File

The project includes an example environment file (`.env.example`) with sample settings. Copy this file to create your own `.env `configuration:

```bash
cp .env.example .env
```
