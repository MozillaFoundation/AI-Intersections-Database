# aidatabase.mozilla.org

## Getting started

Review the README for information about setting up a development environment and compiling scripts/styles.

- [Setup with Docker](#setting-up-development-environment-with-docker)
- [Install dependencies](#installing-dependencies)

## Setting up development environment with Docker

**Requirements**: Docker ([Docker Desktop](https://www.docker.com/products/docker-desktop) for macOS and Windows or [Docker Compose](https://docs.docker.com/compose/install/) for Linux).

### Setup steps

- Instantiate a fresh [WordPress installation](https://github.com/docker/awesome-compose/tree/master/wordpress-mysql)
- Clone the repository (`git clone https://github.com/MozillaFoundation/AI-Intersections-Database.git`) into the root
- Run `docker-compose up -d`

The repository contains the base theme and corresponding sync plugin in their subsequent directories (`wp-content/themes/mozilla-ai-intersections` and `wp-content/plugins/mozilla-salesforce-sync`). Once the environment has been configured, activate the theme and plugin in the WordPress admin and run the Salesforce Sync (found in the main WordPress navigation sidebar).

## Installing dependencies

To properly compile styles and scripts, make sure to install the following dependencies...

- `autoprefixer`
- `concurrently`
- `cross-fetch`
- `cssnano`
- `dotenv`
- `esbuild`
- `node-fetch`
- `postcss`
- `postcss-import`
- `postcss-nested`
- `postcss-nested-ancestors`
- `tailwindcss`
- `terser`

### Steps to install

- Navigate to theme directory (`cd wp-content/themes/mozilla-ai-intersections`)
- Initialize npm (`npm init -y`)
- Install dependencies (`npm install autoprefixer@^10.4.14 concurrently@^7.6.0 cross-fetch@^3.1.5 cssnano@^7.0.1 dotenv@^16.0.3 esbuild@^0.17.12 node-fetch@^3.3.1 postcss@^8.4.21 postcss-import@^15.1.0 postcss-nested@^6.0.1 postcss-nested-ancestors@^3.0.0 tailwindcss@^3.4.1 terser@^5.31.0`)
- Run `npm run watch` to listen for codebase updates and recompile scripts/styles
- Repeat for plugin directory (`cd wp-content/plugins/mozilla-salesforce-sync`)

These commands will add `node_modules` to the theme and plugin directories. Running `npm run watch` enables Tailwind compilation and the proper compilation/minification of all PHP, CSS, and JavaScript files within each directory. The resulting CSS and JavaScript files will live in `dist/css` and `dist/js` respectively.

### Styling notes

This build utilizes Tailwind syntax, both in designated stylesheets and inlined classes added directly to elements. Review the [official Tailwind documentation](https://tailwindcss.com/docs/installation) for more information.
