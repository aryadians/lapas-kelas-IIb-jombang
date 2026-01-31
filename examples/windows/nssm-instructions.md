# NSSM Instructions (Windows)

1. Download NSSM: https://nssm.cc/download and extract to `C:\tools\nssm`.
2. Open PowerShell as Administrator.
3. Install service (example):

```powershell
C:\tools\nssm\nssm.exe install laravel-queue
# Set Path to PHP executable
C:\tools\nssm\nssm.exe set laravel-queue Application C:\php\php.exe
# Set Arguments
C:\tools\nssm\nssm.exe set laravel-queue AppParameters "C:\path\to\project\artisan queue:work database --sleep=3 --tries=3 --timeout=90"
# Set working directory
C:\tools\nssm\nssm.exe set laravel-queue AppDirectory C:\path\to\project
# Set logs
C:\tools\nssm\nssm.exe set laravel-queue AppStdout C:\path\to\project\storage\logs\worker.log
C:\tools\nssm\nssm.exe set laravel-queue AppStderr C:\path\to\project\storage\logs\worker-error.log
# Start service
C:\tools\nssm\nssm.exe start laravel-queue
```

4. To restart service during deploy, use:
```powershell
C:\tools\nssm\nssm.exe restart laravel-queue
```

5. Notes:
- Ensure the service account has write access to project logs and storage directories.
- Use `queue:restart` in deployment scripts to gracefully reload workers when code changes.
