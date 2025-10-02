<?php

declare(strict_types=1);

namespace Brick\Core;

class AssetHelper
{
    private static bool $isDev = false;
    private static ?array $manifest = null;

    public static function setDev(bool $isDev): void
    {
        self::$isDev = $isDev;
    }

    public static function isDev(): bool
    {
        return self::$isDev;
    }

    /**
     * Lädt das Vite-Manifest für Production-Assets
     */
    private static function loadManifest(): array
    {
        if (self::$manifest !== null) {
            return self::$manifest;
        }

        $manifestPath = ROOT_DIR . '/public/src/.vite/manifest.json';
        
        if (!file_exists($manifestPath)) {
            self::$manifest = [];
            return self::$manifest;
        }

        $content = file_get_contents($manifestPath);
        self::$manifest = $content ? json_decode($content, true) : [];
        
        return self::$manifest;
    }

    /**
     * Generiert die Asset-URLs für Development oder Production
     */
    public static function asset(string $path): string
    {
        if (self::$isDev) {
            // Development: Vite Dev Server
            return "http://localhost:3000/{$path}";
        }

        // Production: Kompilierte Assets
        $manifest = self::loadManifest();
        
        if (isset($manifest[$path]['file'])) {
            return "/src/{$manifest[$path]['file']}";
        }

        // Fallback: Direkte Asset-Suche
        $assetDir = ROOT_DIR . '/public/src/assets/';
        if (is_dir($assetDir)) {
            $files = scandir($assetDir);
            $basename = pathinfo($path, PATHINFO_FILENAME);
            
            foreach ($files as $file) {
                if (str_starts_with($file, $basename . '-') && str_ends_with($file, '.' . pathinfo($path, PATHINFO_EXTENSION))) {
                    return "/src/assets/{$file}";
                }
            }
        }

        return "/src/{$path}";
    }

    /**
     * Generiert Script-Tags für Development oder Production
     */
    public static function viteAssets(): string
    {
        if (self::$isDev) {
            $devServer = Config::get('vite.dev_server', 'http://localhost:3000');
            $entryPoint = Config::get('vite.entry_point', 'app/assets/js/app.js');
            
            return "
    <script type=\"module\" src=\"{$devServer}/@vite/client\"></script>
    <script type=\"module\" src=\"{$devServer}/{$entryPoint}\"></script>";
        }

        $cssUrl = self::asset('app/assets/js/app.js');
        $jsUrl = self::asset('app/assets/js/app.js');
        
        // CSS-Asset finden
        $buildDir = Config::get('vite.build_directory', 'src');
        $assetDir = ROOT_DIR . "/public/{$buildDir}/assets/";
        if (is_dir($assetDir)) {
            $files = scandir($assetDir);
            foreach ($files as $file) {
                if (str_starts_with($file, 'app-') && str_ends_with($file, '.css')) {
                    $cssUrl = "/{$buildDir}/assets/{$file}";
                    break;
                }
            }
            foreach ($files as $file) {
                if (str_starts_with($file, 'app-') && str_ends_with($file, '.js')) {
                    $jsUrl = "/{$buildDir}/assets/{$file}";
                    break;
                }
            }
        }

        return "
    <link rel=\"stylesheet\" href=\"{$cssUrl}\">
    <script type=\"module\" src=\"{$jsUrl}\"></script>";
    }
}