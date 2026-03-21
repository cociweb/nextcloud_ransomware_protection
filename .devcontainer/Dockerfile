FROM mcr.microsoft.com/devcontainers/php:8.4

USER root

# Install required PHP extensions for Psalm and Nextcloud
RUN apt-get update && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    unzip \
    git \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    curl \
    gpg \
    && docker-php-ext-install dom simplexml xml mbstring zip curl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install GitHub CLI
RUN curl -fsSL https://cli.github.com/packages/githubcli-archive-keyring.gpg | dd of=/usr/share/keyrings/githubcli-archive-keyring.gpg \
    && chmod go+r /usr/share/keyrings/githubcli-archive-keyring.gpg \
    && echo "deb [arch=$(dpkg --print-architecture) signed-by=/usr/share/keyrings/githubcli-archive-keyring.gpg] https://cli.github.com/packages stable main" | tee /etc/apt/sources.list.d/github-cli.list > /dev/null \
    && apt-get update \
    && apt-get install -y gh \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer if not present
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /workspace

# Copy composer files from project root
COPY composer.json composer.lock ./

# Install dependencies as root (ignore platform requirements since we're using PHP 8.3 vs 8.4.3 requirement)
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --ignore-platform-reqs

# Copy source code
COPY . .

# Set permissions (skip if user doesn't exist)
RUN chown -R vscode:vscode /workspace || true

# Switch to vscode user
USER vscode

# Verify installation and composer scripts
RUN php -v && composer --version && composer run-script --list
