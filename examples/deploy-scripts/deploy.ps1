# PowerShell deploy helper (example) - adapt before use
param(
    [string]$ProjectPath = "C:\path\to\project",
    [string]$Branch = 'main'
)

Write-Host "Deploying $ProjectPath (branch $Branch)"
Set-Location $ProjectPath

git fetch origin
git reset --hard origin/$Branch

Write-Host "Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader

Write-Host "Building assets..."
npm ci; npm run build

Write-Host "Running migrations..."
php artisan migrate --force

Write-Host "Clearing caches..."
php artisan config:cache
php artisan route:cache

Write-Host "Restarting queue workers and Horizon if used..."
php artisan queue:restart

Write-Host "Deploy complete."