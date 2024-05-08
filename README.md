# URL Shortener

This project is a URL shortener built with Laravel and Vue.js, leveraging Inertia.js for a single-page application (SPA) feel. It features a responsive design using Tailwind CSS and includes safety checks via the Google Safe Browsing API to ensure that only safe URLs are shortened and accessed.

## Features

- **Shorten URLs**: Convert long URLs into a manageable and shareable short format.
- **Safety Checks**: Every URL submitted is checked against Google Safe Browsing lists to prevent malicious sites from being shortened.
- **Responsive Design**: Built with Tailwind CSS, ensuring that the application is fully responsive and functional on all devices.
- **Single-Page Application**: Utilizes Inertia.js to provide a seamless user experience without full page reloads.

## Requirements

- PHP >= 8.2
- Composer
- Node.js and npm
- Laravel >= 11.x
- MySQL or a compatible database system

## Installation

Follow these instructions to set up the project on your local machine.

### Clone the repository

```bash
git clone https://github.com/albaremotepro/url-shortener-app.git
cd url-shortener-app
```

### Install PHP dependencies

```bash
composer install
```

### Setup Environment

Copy the `.env.example` file to `.env` and adjust the database settings along with any other configurations.

```bash
cp .env.example .env
```

### Generate Application Key

```bash
php artisan key:generate
```

### Install Node.js dependencies

```bash
npm install
```

### Run database migrations

```bash
php artisan migrate
```

### Build assets

```bash
npm run dev
```

## Usage

Start the application using Laravel's built-in server:

```bash
php artisan serve
```

Visit the application in your web browser at the URL provided in the command output, typically `http://localhost:8000`.

## Adding URLs

- Navigate to the home page.
- Input the URL you want to shorten.
- Submit the form, and if the URL is safe, receive a shortened version.

## Configuration

- **Database Configuration**: Set your database and other environmental settings in the `.env` file.
- **Google Safe Browsing API**: Obtain and set your Google API key in the `.env` file as `GOOGLE_SAFE_BROWSING_API_KEY`.