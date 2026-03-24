<!--
    joomla-lastmodified
    Copyright (C) 2026 Benjamin W. Bohl <b.w.bohl@gmail.com>

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program. If not, see <https://www.gnu.org/licenses/>.
-->

# joomla-lastmodified

A _Joomla!_ plugin that makes the year of the last article update available as a variable insertable in content with `{lastmodified}`.

![PHP CodeSniffer](https://github.com/bwbohl/joomla-lastmodified/actions/workflows/phpcs.yml/badge.svg)

## Requirements

- Joomla 4 or 5
- PHP 8.1 or higher

## Installation

1. Download the latest release ZIP from the [Releases](https://github.com/bwbohl/joomla-lastmodified/releases) page
2. In the Joomla admin panel go to **System > Install > Extensions**
3. Upload the ZIP
4. Go to **System > Manage > Plugins**, find _Content - Last Modified_ and enable it

## Usage

Place `{lastmodified}` anywhere in an article. The plugin replaces it with the four-digit year of the most recently updated article across the site, e.g.:

```
&copy; {lastmodified} Acme Corp
```

renders as:

```
© 2026 Acme Corp
```

## Development Setup

**Prerequisites:** PHP 8.1+, Composer, git with GPG signing enabled

```bash
git clone https://github.com/bwbohl/joomla-lastmodified.git
cd joomla-lastmodified
composer install
```

`composer install` installs dev dependencies and configures git to use the local hooks in `.githooks/`.

### Code style linting

```bash
vendor/bin/phpcs   # check
vendor/bin/phpcbf  # auto-fix
```

The [Joomla coding standard](https://github.com/joomla/coding-standards) ruleset is enforced. The same check runs automatically via GitHub Actions on every push and pull request to `main` and `develop`.

### Git hooks

A `pre-push` hook runs automatically when pushing tags. It aborts if:

- the tag is not annotated — use `git tag -a <version> -m "<message>"`
- the `<version>` in `lastmodified.xml` does not match the tag

## Release Workflow

1. Create a `release/<version>` branch
2. Bump `<version>` in `lastmodified.xml` to the release version
3. Push the branch
4. Open a pull request against `main` — GitHub Actions will validate the build
5. Fix any reported issues and push again
6. Merge to `main` locally with a meaningful merge commit message — this will appear in the auto-generated release notes:
   ```bash
   git checkout main
   git merge --no-ff release/<version> -m "Release <version>"
   ```
7. Create an annotated tag:
   ```bash
   git tag -a <version> -m "<version>"
   ```
8. Push with tags:
   ```bash
   git push --follow-tags
   ```
9. If the pre-push hook aborts, fix the reported issue and retry from step 7

The GitHub Actions release workflow will then create a GitHub Release with auto-generated notes and attach the installable ZIP.

## Trademark Notice

Joomla! is a registered trademark of [Open Source Matters, Inc.](https://www.opensourcematters.org/)
This plugin is not affiliated with or endorsed by Open Source Matters, Inc.
