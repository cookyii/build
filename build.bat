@echo off

@setlocal

set BUILD_PATH=%~dp0

if "%PHP_COMMAND%" == "" set PHP_COMMAND=php.exe

"%PHP_COMMAND%" "%BUILD_PATH%build" %*

@endlocal
