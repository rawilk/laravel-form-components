# Changelog

All notable changes to `laravel-form-components` will be documented in this file

## 1.3.1 - 2020-10-15
### Added
- Add a `wire:model` watcher to the `file-pond` component to watch for manual file deletions

### Changed
- Change how FilePond is initialized on the `file-pond` component.

## 1.3.0 - 2020-10-14
### Added
- Add a file input component ([#2](https://github.com/rawilk/laravel-form-components/issues/2))
- Add a [FilePond](https://pqina.nl/filepond/) component ([#2](https://github.com/rawilk/laravel-form-components/issues/2))

### Changed
- Only render the id attribute on inputs if an id is set on the component

## 1.2.1 - 2020-10-12
### Changed
- Only render the checkbox/radio label markup if a label or description is present

## 1.2.0 - 2020-10-06
### Added
- Add a date picker component ([#7](https://github.com/rawilk/laravel-form-components/pull/7))
- Add directives `@fcStyles` and `@fcScripts` for linking to 3rd party CDN libraries when not in production ([view commit](https://github.com/rawilk/laravel-form-components/commit/5f923ec723c4295128150ee6aaecd4f6797cfafb))

### Changed
- Change format of timezone display in select options

## 1.1.1 - 2020-09-18
### Fixed
- Move x-cloak directive in x-password component to the toggle icon so autofocus can work properly on the input.

## 1.1.0 - 2020-09-16
### Added
- Add timezone select component

## 1.0.0 - 2020-09-13

- initial release
