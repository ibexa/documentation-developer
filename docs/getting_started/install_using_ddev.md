# Ibexa DXP Installation Using DDEV

This guide provides a step-by-step walkthrough of installing Ibexa DXP using DDEV. DDEV is an open-source tool that simplifies the process of setting up local PHP development environments.

## System Requirements

For a successful installation, ensure you have the following software installed:

- Docker
- DDEV

## Installation Steps

### 1. Create a DDEV Project Directory

Start by creating a directory for your DDEV project. Navigate to your desired location in the terminal, then use the following command to create a new directory:

```bash
mkdir my-ddev-project && cd my-ddev-project
```

Replace `my-ddev-project` with your desired directory name.

### 2. Configure DDEV

Next, configure your DDEV environment using the command below:

```bash
ddev config --project-type=php --docroot=public --create-docroot --php-version 8.1
```

This command sets the project type to PHP, the document root to the `public` directory, creates the document root, and sets the PHP version to 8.1.

#### Optional: Switch to PostgreSQL Database

By default, DDEV uses MySQL (MariaDB). To use PostgreSQL instead, add the following flag to the above command:

```bash
--database=postgres:15
```

#### Optional: Enable Mutagen

If you're using MacOS you might wish to enable Mutagen. You can do this by running the following command:

```bash
ddev config --mutagen-enabled
```

### 3. Configure Database Connection

Now, configure the database connection for your Ibexa DXP project. Depending on your database of choice (MySQL or PostgreSQL), use the appropriate command:

For MySQL

```bash
ddev config --web-environment-add DATABASE_URL=mysql://db:db@db:3306/db
```

For PostgreSQL

```bash
ddev config --web-environment-add DATABASE_URL=postgresql://db:db@db:5432/db
```

### 4. Start DDEV

Proceed by starting your DDEV environment with the following command:

```bash
ddev start
```

#### Additional Configuration for Commerce, Experience, and Content Editions

If you're installing the Commerce, Experience, or Content Editions of Ibexa DXP, modify the composer configuration **after** executing the ddev start command.

```bash
ddev composer config --global http-basic.updates.ibexa.co <installation-key> <token-password>
```

Replace `<installation-key>` and `<token-password>` with your actual installation key and token password, respectively.

### 5. Create Ibexa DXP Project

Once DDEV is running, use Composer to create a new Ibexa DXP project. Remember to replace `<edition>` and `<version>` with your desired edition and versions respectively.

```bash
ddev composer create ibexa/<edition>-skeleton:<version>
```

### 6. Install DXP and Database

Once you've made this change, you can proceed to install Ibexa DXP.

```bash
ddev exec php bin/console ibexa:install
ddev exec php bin/console ibexa:graphql:generate-schema
```

### 7. Open browser

Once the above steps are completed, open your Ibexa DXP webpage by running the `ddev launch` command.
