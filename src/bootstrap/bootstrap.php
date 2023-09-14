<?php

function loadEnvironments(): void
{
    $handle = fopen(__DIR__ . "/../../.env", "r");
    if (!$handle) die('.env file does not exist');

    while (($line = fgets($handle)) !== false) {
        $line = trim($line, "\n");

        if (!empty($line)) {
            putenv($line);
        }
    }

    fclose($handle);
}
function loadRoutes(): void
{
    $webRoutesPath = __DIR__ . '/../routes/web.php';
    $apiRoutesPath = __DIR__ . '/../routes/api.php';

    if (!file_exists($webRoutesPath))
        die('File web.php does not exists!');

    if (!file_exists($apiRoutesPath))
        die('File api.php does not exists!');

    $webRoutes = require $webRoutesPath;
    $apiRoutes = require $apiRoutesPath;

    $temp = [];
    foreach ($apiRoutes as $key => $route){

        $parts = explode(' ', $key, 2);

        if (count($parts) === 2) {
            $method = $parts[0];
            $endpoint = $parts[1];

            if (str_contains($endpoint, '/')) {
                $newKey = "$method /api$endpoint";
                $temp[$newKey] = $route;
            }
        }
    }

    $routes = array_merge($webRoutes, $temp);
    define('_ROUTES', $routes);
    $GLOBALS['_ROUTES'] = _ROUTES;
}

function findPhpFiles(string $directory): array
{
    $phpFiles = [];
    $files = scandir($directory);

    if ($files !== false) {
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $directory . '/' . $file;

                if (is_dir($filePath)) {
                    $phpFiles = array_merge($phpFiles, findPhpFiles($filePath));
                } elseif (pathinfo($file, PATHINFO_EXTENSION) === 'php') {
                    $phpFiles[] = $filePath;
                }
            }
        }
    }

    return $phpFiles;
}

function getNamespacesAndClassesFromDirectory($directory): array
{
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));

    $namespacesAndClasses = [];

    foreach ($iterator as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $filePath = $file->getPathname();
            $content = file_get_contents($filePath);

            // Use regular expressions to extract namespaces and classes
            preg_match_all('/namespace\s+(.*?);/s', $content, $namespaceMatches);
            preg_match_all('/class\s+(\w+)/', $content, $classMatches);

            $namespaces = $namespaceMatches[1] ?? [];
            $classes = $classMatches[1] ?? [];

            foreach ($namespaces as $namespace) {
                foreach ($classes as $class) {
                    $namespacesAndClasses[] = $namespace . '\\' . $class;
                }
            }
        }
    }

    return $namespacesAndClasses;
}

function loadDependencies(): void
{
    $directoryToSearch = __DIR__ . '/../app'; // Replace with your root directory
    $phpFiles = findPhpFiles($directoryToSearch);

    foreach ($phpFiles as $phpFile) {
        include $phpFile;
    }

    $namespaceClassList = getNamespacesAndClassesFromDirectory($directoryToSearch);

    $beans = [];
    if (!empty($namespaceClassList)) {
        foreach ($namespaceClassList as $entry) {
            $beans[$entry] = new $entry;
        }
    }

    define('_BEANS', $beans);
    $GLOBALS['_BEANS'] = $beans;
}

loadEnvironments();
loadRoutes();
loadDependencies();

//var_dump($GLOBALS['routes']);
