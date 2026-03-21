# DevContainer for Nextcloud Ransomware Protection

This DevContainer provides a consistent development environment with PHP 8.3 and all required extensions for running Psalm, PHP CS Fixer, and PHPUnit tests.

## Features

- **PHP 8.3** with required extensions (dom, simplexml, mbstring, xml, curl, zip, bcmath, intl, gd)
- **Composer** pre-installed
- **Psalm 6.15** for static analysis
- **PHP CS Fixer** with Nextcloud coding standard
- **PHPUnit 13.0** for testing
- **VS Code extensions** for PHP development and debugging

## Usage

1. Open the project in VS Code
2. When prompted, reopen in the DevContainer
3. The container will automatically build and install dependencies

## Available Commands

Once in the DevContainer, you can run:

```bash
# Run Psalm static analysis
composer run psalm

# Check code style (dry run)
composer run cs:check

# Fix code style
composer run cs:fix

# Run PHP linting
composer run lint

# Update Psalm baseline
composer run psalm:update-baseline

# Clear Psalm cache
composer run psalm:clear

# Auto-fix some Psalm issues
composer run psalm:fix

# Or use the direct commands
php composer.phar run psalm
php composer.phar run cs:fix
php composer.phar run cs:check
```

## Project Configuration

The DevContainer uses the project's root `composer.json` file, which includes:

- **Nextcloud OCP** dependencies (`dev-stable33`)
- **Nextcloud Coding Standard** for code formatting
- **Psalm** for static analysis
- **PHPUnit** for testing

## Troubleshooting

If you encounter any issues:

1. Rebuild the container: `Ctrl+Shift+P` → "Dev Containers: Rebuild Container"
2. Check that all PHP extensions are installed: `php -m`
3. Verify Composer is working: `composer --version`
4. Clear Composer cache: `composer clear-cache`

## File Structure

- `.devcontainer/devcontainer.json` - Main DevContainer configuration
- `.devcontainer/Dockerfile` - Container setup with PHP extensions
- `composer.json` - Project dependencies (used by DevContainer)
- `.devcontainer/README.md` - This file

## Performance Tips

- The vendor directory is mounted as a volume for better performance
- Xdebug is available for debugging if needed
- Container has proper permissions for development
