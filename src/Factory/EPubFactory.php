<?php

namespace Rampmaster\PhpEpubBundle\Factory;

use Rampmaster\EPub\Core\EPub;

class EPubFactory
{
    /**
     * Default language for EPub books (e.g., 'en', 'es', 'fr')
     */
    private string $defaultLanguage;

    /**
     * Default EPUB version (2.0.1, 3.0, 3.0.1, 3.1, or 3.2)
     */
    private string $defaultVersion;

    /**
     * Constructor
     * 
     * Note: When used as a Symfony service, these values are automatically 
     * injected from the bundle configuration (rampmaster_php_epub.default_language 
     * and rampmaster_php_epub.default_version).
     *
     * @param string $defaultLanguage Default language for EPub books (default: 'en')
     * @param string $defaultVersion Default EPUB version (default: '3.2')
     */
    public function __construct(string $defaultLanguage = 'en', string $defaultVersion = '3.2')
    {
        $this->defaultLanguage = $defaultLanguage;
        $this->defaultVersion = $defaultVersion;
    }

    /**
     * Create a new EPub instance with the specified version
     *
     * @param string|null $version EPUB version (2.0.1, 3.0, 3.0.1, 3.1, or 3.2). 
     *                             If null, uses the default version from configuration.
     *                             Invalid versions will default to 3.2.
     * @return EPub The configured EPub instance
     */
    public function create(?string $version = null): EPub
    {
        $version = $version ?? $this->defaultVersion;
        
        $epubVersion = match ($version) {
            '2.0.1' => EPub::BOOK_VERSION_EPUB2,
            '3.0' => EPub::BOOK_VERSION_EPUB3,
            '3.0.1' => EPub::BOOK_VERSION_EPUB301,
            '3.1' => EPub::BOOK_VERSION_EPUB31,
            '3.2' => EPub::BOOK_VERSION_EPUB32,
            default => EPub::BOOK_VERSION_EPUB32,
        };

        $epub = new EPub($epubVersion);
        $epub->setLanguage($this->defaultLanguage);

        return $epub;
    }

    /**
     * Create an EPUB 2.0.1 book
     */
    public function createEpub2(): EPub
    {
        return $this->create('2.0.1');
    }

    /**
     * Create an EPUB 3.0 book
     */
    public function createEpub3(): EPub
    {
        return $this->create('3.0');
    }

    /**
     * Create an EPUB 3.2 book (default)
     */
    public function createEpub32(): EPub
    {
        return $this->create('3.2');
    }
}
