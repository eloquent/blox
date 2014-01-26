# Blox

*A parser for block comment documentation.*

[![The most recent stable version is 3.0.1]][Semantic versioning]
[![Current build status image]][Current build status]
[![Current coverage status image]][Current coverage status]

## Installation and documentation

* Available as [Composer] package [eloquent/blox].
* [API documentation] available.

## What is *Blox*?

*Blox* is a parser for PHP block comment documentation. *Blox* allows a standard
documentation block comment to be parsed into an object tree representation,
with a simple interface for retrieving information.

## Usage

```php
use Eloquent\Blox\BloxParser;

$blockComment = <<<'EOD'
/**
 * This is the summary.
 *     This is also the summary.
 *
 * This is the body.
 *
 * This is also the body.
 *
 * @tagA This is some tag content.
 * @tagA This is some more tag content.
 * @tagB This is content for a different tag
 *     which spans multiple lines.
 *
 * This is ignored.
 */
EOD;

$parser = new BloxParser;
$block = $parser->parseBlockComment($blockComment);

echo $block->summary(); // outputs 'This is the summary. This is also the summary.'
echo $block->body();    // outputs "This is the body.\n\nThis is also the body."

// outputs 'This is some tag content.', then 'This is some more tag content.'
foreach ($block->tagsByName('tagA') as $tag) {
    echo $tag->content();
}

$splatTags = $block->tagsByName('tagB');
echo array_pop($splatTags)->content(); // outputs 'This is content for a different tag which spans multiple lines.'
```

## Conventions

*Blox* has a small set of conventions for block comments. They aim to be quite
loose, so that *Blox* can be used, regardless of the body text format in use.

### Summary text

The summary text starts from the first non-blank line and continues until a
blank line, or the end of the block is encountered. White space at the beginning
of lines, and newlines, are collapsed into a single space.

```php
/**
 * This is the summary.
 *     This is also the summary.
 *
 * This is not the summary.
 */
```

### Body text

The body text starts from the first non-blank line after the summary, and
continues until a tag, or the end of the block is encountered. White space and
newlines are left as-is.

```php
/**
 * This is not the body.
 *
 * This is the body.
 *
 * This is also the body.
 *
 * @tagA This is not the body.
 */
```

### Tags

A tag is any line starting with the 'at' symbol (`@`) followed by one or more
'word' characters (as defined in [PCRE]). These 'word' characters make up the
tag's 'name'.

Tags can optionally be followed by content which will be associated with the
tag. White space directly after the tag name is ignored, but subsequent text is
included in the tag content, as are subsequent lines until a blank line or
another tag is encountered. White space at the beginning of lines, and newlines,
are collapsed into a single space.

```php
/**
 * This is not a tag.
 *
 * @tagA This is some tag content.
 * @tagA This is some more tag content.
 * @tagB This is content for a different tag
 *     which spans multiple lines.
 *
 * This is ignored.
 */
```

<!-- References -->

[API documentation]: http://lqnt.co/blox/artifacts/documentation/api/
[Composer]: http://getcomposer.org/
[eloquent/blox]: https://packagist.org/packages/eloquent/blox
[PCRE]: http://php.net/pcre

[API documentation]: http://lqnt.co/blox/artifacts/documentation/api/
[Composer]: http://getcomposer.org/
[Current build status image]: http://b.adge.me/travis/eloquent/blox/develop.svg "Current build status for the develop branch"
[Current build status]: https://travis-ci.org/eloquent/blox
[Current coverage status image]: http://b.adge.me/coveralls/eloquent/blox/develop.svg "Current test coverage for the develop branch"
[Current coverage status]: https://coveralls.io/r/eloquent/blox
[eloquent/blox]: https://packagist.org/packages/eloquent/blox
[Semantic versioning]: http://semver.org/
[The most recent stable version is 3.0.1]: http://b.adge.me/:semver-3.0.1-brightgreen.svg "This project uses semantic versioning"
