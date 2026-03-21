FROM mcr.microsoft.com/devcontainers/php:8.3

USER root

# Install required PHP extensions for Psalm and Nextcloud (minimal set)
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    && docker-php-ext-install dom simplexml xml mbstring zip curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer if not present
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /workspace

# Copy composer files from project root
COPY composer.json composer.lock ./

# Install dependencies as root
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist

# Copy source code
COPY . .

# Set permissions (skip if user doesn't exist)
RUN chown -R vscode:vscode /workspace || true

# Switch to vscode user
USER vscode

# Verify installation
RUN php -v && composer --version && php -m | grep -E "(dom|simplexml|mbstring|xml|zip|curl)"
