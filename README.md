# PHPePub Symfony Bundle

[![License](https://img.shields.io/badge/License-LGPL%202.1-blue.svg)](https://opensource.org/licenses/LGPL-2.1)

A Symfony bundle for the [PHPePub](https://github.com/rampmaster/phpepub) library, allowing you to easily generate ePub electronic books in your Symfony applications.

## Features

- **Easy Integration**: Seamlessly integrate PHPePub into your Symfony application
- **Multi-version Support**: Generate EPUB 2.0.1, 3.0, 3.0.1, 3.1, and 3.2 files
- **Configurable Defaults**: Set default language and EPUB version in your configuration
- **Factory Service**: Create EPub instances through a convenient factory service
- **Modern PHP**: Compatible with PHP 8.2+
- **Symfony Support**: Works with Symfony 5.4, 6.x, and 7.x

## Installation

Install the bundle using Composer:

```bash
composer require rampmaster/phpepub-bundle
```

### Enable the Bundle

If you're using Symfony Flex, the bundle will be automatically enabled. Otherwise, add it to your `config/bundles.php`:

```php
<?php

return [
    // ...
    Rampmaster\PhpEpubBundle\RampmasterPhpEpubBundle::class => ['all' => true],
];
```

## Configuration

Create a configuration file `config/packages/rampmaster_php_epub.yaml`:

```yaml
rampmaster_php_epub:
    default_language: 'en'    # Default language for EPUB books
    default_version: '3.2'    # Default EPUB version (2.0.1, 3.0, 3.0.1, 3.1, 3.2)
```

All configuration options are optional and have sensible defaults.

## Usage

### Using the Factory Service

Inject the EPub factory service into your controller or service:

```php
<?php

namespace App\Controller;

use Rampmaster\PhpEpubBundle\Factory\EPubFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{
    #[Route('/generate-book', name: 'generate_book')]
    public function generateBook(EPubFactory $epubFactory): Response
    {
        // Create a new EPUB book with default settings
        $book = $epubFactory->create();
        
        // Set mandatory metadata
        $book->setTitle("My First eBook");
        $book->setIdentifier("http://example.com/books/1", \Rampmaster\EPub\Core\EPub::IDENTIFIER_URI);
        $book->setAuthor("John Doe", "Doe, John");
        
        // Add a chapter
        $content = "<h1>Chapter 1</h1><p>Welcome to my book.</p>";
        $book->addChapter("Chapter 1", "chapter1.xhtml", $content);
        
        // Finalize and save
        $book->finalize();
        $book->saveBook("my_book", "/tmp");
        
        return new Response('Book generated successfully!');
    }
}
```

### Create Specific EPUB Versions

```php
// Create an EPUB 2.0.1 book
$book = $epubFactory->createEpub2();

// Create an EPUB 3.0 book
$book = $epubFactory->createEpub3();

// Create an EPUB 3.2 book (default)
$book = $epubFactory->createEpub32();

// Create with a specific version
$book = $epubFactory->create('3.1');
```

### Advanced Features

#### Accessibility Metadata

```php
$book->setAccessibilitySummary("This book contains structural navigation.");
$book->addAccessMode("textual");
$book->addAccessMode("visual");
$book->addAccessibilityFeature("structuralNavigation");
```

#### Adding Chapters with Images

```php
$content = '<h1>Chapter 1</h1><img src="image.jpg" alt="Description" />';
$book->addChapter("Chapter 1", "chapter1.xhtml", $content);
$book->addLargeFile("image.jpg", "image.jpg", file_get_contents("/path/to/image.jpg"));
```

#### Media Overlays (Read Aloud)

```php
$book->addChapterWithAudio(
    "Chapter 1",
    "chap1.xhtml",
    $htmlContent,
    "path/to/audio.mp3",
    "00:05:30" // Duration
);
```

## Service Reference

The bundle provides the following service:

- `Rampmaster\PhpEpubBundle\Factory\EPubFactory` (alias: `rampmaster_php_epub.factory`)

You can inject it using type-hinting or by service ID.

## Requirements

- PHP 8.2 or higher
- Symfony 5.4, 6.x, or 7.x
- rampmaster/phpepub library

## Credits

This bundle wraps the [PHPePub library](https://github.com/rampmaster/phpepub) by rampmaster, which is based on the original work by A. Grandt.

## License

This bundle is licensed under the GNU LGPL 2.1. See the LICENSE file for details.