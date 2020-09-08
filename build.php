#!/bin/php
<?php
// Directories to search for build script in.
$contentDirectories = [
    'wp-content/themes',
    'wp-content/plugins',
    'wp-content/mu-plugins'
];

// Build file name.
$buildFile = 'build.sh';

// Files and directories not suitable for prod to be removed.
$removables = [
    '.git',
    '.gitignore',
    'config',
    'wp-content/uploads',
    '.github',
    'build.php'
];

// Iterate through directories and try to find and run build scripts.
$root = getcwd();
foreach ($contentDirectories as $contentDirectory) {
    $directories = glob("$contentDirectory/*", GLOB_ONLYDIR);
    foreach ($directories as $directory) {
        if (file_exists("$directory/$buildFile")) {
            print "Running build script in $directory.\n";
            chdir($directory);
            shell_exec('bash ' . $buildFile);
            chdir($root);
        }
    }
}

// Remove files and directories.
foreach ($removables as $removable) {
    if (file_exists($removable)) {
        print "Removing $removable\n";
        shell_exec("rm -rf $removable");
    }
}
