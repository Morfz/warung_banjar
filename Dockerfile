FROM serversideup/php:8.2-fpm-nginx

# Switch to root to install dependencies and configure
USER root

# Install NodeJS & NPM for compiling assets
RUN apt-get update && apt-get install -y gnupg curl && \
    curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && rm -rf /var/lib/apt/lists/*

# Set working directory
WORKDIR /var/www/html

# Copy project files
COPY --chown=1000:1000 . .

# Switch to the application user
USER 1000

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install npm dependencies and build frontend assets
RUN npm install && npm run build

# Copy custom entrypoint script
USER root
RUN chmod +x /var/www/html/entrypoint.sh
USER 1000

ENTRYPOINT ["/var/www/html/entrypoint.sh"]
